<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    // Tambahkan baris ini agar user_id, barang_id, dan jumlah bisa disimpan
    protected $fillable = [
        'user_id',
        'barang_id',
        'jumlah',
    ];

    // Tambahkan relasi agar bisa panggil nama barang di view keranjang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}