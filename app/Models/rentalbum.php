<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class rentalbum extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_rent',
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
        return $this->hasOne(Rent::class, 'id_rent', 'id_rent');
    }
}
