<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;

    protected $fillable = [
        'id_user',
        'task_name',
        'task_desc',
        'id_property',
        'id_rent',
    ];
    protected $primaryKey = 'id_task';
}
