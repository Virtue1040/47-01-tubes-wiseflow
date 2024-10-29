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
        Schema::create('contactinformation', function (Blueprint $table) {
            $table->id('id_role');
            $table->char('first_name', 50);
            $table->char('last_name', 50);
            $table->char('no_hp', 18);
            $table->string('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contactinformation');
    }
};
