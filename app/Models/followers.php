<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class followers extends Model
{
    /** @use HasFactory<\Database\Factories\FollowersFactory> */
    use HasFactory;

    protected $fillable =[
        'id_user',
        'id_user_followed'
    ];
    protected $primaryKey = 'id_follower';

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function user_followed()
    {
        return $this->belongsTo(User::class, 'id_user_followed', 'id_user');
    }
}
