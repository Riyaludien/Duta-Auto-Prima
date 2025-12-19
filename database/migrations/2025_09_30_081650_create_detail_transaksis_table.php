<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_transaksis', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke transaksi
            $table->foreignId('transaksi_id')
                  ->constrained('transaksis')
                  ->onDelete('cascade');
            
            // Relasi ke barang
            $table->foreignId('barang_id')
                  ->constrained('barangs')
                  ->onDelete('cascade');
            
            $table->integer('jumlah');
            $table->decimal('harga', 12, 2); // Harga per barang saat transaksi dibuat

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_transaksis');
    }
};
