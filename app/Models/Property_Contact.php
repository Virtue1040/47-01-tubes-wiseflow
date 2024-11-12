<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Property_Contact extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'property_contact';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_property',
        'contact_name',
        'contact_phone',
    ];

    protected $guarded  = 'id';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

}
