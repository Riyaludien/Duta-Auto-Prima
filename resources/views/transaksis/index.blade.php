@extends('layouts.admin')

@section('title', 'Daftar Transaksi')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">Riwayat Transaksi Kasir</h3>
            <p class="text-muted small">Pantau dan kelola seluruh transaksi POS (Point of Sales) di sini.</p>
        </div>
        <a href="{{ route('transaksis.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus me-1"></i> Tambah Transaksi
        </a>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="small fw-bold text-muted mb-1">Cari Pelanggan</label>
                    <select name="user_id" class="form-select form-select-sm select2-filter">
                        <option value="">-- Ketik Nama Pelanggan --</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="small fw-bold text-muted mb-1">Status</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="">-- Semua Status --</option>
                        @foreach($statuses as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="small fw-bold text-muted mb-1">Tanggal</label>
                    <input type="date" name="date" class="form-control form-control-sm" value="{{ request('date') }}">
                </div>

                <div class="col-md-3">
                    <button type="submit" class="btn btn-dark btn-sm px-3">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                    <a href="{{ route('transaksis.index') }}" class="btn btn-light btn-sm px-3 border">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 border-bottom">
            <h6 class="m-0 fw-bold text-primary">Data Transaksi</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-muted small text-uppercase">
                            <th class="ps-3" style="width: 80px;">ID</th>
                            <th>User</th>
                            <th>Total Harga</th>
                            <th class="text-center">Status</th>
                            <th>Tanggal</th>
                            <th class="text-center pe-3" style="width: 220px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksis as $transaksi)
                        <tr>
                            <td class="ps-3 text-muted">#{{ $transaksi->id }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $transaksi->user->name }}</div>
                            </td>
                            <td class="fw-bold text-dark">
                                Rp {{ number_format((float) $transaksi->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                @php
                                $statusBadge = [
                                'selesai' => 'bg-success',
                                'proses' => 'bg-primary',
                                'pending' => 'bg-warning text-dark',
                                'batal' => 'bg-danger'
                                ];
                                $badge = $statusBadge[strtolower($transaksi->status)] ?? 'bg-secondary';
                                @endphp
                                <span class="badge {{ $badge }} fw-normal px-3">
                                    {{ ucfirst($transaksi->status) }}
                                </span>
                            </td>
                            <td class="text-dark small">
                                {{ $transaksi->created_at->format('d/m/Y') }}<br>
                                <span class="text-muted">{{ $transaksi->created_at->format('H:i') }} WIB</span>
                            </td>
                            <td class="pe-3 text-center">
                                <div class="btn-group">
                                    <a href="{{ route('transaksis.show', $transaksi->id) }}" class="btn btn-outline-info btn-sm" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('transaksis.edit', $transaksi->id) }}" class="btn btn-outline-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('transaksis.destroy', $transaksi->id) }}" method="POST" class="d-inline delete-form">
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
                            <td colspan="6" class="text-center py-5 text-muted font-italic">Belum ada transaksi tercatat.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($transaksis instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="d-flex justify-content-end p-3">
                {{ $transaksis->links('pagination::bootstrap-5') }}
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
                    title: "Yakin hapus transaksi?"
                    , text: "Data yang dihapus tidak dapat dikembalikan!"
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

<script>
    $(document).ready(function() {
        $('.select2-filter').select2({
            placeholder: "-- Ketik Nama Pelanggan --"
            , allowClear: true
            , theme: "classic", // Atau hilangkan baris ini untuk tema default
            width: '100%' // Agar lebar mengikuti kolom Bootstrap
        });
    });

</script>
@endsection
