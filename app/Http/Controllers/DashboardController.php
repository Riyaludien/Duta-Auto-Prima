<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\KategoriBarang;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total
        $totalBarang = \App\Models\Barang::count();
        $totalKategori = \App\Models\KategoriBarang::count();

        // Ambil data stok per kategori
        $stokPerKategori = \App\Models\KategoriBarang::withCount('barangs')
            ->withSum('barangs', 'stok')
            ->get(['id', 'nama_kategori']);

        // Ambil daftar barang terbaru
        $barangList = \App\Models\Barang::with('kategori')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('dashboard', [
            'totalBarang' => $totalBarang,
            'totalKategori' => $totalKategori,
            'stokPerKategori' => $stokPerKategori,
            'barangList' => $barangList
        ]);
    }


}
