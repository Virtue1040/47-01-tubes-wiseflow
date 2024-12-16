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
            $table->integer('id_property', 1)->length(11)->primary();
            $table->integer('id_user_owner');
            $table->foreign('id_user_owner')->references('id_user')->on('users')->onDelete('cascade');;
            $table->char('property_name', 255);
            $table->string('property_desc');
            $table->char('property_category', 30);
            $table->char('property_tag', 30)->nullable();
            $table->integer('property_bank')->default('0');
            $table->integer('id_cover')->nullable()->length(11);
            // $table->foreign('id_cover')->references('id_album')->on('albums');
            $table->timestamps();
        });
        Schema::create('property_contact', function (Blueprint $table) {
            $table->id();
            $table->integer('id_property');
            $table->foreign('id_property')->references('id_property')->on('property')->onDelete('cascade');
            $table->char('contact_name', 255);
            $table->char('contact_phone', 30);
            $table->timestamps();
        });
        Schema::create('property_address', function (Blueprint $table) {
            $table->integer('id_property')->primary();
            $table->foreign('id_property')->references('id_property')->on('property')->onDelete('cascade');
            $table->string('street_name');
            $table->string('state');
            $table->string('province');
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->integer('zipcode');
            $table->string('country');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property');
        Schema::dropIfExists('property_address');
        Schema::dropIfExists('property_contact');
    }
};
