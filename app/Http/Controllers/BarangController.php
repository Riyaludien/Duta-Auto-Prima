<?php

namespace App\Http\Controllers;

use App\Models\LogStok;
use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::with('kategori');

        if ($request->kategori_id) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->supplier) {
            $query->where('supplier', 'like', '%' . $request->supplier . '%');
        }

        $barangs = $query->paginate(15)->withQueryString();
        $kategoris = KategoriBarang::all();

        return view('barangs.index', compact('barangs', 'kategoris'));
    }


    public function create()
    {
        $kategoris = KategoriBarang::all();
        $suppliers = Supplier::all();
        return view('barangs.create', compact('kategoris', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_barangs,id',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // ✅ TAMBAH INI
        ]);

        // ambil semua data lama (AMAN)
        $data = $request->all();

        // handle upload gambar (OPSIONAL, TIDAK GANGGU YG LAIN)
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('barangs', 'public');
        }

        // buat barang baru
        $barang = Barang::create($data);

        // log stok tetap jalan seperti semula
        if ($barang->stok > 0) {
            LogStok::create([
                'barang_id' => $barang->id,
                'user_id' => Auth::id(),
                'jumlah_perubahan' => $barang->stok,
                'keterangan' => 'Tambah barang',
            ]);
        }

        return redirect()
            ->route('barangs.index')
            ->with('success', 'Barang berhasil ditambahkan!');
    }

    public function edit(Barang $barang)
    {
        $kategoris = KategoriBarang::all();
        $suppliers = Supplier::all();
        return view('barangs.edit', compact('barang', 'kategoris', 'suppliers'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_barangs,id',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'supplier_id' => 'nullable|exists:suppliers,id',
        ]);

        $oldStok = $barang->stok;
        $barang->update($request->all());

        // Buat log jika stok berubah
        $diff = $barang->stok - $oldStok;
        if ($diff != 0) {
            LogStok::create([
                'barang_id' => $barang->id,
                'user_id' => Auth::id(),
                'jumlah_perubahan' => $diff,
                'keterangan' => 'Update stok',
            ]);
        }

        return redirect()->route('barangs.index')->with('success', 'Barang berhasil diperbarui!');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();

        return redirect()->route('barangs.index')->with('success', 'Barang berhasil dihapus!');
    }
}
