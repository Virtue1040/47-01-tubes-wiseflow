<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'orderNumber',
        'id_user',
    ];
    protected $primaryKey = 'orderNumber';
    protected $keyType = 'string';
    protected $cast = [
        "orderNumber" => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function orderDetails()
    {
        return $this->hasOne(orderdetails::class, 'orderNumber', 'orderNumber');
    }
}
