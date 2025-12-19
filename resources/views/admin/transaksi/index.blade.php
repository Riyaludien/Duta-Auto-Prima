@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <h2 class="fw-bold mb-4 text-white">PESANAN BARANG MASUK</h2>

    <div class="card bg-dark border-secondary shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle">
                    <thead>
                        <tr class="text-secondary">
                            <th>Invoice</th>
                            <th>Pelanggan</th>
                            <th>Item</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksis as $trx)
                        <tr>
                            <td class="fw-bold text-danger">{{ $trx->nomor_invoice }}</td>
                            <td>
                                <div class="text-white">{{ $trx->user->name }}</div>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $trx->no_wa) }}" class="small text-success text-decoration-none">
                                    <i class="bi bi-whatsapp"></i> {{ $trx->no_wa }}
                                </a>
                            </td>
                            <td>
                                <ul class="list-unstyled mb-0 small text-secondary">
                                    @foreach($trx->details as $detail)
                                        <li>• {{ $detail->barang->nama_barang }} (x{{ $detail->jumlah }})</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="text-white">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                            <td>
                                @php
                                    $badge = 'bg-warning';
                                    if($trx->status == 'Proses') $badge = 'bg-primary';
                                    if($trx->status == 'Selesai') $badge = 'bg-success';
                                    if($trx->status == 'Batal') $badge = 'bg-danger';
                                @endphp
                                <span class="badge {{ $badge }}">{{ $trx->status }}</span>
                            </td>
                            <td>
                                <form action="{{ route('transaksi.update', $trx->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <select name="status" onchange="this.form.submit()" class="form-select form-select-sm bg-black text-white border-secondary">
                                        <option value="Pending" {{ $trx->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Proses" {{ $trx->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                                        <option value="Selesai" {{ $trx->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="Batal" {{ $trx->status == 'Batal' ? 'selected' : '' }}>Batal</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">Belum ada pesanan barang masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection