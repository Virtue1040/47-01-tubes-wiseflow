<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    /** @use HasFactory<\Database\Factories\BookingFactory> */
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_rent',
        'id_property',
        'orderNumber',
        'status',
        'checkin',
        'checkout'
    ];

    protected $primaryKey = 'id_booking';
}
