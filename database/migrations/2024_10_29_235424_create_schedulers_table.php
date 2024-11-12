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
        Schema::create('scheduler', function (Blueprint $table) {
            $table->id('id_schedule');
            $table->integer('id_property')->length(11)->nullable();
            $table->foreign('id_property')->references('id_property')->on('property');
            $table->integer('id_user');
            $table->timestamp('schedule_date');
            $table->char('type_activity', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scheduler');
    }
};
