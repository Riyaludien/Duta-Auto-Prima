@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Edit Kategori</h2>

    <form action="{{ route('kategoris.update', $kategori->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Kategori</label>
            <input type="text" name="nama_kategori" class="form-control" value="{{ $kategori->nama_kategori }}" required>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3">{{ $kategori->deskripsi }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('kategoris.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
