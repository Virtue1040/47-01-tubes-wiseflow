<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = [
        'id_property',
        'facility_name',
        'facility_type',
        'facility_desc',
        'facility_image',
    ];
    protected $table = 'facility';
    protected $primaryKey = 'id_facility';
    protected $guarded = 'id_facility';
}
