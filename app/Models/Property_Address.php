<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Property_Address extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'property_address';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_property',
        'street_name',
        'province',
        'zipcode',
        'country',
        'state'
    ];

    protected $primaryKey = 'id_property';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

}
