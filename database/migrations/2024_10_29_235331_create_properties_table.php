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
        Schema::create('property', function (Blueprint $table) {
            $table->id('id_property');
            $table->integer('id_user_owner');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
        Schema::create('property_address', function (Blueprint $table) {
            $table->id('id_property');
            $table->string('street_name');
            $table->string('state');
            $table->string('province');
            $table->integer('zipcode');
            $table->string('country');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property');
        Schema::dropIfExists('property_address');
    }
};
