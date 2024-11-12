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
        Schema::create('iurans', function (Blueprint $table) {
            $table->integer('id_iuran', 1)->lenght(11)->primary();
            $table->integer('id_property')->length(11);
            $table->foreign('id_property')->references('id_property')->on('property');
            $table->char('type_iuran', 20);
            $table->integer('nominal_iuran')->length(11);
            $table->timestamp('tanggal_iuran');
            $table->timestamp('tenggat_iuran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iurans');
    }
};
