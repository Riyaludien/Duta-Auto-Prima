<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\Booking;    // Tambahkan ini
use App\Models\Transaksi;  // Tambahkan ini

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Hitung total statistik utama
        $totalBarang = Barang::count();
        $totalKategori = KategoriBarang::count();
        
        // 2. Ambil data Booking Jasa dan Transaksi Barang
        $totalBooking = Booking::count();
        $totalTransaksi = Transaksi::count();

        // 3. Ambil data stok per kategori untuk Grafik
        $stokPerKategori = KategoriBarang::withCount('barangs')
            ->withSum('barangs', 'stok')
            ->get(['id', 'nama_kategori']);

        // 4. Ambil daftar barang terbaru (10 barang)
        $barangList = Barang::with('kategori')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Kirim semua variabel ke view 'dashboard'
        return view('dashboard', [
            'totalBarang' => $totalBarang,
            'totalKategori' => $totalKategori,
            'totalBooking' => $totalBooking,
            'totalTransaksi' => $totalTransaksi,
            'stokPerKategori' => $stokPerKategori,
            'barangList' => $barangList
        ]);
    }

    public function about()
    {
        return view('user.about.index');
    }
}