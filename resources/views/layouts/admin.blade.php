<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') | CV Duta Auto Prima</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    {{-- Tambahkan FontAwesome untuk Ikon jika belum ada --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-wrench me-2"></i>Duta Auto Prima
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    {{-- 1. DASHBOARD --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            Dashboard
                        </a>
                    </li>

                    {{-- 2. PESANAN MASUK (TITAH BARU) --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.bookings.index') }}" class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active fw-bold text-warning' : '' }}">
                            <i class="fas fa-clipboard-list me-1"></i> Pesanan Jasa
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('transaksi.index') }}">
                            <i class="bi bi-cart-check"></i> Pesanan Barang
                        </a>
                    </li>

                    {{-- 3. TRANSAKSI (POS/Kasir) --}}
                    <li class="nav-item">
                        <a href="{{ route('transaksis.index') }}" class="nav-link {{ request()->is('transaksis*') ? 'active' : '' }}">
                            Transaksi
                        </a>
                    </li>

                    {{-- 4. MASTER DATA --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->is('barangs*', 'kategoris*', 'suppliers*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                            Master Data
                        </a>
                        <ul class="dropdown-menu border-0 shadow">
                            <li><a class="dropdown-item" href="{{ route('barangs.index') }}">Data Barang</a></li>
                            <li><a class="dropdown-item" href="{{ route('kategoris.index') }}">Kategori</a></li>
                            <li><a class="dropdown-item" href="{{ route('suppliers.index') }}">Supplier</a></li>
                        </ul>
                    </li>

                    {{-- 5. RIWAYAT STOK --}}
                    <li class="nav-item">
                        <a href="{{ route('log_stoks.index') }}" class="nav-link {{ request()->is('log_stoks*') ? 'active' : '' }}">
                            Log Stok
                        </a>
                    </li>
                </ul>

                {{-- MENU KANAN (LOGOUT) --}}
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item me-3 text-white small">
                        Halo, {{ Auth::user()->name ?? 'Admin' }}
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-danger btn-sm rounded-pill px-3">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Konten --}}
    <div class="container py-4">
        @yield('content')
        @yield('scripts')
    </div>

    {{-- Bootstrap & SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- ✅ Toast Notifikasi (Script Lama Baginda) --}}
    @if (session('success'))
    <script>
        Swal.fire({
            toast: true
            , position: 'top-end'
            , icon: 'success'
            , title: @json(session('success'))
            , showConfirmButton: false
            , timer: 2500
            , timerProgressBar: true
            , background: '#198754'
            , color: '#fff'
        });

    </script>
    @endif

    @if (session('error'))
    <script>
        Swal.fire({
            toast: true
            , position: 'top-end'
            , icon: 'error'
            , title: @json(session('error'))
            , showConfirmButton: false
            , timer: 2500
            , timerProgressBar: true
            , background: '#dc3545'
            , color: '#fff'
        });

    </script>
    @endif

    @if (session('deleted'))
    <script>
        Swal.fire({
            toast: true
            , position: 'top-end'
            , icon: 'info'
            , title: @json(session('deleted'))
            , showConfirmButton: false
            , timer: 2500
            , timerProgressBar: true
            , background: '#fd0d0dff'
            , color: '#fff'
        });

    </script>
    @endif

    {{-- 🗑️ Konfirmasi Hapus --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForms = document.querySelectorAll('form.delete-confirm');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Yakin ingin menghapus?'
                        , text: "Data yang dihapus tidak bisa dikembalikan!"
                        , icon: 'warning'
                        , showCancelButton: true
                        , confirmButtonColor: '#d33'
                        , cancelButtonColor: '#6c757d'
                        , confirmButtonText: 'Ya, hapus!'
                        , cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });

    </script>

</body>
</html>
