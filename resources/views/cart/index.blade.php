<h3>Keranjang Saya</h3>

@if ($carts->isEmpty())
    <p>Keranjang kosong</p>
@else
    @foreach ($carts as $cart)
        <div class="d-flex align-items-center mb-3">
            @if ($cart->barang && $cart->barang->gambar)
                <img src="{{ asset('storage/' . $cart->barang->gambar) }}" width="80">
            @else
                <img src="{{ asset('images/katalog/default.jpg') }}" width="80">
            @endif


            <div class="ms-3">
                <strong>{{ $cart->barang->nama_barang ?? 'Barang tidak tersedia' }}
                </strong><br>
                Qty: {{ $cart->qty }}<br>
                Harga: Rp {{ number_format($cart->barang->harga, 0, ',', '.') }}
            </div>
        </div>
    @endforeach
@endif