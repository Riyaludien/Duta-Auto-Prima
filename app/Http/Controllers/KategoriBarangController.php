<?php

namespace App\Http\Controllers;

use App\Models\KategoriBarang;
use Illuminate\Http\Request;

class KategoriBarangController extends Controller
{
    public function index(Request $request)
    {
        $query = KategoriBarang::query();

        if ($request->nama) {
            $query->where('nama_kategori', 'like', '%' . $request->nama . '%');
        }

        $kategoris = $query->paginate(15)->withQueryString();

        return view('kategoris.index', compact('kategoris'));
    }


    public function create()
    {
        return view('kategoris.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_barangs,nama_kategori',
            'deskripsi' => 'nullable|string',
        ]);

        KategoriBarang::create($request->all());

        return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(KategoriBarang $kategori)
    {
        return view('kategoris.edit', compact('kategori'));
    }

    public function update(Request $request, KategoriBarang $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_barangs,nama_kategori,' . $kategori->id,
            'deskripsi' => 'nullable|string',
        ]);

        $kategori->update($request->all());

        return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(KategoriBarang $kategori)
    {
        $kategori->delete();

        return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
