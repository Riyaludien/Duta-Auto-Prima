<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Barang;
use App\Models\LogStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with(['user', 'details.barang']);

        // Filter berdasarkan user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $users = User::all(); // buat dropdown user
        $statuses = ['pending', 'proses', 'selesai']; // dropdown status

        $transaksis = $query->latest()->paginate(15)->withQueryString();

        return view('transaksis.index', compact('transaksis', 'users', 'statuses'));
    }



    public function create()
    {
        $barangs = Barang::all();
        return view('transaksis.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id.*' => 'required|exists:barangs,id',
            'jumlah.*' => 'required|integer|min:1',
        ]);

        // Hitung total harga
        $total_harga = 0;
        foreach ($request->barang_id as $i => $id) {
            $barang = Barang::findOrFail($id);
            $jumlah = $request->jumlah[$i];
            $total_harga += $barang->harga * $jumlah;
        }

        // Buat transaksi
        $transaksi = Transaksi::create([
            'user_id' => Auth::id(),
            'total_harga' => $total_harga,
            'status' => 'pending',
        ]);

        // Track barang yang sudah masuk
        $barangMap = [];

        foreach ($request->barang_id as $i => $id) {
            $barang = Barang::findOrFail($id);
            $jumlah = $request->jumlah[$i];

            // Jika barang sudah ada di transaksi, jumlah ditambah
            if (isset($barangMap[$id])) {
                $detail = $barangMap[$id];
                $detail->update([
                    'jumlah' => $detail->jumlah + $jumlah
                ]);
            } else {
                // Buat detail transaksi baru
                $detail = DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'barang_id' => $id,
                    'jumlah' => $jumlah,
                    'harga' => $barang->harga,
                ]);
                $barangMap[$id] = $detail;
            }

            // Kurangi stok barang
            $barang->decrement('stok', $jumlah);

            // Buat log stok
            LogStok::create([
                'barang_id' => $barang->id,
                'user_id' => Auth::id(),
                'jumlah_perubahan' => -$jumlah,
                'keterangan' => 'Transaksi ID: ' . $transaksi->id,
            ]);
        }

        return redirect()->route('transaksis.index')->with('success', 'Transaksi berhasil dibuat!');
    }


    public function show($id)
    {
        $transaksi = Transaksi::with(['user', 'details.barang'])->findOrFail($id);
        return view('transaksis.show', compact('transaksi'));
    }


    public function edit(Transaksi $transaksi)
    {
        $barangs = Barang::all();
        $transaksi->load('details');
        return view('transaksis.edit', compact('transaksi', 'barangs'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        // Update status transaksi saja
        $request->validate([
            'status' => 'required|in:pending,proses,selesai',
        ]);

        $transaksi->update([
            'status' => $request->status
        ]);

        return redirect()->route('transaksis.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy(Transaksi $transaksi)
    {
        // 🔁 Kembalikan stok barang sebelum hapus transaksi
        foreach ($transaksi->details as $detail) {
            $barang = $detail->barang;

            // Kembalikan stok
            $barang->increment('stok', $detail->jumlah);

            // Catat log stok
            LogStok::create([
                'barang_id' => $barang->id,
                'user_id' => Auth::id(),
                'jumlah_perubahan' => $detail->jumlah,
                'keterangan' => 'Hapus transaksi ID: ' . $transaksi->id,
            ]);
        }

        // 🔥 Hapus transaksi
        $transaksi->delete();

        // 🎉 Tampilkan toast notifikasi hapus
        return redirect()
            ->route('transaksis.index')
            ->with('deleted', 'Transaksi berhasil dihapus!');
    }



}
