<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class property_detail extends Model
{
    /** @use HasFactory<\Database\Factories\PropertyDetailFactory> */
    use HasFactory;
    protected $fillable =[
        'id_property',
        'isFurnished',
        'furnishedType'
    ]
}
