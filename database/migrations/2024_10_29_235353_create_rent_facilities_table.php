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
        Schema::create('rentfacility', function (Blueprint $table) {
            $table->integer('id_rentfacility')->length(11)->primary();
            $table->integer('id_rent')->length(11);
            $table->foreign('id_rent')->references('id_rent')->on('rents');
            $table->integer('quantity')->length(11);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentfacility');
    }
};
