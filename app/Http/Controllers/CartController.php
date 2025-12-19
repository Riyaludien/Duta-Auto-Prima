<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\PesananBaruBarang;
use App\Mail\NotifPesananAdminBarang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    // 1. Menampilkan halaman keranjang
    public function index()
    {
        $cartItems = Cart::with('barang')->where('user_id', Auth::id())->get();
        $total = $cartItems->sum(function ($item) {
            return $item->barang->harga * $item->jumlah;
        });

        return view('user.cart.index', compact('cartItems', 'total'));
    }

    // 2. FUNGSI YANG HILANG: Menambah barang ke keranjang
    public function add(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);
        $cart = Cart::where('user_id', Auth::id())->where('barang_id', $id)->first();

        if ($cart) {
            $cart->update(['jumlah' => $cart->jumlah + 1]);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'barang_id' => $id,
                'jumlah' => 1
            ]);
        }

        return redirect()->back()->with('success', 'Barang berhasil ditambah ke keranjang!');
    }

    // 3. FUNGSI YANG HILANG: Menghapus barang dari keranjang
    public function destroy($id)
    {
        $cart = Cart::where('user_id', Auth::id())->findOrFail($id);
        $cart->delete();
        return redirect()->back()->with('success', 'Barang dihapus dari keranjang.');
    }

    // 4. Proses Checkout
    public function checkout(Request $request)
    {
        // Validasi input tambahan
        $request->validate([
            'metode_pembayaran' => 'required',
            'no_wa' => 'required|numeric|min:10',
        ]);

        $userId = Auth::id();
        $user = Auth::user();
        $cartItems = Cart::with('barang')->where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Keranjang kosong!');
        }

        try {
            DB::transaction(function () use ($userId, $user, $cartItems, $request) {
                $total = $cartItems->sum(function ($item) {
                    return $item->barang->harga * $item->jumlah;
                });

                // Simpan Transaksi dengan tambahan metode & wa
                $transaksi = Transaksi::create([
                    'user_id' => $userId,
                    'total_harga' => $total,
                    'status' => 'Pending',
                    'metode_pembayaran' => $request->metode_pembayaran,
                    'no_wa' => $request->no_wa,
                ]);

                foreach ($cartItems as $item) {
                    DetailTransaksi::create([
                        'transaksi_id' => $transaksi->id,
                        'barang_id' => $item->barang_id,
                        'jumlah' => $item->jumlah,
                        'harga' => $item->barang->harga,
                    ]);
                    $item->barang->decrement('stok', $item->jumlah);
                }

                Cart::where('user_id', $userId)->delete();

                // Email (Trigger mailable yang sudah kita buat)
                Mail::to($user->email)->send(new PesananBaruBarang($transaksi));
                Mail::to('novieanramadan@gmail.com')->send(new NotifPesananAdminBarang($transaksi));
            });

            return redirect()->route('riwayat.index')->with('success', 'Pesanan berhasil dibuat! Admin akan segera menghubungi WhatsApp Anda.');

        } catch (\Exception $e) {
            Log::error('Error Checkout: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan. Coba lagi.');
        }
    }

}