@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item small"><a href="#">Admin</a></li>
                    <li class="breadcrumb-item small active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
            <h3 class="fw-bold text-dark">Ringkasan Statistik</h3>
        </div>
        <div class="text-muted small">
            <i class="fas fa-calendar-alt me-1"></i> {{ date('d F Y') }}
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100" style="border-left: 5px solid #3b82f6 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted small text-uppercase fw-bold mb-1">Total Barang</p>
                            <h2 class="fw-bold mb-0">{{ $totalBarang }}</h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-box text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100" style="border-left: 5px solid #10b981 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted small text-uppercase fw-bold mb-1">Kategori</p>
                            <h2 class="fw-bold mb-0">{{ $totalKategori }}</h2>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-tags text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100" style="border-left: 5px solid #f59e0b !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted small text-uppercase fw-bold mb-1">Pesanan Jasa</p>
                            <h2 class="fw-bold mb-0">{{ $totalBooking ?? 0 }}</h2>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-tools text-warning fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100" style="border-left: 5px solid #ef4444 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted small text-uppercase fw-bold mb-1">Order Barang</p>
                            <h2 class="fw-bold mb-0">{{ $totalTransaksi ?? 0 }}</h2>
                        </div>
                        <div class="bg-danger bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-cart-fill text-danger fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-dark"><i class="fas fa-chart-bar me-2 text-primary"></i>Stok per Kategori</h6>
                </div>
                <div class="card-body">
                    <canvas id="stokChart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-dark">Barang Terbaru</h6>
                    <a href="{{ route('barangs.index') }}" class="btn btn-sm btn-outline-primary py-0">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr class="small text-muted text-uppercase">
                                    <th class="ps-3">Nama</th>
                                    <th>Stok</th>
                                    <th class="pe-3">Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($barangList->take(5) as $barang)
                                    <tr>
                                        <td class="ps-3">
                                            <div class="fw-bold text-dark" style="font-size: 0.85rem;">{{ $barang->nama_barang }}</div>
                                            <div class="small text-muted">{{ $barang->kategori->nama_kategori ?? '-' }}</div>
                                        </td>
                                        <td>
                                            <span class="badge {{ $barang->stok <= 5 ? 'bg-danger' : 'bg-light text-dark border' }}">
                                                {{ $barang->stok }}
                                            </span>
                                        </td>
                                        <td class="pe-3 small fw-bold">Rp{{ number_format($barang->harga, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted small">Data kosong</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('stokChart');
        const labels = @json($stokPerKategori->pluck('nama_kategori'));
        const data = @json($stokPerKategori->pluck('barangs_sum_stok'));

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Stok ',
                    data: data,
                    backgroundColor: '#3b82f6',
                    borderRadius: 5,
                    barThickness: 25,
                }]
            },
            options: { 
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { 
                    y: { beginAtZero: true, grid: { display: false } },
                    x: { grid: { display: false } }
                } 
            }
        });
    </script>
@endsection