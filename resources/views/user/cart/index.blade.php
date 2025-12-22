@extends('layouts.user')

@section('content')
<div class="container py-5" style="background-color: #000; color: #fff; min-height: 100vh;">
    <h2 class="fw-bold mb-4" style="color: #FF0000;">KERANJANG BELANJA</h2>

    @if($cartItems->isEmpty())
    <div class="text-center py-5">
        <p class="text-muted">Keranjangmu masih kosong.</p>
        <a href="/katalog" class="btn btn-danger rounded-pill">Mulai Belanja</a>
    </div>
    @else
    <div class="row">
        <div class="col-lg-8">
            @foreach($cartItems as $item)
            <div class="card mb-3" style="background: #121212; border: 1px solid #2A2A2A;">
                <div class="card-body d-flex align-items-center">
                    <img src="{{ asset('storage/' . $item->barang->gambar) }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                    <div class="ms-3 flex-grow-1">
                        {{-- Nama Barang diubah jadi Putih Terang --}}
                        <h6 class="mb-1 fw-bold text-white">{{ $item->barang->nama_barang }}</h6>
                        <p class="mb-0 text-danger fw-bold">Rp {{ number_format($item->barang->harga, 0, ',', '.') }}</p>
                        <small class="text-muted">Jumlah: {{ $item->jumlah }}</small>
                    </div>
                    <form action="{{ route('cart.delete', $item->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm text-secondary"><i class="bi bi-trash"></i></button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        <div class="col-lg-4">
            <div class="card p-4" style="background: #121212; border: 1px solid #2A2A2A;">
                {{-- RINGKASAN diubah jadi Putih Terang --}}
                <h5 class="fw-bold mb-3 text-white">RINGKASAN</h5>
                
                <div class="d-flex justify-content-between mb-3">
                    {{-- Total Harga label diubah jadi Putih Terang --}}
                    <span class="text-white">Total Harga:</span>
                    <span class="fw-bold text-danger" style="font-size: 1.1rem;">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>

                <form action="{{ route('checkout') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label text-white small">Nomor WhatsApp Aktif</label>
                        <input type="number" name="no_wa" class="form-control bg-dark text-white border-secondary" placeholder="Contoh: 08123456789" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-white small">Metode Pembayaran</label>
                        <select name="metode_pembayaran" class="form-select bg-dark text-white border-secondary" required onchange="toggleRekening(this)">
                            <option value="">-- Pilih Pembayaran --</option>
                            <option value="Transfer Bank">Transfer Bank (Cek Rekening)</option>
                            <option value="Bayar di Bengkel">Bayar di Bengkel (Offline)</option>
                        </select>
                    </div>

                    <div id="infoRekening" class="alert border-0 p-3 mb-3" style="display:none; background: #1a1a1a; color: #fff; border: 1px dashed #444 !important;">
                        <p class="small mb-1 text-secondary">Silakan transfer ke:</p>
                        <h6 class="fw-bold text-white mb-1">BANK BCA - <span class="text-danger">1690316141</span></h6>
                        <p class="small mb-0 text-white">A.N DIMAS ARIF PURNOMO </p>
                    </div>

                    <button type="submit" class="btn btn-danger w-100 fw-bold rounded-pill py-2 shadow-sm">CHECKOUT SEKARANG</button>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
    function toggleRekening(select) {
        const info = document.getElementById('infoRekening');
        info.style.display = (select.value === 'Transfer Bank') ? 'block' : 'none';
    }
</script>
@endsection