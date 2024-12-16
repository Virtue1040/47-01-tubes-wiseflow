<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class property_visited extends Model
{
    /** @use HasFactory<\Database\Factories\PropertyVisitedFactory> */
    use HasFactory;
    protected $fillable = [
        'id_user',
        'id_property',
    ];
    protected $primaryKey = 'id_property_visited';

    public function property()
    {
        return $this->belongsTo(Property::class, 'id_property', 'id_property');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
