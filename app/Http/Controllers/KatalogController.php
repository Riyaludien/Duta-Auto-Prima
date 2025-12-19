<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\KategoriBarang;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        // Gunakan query builder
        $query = Barang::with('kategori');

        // Gunakan filled() untuk memastikan input tidak kosong/null
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        if ($request->filled('min')) {
            $query->where('harga', '>=', $request->min);
        }

        if ($request->filled('max')) {
            $query->where('harga', '<=', $request->max);
        }

        // Tambahkan fitur search jika ingin pencarian dari navbar berfungsi di sini
        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        $barangs = $query->latest()->paginate(12)->withQueryString();
        $kategoris = KategoriBarang::all();

        return view('user.katalog.index', compact('barangs', 'kategoris'));
    }

}
