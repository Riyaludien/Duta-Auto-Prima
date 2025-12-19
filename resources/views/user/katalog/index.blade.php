@extends('layouts.user')

@section('title', 'Katalog Produk & Sparepart')

@section('content')

    {{-- 1. CSS KHUSUS TEMA DARK MODE (HIGH CONTRAST) --}}
    <style>
        :root {
            /* --- PALET WARNA BARU --- */
            --primary-red: #FF0000;
            /* Merah Terang */
            --primary-green: #2ECC71;
            /* Hijau Emerald */
            --bg-black: #000000;
            /* Hitam Pekat */
            --surface-dark: #121212;
            /* Hitam Abu (Card) */
            --border-dark: #2A2A2A;
            /* Warna Border Halus */

            --text-main: #F0F8FF;
            /* Putih Bersih */
            --text-muted: #B0BEC5;
            /* Abu Terang */
        }

        /* Override Body khusus halaman ini */
        body {
            background-color: var(--bg-black) !important;
            color: var(--text-main) !important;
        }

        /* Styling Sidebar Filter (Dark) */
        .filter-card {
            background: var(--surface-dark);
            border-radius: 12px;
            border: 1px solid var(--border-dark);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
            /* Shadow lebih gelap */
        }

        .filter-header {
            font-size: 0.9rem;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--primary-red);
            /* Judul Filter Merah */
            letter-spacing: 0.5px;
            margin-bottom: 15px;
        }

        /* Styling Input & Checkbox di Dark Mode */
        .form-control,
        .form-select {
            background-color: #1E1E1E;
            border: 1px solid var(--border-dark);
            color: var(--text-main);
        }

        .form-control:focus,
        .form-select:focus {
            background-color: #1E1E1E;
            border-color: var(--primary-red);
            color: var(--text-main);
            box-shadow: 0 0 0 0.25rem rgba(255, 0, 0, 0.25);
        }

        .form-check-input {
            background-color: #1E1E1E;
            border-color: #555;
        }

        .form-check-input:checked {
            background-color: var(--primary-red);
            border-color: var(--primary-red);
        }

        /* Styling Card Produk (Dark) */
        .product-card {
            background: var(--surface-dark);
            border: 1px solid var(--border-dark);
            border-radius: 12px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            border-color: var(--primary-red);
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(255, 0, 0, 0.2);
            /* Glow Merah */
        }

        .product-img-wrapper {
            height: 180px;
            overflow: hidden;
            position: relative;
            background: #000;
            /* Background gambar hitam */
        }

        .product-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
            opacity: 0.9;
            /* Sedikit redup biar menyatu */
        }

        .product-card:hover .product-img-wrapper img {
            transform: scale(1.1);
            opacity: 1;
        }

        .badge-promo {
            position: absolute;
            top: 10px;
            left: 10px;
            background: var(--primary-red);
            color: #fff;
            font-weight: bold;
            font-size: 0.7rem;
            padding: 4px 8px;
            border-radius: 4px;
            z-index: 2;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
        }

        /* Tombol Tambah (Lingkaran) */
        .btn-add-cart {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            border: 1px solid var(--primary-green);
            /* Pakai Hijau biar kontras */
            color: var(--primary-green);
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s;
        }

        .btn-add-cart:hover {
            background: var(--primary-green);
            color: #000;
            /* Teks hitam saat hover hijau */
            box-shadow: 0 0 10px var(--primary-green);
            /* Glow Hijau */
        }

        /* Teks dan Harga */
        .text-price {
            color: var(--primary-red);
            font-weight: 800;
            font-size: 1.1rem;
            text-shadow: 0 0 10px rgba(255, 0, 0, 0.3);
        }

        .product-title a {
            color: var(--text-main);
            text-decoration: none;
            transition: 0.2s;
        }

        .product-title a:hover {
            color: var(--primary-red);
        }

        /* Pagination Dark */
        .pagination .page-link {
            background-color: var(--surface-dark);
            border-color: var(--border-dark);
            color: var(--text-main);
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary-red);
            border-color: var(--primary-red);
            color: white;
        }

        .pagination .page-item.disabled .page-link {
            background-color: #000;
            color: #555;
        }

        /* --- TAMBAHAN: UPDATE NAVBAR JADI HITAM (Override Layout) --- */

        /* 1. Ubah Background Navbar jadi Hitam */
        .navbar {
            background-color: var(--bg-black) !important;
            border-bottom: 1px solid var(--border-dark);
            box-shadow: none !important;
        }

        /* 2. Ubah Warna Teks Menu jadi Putih */
        .navbar .nav-link {
            color: var(--text-muted) !important;
        }

        .navbar .nav-link:hover {
            color: var(--primary-red) !important;
        }

        /* 3. Ubah Tulisan Logo "Momo" jadi Putih (Biar kebaca) */
        .navbar-brand {
            color: white !important;
        }

        /* 4. Ubah Kotak Pencarian (Search Bar) di Navbar jadi Gelap */
        .navbar .input-group-text,
        .navbar input.form-control {
            background-color: var(--surface-dark) !important;
            border-color: var(--border-dark) !important;
            color: var(--text-main) !important;
        }

        /* Ubah ikon search jadi abu */
        .navbar .input-group-text i {
            color: var(--text-muted);
        }

        /* 5. Dropdown Menu User (Logout dll) jadi Gelap */
        .dropdown-menu {
            background-color: var(--surface-dark) !important;
            border: 1px solid var(--border-dark) !important;
        }

        .dropdown-item {
            color: var(--text-muted) !important;
        }

        .dropdown-item:hover {
            background-color: var(--bg-black) !important;
            color: var(--primary-red) !important;
        }
    </style>

    {{-- 2. KONTEN UTAMA --}}
    <div class="container pb-5">

        <nav aria-label="breadcrumb" class="mb-4 pt-3">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="{{ route('beranda') }}"
                        class="text-decoration-none text-muted">Beranda</a></li>
                <li class="breadcrumb-item active" style="color: var(--primary-red);" aria-current="page">Katalog</li>
            </ol>
        </nav>

        <div class="row">

            <div class="col-lg-3 mb-4">
                <div class="filter-card p-4">
                    <h5 class="fw-bold mb-4" style="color: var(--text-main);"><i class="bi bi-funnel me-2"></i>FILTER</h5>

                    <div class="mb-4">
                        <div class="filter-header">Kategori</div>
                        <form method="GET">
                            <div class="mb-4">
                                <div class="filter-header">Kategori</div>

                                @foreach ($kategoris as $kategori)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="kategori" value="{{ $kategori->id }}"
                                            id="cat_{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'checked' : '' }}><label class="form-check-label small text-muted" for="cat_{{ $kategori->id }}">
                                            {{ $kategori->nama_kategori }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <hr style="border-color: var(--border-dark);">

                            <div class="mb-4">
                                <div class="filter-header">Rentang Harga</div>
                                <div class="d-flex gap-2 align-items-center mb-2">
                                    <input type="number" name="min" class="form-control form-control-sm" placeholder="Min"
                                        value="{{ request('min') }}">
                                    <span class="text-muted">-</span>
                                    <input type="number" name="max" class="form-control form-control-sm" placeholder="Max"
                                        value="{{ request('max') }}">
                                </div>
                            </div>

                            <button class="btn w-100 btn-sm rounded-pill fw-bold"
                                style="background-color: var(--primary-red); color: white;">
                                TERAPKAN
                            </button>
                        </form>

                    </div>

                    <hr style="border-color: var(--border-dark);">
                </div>
            </div>

            <div class="col-lg-9">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold m-0" style="color: var(--text-main);">Semua Produk</h5>
                    <select class="form-select w-auto form-select-sm rounded-pill px-3">
                        <option>Urutkan: Terbaru</option>
                        <option>Harga: Rendah ke Tinggi</option>
                        <option>Harga: Tinggi ke Rendah</option>
                    </select>
                </div>

                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
                    @forelse ($barangs as $barang)
                                <div class="col">
                                    <div class="product-card">

                                        @if($barang->stok > 0)
                                            <div class="badge-promo">READY</div>
                                        @endif

                                        <div class="product-img-wrapper">
                                            <a href="#">
                                                <img src="{{ $barang->gambar
                        ? asset('storage/' . $barang->gambar)
                        : asset('images/katalog/default.jpg') }}" alt="{{ $barang->nama_barang }}">
                                            </a>
                                        </div>

                                        <div class="p-3 d-flex flex-column flex-grow-1">
                                            <small class="mb-1 text-muted" style="font-size: 0.75rem;">
                                                {{ $barang->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                                            </small>

                                            <h6 class="fw-bold mb-1 text-truncate product-title">
                                                <a href="#">
                                                    {{ $barang->nama_barang }}
                                                </a>
                                            </h6>

                                            <div class="mb-2 small">
                                                <i class="bi bi-star-fill" style="color: #F1C40F;"></i>
                                                <span class="text-muted ms-1">(4.8)</span>
                                            </div>

                                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                                <div class="text-price">
                                                    Rp {{ number_format($barang->harga, 0, ',', '.') }}
                                                </div>

                                                <form action="{{ route('cart.add', $barang->id) }}" method="POST">
                                                    @csrf
                                                    <button class="btn-add-cart" title="Tambah ke Keranjang">
                                                        <i class="bi bi-plus-lg"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    @empty
                        <p class="text-muted">Produk tidak ditemukan.</p>
                    @endforelse


                </div>

                <nav class="mt-5 d-flex justify-content-center">
                    <div class="mt-5 d-flex justify-content-center">
                        {{ $barangs->links() }}
                    </div>

                </nav>

            </div>
        </div>
    </div>
@endsection