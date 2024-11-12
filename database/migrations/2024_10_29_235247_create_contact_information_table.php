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
        Schema::create('contact_information', function (Blueprint $table) {
            $table->integer('id_user')->length(11)->primary();
            $table->foreign('id_user')->references('id_user')->on('users');
            $table->char('first_name', 50);
            $table->char('last_name', 50);
            $table->char('gender', 10);
            $table->char('no_hp', 30);
            $table->string('email');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_information');
    }
};
