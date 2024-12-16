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
        Schema::create('residents', function (Blueprint $table) {
            $table->integer('id_resident', 1)->length(11)->primary();
            $table->integer('id_user');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');;
            $table->integer('id_property');
            $table->foreign('id_property')->references('id_property')->on('property')->onDelete('cascade');;
            $table->integer('id_rent');
            $table->foreign('id_rent')->references('id_rent')->on('rents')->onDelete('cascade');;
            $table->integer('id_booking');
            $table->foreign('id_booking')->references('id_booking')->on('bookings')->onDelete('cascade');;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};
