@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Riwayat Log Stok</h2>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form method="GET" class="mb-3 d-flex gap-2">
                <select name="barang_id" class="form-select">
                    <option value="">-- Semua Barang --</option>
                    @foreach($barangs as $barang)
                    <option value="{{ $barang->id }}" {{ request('barang_id') == $barang->id ? 'selected' : '' }}>
                        {{ $barang->nama_barang }}
                    </option>
                    @endforeach
                </select>

                <select name="user_id" class="form-select">
                    <option value="">-- Semua User --</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('log_stoks.index') }}" class="btn btn-secondary">Reset</a>
            </form>

            <table class="table table-striped table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Barang</th>
                        <th>User</th>
                        <th>Jumlah Perubahan</th>
                        <th>Keterangan</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td>{{ $log->barang->nama_barang }}</td>
                        <td>{{ $log->user->name }}</td>
                        <td>{{ $log->jumlah_perubahan }}</td>
                        <td>{{ $log->keterangan ?? '-' }}</td>
                        <td>{{ $log->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center mt-3">
                {{ $logs->withQueryString()->links('pagination::bootstrap-5') }}
            </div>

            <style>
                /* ✨ Biar pagination kelihatan rapi dan kecil */
                .pagination {
                    justify-content: center;
                    font-size: 0.9rem;
                }

                .pagination .page-item .page-link {
                    padding: 0.35rem 0.7rem;
                    border-radius: 8px;
                }

                .pagination .page-item.active .page-link {
                    background-color: #0d6efd;
                    border-color: #0d6efd;
                }

            </style>

        </div>
    </div>
</div>
@endsection
