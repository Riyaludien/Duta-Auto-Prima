@extends('layouts.user')

@section('content')
<div class="container-fluid py-5" style="background-color: #000; color: #fff; min-height: 100vh;">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="fw-bold display-4" style="color: #FF0000;">TENTANG KAMI</h1>
            <p class="text-secondary">Pusat Perbaikan & Perawatan Kendaraan Terpercaya di Yogyakarta</p>
            <hr style="width: 100px; height: 5px; background: #FF0000; margin: 20px auto; border: none; opacity: 1;">
        </div>

        <div class="row align-items-center mb-5">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="fw-bold text-white mb-4">Bengkel Momo Yogyakarta</h2>
                <p class="lead" style="color: #ccc; text-align: justify;">
                    <strong>Bengkel Mobil Panggilan 24 Jam Yogyakarta (Bengkel Momo)</strong> adalah pusat perbaikan dan perawatan kendaraan terpercaya yang berlokasi di Tamantirto, Bantul.
                </p>
                <p style="color: #aaa; text-align: justify;">
                    Kami hadir sebagai solusi lengkap bagi pemilik kendaraan yang membutuhkan penanganan teknis berkualitas tinggi. Dengan dedikasi tinggi terhadap kepuasan pelanggan, kami siap melayani Anda baik di bengkel maupun dalam kondisi darurat di jalan (Emergency Service).
                </p>
            </div>
            <div class="col-lg-6">
                <div class="card p-4 border-0" style="background: #121212; border-left: 5px solid #FF0000 !important;">
                    <h4 class="fw-bold text-white"><i class="bi bi-shield-check text-danger me-2"></i>Komitmen Kami</h4>
                    <p class="mb-0" style="color: #ccc;">Kendaraan adalah aset penting mobilitas Anda. Bengkel Momo didukung oleh mekanik berpengalaman dan peralatan modern untuk memastikan setiap masalah kendaraan tertangani dengan <strong>akurat, transparan, dan efisien.</strong></p>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-12 text-center mb-2">
                <h3 class="fw-bold text-white">Layanan Unggulan Kami</h3>
            </div>
            @php
                $services = [
                    ['title' => 'Perawatan Mesin', 'desc' => 'Tune up, Gurah Carbon Cleaner, servis mobil injeksi, dan diesel.', 'icon' => 'bi-gear-wide-connected'],
                    ['title' => 'Transmisi & Kemudi', 'desc' => 'Servis mobil matic dan perbaikan power steering.', 'icon' => 'bi-compass'],
                    ['title' => 'Kenyamanan', 'desc' => 'Perbaikan kaki-kaki mobil dan sistem kelistrikan.', 'icon' => 'bi-lightning-charge'],
                    ['title' => 'Layanan Darurat', 'desc' => 'Servis panggil 24 jam wilayah Yogyakarta & sekitarnya.', 'icon' => 'bi-telephone-outbound'],
                ];
            @endphp

            @foreach($services as $s)
            <div class="col-md-3">
                <div class="card h-100 p-3 text-center border-0" style="background: #121212; transition: 0.3s;">
                    <i class="bi {{ $s['icon'] }} display-5 text-danger mb-3"></i>
                    <h5 class="fw-bold text-white">{{ $s['title'] }}</h5>
                    <p class="small text-secondary">{{ $s['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="row mb-5 py-5 rounded" style="background: #121212;">
            <div class="col-md-4 text-center">
                <h1 class="fw-bold text-danger mb-0">4.8/5</h1>
                <p class="text-white">Rating Google</p>
            </div>
            <div class="col-md-4 text-center border-start border-secondary">
                <h1 class="fw-bold text-danger mb-0">24 Jam</h1>
                <p class="text-white">Layanan Darurat</p>
            </div>
            <div class="col-md-4 text-center border-start border-secondary">
                <h1 class="fw-bold text-danger mb-0">Bantul</h1>
                <p class="text-white">Lokasi Strategis</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <h3 class="fw-bold text-white mb-4">Hubungi Kami</h3>
                <ul class="list-unstyled text-secondary">
                    <li class="mb-3">
                        <i class="bi bi-geo-alt-fill text-danger me-2"></i>
                        Kasihan RT 07, Tamantirto, Kec. Kasihan, Kab. Bantul, DIY 55183.
                    </li>
                    <li class="mb-3">
                        <i class="bi bi-whatsapp text-danger me-2"></i>
                        +62 857-4390-9369
                    </li>
                    <li class="mb-3">
                        <i class="bi bi-clock-fill text-danger me-2"></i>
                        08.30 – 23.00 WIB (Jumat Libur)
                    </li>
                </ul>
            </div>
            <div class="col-md-6 text-center">
                <div class="mt-4 p-4 rounded border border-secondary">
                    <h5 class="text-white mb-3">Butuh Bantuan Darurat?</h5>
                    <a href="https://wa.me/6283838762064" class="btn btn-danger btn-lg rounded-pill px-5 fw-bold">
                        <i class="bi bi-whatsapp me-2"></i>HUBUNGI TEKNISI
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card:hover {
        transform: translateY(-10px);
        background: #1a1a1a !important;
    }
</style>
@endsection