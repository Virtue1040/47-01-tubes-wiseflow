<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class property_favorited extends Model
{
    /** @use HasFactory<\Database\Factories\PropertyFavoritedFactory> */
    use HasFactory;
    protected $fillable = [
        'id_property',
        'id_user',
    ];
    protected $primaryKey = 'id_property_favorited';

    public function property()
    {
        return $this->belongsTo(Property::class, 'id_property', 'id_property');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
