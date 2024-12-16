<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class property_comment extends Model
{
    /** @use HasFactory<\Database\Factories\PropertyCommentFactory> */
    use HasFactory;
    protected $fillable = [
        'id_property',
        'id_user',
        'id_rent',
        'comment',
        'rating'
    ];
    protected $primaryKey = 'id_property_commented';
    public function property()
    {
        return $this->belongsTo(property::class, 'id_property');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function rent()
    {
        return $this->belongsTo(Rent::class, 'id_rent');
    }
}
