<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            // Menyimpan ID User jika dia login (bisa null jika tamu)
            $table->unsignedBigInteger('user_id')->nullable();

            // Data Pemesan
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');

            // Data Layanan
            $table->string('item_name'); // Nama Jasa/Barang
            $table->string('item_code')->nullable(); // Kode Jasa
            $table->string('item_price'); // Harga (masih string karena format Rp)

            // Status & Tanggal
            $table->date('booking_date');
            $table->string('status')->default('Menunggu'); // Menunggu, Proses, Selesai

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
