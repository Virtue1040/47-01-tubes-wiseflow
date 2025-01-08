<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('iuran_pays', function (Blueprint $table) {
            $table->integer("id_iuran_pay", 1)->lenght(11)->primary();
            $table->integer("id_user")->lenght(11);
            $table->foreign("id_user")->references("id_user")->on("users")->onDelete('CASCADE');
            $table->integer("id_iuran")->lenght(11);
            $table->foreign("id_iuran")->references("id_iuran")->on("iurans")->onDelete('CASCADE');
            $table->string("orderNumber");
            $table->foreign("orderNumber")->references("orderNumber")->on("orders")->onDelete('CASCADE');
            $table->integer("nominal");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iuran_pays');
    }
};
