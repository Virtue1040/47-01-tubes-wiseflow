<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class renttag extends Model
{
    /** @use HasFactory<\Database\Factories\RenttagFactory> */
    use HasFactory;

    protected $fillable = [
        'id_rent',
        'tag'
    ];
    protected $primaryKey = 'id_tag';
    protected $guarded  = 'id_tag';
}
