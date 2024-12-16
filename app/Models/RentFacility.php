<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentFacility extends Model
{
    protected $fillable = [
        'id_rent',
        'id_facility',
        'quantity',
        'item_order',
    ];
    protected $primaryKey = 'id_rentfacility';
    protected $table = "rentfacility";

    public function rent()
    {
        return $this->belongsTo(Rent::class, "id_rent", "id_rent");
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class, "id_facility", "id_facility");
    }
}
