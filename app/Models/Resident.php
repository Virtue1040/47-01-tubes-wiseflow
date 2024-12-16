<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    protected $fillable = [
        'id_user',
        'id_property',
        'id_rent',
        'id_role'
    ];
    protected $primaryKey = 'id_resident';
    
}
