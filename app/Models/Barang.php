<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barangs';
    protected $fillable = [
        'nama_barang',
        'kategori_id',
        'stok',
        'harga',
        'supplier',
        'gambar',
    ];

    // Relasi ke kategori
    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'kategori_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function logStoks()
    {
        return $this->hasMany(LogStok::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
