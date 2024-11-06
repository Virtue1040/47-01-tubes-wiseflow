<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Property extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id_user_owner',
    ];

    protected $primaryKey = 'id_property';
}
