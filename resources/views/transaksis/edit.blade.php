@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Edit Transaksi #{{ $transaksi->id }}</h2>

    <form action="{{ route('transaksis.update', $transaksi->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select" required>
                <option value="pending" {{ $transaksi->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="proses" {{ $transaksi->status == 'proses' ? 'selected' : '' }}>Proses</option>
                <option value="selesai" {{ $transaksi->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('transaksis.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
