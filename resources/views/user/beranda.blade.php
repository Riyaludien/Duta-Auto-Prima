@extends('layouts.user')

@section('title', 'Bengkel Momo - Booking Service Mudah & Terpercaya')

@section('content')


    {{-- HERO SECTION --}}
    <section class="hero-section"
        style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ asset('images/banner-1.jpeg') }}'); background-size: cover; background-position: center;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-7 text-white">
                    <h1 class="hero-title">Nikmati hematnya servis kendaraan!</h1>
                    <p class="fs-5 opacity-75">Jelajahi promo dari bengkel terdekat dan booking sekarang.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- FLOATING MENU LAYANAN --}}
    <div class="container mb-5">
        <div class="floating-menu-container">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="mobil-tab" data-bs-toggle="tab" data-bs-target="#mobil-pane"
                        type="button"><i class="bi bi-car-front-fill me-2"></i>Mobil</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="motor-tab" data-bs-toggle="tab" data-bs-target="#motor-pane"
                        type="button"><i class="bi bi-bicycle me-2"></i>Motor</button>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="mobil-pane">
                    <div class="row g-3 row-cols-2 row-cols-md-5">
                        <div class="col"><a href="#" class="service-icon-box"><i
                                    class="bi bi-gear-wide-connected"></i><span>Spooring &<br>Balancing</span></a></div>
                        <div class="col"><a href="#" class="service-icon-box"><i
                                    class="bi bi-tools"></i><span>Service<br>Kaki-Kaki</span></a></div>
                        <div class="col"><a href="#" class="service-icon-box"><i
                                    class="bi bi-speaker"></i><span>Audio<br>System</span></a></div>
                        <div class="col"><a href="#" class="service-icon-box"><i
                                    class="bi bi-droplet-fill"></i><span>Ganti<br>Oli</span></a></div>
                        <div class="col"><a href="#" class="service-icon-box"><i
                                    class="bi bi-lightbulb"></i><span>Spesialis<br>Lampu</span></a></div>
                        <div class="col"><a href="#" class="service-icon-box"><i
                                    class="bi bi-fan"></i><span>Service<br>AC</span></a></div>
                        <div class="col"><a href="#" class="service-icon-box"><i class="bi bi-disc"></i><span>Ban
                                    &<br>Velg</span></a></div>
                        <div class="col"><a href="#" class="service-icon-box"><i
                                    class="bi bi-clipboard-check"></i><span>Inspeksi<br>Mobil</span></a></div>
                        <div class="col"><a href="#" class="service-icon-box"><i
                                    class="bi bi-window"></i><span>Kaca<br>Film</span></a></div>
                        <div class="col">
                            <a href="{{ route('jasa.index') }}" class="service-icon-box">
                                <i class="bi bi-grid-fill"></i>
                                <span>Lainnya</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="motor-pane">
                    <div class="row g-3 row-cols-2 row-cols-md-5">
                        <div class="col"><a href="#" class="service-icon-box"><i class="bi bi-droplet"></i><span>Ganti
                                    Oli<br>Motor</span></a></div>
                        <div class="col"><a href="#" class="service-icon-box"><i
                                    class="bi bi-gear"></i><span>Service<br>CVT</span></a></div>
                        <div class="col"><a href="#" class="service-icon-box"><i
                                    class="bi bi-disc"></i><span>Ganti<br>Ban</span></a></div>
                        <div class="col"><a href="#" class="service-icon-box"><i
                                    class="bi bi-wrench"></i><span>Tune<br>Up</span></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- KATALOG PRODUK --}}
    <style>
        .card-img-top {
            height: 180%;
            width: 100%;
            object-fit: cover;
            object-position: center;
        }

        .custom-card {
            height: 100%;
        }

        .card-body-custom {
            min-height: 150px;
        }
    </style>
    <section class="container mb-5">
        <div class="section-header">
            <div>
                <h2 class="section-title">Katalog Produk & Sparepart</h2>
                <p class="text-muted small mb-0">Suku cadang original untuk kendaraan kesayanganmu</p>
            </div>
            <a href="{{ route('katalog.index') }}" class="see-all">
                Lihat Semua <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="horizontal-scroll-wrapper">
            <button class="scroll-btn left" onclick="scrollKatalog('left')">
                <i class="bi bi-chevron-left"></i>
            </button>

            <div class="horizontal-scroll-container" id="katalogProduk">

                {{-- ROW HARUS LANGSUNG DI SINI --}}
                <div class="row g-4 flex-nowrap">
                    @foreach ($barangs as $barang)
                                <div class="col-10 col-sm-6 col-md-4 col-lg-3">
                                    <div class="custom-card h-100 d-flex flex-column">
                                        <img src="{{ $barang->gambar
                        ? asset('storage/' . $barang->gambar)
                        : asset('images/katalog/default.jpg') }}" class="card-img-top"
                                            alt="{{ $barang->nama_barang }}">

                                        <div class="card-body-custom flex-grow-1">
                                            <span class="product-category">
                                                {{ $barang->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                                            </span>

                                            <h5 class="card-title-custom text-wrap">
                                                {{ $barang->nama_barang }}
                                            </h5>

                                            <div class="mb-2">
                                                <i class="bi bi-star-fill text-warning small"></i>
                                                <span class="small text-muted ms-1">(15)</span>
                                            </div>

                                            <div class="product-price">
                                                Rp {{ number_format($barang->harga, 0, ',', '.') }}
                                            </div>
                                        </div>

                                        <div class="p-3 pt-0 mt-auto">
                                            <form action="{{ route('cart.add', $barang->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-custom rounded-pill w-100">Tambah ke
                                                    Keranjang</button>
                                            </form>

                                        </div>

                                    </div>
                                </div>
                    @endforeach
                </div>

            </div>

            <button class="scroll-btn right" onclick="scrollKatalog('right')">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>
    </section>


    {{-- LOKASI BENGKEL --}}
    <section class="container mb-5">
        <div class="section-header">
            <div>
                <h2 class="section-title">Lokasi Bengkel & Cabang</h2>
                <p class="text-muted small mb-0">Temukan layanan servis profesional di kota Anda</p>
            </div>
            <a href="#" class="see-all">Cari Lokasi Lain <i class="bi bi-arrow-right"></i></a>
        </div>

        <div class="row row-cols-1 row-cols-md-4 g-4">
            <div class="col">
                <div class="location-card">
                    <div class="location-img-wrapper">
                        <span class="status-badge open">Buka • Tutup 23:00</span>
                        <img src="{{ asset('images/bengkel/bengkel1.webp') }}" class="card-img-top" alt="Bengkel MOmo">
                    </div>
                    <div class="location-body">
                        <h5 class="location-title">Bengkel MOmo Pusat</h5>
                        <div class="location-info">
                            <i class="bi bi-geo-alt-fill"></i>
                            <span>Kasihan RT 07 Tamantirto, Kasih, Tamantirto, Kec. Kasihan, Kabupaten Bantul, Daerah
                                Istimewa Yogyakarta 55183</span>
                        </div>
                        <div class="location-info">
                            <i class="bi bi-clock-fill"></i>
                            <span>Senin - Sabtu (08:30 - 23:00)</span>
                        </div>
                        <div class="mt-3">
                            <a href="https://share.google/kXqQN2FDRTUEqvOtx" target="_blank" class="btn btn-maps">
                                <i class="bi bi-map me-2"></i>Petunjuk Arah
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- MENGAPA MEMILIH KAMI --}}
    <section class="container mb-5">
        <h2 class="section-title mb-4">Mengapa Booking Lewat Bengkel MOmo?</h2>
        <div class="row row-cols-1 row-cols-md-4 g-3">
            <div class="col">
                <div class="feature-box">
                    <div class="feature-icon-circle"><i class="bi bi-percent"></i></div>
                    <h6 class="fw-bold mb-2">Beragam Promo Menarik</h6>
                    <p class="small text-muted">Nikmati berbagai layanan servis mobil dan motor lebih hemat dengan promo.
                    </p>
                </div>
            </div>
            <div class="col">
                <div class="feature-box">
                    <div class="feature-icon-circle"><i class="bi bi-geo-alt"></i></div>
                    <h6 class="fw-bold mb-2">Cakupan Area Luas</h6>
                    <p class="small text-muted">Bengkel rekanan tersebar di berbagai kota besar di Indonesia.</p>
                </div>
            </div>
            <div class="col">
                <div class="feature-box">
                    <div class="feature-icon-circle"><i class="bi bi-phone"></i></div>
                    <h6 class="fw-bold mb-2">Booking Mudah & Nyaman</h6>
                    <p class="small text-muted">Booking servis mudah langsung dari HP atau gadgetmu.</p>
                </div>
            </div>
            <div class="col">
                <div class="feature-box">
                    <div class="feature-icon-circle"><i class="bi bi-clock-history"></i></div>
                    <h6 class="fw-bold mb-2">Fitur Pengingat & Riwayat</h6>
                    <p class="small text-muted">Fitur pengingat servis yang memudahkan konsumen.</p>
                </div>
            </div>
        </div>
    </section>


    {{-- ============================================== --}}
    {{-- ✅ BAGIAN ULASAN PELANGGAN (DITAMBAHKAN BARU) --}}
    {{-- ============================================== --}}
    <section class="container mb-5">
        <div class="section-header">
            <div>
                <h2 class="section-title">Apa Kata Mereka?</h2>
                <p class="text-muted small mb-0">Ulasan asli dari pelanggan setia Bengkel Momo</p>
            </div>
            {{-- Jika ingin tombol 'Lihat Semua Ulasan', bisa ditambah disini --}}
        </div>

        <div class="row g-4">
            {{-- Kita cek apakah variabel $reviews ada dan tidak kosong --}}
            @if(isset($reviews) && $reviews->count() > 0)
                @foreach($reviews as $review)
                    <div class="col-md-6 col-lg-4">
                        <div class="custom-card h-100 p-4 border-0 shadow-sm" style="background: #1c1c1c;">

                            {{-- Header Ulasan (Avatar & Nama) --}}
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-danger rounded-circle d-flex align-items-center justify-content-center me-3 text-white fw-bold"
                                    style="width: 45px; height: 45px;">
                                    {{ substr($review->user->name ?? 'U', 0, 1) }}
                                </div>
                                <div>
                                    <h6 class="text-white mb-0 fw-bold">{{ $review->user->name ?? 'Pelanggan' }}</h6>
                                    <small class="text-muted"
                                        style="font-size: 12px;">{{ $review->created_at->diffForHumans() }}</small>
                                </div>
                            </div>

                            {{-- Bintang Rating --}}
                            <div class="mb-3 text-warning">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating) <i class="bi bi-star-fill"></i> @else <i class="bi bi-star"></i> @endif
                                @endfor
                            </div>

                            {{-- Isi Komentar --}}
                            <div class="position-relative">
                                <i class="bi bi-quote text-secondary position-absolute top-0 start-0 opacity-25"
                                    style="font-size: 2rem; transform: translate(-10px, -20px);"></i>
                                <p class="card-text text-light fst-italic ps-3 mb-0" style="min-height: 50px;">
                                    "{{ Str::limit($review->comment ?? 'Pelayanan sangat memuaskan!', 100) }}"
                                </p>
                            </div>

                        </div>
                    </div>
                @endforeach
            @else
                {{-- Tampilan Jika Belum Ada Ulasan --}}
                <div class="col-12 text-center py-5">
                    <div class="p-4 rounded bg-light border border-dashed">
                        <i class="bi bi-chat-heart text-secondary display-5 mb-3"></i>
                        <p class="text-muted mb-0">Belum ada ulasan yang ditampilkan saat ini.</p>
                    </div>
                </div>
            @endif
        </div>
    </section>
    {{-- ============================================== --}}


    {{-- STATISTIK --}}
    <section class="stats-section text-center">
        <div class="container">
            <div class="row">
                <div class="col-6 col-md-3 mb-4 mb-md-0">
                    <div class="stat-number">2000+</div>
                    <div class="stat-label">Mitra Bengkel</div>
                </div>
                <div class="col-6 col-md-3 mb-4 mb-md-0">
                    <div class="stat-number">150.000+</div>
                    <div class="stat-label">Customer</div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Layanan Servis</div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-number">38+</div>
                    <div class="stat-label">Kota Terjangkau</div>
                </div>
            </div>
        </div>
    </section>

    {{-- SCRIPT SCROLL KATALOG --}}
    <script>
        function scrollKatalog(direction) {
            const container = document.getElementById('katalogProduk');
            const scrollAmount = 300;

            if (direction === 'left') {
                container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            } else {
                container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            }
        }
    </script>

@endsection