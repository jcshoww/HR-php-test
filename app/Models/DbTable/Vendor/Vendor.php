<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Vendor extends Model
{
    use Notifiable;

    protected $fillable = [
        'email', 'name'
    ];
    protected $casts = [
        'email' => 'string',
        'name' => 'string',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'vendor_id', 'id');
    }

    public function routeNotificationForMail()
    {
        return $this->email;
    }
}
