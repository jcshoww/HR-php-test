<?php

namespace App;

use App\Notifications\OrderFinished;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    const STATUS = [
        'NEW' => ['id' => 0, 'label' => 'Новый'],
        'CONFIRMED' => ['id' => 10, 'label' => 'Подтвержден'],
        'FINISHED' => ['id' => 20, 'label' => 'Завершен']
    ];

    protected $fillable = [
        'status', 'client_email', 'partner_id', 'delivery_dt'
    ];
    protected $casts = [
        'status' => 'integer',
        'client_email' => 'string',
        'partner_id' => 'integer',
    ];

    protected $dates = [
        'delivery_dt'
    ];

    protected $appends = ['status_description', 'edit_route'];

    public function getStatusDescriptionAttribute()
    {
        return head(Arr::where(self::STATUS, function ($value) {
            return $value['id'] == $this->status;
        }))['label'];
    }

    public function getEditRouteAttribute()
    {
        return route('orders.edit', $this->id);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id', 'id');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products', 'order_id', 'product_id')->withPivot('quantity');
    }

    public function scopeList($q)
    {
        return $q->select('id', 'status', 'partner_id', 'delivery_dt')->relatedData();
    }
    public function scopeRelatedData($q)
    {
        return $q->withCount([
            'products as products_price' => function($q) {
                $q->select(DB::raw('SUM(' 
                    . (new Product())->getTable() . '.price * '
                    . (new OrderProduct())->getTable() . '.quantity' . 
                ')'));
            }
        ])
        ->with([
            'partner' => function($q){
                $q->select('id', 'name');
            },
            'products'
        ]);
    }
    public function scopeConfirmed($q)
    {
        return $q->where('status', self::STATUS['CONFIRMED']['id']);
    }
    public function scopeCurrent($q)
    {
        $now = Carbon::now();
        return $q->confirmed()->whereBetween('delivery_dt', [$now, $now->copy()->addHours(24)]);
    }
    public function scopeNew($q)
    {
        return $q->where('status', self::STATUS['NEW']['id'])->where('delivery_dt', '>=', Carbon::now());
    }
    public function scopeDelayed($q)
    {
        return $q->where('status', self::STATUS['CONFIRMED']['id'])->where('delivery_dt', '<', Carbon::now());
    }
    public function scopeFinished($q)
    {
        $startOfDay = Carbon::now()->startOfDay();
        return $q->where('status', self::STATUS['FINISHED']['id'])->whereBetween('delivery_dt', [$startOfDay, $startOfDay->copy()->endOfDay()]);
    }

    public static function boot()
    {
        parent::boot();

        self::updating(function($model){
            if($model->status != $model->getOriginal('status') && $model->status == self::STATUS['FINISHED']['id']) {
                $notification = new OrderFinished($model);
                $model->partner->notify($notification);
                foreach($model->products as $product) {
                    $product->vendor->notify($notification);
                }
            }
        });
    }
}
