<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class ContactInformation extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_user',
        'first_name',
        'last_name',
        'no_hp',
        'gender',
        'email',
    ];

    protected $primaryKey = 'id_user';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
