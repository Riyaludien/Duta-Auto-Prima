@extends('layouts.admin')

@section('title', 'Riwayat Log Stok')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">Riwayat Log Stok</h3>
            <p class="text-muted small">Pantau setiap perubahan stok barang masuk dan keluar secara real-time.</p>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="small fw-bold text-muted mb-1">Pilih Barang</label>
                    <select name="barang_id" class="form-select form-select-sm select2-filter">
                        <option value="">-- Semua Barang --</option>
                        @foreach($barangs as $barang)
                        <option value="{{ $barang->id }}" {{ request('barang_id') == $barang->id ? 'selected' : '' }}>
                            {{ $barang->nama_barang }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="small fw-bold text-muted mb-1">Admin/User</label>
                    <select name="user_id" class="form-select form-select-sm">
                        <option value="">-- Semua User --</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <button type="submit" class="btn btn-dark btn-sm px-3">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                    <a href="{{ route('log_stoks.index') }}" class="btn btn-light btn-sm px-3 border">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 border-bottom">
            <h6 class="m-0 fw-bold text-primary">Data Log Stok</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-muted small text-uppercase">
                            <th class="ps-3" style="width: 80px;">ID</th>
                            <th>Barang</th>
                            <th>Oleh User</th>
                            <th class="text-center">Perubahan</th>
                            <th>Keterangan</th>
                            <th class="pe-3">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td class="ps-3 text-muted">#{{ $log->id }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $log->barang->nama_barang }}</div>
                                <div class="small text-muted">Kategori: {{ $log->barang->kategori->nama_kategori ?? '-' }}</div>
                            </td>
                            <td>
                                <div class="text-dark">{{ $log->user->name }}</div>
                            </td>
                            <td class="text-center">
                                @php
                                $isPositive = $log->jumlah_perubahan > 0;
                                @endphp
                                <span class="badge {{ $isPositive ? 'bg-success' : 'bg-danger' }} fw-normal px-2">
                                    {{ $isPositive ? '+' : '' }}{{ $log->jumlah_perubahan }}
                                </span>
                            </td>
                            <td class="text-muted small">
                                {{ $log->keterangan ?? '-' }}
                            </td>
                            <td class="pe-3 text-dark small">
                                {{ $log->created_at->format('d/m/Y') }}<br>
                                <span class="text-muted">{{ $log->created_at->format('H:i') }} WIB</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted font-italic">Belum ada riwayat log stok.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end p-3">
                {{ $logs->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Jika Baginda sudah memasang Select2 di layout admin
        $('.select2-filter').select2({
            theme: "bootstrap-5"
            , width: '100%'
            , placeholder: "-- Cari Barang --"
        });
    });

</script>
@endsection
