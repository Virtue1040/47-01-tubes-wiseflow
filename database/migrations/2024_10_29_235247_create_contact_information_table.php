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
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');;
            $table->char('first_name', 50);
            $table->char('last_name', 50);
            $table->string('description', 255)->default('I’m passionate about connecting people with properties they love. Whether you’re looking for your dream home or an investment opportunity, I’m here to make your journey simple and enjoyable. Let’s explore great spaces together!');
            $table->char('gender', 10);
            $table->char('no_hp', 30);
            $table->string('email');
            $table->string('profilePath')->nullable();
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
