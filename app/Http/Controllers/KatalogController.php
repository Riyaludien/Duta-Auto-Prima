<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\KategoriBarang;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::with('kategori');

        if ($request->kategori) {
            $query->where('kategori_id', $request->kategori);
        }

        if ($request->min) {
            $query->where('harga', '>=', $request->min);
        }

        if ($request->max) {
            $query->where('harga', '<=', $request->max);
        }

        $barangs = $query->latest()->paginate(12)->withQueryString();
        $kategoris = KategoriBarang::all();

        return view('user.katalog.index', compact('barangs', 'kategoris'));
    }

}
