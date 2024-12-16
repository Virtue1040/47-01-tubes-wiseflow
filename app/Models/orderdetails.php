<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class orderdetails extends Model
{
    protected $fillable = [
        'orderNumber',
        'checkNumber',
        'status',
        'type_order',
        'id_item',
        'quantity',
        'total_order',
    ];
    protected $primaryKey = 'orderNumber';
    protected $table = 'orderdetails';
}
