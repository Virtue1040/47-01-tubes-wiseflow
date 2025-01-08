<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class payments extends Model
{
    protected $fillable = [
        'checkNumber',
        'id_transaction',
        'nominal',
        'status_payment',
        'type_payment',
        'payment_date',
    ];
    protected $primaryKey = "checkNumber";
    protected $casts = [
        'checkNumber' => 'string',
    ];
}
