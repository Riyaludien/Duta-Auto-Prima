<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') | Duta Auto Prima</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --sidebar-width: 260px;
            --navy-dark: #1e293b;
            --navy-light: #334155;
            --accent-blue: #3b82f6;
            --bg-light: #f8fafc;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        #sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background-color: var(--navy-dark);
            color: white;
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 20px;
            background: rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .nav-link {
            color: #94a3b8;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            transition: 0.2s;
            border-radius: 8px;
            margin: 4px 15px;
        }

        .nav-link:hover,
        .nav-link.active {
            color: white;
            background-color: var(--accent-blue);
        }

        .nav-link i {
            width: 25px;
            font-size: 1.1rem;
        }

        .nav-group-label {
            padding: 20px 25px 10px;
            text-transform: uppercase;
            font-size: 0.7rem;
            font-weight: 700;
            color: #64748b;
            letter-spacing: 1px;
        }

        /* Main Content Styling */
        #main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s;
        }

        .top-navbar {
            background: white;
            height: 70px;
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .content-body {
            padding: 30px;
        }

        /* Card Styling */
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border-radius: 12px;
        }

        @media (max-width: 992px) {
            #sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }

            #main-content {
                margin-left: 0;
            }

            #sidebar.active {
                margin-left: 0;
            }
        }

    </style>
</head>
<body>

    <div id="sidebar">
        <div class="sidebar-header">
            <h5 class="mb-0 fw-bold text-white"><i class="fas fa-wrench me-2 text-primary"></i> MOmo ADMIN</h5>
        </div>

        <div class="nav-group-label">Menu Utama</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-th-large"></i> Dashboard
        </a>

        <div class="nav-group-label">Pesanan & Transaksi</div>
        <a href="{{ route('admin.bookings.index') }}" class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
            <i class="fas fa-clipboard-list"></i> Pesanan Jasa
        </a>
        <a href="{{ route('transaksi.index') }}" class="nav-link {{ request()->routeIs('transaksi.index') ? 'active' : '' }}">
            <i class="bi bi-cart-check-fill"></i> Pesanan Barang
        </a>
        <a href="{{ route('transaksis.index') }}" class="nav-link {{ request()->is('transaksis*') ? 'active' : '' }}">
            <i class="fas fa-cash-register"></i> Kasir / POS
        </a>

        <div class="nav-group-label">Manajemen Data</div>
        <a href="{{ route('barangs.index') }}" class="nav-link {{ request()->is('barangs*') ? 'active' : '' }}">
            <i class="fas fa-box"></i> Data Barang
        </a>
        <a href="{{ route('log_stoks.index') }}" class="nav-link {{ request()->is('log_stoks*') ? 'active' : '' }}">
            <i class="fas fa-history"></i> Log Stok
        </a>

        <div class="dropdown mx-3 mt-2">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                <i class="fas fa-database"></i> Master Lain
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
                <li><a class="dropdown-item" href="{{ route('kategoris.index') }}">Kategori</a></li>
                <li><a class="dropdown-item" href="{{ route('suppliers.index') }}">Supplier</a></li>
            </ul>
        </div>
    </div>

    <div id="main-content">
        <div class="top-navbar">
            <button class="btn btn-light d-lg-none" id="sidebarCollapse">
                <i class="fas fa-bars"></i>
            </button>

            <div class="ms-auto d-flex align-items-center">
                <div class="me-3 text-end d-none d-sm-block">
                    <div class="fw-bold small text-dark">{{ Auth::user()->name ?? 'Administrator' }}</div>
                    <div class="text-muted small" style="font-size: 0.75rem;">Admin Bengkel</div>
                </div>
                <div class="dropdown">
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Admin' }}&background=3b82f6&color=fff" class="rounded-circle border cursor-pointer dropdown-toggle" width="40" height="40" data-bs-toggle="dropdown">
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="content-body">
            @yield('content')
        </div>
    </div>
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Sidebar Toggle for Mobile
        document.getElementById('sidebarCollapse') ? .addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });

        // SweetAlerts (Tetap sama seperti kode Baginda)
        @if(session('success'))
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
        @endif
        @if(session('error'))
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
        @endif

    </script>
    @yield('scripts')
</body>
</html>
