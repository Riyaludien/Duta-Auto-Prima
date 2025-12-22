@extends('layouts.admin')

@section('title', 'Daftar Barang')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">Manajemen Inventaris Barang</h3>
            <p class="text-muted small">Kelola stok sparepart, oli, dan perlengkapan Bengkel Momo.</p>
        </div>
        <a href="{{ route('barangs.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus me-1"></i> Tambah Barang
        </a>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="small fw-bold text-muted mb-1">Filter Kategori</label>
                    <select name="kategori_id" class="form-select form-select-sm">
                        <option value="">-- Semua Kategori --</option>
                        @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="small fw-bold text-muted mb-1">Cari Supplier</label>
                    <input type="text" name="supplier" class="form-control form-control-sm" placeholder="Nama supplier..." value="{{ request('supplier') }}">
                </div>

                <div class="col-md-4">
                    <button type="submit" class="btn btn-dark btn-sm px-3">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                    <a href="{{ route('barangs.index') }}" class="btn btn-light btn-sm px-3 border">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 border-bottom">
            <h6 class="m-0 fw-bold text-primary">Daftar Stok Barang</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-muted small text-uppercase">
                            <th class="ps-3" style="width: 50px;">No</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th class="text-center">Stok</th>
                            <th>Harga Jual</th>
                            <th>Supplier</th>
                            <th class="text-center pe-3" style="width: 160px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($barangs as $barang)
                        <tr>
                            <td class="ps-3 text-muted">{{ $loop->iteration + ($barangs->firstItem() - 1) }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $barang->nama_barang }}</div>
                                <div class="small text-muted">ID: #{{ $barang->id }}</div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border fw-normal">
                                    {{ $barang->kategori->nama_kategori ?? '-' }}
                                </span>
                            </td>
                            <td class="text-center">
                                @php
                                $stokClass = $barang->stok <= 5 ? 'badge bg-danger' : 'badge bg-info text-white' ; @endphp <span class="{{ $stokClass }} fw-normal px-3">
                                    {{ $barang->stok }}
                                    </span>
                            </td>
                            <td class="fw-bold text-dark">
                                Rp {{ number_format((float) $barang->harga, 0, ',', '.') }}
                            </td>
                            <td class="text-muted small">
                                {{ $barang->supplier ?? '-' }}
                            </td>
                            <td class="pe-3 text-center">
                                <div class="btn-group">
                                    <a href="{{ route('barangs.edit', $barang->id) }}" class="btn btn-outline-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('barangs.destroy', $barang->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-outline-danger btn-sm btn-delete" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">Belum ada data barang yang sesuai.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end p-3">
                {{ $barangs->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const deleteButtons = document.querySelectorAll(".btn-delete");
        deleteButtons.forEach(button => {
            button.addEventListener("click", function() {
                const form = this.closest("form");
                Swal.fire({
                    title: "Hapus Barang?"
                    , text: "Menghapus barang akan menghilangkan data stok ini!"
                    , icon: "warning"
                    , showCancelButton: true
                    , confirmButtonColor: "#d33"
                    , cancelButtonColor: "#6c757d"
                    , confirmButtonText: "Ya, hapus!"
                    , cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });

</script>
@endsection
