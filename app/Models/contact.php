<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class contact extends Model
{
    protected $fillable = [
        'id_user',
        'name',
        'email',
        'no_hp',
    ];

    protected $primaryKey = 'id_contact';
}
