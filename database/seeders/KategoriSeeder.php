<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kategori_barangs')->insert([
            ['nama_kategori' => 'Oli & Pelumas', 'deskripsi' => 'Berbagai jenis oli kendaraan.'],
            ['nama_kategori' => 'Sparepart Mesin', 'deskripsi' => 'Komponen untuk perbaikan mesin.'],
            ['nama_kategori' => 'Aksesoris Mobil', 'deskripsi' => 'Aksesoris interior dan eksterior mobil.'],
        ]);
    }
}
