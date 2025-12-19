@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <h1 class="mb-4">Dashboard</h1>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5>Total Barang</h5>
                    <h2>{{ $totalBarang }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5>Total Kategori</h5>
                    <h2>{{ $totalKategori }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Grafik Stok --}}
    <div class="card mt-5 shadow-sm border-0">
        <div class="card-body">
            <h5 class="mb-4 text-center">Grafik Stok per Kategori</h5>
            <canvas id="stokChart"></canvas>
        </div>
    </div>

    {{-- Tabel Barang --}}
    <div class="card mt-5 shadow-sm border-0">
        <div class="card-body">
            <h5 class="mb-4 text-center">Daftar Barang Terbaru</h5>

            <table class="table table-striped table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Supplier</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($barangList as $barang)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $barang->nama_barang }}</td>
                            <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                            <td>{{ $barang->stok }}</td>
                            <td>Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                            <td>{{ $barang->supplier ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada data barang</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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
                    label: 'Total Stok',
                    data: data,
                    borderWidth: 1,
                    backgroundColor: '#0d6efd'
                }]
            },
            options: { scales: { y: { beginAtZero: true } } }
        });
    </script>
@endsection
