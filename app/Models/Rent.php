<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    protected $fillable = [
        'id_property',
        'rent_name',
        'rent_desc',
        'rent_price',
        'stock',
        'id_cover',
        'availability',
    ];

    protected $primaryKey = 'id_rent';
    protected $guarded  = 'id_rent';

    public function album()
    {
        return $this->hasOne(rentalbum::class, "id_album", "id_cover");
    }

    public function property()
    {
        return $this->belongsTo(Property::class, "id_property", "id_property");
    }
    public function getAlbum() {
        return $this->hasMany(rentalbum::class, "id_rent", "id_rent");
    }
    public function getRentFacility() {
        return $this->hasMany(RentFacility::class, "id_rent", "id_rent")->orderBy('item_order', 'asc');
    }
    public function getRentTag() {
        return $this->hasMany(renttag::class, "id_rent", "id_rent");
    }
}
