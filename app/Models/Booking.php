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
        'checkout',
        'isRated'
    ];

    protected $primaryKey = 'id_booking';

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function rent()
    {
        return $this->belongsTo(Rent::class, 'id_rent', 'id_rent');
    }

    public function property()
    {
        return $this->belongsTo(Property::class, 'id_property', 'id_property');
    }
}
