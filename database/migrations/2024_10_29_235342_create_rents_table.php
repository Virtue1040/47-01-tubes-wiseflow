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
        Schema::create('rents', function (Blueprint $table) {
            $table->integer('id_rent', 1)->length(11)->primary();
            $table->integer('id_property')->length(11);
            $table->foreign('id_property')->references('id_property')->on('property')->onDelete('cascade');;
            $table->char('rent_name', 50);
            $table->string('rent_desc');
            $table->bigInteger('rent_price');
            $table->char('rent_tag', 30)->nullable();
            $table->integer('stock')->length(11);
            $table->boolean('availability');
            $table->integer('id_cover')->nullable()->length(11);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rents');
    }
};
