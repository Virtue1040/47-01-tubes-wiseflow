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
        Schema::create('renttags', function (Blueprint $table) {
            $table->integer('id_tag', 1)->length(11);
            $table->integer('id_rent')->length(11);
            $table->foreign('id_rent')->references('id_rent')->on('rents')->onDelete('cascade');;
            $table->char('tag', 30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('renttags');
    }
};
