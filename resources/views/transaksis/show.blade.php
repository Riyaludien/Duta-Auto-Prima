@extends('layouts.admin')

@section('title', 'Detail Transaksi')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg border-0 p-4" id="invoiceArea">
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
            <div>
                <h3 class="fw-bold mb-0 text-primary">CV Duta Auto Prima</h3>
                <small>Kasihan RT 07 Tamantirto, Kasih, Tamantirto, Kasihan, Bantul, Daerah Istimewa Yogyakarta 55183<br>Telp: 0857-4390-9369</small>
            </div>
            <div class="text-end">
                <h4 class="fw-bold text-uppercase mb-0">Invoice</h4>
                <small>No: <strong>{{ $transaksi->nomor_invoice }}</strong></small><br>
                <small>Tanggal: {{ $transaksi->created_at->format('d M Y H:i') }}</small>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <h6><strong>Kasir:</strong> {{ $transaksi->user->name ?? '-' }}</h6>
            </div>
            <div class="col-md-6 text-end">
                <h6>
                    <strong>Status:</strong>
                    <span class="badge 
                        @if($transaksi->status == 'pending') bg-warning
                        @elseif($transaksi->status == 'proses') bg-info
                        @else bg-success @endif">
                        {{ ucfirst($transaksi->status) }}
                    </span>
                </h6>
            </div>
        </div>

        <table class="table table-bordered table-striped align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Nama Barang</th>
                    <th style="width: 100px;">Jumlah</th>
                    <th style="width: 150px;">Harga Satuan</th>
                    <th style="width: 150px;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksi->details as $i => $detail)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $detail->barang->nama_barang }}</td>
                    <td class="text-center">{{ $detail->jumlah }}</td>
                    <td class="text-end">Rp {{ number_format($detail->barang->harga, 0, ',', '.') }}</td>
                    <td class="text-end">Rp {{ number_format($detail->barang->harga * $detail->jumlah, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>

            <tfoot>
                <tr class="fw-bold">
                    <td colspan="4" class="text-end">Total</td>
                    <td class="text-end text-success">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="text-end mt-4">
            <p class="small fst-italic">Terima kasih atas kepercayaan Anda 💙</p>
        </div>

        {{-- Tambahan QR Code --}}
        <div class="mt-4 text-center">
            <div class="qr-wrapper">
                <p class="mb-1 small text-muted">Scan untuk verifikasi transaksi</p>
                {!! QrCode::size(100)->generate(route('transaksis.show', $transaksi->id)) !!}
            </div>
        </div>
    </div>

    <div class="mt-3 d-flex justify-content-between">
        <a href="{{ route('transaksis.index') }}" class="btn btn-outline-secondary">⬅ Kembali</a>
        <button class="btn btn-primary" onclick="window.print()">🖨 Cetak Invoice</button>
    </div>
</div>

<style>
    .qr-wrapper {
        display: inline-block;
        padding: 10px 15px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    @media print {
        body * {
            visibility: hidden;
        }

        #invoiceArea,
        #invoiceArea * {
            visibility: visible;
        }

        #invoiceArea {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            padding: 20px;
        }

        .btn,
        .btn * {
            display: none !important;
        }
    }

</style>
@endsection
