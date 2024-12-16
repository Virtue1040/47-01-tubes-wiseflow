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
        Schema::create('property_comments', function (Blueprint $table) {
            $table->integer('id_property_commented', 1)->length(11)->primary();
            $table->integer('id_property')->length(11);
            $table->integer('id_user')->length(11);
            $table->integer('id_rent')->length(11);
            $table->text('comment');
            $table->integer('rating')->length(1);
            $table->foreign('id_property')->references('id_property')->on('property')->onDelete('cascade');
            $table->foreign('id_rent')->references('id_rent')->on('rents')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_comments');
    }
};
