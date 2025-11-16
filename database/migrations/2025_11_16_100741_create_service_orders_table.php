<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_orders', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel service_items
            $table->unsignedBigInteger('service_item_id');
            $table->foreign('service_item_id')->references('id')->on('service_items')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            // Data pembeli
            $table->string('customer_name');
            $table->string('customer_phone', 20);
            $table->text('address');
            $table->text('note')->nullable();

            // Harga total
            $table->integer('total_price');

            // Bukti pembayaran
            $table->string('payment_proof')->nullable();

            // Status
            $table->enum('order_status', ['pending', 'processing', 'completed', 'canceled'])
                ->default('pending');

            $table->enum('payment_status', ['unpaid', 'waiting_verification', 'paid', 'rejected'])
                ->default('unpaid');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_orders');
    }
};
