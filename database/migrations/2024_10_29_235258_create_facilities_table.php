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
        Schema::create('facility', function (Blueprint $table) {
            $table->integer('id_facility', 1)->length(11)->primary();
            $table->integer("id_property")->nullable()->length(11);
            $table->char('facility_name', 50);
            $table->char('facility_type', 25);
            $table->string('facility_desc');
            $table->char("facility_image", 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facility');
    }
};
