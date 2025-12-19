<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('barangs')->insert([
            [
                'nama_barang' => 'Oli Mesin Castrol 1L',
                'kategori_id' => 1,
                'stok' => 50,
                'harga' => 85000,
                'supplier' => 'PT Castrol Indonesia',
            ],
            [
                'nama_barang' => 'Busi NGK BPR6ES',
                'kategori_id' => 2,
                'stok' => 100,
                'harga' => 25000,
                'supplier' => 'PT NGK Indonesia',
            ],
            [
                'nama_barang' => 'Wiper Bosch Clear Advantage',
                'kategori_id' => 3,
                'stok' => 30,
                'harga' => 75000,
                'supplier' => 'Bosch Automotive',
            ],
        ]);
    }
}
