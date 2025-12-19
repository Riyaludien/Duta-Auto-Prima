@extends('layouts.admin')

@section('title', 'Daftar Transaksi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Daftar Transaksi</h1>
    <a href="{{ route('transaksis.create') }}" class="btn btn-primary">+ Tambah</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <form method="GET" class="mb-3 row g-2 align-items-center">
            <div class="col-auto">
                <select name="user_id" class="form-select">
                    <option value="">-- Semua User --</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-auto">
                <select name="status" class="form-select">
                    <option value="">-- Semua Status --</option>
                    @foreach($statuses as $status)
                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-auto">
                <input type="date" name="date" class="form-control" value="{{ request('date') }}">
            </div>

            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('transaksis.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        <table class="table table-striped table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksis as $transaksi)
                <tr>
                    <td>{{ $transaksi->id }}</td>
                    <td>{{ $transaksi->user->name }}</td>
                    <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($transaksi->status) }}</td>
                    <td>{{ $transaksi->created_at->format('d-m-Y H:i') }}</td>
                    <td>
                        <a href="{{ route('transaksis.show', $transaksi->id) }}" class="btn btn-sm btn-info">Detail</a>
                        <a href="{{ route('transaksis.edit', $transaksi->id) }}" class="btn btn-sm btn-warning">Edit</a>

                        {{-- Tombol hapus pakai SweetAlert --}}
                        <form action="{{ route('transaksis.destroy', $transaksi->id) }}" method="POST" class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger btn-delete">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada transaksi</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{ $transaksis->links() }}
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const deleteButtons = document.querySelectorAll(".btn-delete");

        deleteButtons.forEach(button => {
            button.addEventListener("click", function(e) {
                const form = this.closest("form");

                Swal.fire({
                    title: "Yakin hapus transaksi?"
                    , text: "Data yang dihapus tidak dapat dikembalikan!"
                    , icon: "warning"
                    , showCancelButton: true
                    , confirmButtonColor: "#d33"
                    , cancelButtonColor: "#3085d6"
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
