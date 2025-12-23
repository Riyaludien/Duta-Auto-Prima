@extends('layouts.user')

@section('title', 'Riwayat Transaksi - Bengkel Momo')

@section('content')

{{-- CSS KHUSUS HALAMAN INI --}}
<style>
    :root {
        --primary-red: #ff0000;
        --surface-dark: #1c1c1c;
        --border-dark: #333;
        --text-muted: #888;
        --bg-jasa: #0dcaf0;
        --bg-barang: #dc3545;
    }

    .page-header {
        background: linear-gradient(to right, #000000, #1a0505);
        padding: 40px 0;
        border-bottom: 2px solid var(--primary-red);
        margin-bottom: 30px;
    }

    /* Filter Group Styling */
    .filter-section {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .filter-group {
        display: flex;
        gap: 10px;
        flex-wrap: nowrap;
        overflow-x: auto;
        padding-bottom: 5px;
        -webkit-overflow-scrolling: touch;
    }

    .filter-group::-webkit-scrollbar {
        display: none;
    }

    .btn-filter {
        border-radius: 50px;
        padding: 6px 20px;
        font-size: 0.85rem;
        transition: 0.3s;
        border: 1px solid #444;
        color: white;
        background: transparent;
        white-space: nowrap;
        text-decoration: none;
    }

    .btn-filter.active {
        background-color: var(--primary-red);
        border-color: var(--primary-red);
        color: white;
    }

    .btn-filter:hover:not(.active) {
        border-color: #777;
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
    }

    .transaksi-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 20px rgba(255, 0, 0, 0.1);
    }

    .type-badge {
        font-size: 0.7rem;
        text-transform: uppercase;
        font-weight: bold;
        letter-spacing: 0.5px;
        padding: 4px 12px;
        border-radius: 50px;
        margin-bottom: 10px;
        display: inline-block;
    }

    /* Status Indicators */
    .border-status-selesai {
        border-left: 5px solid #2ECC71;
    }

    .border-status-proses {
        border-left: 5px solid #3498DB;
    }

    .border-status-batal {
        border-left: 5px solid #E74C3C;
    }

    .border-status-pending {
        border-left: 5px solid #F1C40F;
    }

    .text-price {
        font-size: 1.15rem;
        font-weight: 800;
        color: #ffffff;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
    }

</style>

{{-- HEADER --}}
<section class="page-header">
    <div class="container">
        <h2 class="fw-bold text-white mb-0">Riwayat Transaksi</h2>
        <p class="text-muted small mb-0">Pantau status servis dan riwayat belanja Anda di Bengkel Momo.</p>
    </div>
</section>

<div class="container mb-5">

    {{-- FILTER SECTION --}}
    <div class="filter-section mb-4">
        {{-- Filter Tipe --}}
        <div>
            <label class="text-muted small fw-bold mb-2 d-block">TIPE PESANAN</label>
            <div class="filter-group">
                <a href="{{ route('riwayat.index', array_merge(request()->query(), ['type' => 'all'])) }}" class="btn-filter {{ !request('type') || request('type') == 'all' ? 'active' : '' }}">Semua</a>
                <a href="{{ route('riwayat.index', array_merge(request()->query(), ['type' => 'jasa'])) }}" class="btn-filter {{ request('type') == 'jasa' ? 'active' : '' }}">Jasa (Servis)</a>
                <a href="{{ route('riwayat.index', array_merge(request()->query(), ['type' => 'barang'])) }}" class="btn-filter {{ request('type') == 'barang' ? 'active' : '' }}">Barang (Sparepart)</a>
            </div>
        </div>

        {{-- Filter Status --}}
        <div>
            <label class="text-muted small fw-bold mb-2 d-block">STATUS</label>
            <div class="filter-group">
                <a href="{{ route('riwayat.index', array_merge(request()->query(), ['status' => ''])) }}" class="btn-filter {{ !request('status') ? 'active' : '' }}">Semua Status</a>
                <a href="{{ route('riwayat.index', array_merge(request()->query(), ['status' => 'Menunggu'])) }}" class="btn-filter {{ request('status') == 'Menunggu' ? 'active' : '' }}">Menunggu</a>
                <a href="{{ route('riwayat.index', array_merge(request()->query(), ['status' => 'Proses'])) }}" class="btn-filter {{ request('status') == 'Proses' ? 'active' : '' }}">Diproses</a>
                <a href="{{ route('riwayat.index', array_merge(request()->query(), ['status' => 'Selesai'])) }}" class="btn-filter {{ request('status') == 'Selesai' ? 'active' : '' }}">Selesai</a>
                <a href="{{ route('riwayat.index', array_merge(request()->query(), ['status' => 'Batal'])) }}" class="btn-filter {{ request('status') == 'Batal' ? 'active' : '' }}">Dibatalkan</a>
            </div>
        </div>
    </div>

    {{-- LIST TRANSAKSI --}}
    <div class="row">
        @forelse($bookings as $item)
        @php
        // Cek apakah ini Jasa (Booking) atau Barang (Transaksi)
        // Sesuaikan property check ini dengan field unik di masing-masing tabelmu
        $isJasa = isset($item->booking_date);

        // Logika Status
        $statusColor = 'warning';
        $borderColor = 'border-status-pending';

        $currentStatus = strtolower($item->status);
        if($currentStatus == 'proses' || $currentStatus == 'dikirim') {
        $statusColor = 'primary';
        $borderColor = 'border-status-proses';
        } elseif($currentStatus == 'selesai') {
        $statusColor = 'success';
        $borderColor = 'border-status-selesai';
        } elseif($currentStatus == 'batal') {
        $statusColor = 'danger';
        $borderColor = 'border-status-batal';
        }
        @endphp

        <div class="col-12">
            <div class="transaksi-card {{ $borderColor }}">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                    <div>
                        <span class="type-badge {{ $isJasa ? 'bg-info text-dark' : 'bg-danger text-white' }}">
                            {{ $isJasa ? 'Jasa Servis' : 'Pembelian Barang' }}
                        </span>

                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge bg-{{ $statusColor }} px-3 rounded-pill">{{ ucfirst($item->status) }}</span>
                            <small class="text-muted fw-bold">#{{ $isJasa ? 'SRV' : 'TRX' }}-{{ $item->id }}</small>
                        </div>

                        <h5 class="fw-bold text-white mb-1">
                            {{ $isJasa ? $item->item_name : ($item->nomor_invoice ?? 'Order Barang') }}
                        </h5>

                        <p class="text-muted small mb-0">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $isJasa ? \Carbon\Carbon::parse($item->booking_date)->format('d M Y') : $item->created_at->format('d M Y') }}
                        </p>
                    </div>

                    <div class="text-md-end text-start">
                        <small class="text-muted d-block mb-1">Total Biaya</small>
                        <span class="text-price">
                            Rp {{ number_format($isJasa ? (float)$item->item_price : (float)$item->total_harga, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <hr class="border-secondary opacity-25 my-3">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div class="small text-muted">
                        @if($isJasa)
                        <i class="bi bi-geo-alt me-1"></i> Lokasi: Bengkel Momo Pusat
                        @else
                        <i class="bi bi-box-seam me-1"></i> Transaksi Sparepart
                        @endif
                    </div>

                    <div class="d-flex gap-2">
                        {{-- CEK JIKA STATUS SELESAI --}}
                        @if(strtolower($item->status) == 'selesai')

                        {{-- TOMBOL INVOICE --}}
                        @if($isJasa)
                        {{-- Gunakan nama route yang benar, biasanya 'riwayat.invoice' --}}
                        <a href="{{ route('riwayat.invoice', $item->id) }}" target="_blank" class="btn btn-sm btn-outline-light rounded-pill px-3">
                            <i class="bi bi-printer me-1"></i> Invoice Jasa
                        </a>
                        @else
                        {{-- Untuk Barang, pastikan kamu sudah punya route invoice khusus barang --}}
                        {{-- Jika belum ada, sementara bisa arahkan ke detail atau hubungi admin --}}
                        <a href="{{ route('riwayat.invoice.barang', $item->id) }}" target="_blank" class="btn btn-sm btn-outline-light rounded-pill px-3">
                            <i class="bi bi-printer me-1"></i> Invoice Barang
                        </a>
                        @endif

                        {{-- TOMBOL ULASAN (Hanya untuk Jasa) --}}
                        @if($isJasa)
                        @if($item->review)
                        <button class="btn btn-sm btn-secondary rounded-pill px-3" disabled>
                            <i class="bi bi-star-fill text-warning"></i> {{ $item->review->rating }}/5
                        </button>
                        @else
                        <button type="button" class="btn btn-sm btn-danger rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#reviewModal{{ $item->id }}">
                            <i class="bi bi-star me-1"></i> Ulas
                        </button>
                        @endif
                        @endif

                        {{-- CEK JIKA STATUS MENUNGGU --}}
                        @elseif(strtolower($item->status) == 'menunggu')
                        <form action="{{ $isJasa ? route('riwayat.cancel', $item->id) : route('riwayat.cancelBarang', $item->id) }}" method="POST">
                            @csrf @method('PUT')
                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">Batalkan</button>
                        </form>
                        @endif

                        <a href="https://wa.me/6283838762064" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-3">
                            <i class="bi bi-whatsapp"></i> Chat
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL ULASAN (Hanya muncul jika Jasa & Selesai) --}}
        @if($isJasa && $currentStatus == 'selesai' && !$item->review)
        <div class="modal fade" id="reviewModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark text-white border-secondary">
                    <div class="modal-header border-secondary">
                        <h5 class="modal-title fw-bold">Beri Ulasan Servis</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('riwayat.review.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="booking_id" value="{{ $item->id }}">
                        <div class="modal-body">
                            <div class="text-center mb-4">
                                <p class="text-muted mb-3 small">Layanan: {{ $item->item_name }}</p>
                                <label class="form-label d-block fw-bold">Rating Pelayanan</label>
                                <div class="btn-group" role="group">
                                    @for($i=1; $i<=5; $i++) <input type="radio" class="btn-check" name="rating" id="star{{$i}}_{{$item->id}}" value="{{$i}}" required>
                                        <label class="btn btn-outline-warning border-0 fs-4" for="star{{$i}}_{{$item->id}}">
                                            <i class="bi bi-star-fill"></i>
                                        </label>
                                        @endfor
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Komentar</label>
                                <textarea name="comment" class="form-control bg-black text-white border-secondary" rows="3" placeholder="Ceritakan pengalaman servis Baginda..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer border-secondary">
                            <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger rounded-pill px-4">Kirim Ulasan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif

        @empty
        <div class="col-12">
            <div class="empty-state">
                <i class="bi bi-clipboard-x text-muted" style="font-size: 5rem; opacity: 0.3;"></i>
                <h4 class="text-white mt-4 fw-bold">Tidak ada riwayat transaksi</h4>
                <p class="text-muted">Sepertinya Baginda belum memiliki riwayat pada kategori/status ini.</p>
                <a href="{{ route('katalog.index') }}" class="btn btn-danger rounded-pill px-4 mt-2">Mulai Belanja</a>
            </div>
        </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $bookings->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection
