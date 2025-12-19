<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi; // Tetap pakai Model Transaksi
use Illuminate\Http\Request;

class OrderBarangController extends Controller
{
    public function index()
    {
        // Mengambil semua transaksi barang
        $transaksis = Transaksi::with(['user', 'details.barang'])->latest()->get();
        return view('admin.transaksi.index', compact('transaksis'));
    }

    public function updateStatus(Request $request, $id)
    {
        $trx = Transaksi::findOrFail($id);
        $trx->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}