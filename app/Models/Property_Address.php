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
        'longitude',
        'latitude',
        'street_name',
        'province',
        'zipcode',
        'country',
        'state'
    ];

    protected $primaryKey = 'id_property';

    public function getDisplayName() {
        return $this->street_name . ', ' . $this->province . ', ' . $this->state . ', ' . $this->zipcode . ', ' . $this->country;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

}
