@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Tambah Kategori</h2>

    <form action="{{ route('kategoris.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nama Kategori</label>
            <input type="text" name="nama_kategori" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('kategoris.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
