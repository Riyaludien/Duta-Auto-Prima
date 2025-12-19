@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h2>Tambah Barang</h2>

        <form action="{{ route('barangs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label>Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang') }}" required>
            </div>

            <div class="mb-3">
                <label>Kategori</label>
                <select name="kategori_id" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}">
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Stok</label>
                <input type="number" name="stok" class="form-control" value="0" required>
            </div>

            <div class="mb-3">
                <label>Harga</label>
                <input type="number" name="harga" class="form-control" value="0" required>
            </div>

            <div class="mb-3">
                <label>Supplier</label>
                <input type="text" name="supplier" class="form-control" value="{{ old('supplier') }}">
            </div>

            <div class="mb-3">
                <label>Gambar Barang</label>
                <input type="file" name="gambar" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('barangs.index') }}" class="btn btn-secondary">Batal</a>
        </form>

    </div>
@endsection