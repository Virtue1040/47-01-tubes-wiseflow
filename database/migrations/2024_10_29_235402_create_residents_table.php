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
            $table->id('id_resident');
            $table->integer('id_user');
            $table->foreign('id_user')->references('id_user')->on('users');
            $table->integer('id_property');
            $table->foreign('id_property')->references('id_property')->on('property');
            $table->integer('id_role');
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
