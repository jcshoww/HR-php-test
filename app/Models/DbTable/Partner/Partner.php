<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Partner extends Model
{
    use Notifiable;

    protected $fillable = [
        'email', 'name'
    ];
    protected $casts = [
        'email' => 'string',
        'client_email' => 'string',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'partner_id', 'id');
    }

    public function routeNotificationForMail()
    {
        return $this->email;
    }
}
