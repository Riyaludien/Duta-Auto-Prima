<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bengkel Momo - Booking Service Mudah & Terpercaya</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <nav class="navbar navbar-expand-lg sticky-top bg-white shadow-sm">
        <div class="container">
            {{-- LOGO BENGKEL --}}
            <a class="navbar-brand fw-bold" href="{{ route('beranda') }}">
                <span class="text-danger">Bengkel</span>Momo
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- MENU UTAMA (Digeser ke Kanan dengan ms-auto) --}}
            <div class="collapse navbar-collapse" id="navbarNav">
                {{-- Ganti bagian <ul class="navbar-nav ms-auto ..."> di layout kamu dengan ini --}}

                <ul class="navbar-nav ms-auto align-items-center gap-4">

                    {{-- 1. BERANDA --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('beranda') ? 'text-danger fw-bold' : 'text-dark' }}" href="{{ route('beranda') }}">
                            Beranda
                        </a>
                    </li>

                    {{-- 2. JASA --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('jasa.*') ? 'text-danger fw-bold' : 'text-dark' }}" href="{{ route('jasa.index') }}">
                            Jasa
                        </a>
                    </li>

                    {{-- 3. KATALOG --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('katalog.*') ? 'text-danger fw-bold' : 'text-dark' }}" href="{{ route('katalog.index') }}">
                            Katalog
                        </a>
                    </li>

                    {{-- 4. RIWAYAT TRANSAKSI --}}
                    @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('riwayat.*') ? 'text-danger fw-bold' : 'text-dark' }}" href="{{ route('riwayat.index') }}">
                            Riwayat
                        </a>
                    </li>

                    {{-- 5. KERANJANG (IKON DENGAN BADGE JUMLAH) --}}
                    <li class="nav-item">
                        <a class="nav-link position-relative {{ request()->routeIs('cart.*') ? 'text-danger' : 'text-dark' }}" href="{{ route('cart.index') }}">
                            <i class="bi bi-bag fs-5"></i>
                            {{-- Badge jumlah barang di keranjang --}}
                            @php
                            $cartCount = \App\Models\Cart::where('user_id', Auth::id())->sum('jumlah');
                            @endphp
                            @if($cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                {{ $cartCount }}
                            </span>
                            @endif
                        </a>
                    </li>
                    @endauth

                    {{-- 6. MENU USER / LOGIN --}}
                    @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-bold text-danger border border-danger rounded-pill px-3" href="#" role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li><a class="dropdown-item" href="{{ route('beranda') }}">Dashboard</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @else
                    <li class="nav-item"><a class="btn btn-primary btn-sm rounded-pill px-4 ms-2" href="{{ route('login') }}">Masuk</a></li>
                    @endauth

                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <a href="#" class="footer-logo"><span class="text-danger">Bengkel</span>Momo</a>
                    <p class="small text-secondary">
                        Bengkel Momo adalah platform booking servis kendaraan terpercaya di Indonesia. Kami menghubungkan pemilik kendaraan dengan ribuan bengkel berkualitas.
                    </p>
                    <div class="social-icons mt-3">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="https://www.instagram.com/masmomo_bengkelmobiljogja/" target="_blank" class="text-white fs-5">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#"><i class="bi bi-youtube"></i></a>
                        <a href="#"><i class="bi bi-tiktok"></i></a>
                    </div>
                </div>

                <div class="col-md-2 col-6 mb-4">
                    <h6 class="footer-title">Perusahaan</h6>
                    <div class="footer-links">
                        <a href="{{ route('about') }}">Tentang Kami</a>
                        <a href="https://api.whatsapp.com/send?phone=6283838762064&text=Halo%20Admin%20Bengkel%20Momo,%20saya%20butuh%20bantuan." target="_blank">Hubungi Kami</a>
                        <a href="#">Karir</a>
                        <a href="#">Blog</a>
                    </div>
                </div>

                <div class="col-md-2 col-6 mb-4">
                    <h6 class="footer-title">Layanan</h6>
                    <div class="footer-links">
                        <a href="#">Servis Mobil</a>
                        <a href="#">Inspeksi</a>
                        <a href="#">Promo</a>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <h6 class="footer-title">Bantuan & Dukungan</h6>
                    <div class="footer-links">
                        <a href="#">Syarat & Ketentuan</a>
                        <a href="#">Kebijakan Privasi</a>
                        <a href="#">Pusat Bantuan</a>
                        <a href="#">Daftar Mitra Bengkel</a>
                    </div>
                    <div class="mt-3">
                        <p class="text-white mb-1 fw-bold">Download Aplikasi</p>
                        <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Google Play" height="40">
                    </div>
                </div>
            </div>

            <div class="copyright">
                &copy; 2025 Bengkel Momo. All rights reserved.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cancelForms = document.querySelectorAll('.delete-confirm'); // Class form tadi
            cancelForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Yakin mau membatalkan?'
                        , text: "Slot antrian Anda akan hilang!"
                        , icon: 'warning'
                        , showCancelButton: true
                        , confirmButtonColor: '#d33'
                        , cancelButtonColor: '#3085d6'
                        , confirmButtonText: 'Ya, Batalkan!'
                        , cancelButtonText: 'Gajadi'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });

    </script>

    {{-- ========================================== --}}
    {{-- TOMBOL WHATSAPP MENGAPUNG (FLOATING WA) --}}
    {{-- ========================================== --}}
    <a href="https://wa.me/6283838762064?text=Halo%20Admin%20Bengkel%20Momo,%20saya%20ingin%20bertanya%20tentang%20servis..." class="float-wa" target="_blank">
        <i class="bi bi-whatsapp"></i>
    </a>

    <style>
        .float-wa {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 30px;
            /* Jarak dari bawah */
            right: 30px;
            /* Jarak dari kanan */
            background-color: #25d366;
            /* Warna Hijau WA */
            color: #FFF;
            border-radius: 50px;
            /* Bulat sempurna */
            text-align: center;
            font-size: 32px;
            /* Ukuran Ikon */
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);
            /* Bayangan agar timbul */
            z-index: 9999;
            /* Agar selalu di paling atas */
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .float-wa:hover {
            background-color: #128C7E;
            /* Warna hijau lebih gelap saat disentuh */
            color: #FFF;
            transform: scale(1.1);
            /* Efek membesar sedikit */
        }

        /* Animasi Berdenyut (Opsional - Agar menarik perhatian) */
        @keyframes pulse-green {
            0% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7);
            }

            70% {
                box-shadow: 0 0 0 15px rgba(37, 211, 102, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0);
            }
        }

        .float-wa {
            animation: pulse-green 2s infinite;
        }

    </style>

</body>
</html>
