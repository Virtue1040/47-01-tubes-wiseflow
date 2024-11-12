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
        Schema::create('bookings', function (Blueprint $table) {
            $table->integer("id_booking", 1)->length(11)->primary();
            $table->integer("id_user")->length(11);
            $table->foreign('id_user')->references('id_user')->on('users');
            $table->integer('id_property')->length(11);
            $table->foreign('id_property')->references('id_property')->on('property');
            $table->char('status')->length(10);
            $table->timestamp('checkin');
            $table->timestamp('checkout');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
