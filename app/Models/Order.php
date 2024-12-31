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

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
