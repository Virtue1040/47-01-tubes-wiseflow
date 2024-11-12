<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Property extends Model
{
    protected $table = 'property';
    use HasFactory, Notifiable;

    protected $fillable = [
        'id_user_owner',
        'property_name',
        'property_desc',
        'property_category',
        'id_cover',
    ];

    protected $primaryKey = 'id_property';
    protected $guarded  = 'id_property';

    public function user()
    {
        return $this->hasOne(User::class, "id_user", "id_user_owner");
    }

    public function album()
    {
        return $this->hasOne(Album::class, "id_album", "id_cover");
    }
}
