@extends('layouts.admin')

@section('title', 'Kategori Barang')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">Master Kategori</h3>
            <p class="text-muted small">Kelola pengelompokan jenis barang agar inventaris lebih terorganisir.</p>
        </div>
        <a href="{{ route('kategoris.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus me-1"></i> Tambah Kategori
        </a>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label class="small fw-bold text-muted mb-1">Cari Nama Kategori</label>
                    <input type="text" name="nama" class="form-control form-control-sm" placeholder="Ketik nama kategori..." value="{{ request('nama') }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-dark btn-sm px-3">
                        <i class="fas fa-search me-1"></i> Cari
                    </button>
                    <a href="{{ route('kategoris.index') }}" class="btn btn-light btn-sm px-3 border">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 border-bottom">
            <h6 class="m-0 fw-bold text-primary">Daftar Kategori</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-muted small text-uppercase">
                            <th class="ps-3" style="width: 80px;">No</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th class="text-center pe-3" style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kategoris as $kategori)
                        <tr>
                            <td class="ps-3 text-muted">{{ $loop->iteration + ($kategoris->firstItem() - 1) }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $kategori->nama_kategori }}</div>
                            </td>
                            <td class="text-muted small">
                                {{ $kategori->deskripsi ?? '-' }}
                            </td>
                            <td class="pe-3 text-center">
                                <div class="btn-group">
                                    <a href="{{ route('kategoris.edit', $kategori->id) }}" class="btn btn-outline-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('kategoris.destroy', $kategori->id) }}" method="POST" class="d-inline delete-form">
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
                            <td colspan="4" class="text-center py-5 text-muted font-italic">Belum ada kategori barang.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end p-3">
                {{ $kategoris->links('pagination::bootstrap-5') }}
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
                    title: "Hapus Kategori?"
                    , text: "Menghapus kategori mungkin akan berdampak pada barang yang terkait!"
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
