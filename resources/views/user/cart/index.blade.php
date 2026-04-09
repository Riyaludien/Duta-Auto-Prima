@extends('layouts.user')

@section('content')
<div class="container py-5" style="background:#f1f5f9; min-height:100vh;">

    <h3 class="fw-bold mb-4">🛒 Keranjang Belanja</h3>

    @if($cartItems->isEmpty())
    <div class="text-center py-5">
        <p class="text-muted">Keranjang kosong 😢</p>
        <a href="/katalog" class="btn btn-primary rounded-pill">Belanja</a>
    </div>
    @else

    <div class="row g-4">
        <form id="checkoutForm" action="{{ route('checkout') }}" method="POST">
            @csrf

            <!-- ================= LIST PRODUK ================= -->
            <div class="col-lg-8">

                <!-- CHECKOUT FORM (HANYA UNTUK PILIH ITEM) -->


                <!-- PILIH SEMUA -->
                <div class="mb-3">
                    <input type="checkbox" id="checkAll">
                    <label for="checkAll" class="fw-semibold">Pilih Semua</label>
                </div>

                @foreach($cartItems as $item)
                <div class="card border-0 shadow-sm mb-3" style="border-radius:16px;">
                    <div class="card-body d-flex align-items-center gap-3">

                        <!-- CHECKBOX -->
                        <input type="checkbox" name="selected_items[]" value="{{ $item->id }}" class="item-checkbox" data-harga="{{ $item->barang->harga * $item->jumlah }}">

                        <!-- IMAGE -->
                        <img src="{{ asset('storage/' . $item->barang->gambar) }}" style="width:90px;height:90px;object-fit:cover;border-radius:12px;">

                        <!-- INFO -->
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-1">{{ $item->barang->nama_barang }}</h6>
                            <small class="text-muted">Jumlah: {{ $item->jumlah }}</small>
                        </div>

                        <!-- HARGA -->
                        <div class="fw-bold text-primary">
                            Rp {{ number_format($item->barang->harga, 0, ',', '.') }}
                        </div>

                        <!-- DELETE (FORM TERPISAH, AMAN) -->
                        <form action="{{ route('cart.delete', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-light text-danger">🗑</button>
                        </form>

                    </div>
                </div>
                @endforeach
            </div>

            <!-- ================= SUMMARY ================= -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm p-4 position-sticky" style="top:100px; border-radius:16px;">

                    <h5 class="fw-bold mb-3">Ringkasan</h5>

                    <div class="d-flex justify-content-between mb-3">
                        <span>Total</span>
                        <span id="totalHarga" class="fw-bold text-primary">Rp 0</span>
                    </div>

                    <input type="text" name="no_wa" class="form-control mb-3" placeholder="Nomor WhatsApp" required>

                    <select name="metode_pembayaran" class="form-select mb-3" required onchange="toggleRekening(this)">
                        <option value="">Pilih Pembayaran</option>
                        <option value="Transfer Bank">Transfer Bank</option>
                        <option value="Bayar di Bengkel">Bayar di Bengkel</option>
                    </select>

                    <div id="infoRekening" class="p-3 mb-3" style="display:none; background:#e0f2fe; border-radius:10px;">
                        <small>Transfer ke:</small><br>
                        <b>BCA - 1690316141</b><br>
                        A.N DIMAS
                    </div>

                    <!-- SUBMIT CHECKOUT -->
                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold">
                        Checkout
                    </button>

                </div>
            </div>
        </form>
    </div>


    @endif
</div>

<script>
    // ================= PILIH SEMUA =================
    document.getElementById('checkAll').addEventListener('change', function() {
        document.querySelectorAll('.item-checkbox').forEach(cb => {
            cb.checked = this.checked;
        });
        updateTotal();
    });

    // ================= HITUNG TOTAL =================
    const checkboxes = document.querySelectorAll('.item-checkbox');
    const totalDisplay = document.getElementById('totalHarga');

    function updateTotal() {
        let total = 0;
        checkboxes.forEach(cb => {
            if (cb.checked) {
                total += parseInt(cb.dataset.harga);
            }
        });
        totalDisplay.innerText = 'Rp ' + total.toLocaleString('id-ID');
    }

    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateTotal);
    });

    // ================= REKENING =================
    function toggleRekening(select) {
        document.getElementById('infoRekening').style.display =
            select.value === 'Transfer Bank' ? 'block' : 'none';
    }

</script>

@endsection
