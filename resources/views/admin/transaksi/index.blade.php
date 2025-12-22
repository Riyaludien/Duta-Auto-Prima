@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">Daftar Pesanan Barang</h3>
            <p class="text-muted small">Kelola transaksi pembelian sparepart dan barang dari pelanggan di sini.</p>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 border-bottom">
            <h6 class="m-0 fw-bold text-primary">Data Transaksi</h6>
        </div>
        <div class="card-body p-0"> {{-- p-0 agar tabel penuh ke samping --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-muted small text-uppercase">
                            <th class="ps-3" style="width: 150px;">Invoice</th>
                            <th>Pelanggan</th>
                            <th>Item</th>
                            <th>Total</th>
                            <th class="text-center">Status</th>
                            <th class="text-center pe-3" style="width: 200px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksis as $trx)
                        <tr>
                            <td class="ps-3 fw-bold text-danger">{{ $trx->nomor_invoice }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $trx->user->name }}</div>
                                <div class="small text-muted">{{ $trx->no_wa }}</div>
                            </td>
                            <td>
                                <ul class="list-unstyled mb-0 small text-dark">
                                    @foreach($trx->details as $detail)
                                    <li>• {{ $detail->barang->nama_barang }} (x{{ $detail->jumlah }})</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="fw-bold text-dark">
                                Rp {{ number_format((float) $trx->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                @php
                                $badgeColor = [
                                'Selesai' => 'bg-success',
                                'Proses' => 'bg-primary',
                                'Pending' => 'bg-warning text-dark',
                                'Batal' => 'bg-danger'
                                ];
                                $currentBadge = $badgeColor[$trx->status] ?? 'bg-secondary';
                                @endphp
                                <span class="badge {{ $currentBadge }} fw-normal px-3">
                                    {{ $trx->status }}
                                </span>
                            </td>
                            <td class="pe-3">
                                <form action="{{ route('transaksi.update', $trx->id) }}" method="POST" class="d-flex justify-content-center align-items-center gap-2">
                                    @csrf @method('PUT')

                                    <select name="status" class="form-select form-select-sm" style="width: 125px;">
                                        <option value="Pending" {{ $trx->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Proses" {{ $trx->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                                        <option value="Selesai" {{ $trx->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="Batal" {{ $trx->status == 'Batal' ? 'selected' : '' }}>Batal</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary btn-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; flex-shrink: 0;">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted font-italic">Belum ada pesanan barang masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Jika Ada --}}
            @if($transaksis instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="d-flex justify-content-end p-3">
                {{ $transaksis->links('pagination::bootstrap-5') }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
