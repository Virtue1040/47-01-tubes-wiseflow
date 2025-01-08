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
        Schema::create('tasks', function (Blueprint $table) {
            $table->integer("id_task", 1)->lenght(11)->primary();
            $table->integer("id_user")->lenght(11);
            $table->foreign('id_user')->references('id_user')->on('users');
            $table->string("task_name", 255);
            $table->string("task_desc");
            $table->integer("id_property")->lenght(11);
            $table->foreign('id_property')->references('id_property')->on('property');
            $table->integer("id_rent")->lenght(11);
            $table->foreign('id_rent')->references('id_rent')->on('rents');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
