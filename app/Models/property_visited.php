<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class property_visited extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_property_visited';

    protected $fillable = [
        'id_user',
        'id_property',
    ];
}
