<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use App\Models\Barang;
use App\Models\LogStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailTransaksiController extends Controller
{
    // Lihat detail transaksi
    public function index(Transaksi $transaksi)
    {
        $transaksi->load(['detailTransaksis.barang', 'user']);
        return view('detail_transaksis.index', compact('transaksi'));
    }

    // Form tambah barang ke transaksi
    public function create(Transaksi $transaksi)
    {
        $barangs = Barang::all();
        return view('detail_transaksis.create', compact('transaksi', 'barangs'));
    }

    // Simpan barang baru ke transaksi
    public function store(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        // Buat detail transaksi
        $detail = DetailTransaksi::create([
            'transaksi_id' => $transaksi->id,
            'barang_id' => $barang->id,
            'jumlah' => $request->jumlah,
            'harga' => $barang->harga,
        ]);

        // Kurangi stok
        $barang->decrement('stok', $request->jumlah);

        // Buat log stok
        LogStok::create([
            'barang_id' => $barang->id,
            'user_id' => Auth::id(),
            'jumlah_perubahan' => -$request->jumlah,
            'keterangan' => 'Tambah barang ke Transaksi ID: '.$transaksi->id,
        ]);

        // Update total harga transaksi
        $transaksi->update([
            'total_harga' => $transaksi->total_harga + ($barang->harga * $request->jumlah)
        ]);

        return redirect()->route('detail_transaksis.index', $transaksi->id)
                         ->with('success', 'Barang berhasil ditambahkan ke transaksi!');
    }

    // Form edit jumlah barang di transaksi
    public function edit(Transaksi $transaksi, DetailTransaksi $detailTransaksi)
    {
        return view('detail_transaksis.edit', compact('transaksi', 'detailTransaksi'));
    }

    // Update jumlah barang di transaksi
    public function update(Request $request, Transaksi $transaksi, DetailTransaksi $detailTransaksi)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $oldJumlah = $detailTransaksi->jumlah;
        $diff = $request->jumlah - $oldJumlah;

        // Update jumlah
        $detailTransaksi->update([
            'jumlah' => $request->jumlah
        ]);

        // Update stok barang
        $barang = $detailTransaksi->barang;
        $barang->decrement('stok', $diff * ($diff > 0 ? 1 : -1));

        // Buat log stok
        LogStok::create([
            'barang_id' => $barang->id,
            'user_id' => Auth::id(),
            'jumlah_perubahan' => -$diff,
            'keterangan' => 'Update barang di Transaksi ID: '.$transaksi->id,
        ]);

        // Update total harga transaksi
        $transaksi->update([
            'total_harga' => $transaksi->detailTransaksis->sum(function($item){
                return $item->harga * $item->jumlah;
            })
        ]);

        return redirect()->route('detail_transaksis.index', $transaksi->id)
                         ->with('success', 'Jumlah barang berhasil diperbarui!');
    }

    // Hapus barang dari transaksi
    public function destroy(Transaksi $transaksi, DetailTransaksi $detailTransaksi)
    {
        $barang = $detailTransaksi->barang;
        $jumlah = $detailTransaksi->jumlah;

        // Kembalikan stok barang
        $barang->increment('stok', $jumlah);

        // Buat log stok
        LogStok::create([
            'barang_id' => $barang->id,
            'user_id' => Auth::id(),
            'jumlah_perubahan' => $jumlah,
            'keterangan' => 'Hapus barang dari Transaksi ID: '.$transaksi->id,
        ]);

        // Update total harga transaksi
        $transaksi->update([
            'total_harga' => $transaksi->total_harga - ($barang->harga * $jumlah)
        ]);

        $detailTransaksi->delete();

        return redirect()->route('detail_transaksis.index', $transaksi->id)
                         ->with('success', 'Barang berhasil dihapus dari transaksi!');
    }
}
