@extends('layouts.admin')

@section('title', 'Daftar Supplier')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">Daftar Supplier</h3>
            <p class="text-muted small">Kelola data mitra penyedia barang dan sparepart Bengkel Momo.</p>
        </div>
        <a href="{{ route('suppliers.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus me-1"></i> Tambah Supplier
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 border-bottom">
            <h6 class="m-0 fw-bold text-primary">Data Mitra Supplier</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-muted small text-uppercase">
                            <th class="ps-3" style="width: 80px;">ID</th>
                            <th>Nama Supplier</th>
                            <th>Kontak</th>
                            <th>Alamat</th>
                            <th class="text-center pe-3" style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suppliers as $supplier)
                        <tr>
                            <td class="ps-3 text-muted">#{{ $supplier->id }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $supplier->nama_supplier }}</div>
                            </td>
                            <td>
                                <div class="text-dark small">
                                    <i class="fas fa-phone-alt me-1 text-muted"></i> {{ $supplier->kontak ?? '-' }}
                                </div>
                            </td>
                            <td>
                                <div class="text-muted small text-truncate" style="max-width: 250px;">
                                    {{ $supplier->alamat ?? '-' }}
                                </div>
                            </td>
                            <td class="pe-3 text-center">
                                <div class="btn-group">
                                    <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-outline-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="d-inline delete-form">
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
                            <td colspan="5" class="text-center py-5 text-muted font-italic">Belum ada data supplier.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($suppliers instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="d-flex justify-content-end p-3">
                {{ $suppliers->links('pagination::bootstrap-5') }}
            </div>
            @endif
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
                    title: "Hapus Supplier?"
                    , text: "Data supplier ini akan dihapus secara permanen!"
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
