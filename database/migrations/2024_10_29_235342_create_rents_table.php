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
        Schema::create('rents', function (Blueprint $table) {
            $table->integer('id_rent')->length(11)->primary();
            $table->integer('id_property')->length(11);
            $table->foreign('id_property')->references('id_property')->on('property');
            $table->char('rent_name', 50);
            $table->string('rent_description');
            $table->bigInteger('rent_price');
            $table->integer('stock')->length(11);
            $table->boolean('availability');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rents');
    }
};
