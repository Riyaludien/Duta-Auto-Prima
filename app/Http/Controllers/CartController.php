<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // tambah barang ke cart
    public function add($barang_id)
    {
        $cart = Cart::where('user_id', Auth::id())
            ->where('barang_id', $barang_id)
            ->first();

        if ($cart) {
            $cart->qty += 1;
            $cart->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'barang_id' => $barang_id,
                'qty' => 1,
            ]);
        }

        return back()->with('success', 'Produk ditambahkan ke keranjang');
    }

    // lihat isi cart
    public function index()
    {
        $carts = Cart::where('user_id', Auth::id())->get();
        return view('cart.index', compact('carts'));
    }
}

