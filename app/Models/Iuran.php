<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Iuran extends Model
{
    protected $fillable = [
        'id_property',
        'type_iuran',
        'nominal_iuran',
        'status',
        'tanggal_iuran',
        'tenggat_iuran',
        'created_at',
        'updated_at',
    ];
    protected $primaryKey = 'id_iuran';

    public function property()
    {
        return $this->belongsTo(Property::class, 'id_property', 'id_property');
    }

    public function order() {
        return $this->hasMany(Order::class, 'orderNumber', 'orderNumber');
    }

    public function orderdetail() {
        return $this->hasMany(orderdetails::class, 'orderNumber', 'orderNumber');
    }

    public function isLunas() {
        $getTotalIuran = $this->orderdetail()->sum('total_order');
        return $this->nominal_iuran >= $getTotalIuran ? $this->status = true : false;
    }
}
