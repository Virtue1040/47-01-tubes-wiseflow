<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Album extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_property',
        'imagePath',
    ];

    protected $primaryKey = 'id_album';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

     public function Property()
    {
        return $this->belongsTo(Property::class, 'id_property', 'id_property');
    }
}
