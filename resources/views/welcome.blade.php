<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang - Duta Auto Prima</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root {
            /* Palet Warna Bengkel Momo (Duta Auto Prima) */
            --primary-red: #FF0000;
            --bg-black: #000000;
            --surface-dark: #121212;
            --text-main: #F0F8FF;
            --text-muted: #B0BEC5;
        }

        body {
            font-family: 'Poppins', sans-serif;
            /* Background Gambar dengan Overlay Gelap */
            background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.9)), url('{{ asset('images/banner-1.jpeg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            color: var(--text-main);
        }

        .hero-section {
            background-color: var(--surface-dark);
            border: 1px solid #333;
            border-radius: 20px;
            /* Glow Merah Halus di sekeliling Card */
            box-shadow: 0 0 30px rgba(255, 0, 0, 0.15);
            padding: 60px 40px;
            max-width: 700px;
            width: 90%;
            text-align: center;
            animation: slideUp 0.8s ease-out;
            position: relative;
            overflow: hidden;
        }

        /* Garis Merah di Atas Card */
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--primary-red);
        }

        .hero-section .logo-icon {
            font-size: 80px;
            color: var(--primary-red);
            margin-bottom: 20px;
            display: inline-block;
            animation: pulse-red 2s infinite;
        }

        .hero-section h1 {
            font-size: 3rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 15px;
            letter-spacing: -1px;
        }

        .text-highlight {
            color: var(--primary-red);
        }

        .hero-section p.lead {
            font-size: 1.1rem;
            color: var(--text-muted);
            margin-bottom: 40px;
            font-weight: 300;
        }

        /* Tombol Kustom */
        .btn-custom-primary {
            background-color: var(--primary-red);
            border-color: var(--primary-red);
            color: white;
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 50px;
            transition: 0.3s;
        }
        
        .btn-custom-primary:hover {
            background-color: #cc0000;
            box-shadow: 0 0 15px rgba(255, 0, 0, 0.4);
            transform: translateY(-2px);
        }

        .btn-custom-outline {
            background-color: transparent;
            border: 2px solid #555;
            color: var(--text-main);
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 50px;
            transition: 0.3s;
        }

        .btn-custom-outline:hover {
            border-color: var(--text-main);
            background-color: rgba(255,255,255,0.1);
            color: white;
            transform: translateY(-2px);
        }

        /* Animasi */
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulse-red {
            0% { transform: scale(1); text-shadow: 0 0 0 rgba(255, 0, 0, 0.7); }
            50% { transform: scale(1.05); text-shadow: 0 0 20px rgba(255, 0, 0, 0.5); }
            100% { transform: scale(1); text-shadow: 0 0 0 rgba(255, 0, 0, 0); }
        }

        @media (max-width: 768px) {
            .hero-section h1 { font-size: 2rem; }
            .hero-section { padding: 40px 20px; }
        }
    </style>
</head>
<body>

    <div class="hero-section">
        <i class="bi bi-gear-wide-connected logo-icon"></i> 
        
        <h1>Duta <span class="text-highlight">Auto</span> Prima</h1>
        <p class="lead">
            Solusi otomotif terpercaya dengan suku cadang original dan mekanik profesional.
        </p>
        
        @auth
            <div class="mb-4 p-3 rounded" style="background: rgba(255,255,255,0.05);">
                <p class="mb-0 text-muted">Selamat datang kembali,</p>
                <h4 class="fw-bold text-white">{{ auth()->user()->name }}</h4>
            </div>
            
            <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                <a href="{{ route('beranda') }}" class="btn btn-custom-primary">
                    <i class="bi bi-speedometer2 me-2"></i> Buka Dashboard
                </a>
                
                <a href="{{ route('logout') }}" 
                   class="btn btn-custom-outline" 
                   onclick="event.preventDefault(); document.getElementById('welcome-logout-form').submit();">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
                
                <form id="welcome-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>

        @elseguest
            <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                <a href="{{ route('login') }}" class="btn btn-custom-primary">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Login Member
                </a>
                <a href="{{ route('register') }}" class="btn btn-custom-outline">
                    <i class="bi bi-person-add me-2"></i> Daftar Baru
                </a>
            </div>
            
            <div class="mt-4 pt-4 border-top border-secondary">
                <a href="{{ route('beranda') }}" class="link-beranda">
                    <i class="bi bi-eye me-1"></i> Lihat beranda & layanan tanpa login
                </a>
            </div>

        @endguest
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>