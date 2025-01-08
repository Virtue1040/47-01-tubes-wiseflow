<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class iuran_pay extends Model
{
    /** @use HasFactory<\Database\Factories\IuranPayFactory> */
    use HasFactory;

    protected $fillable = ["id_user", "id_iuran","orderNumber", "nominal"];
    protected $primaryKey = "id_iuran_pay";

    public function iuran()
    {
        return $this->belongsTo(iuran::class, "id_iuran", "id_iuran");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "id_user", "id_user");
    }

    public function order()
    {
        return $this->belongsTo(Order::class, "orderNumber", "orderNumber");
    }
}
