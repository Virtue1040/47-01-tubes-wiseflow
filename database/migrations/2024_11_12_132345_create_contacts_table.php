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
        Schema::create('contacts', function (Blueprint $table) {
            $table->integer("id_contact", 1)->length(11)->primary();
            $table->integer("id_user")->length(11);
            $table->foreign('id_user')->references('id_user')->on('users');
            $table->char("name", 255);
            $table->string('email');
            $table->char('no_hp', 30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
