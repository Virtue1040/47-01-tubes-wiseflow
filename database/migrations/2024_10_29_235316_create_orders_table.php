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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('orderNumber');
            $table->integer('id_user');
            $table->timestamp('created_at');
            $table->char('status_order', 10);
        });

        Schema::create('orderdetails', function (Blueprint $table) {
            $table->id('orderNumber');
            $table->char('checkNumber', 50)->unique();
            $table->char('status_order', 10);
            $table->char('type_order', 20);
            $table->bigInteger('total_order');
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id('checkNumber');
            $table->char('id_transaction', 50)->unique();
            $table->bigInteger('nominal');
            $table->char('status_payment', 10);
            $table->char('type_payment', 20);
            $table->timestamp('payment_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('orderdetails');
        Schema::dropIfExists('payments');
    }
};
