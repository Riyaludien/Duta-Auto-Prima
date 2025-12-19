@extends('layouts.user')

@section('title', 'Riwayat Transaksi - Bengkel Momo')

@section('content')

{{-- CSS KHUSUS HALAMAN INI --}}
<style>
    /* Hero Header Kecil */
    .page-header {
        background: linear-gradient(to right, #000000, #1a0505);
        padding: 40px 0;
        border-bottom: 2px solid var(--primary-red);
        margin-bottom: 30px;
    }

    /* Filter Tabs */
    .nav-pills .nav-link {
        color: var(--text-muted);
        background: transparent;
        border: 1px solid #333;
        border-radius: 50px;
        padding: 8px 20px;
        margin-right: 10px;
        transition: 0.3s;
    }

    .nav-pills .nav-link.active,
    .nav-pills .nav-link:hover {
        background-color: var(--primary-red);
        border-color: var(--primary-red);
        color: white;
    }

    /* Kartu Transaksi */
    .transaksi-card {
        background-color: var(--surface-dark);
        border: 1px solid var(--border-dark);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        transition: 0.3s;
        position: relative;
        overflow: hidden;
    }

    .transaksi-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 20px rgba(255, 0, 0, 0.1);
        border-color: #555;
    }

    /* Garis Status di Kiri Kartu */
    .border-status-selesai {
        border-left: 5px solid #2ECC71;
    }

    /* Hijau */
    .border-status-proses {
        border-left: 5px solid #3498DB;
    }

    /* Biru */
    .border-status-batal {
        border-left: 5px solid #E74C3C;
    }

    /* Merah */
    .border-status-pending {
        border-left: 5px solid #F1C40F;
    }

    /* Kuning */

    .text-price {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--primary-red);
    }

    .badge-status {
        font-size: 0.8rem;
        padding: 5px 12px;
        border-radius: 20px;
    }

    /* Kosong State */
    .empty-state {
        text-align: center;
        padding: 50px 20px;
        color: var(--text-muted);
    }

    .empty-icon {
        font-size: 4rem;
        color: #333;
        margin-bottom: 20px;
    }

</style>

{{-- HEADER --}}
<section class="page-header">
    <div class="container">
        <h2 class="fw-bold text-white mb-0">Riwayat Transaksi</h2>
        <p class="text-muted small mb-0">Pantau status servis dan riwayat belanja Baginda di sini.</p>
    </div>
</section>

<div class="container mb-5">

    {{-- FILTER BUTTONS --}}
    <div class="d-flex gap-2 mb-4 overflow-auto pb-2">
        <a href="{{ route('riwayat.index') }}" class="btn btn-sm rounded-pill px-4 {{ !request('status') ? 'btn-primary' : 'btn-outline-secondary' }}">
            Semua
        </a>

        <a href="{{ route('riwayat.index', ['status' => 'Menunggu']) }}" class="btn btn-sm rounded-pill px-4 {{ request('status') == 'Menunggu' ? 'btn-warning text-white' : 'btn-outline-secondary' }}">
            Menunggu
        </a>

        <a href="{{ route('riwayat.index', ['status' => 'Proses']) }}" class="btn btn-sm rounded-pill px-4 {{ request('status') == 'Proses' ? 'btn-primary' : 'btn-outline-secondary' }}">
            Diproses
        </a>

        <a href="{{ route('riwayat.index', ['status' => 'Selesai']) }}" class="btn btn-sm rounded-pill px-4 {{ request('status') == 'Selesai' ? 'btn-success' : 'btn-outline-secondary' }}">
            Selesai
        </a>

        <a href="{{ route('riwayat.index', ['status' => 'Batal']) }}" class="btn btn-sm rounded-pill px-4 {{ request('status') == 'Batal' ? 'btn-danger' : 'btn-outline-secondary' }}">
            Batal
        </a>
    </div>

    {{-- LIST TRANSAKSI --}}
    {{-- NAV TABS --}}
    <ul class="nav nav-pills mb-4 gap-2" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-jasa-tab" data-bs-toggle="pill" data-bs-target="#tab-jasa" type="button" role="tab">
                <i class="bi bi-tools me-1"></i> Servis & Jasa
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-barang-tab" data-bs-toggle="pill" data-bs-target="#tab-barang" type="button" role="tab">
                <i class="bi bi-box-seam me-1"></i> Pembelian Barang
            </button>
        </li>
    </ul>

    <div class="tab-content" id="pills-tabContent">

        {{-- TAB 1: RIWAYAT JASA (KODE ASLI KAMU) --}}
        <div class="tab-pane fade show active" id="tab-jasa" role="tabpanel">
            <div class="row">
                @forelse($bookings as $item)
                {{-- Logika Warna Status Jasa --}}
                @php
                $statusColor = 'warning'; $borderColor = 'border-status-pending';
                if($item->status == 'Proses') { $statusColor = 'primary'; $borderColor = 'border-status-proses'; }
                elseif($item->status == 'Selesai') { $statusColor = 'success'; $borderColor = 'border-status-selesai'; }
                elseif($item->status == 'Batal') { $statusColor = 'danger'; $borderColor = 'border-status-batal'; }
                @endphp

                <div class="col-12 mb-3">
                    <div class="transaksi-card {{ $borderColor }}">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <span class="badge bg-{{ $statusColor }} badge-status mb-2">{{ $item->status }}</span>
                                <h5 class="fw-bold text-white mb-1">{{ $item->item_name }}</h5>
                                <small class="text-muted">INV/JASA/{{ $item->created_at->format('Ymd') }}/{{ $item->id }}</small>
                            </div>
                            <div class="text-end">
                                <small class="text-muted d-block">Total Biaya</small>
                                <span class="text-price">{{ $item->item_price }}</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            @if($item->status == 'Menunggu')
                            <form action="{{ route('riwayat.cancel', $item->id) }}" method="POST" class="delete-confirm">
                                @csrf @method('PUT')
                                <button class="btn btn-sm btn-outline-danger rounded-pill px-3">Batalkan</button>
                            </form>
                            @endif
                            <a href="https://wa.me/6283838762064" class="btn btn-sm btn-outline-success rounded-pill px-3">Hubungi Admin</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <i class="bi bi-calendar-x empty-icon"></i>
                    <h5 class="text-white">Belum ada riwayat jasa</h5>
                </div>
                @endforelse
            </div>
        </div>

        {{-- TAB 2: RIWAYAT BARANG (YANG BARU) --}}
        <div class="tab-pane fade" id="tab-barang" role="tabpanel">
            <div class="row">
                @forelse($transaksis as $trx)
                <div class="col-12 mb-3">
                    <div class="transaksi-card border-status-proses">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <span class="badge bg-primary badge-status mb-2">{{ $trx->status }}</span>
                                <h5 class="fw-bold text-white mb-1">{{ $trx->nomor_invoice }}</h5>
                                <small class="text-muted">Dipesan pada {{ $trx->created_at->format('d M Y H:i') }}</small>
                            </div>
                            <div class="text-end">
                                <small class="text-muted d-block">Total Belanja</small>
                                <span class="text-price">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        {{-- Daftar Item Barang --}}
                        <div class="bg-black p-3 rounded mb-3 border border-secondary border-opacity-25">
                            @foreach($trx->details as $detail)
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <small class="text-white">{{ $detail->barang->nama_barang }} (x{{ $detail->jumlah }})</small>
                                <small class="text-muted">Rp {{ number_format($detail->harga * $detail->jumlah, 0, ',', '.') }}</small>
                            </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="https://wa.me/6283838762064?text=Halo%20Admin,%20saya%20mau%20tanya%20pesanan%20{{ $trx->nomor_invoice }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-4">
                                <i class="bi bi-whatsapp"></i> Tanya Admin
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <i class="bi bi-cart-x empty-icon"></i>
                    <h5 class="text-white">Belum ada riwayat belanja</h5>
                    <a href="{{ route('katalog.index') }}" class="btn btn-danger rounded-pill mt-3 px-4">Ke Katalog</a>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
