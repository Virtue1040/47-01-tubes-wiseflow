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
        Schema::create('rentalbums', function (Blueprint $table) {
            $table->integer('id_album', 1)->length(11)->primary();
            $table->integer('id_rent')->length(11);
            $table->foreign('id_rent')->references('id_rent')->on('rents')->onDelete('cascade');
            $table->string('imagePath');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentalbums');
    }
};
