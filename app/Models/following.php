<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Following extends Model
{
    use HasFactory;

    protected $table = 'following';

    protected $fillable = [
        'name',
        'email',
        'username',
        'user_id',
    ];
}
