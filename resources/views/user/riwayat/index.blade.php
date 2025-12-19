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
    .border-status-selesai { border-left: 5px solid #2ECC71; } /* Hijau */
    .border-status-proses { border-left: 5px solid #3498DB; } /* Biru */
    .border-status-batal { border-left: 5px solid #E74C3C; } /* Merah */
    .border-status-pending { border-left: 5px solid #F1C40F; } /* Kuning */

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
    <div class="row">

        @forelse($bookings as $item)
        {{-- LOGIKA WARNA STATUS --}}
        @php
            $statusColor = 'warning'; 
            $borderColor = 'border-status-pending';

            if($item->status == 'Proses') {
                $statusColor = 'primary'; 
                $borderColor = 'border-status-proses';
            } elseif($item->status == 'Selesai') {
                $statusColor = 'success'; 
                $borderColor = 'border-status-selesai';
            } elseif($item->status == 'Batal') {
                $statusColor = 'danger'; 
                $borderColor = 'border-status-batal';
            }
        @endphp

        <div class="col-12">
            <div class="transaksi-card {{ $borderColor }}">
                
                {{-- Bagian Atas Card --}}
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="badge bg-{{ $statusColor }} badge-status">{{ $item->status }}</span>
                            <small class="text-muted">INV/{{ $item->created_at->format('Ymd') }}/{{ $item->id }}</small>
                        </div>
                        <h5 class="fw-bold text-white mb-0">{{ $item->item_name }}</h5>
                        <small class="text-muted">{{ $item->booking_date }} • Dibuat pada {{ $item->created_at->format('d M Y') }}</small>
                    </div>
                    <div class="text-end">
                        <small class="text-muted d-block">Estimasi Biaya</small>
                        <span class="text-price">{{ $item->item_price }}</span>
                    </div>
                </div>

                {{-- Bagian Tengah Card --}}
                <div class="bg-black p-3 rounded mb-3 border border-secondary border-opacity-25">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-dark p-2 rounded">
                            <i class="bi bi-tools text-danger fs-4"></i>
                        </div>
                        <div>
                            <p class="text-white mb-0 fw-bold">Layanan Bengkel Momo</p>
                            <small class="text-muted">Pemesan: {{ $item->customer_name }} ({{ $item->customer_phone }})</small>
                        </div>
                    </div>
                </div>

                {{-- Bagian Tombol Aksi --}}
                <div class="d-flex justify-content-end gap-2">

                    {{-- 1. TOMBOL BATAL (Hanya muncul jika status Menunggu) --}}
                    @if($item->status == 'Menunggu')
                        <form action="{{ route('riwayat.cancel', $item->id) }}" method="POST" class="d-inline delete-confirm">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                <i class="bi bi-x-circle"></i> Batalkan
                            </button>
                        </form>
                    @endif

                    {{-- 2. TOMBOL AKSI JIKA SELESAI (Invoice & Ulasan) --}}
                    @if($item->status == 'Selesai')
                        
                        {{-- Tombol Cetak Invoice --}}
                        <a href="{{ route('riwayat.invoice', $item->id) }}" target="_blank" class="btn btn-sm btn-outline-light rounded-pill px-4">
                            <i class="bi bi-printer"></i> Invoice
                        </a>

                        {{-- Logika Tombol Ulasan --}}
                        @if($item->review)
                            {{-- Jika SUDAH review --}}
                            <button class="btn btn-sm btn-secondary rounded-pill px-4" disabled>
                                <i class="bi bi-star-fill text-warning"></i> {{ $item->review->rating }}/5
                            </button>
                        @else
                            {{-- Jika BELUM review --}}
                            <button type="button" class="btn btn-sm btn-success rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#reviewModal{{ $item->id }}">
                                <i class="bi bi-star"></i> Beri Ulasan
                            </button>
                            {{-- ⚠️ KODE MODAL TELAH DIHAPUS DARI SINI --}}
                        @endif

                    {{-- 3. TOMBOL HUBUNGI ADMIN (Muncul selain Selesai & Batal) --}}
                    @elseif($item->status != 'Batal')
                        <a href="https://wa.me/6283838762064?text=Halo%20Admin,%20saya%20mau%20tanya%20status%20booking%20{{ $item->item_name }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-4">
                            <i class="bi bi-whatsapp"></i> Hubungi Admin
                        </a>
                    @endif

                </div>
            </div> {{-- Tutup Transaksi Card --}}


            {{-- ✅ KODE MODAL DIPINDAHKAN KE SINI (DI LUAR CARD, TAPI MASIH DI DALAM COL-12) --}}
            @if($item->status == 'Selesai' && !$item->review)
            <div class="modal fade" id="reviewModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content bg-dark text-white border-secondary">
                        <div class="modal-header border-secondary">
                            <h5 class="modal-title">Bagaimana pelayanan kami?</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('riwayat.review.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="booking_id" value="{{ $item->id }}">

                            <div class="modal-body text-center">
                                <p class="text-muted mb-2">Layanan: {{ $item->item_name }}</p>

                                {{-- Input Bintang --}}
                                <div class="mb-3">
                                    <label class="form-label d-block text-white">Beri Bintang</label>
                                    <div class="btn-group" role="group">
                                        @for($i=1; $i<=5; $i++) 
                                            <input type="radio" class="btn-check" name="rating" id="star{{$i}}_{{$item->id}}" value="{{$i}}" autocomplete="off" required>
                                            <label class="btn btn-outline-warning" for="star{{$i}}_{{$item->id}}">{{$i}} <i class="bi bi-star-fill"></i></label>
                                        @endfor
                                    </div>
                                </div>

                                {{-- Input Komentar --}}
                                <div class="mb-3 text-start">
                                    <label class="form-label text-white">Komentar (Opsional)</label>
                                    <textarea name="comment" class="form-control bg-black text-white border-secondary" rows="3" placeholder="Contoh: Pelayanan cepat dan ramah..."></textarea>
                                </div>
                            </div>
                            <div class="modal-footer border-secondary">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success">Kirim Ulasan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
            {{-- ✅ END KODE MODAL --}}

        </div> {{-- Tutup Col-12 --}}

        @empty
        {{-- TAMPILAN JIKA BELUM ADA DATA --}}
        <div class="col-12">
            <div class="empty-state">
                <i class="bi bi-cart-x empty-icon text-secondary" style="font-size: 4rem;"></i>
                <h5 class="text-white mt-3">Belum ada riwayat transaksi</h5>
                <p class="text-muted">Baginda belum pernah melakukan pemesanan jasa.</p>
                <a href="{{ route('katalog.index') }}" class="btn btn-danger rounded-pill mt-3 px-4">Mulai Booking</a>
            </div>
        </div>
        @endforelse

    </div>
</div>

@endsection