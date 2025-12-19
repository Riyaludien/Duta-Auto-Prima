@extends('layouts.admin')

@section('title', 'Kategori Barang')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Kategori Barang</h1>
    <a href="{{ route('kategoris.create') }}" class="btn btn-primary">+ Tambah</a>
</div>

@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-body">
        <form method="GET" class="mb-3 d-flex gap-2">
            <input type="text" name="nama" class="form-control" placeholder="Cari Kategori" value="{{ request('nama') }}">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('kategoris.index') }}" class="btn btn-secondary">Reset</a>
        </form>

        <table class="table table-striped table-hover align-middle">
            <thead class="table-primary">
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kategoris as $kategori)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $kategori->nama_kategori }}</td>
                    <td>{{ $kategori->deskripsi ?? '-' }}</td>
                    <td>
                        <a href="{{ route('kategoris.edit', $kategori->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('kategoris.destroy', $kategori->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau hapus kategori ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada kategori.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{ $kategoris->links() }}
    </div>
    @endsection
