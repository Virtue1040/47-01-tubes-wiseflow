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
            $table->integer('id_rentfacility', 1)->length(11)->primary();
            $table->integer('id_rent')->length(11);
            $table->foreign('id_rent')->references('id_rent')->on('rents')->onDelete('cascade');
            $table->integer('id_facility')->length(11);
            $table->foreign('id_facility')->references('id_facility')->on('facility')->onDelete('cascade');
            $table->integer('quantity')->length(11);
            $table->integer('item_order')->length(11);
            $table->timestamps();
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
