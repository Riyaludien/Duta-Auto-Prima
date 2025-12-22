@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">Daftar Pesanan Jasa</h3>
            <p class="text-muted small">Kelola antrean booking servis dan jasa pelanggan di sini.</p>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 border-bottom">
            <h6 class="m-0 fw-bold text-primary">Data Booking</h6>
        </div>
        <div class="card-body p-0"> {{-- p-0 agar tabel penuh ke samping --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-muted small text-uppercase">
                            <th class="ps-3" style="width: 130px;">Tgl</th>
                            <th>Pelanggan</th>
                            <th>Layanan</th>
                            <th>Harga</th>
                            <th class="text-center">Status</th>
                            <th class="text-center pe-3" style="width: 200px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $item)
                        <tr>
                            <td class="ps-3 text-dark">{{ $item->booking_date }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $item->customer_name }}</div>
                                <div class="small text-muted">{{ $item->customer_phone }}</div>
                            </td>
                            <td class="text-dark">{{ strtoupper($item->item_name) }}</td>
                            <td class="fw-bold text-dark">
                                @php
                                // Menghapus semua karakter selain angka
                                $cleanPrice = preg_replace('/[^0-9]/', '', $item->item_price);
                                @endphp
                                Rp {{ number_format((float) $cleanPrice, 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                @php
                                $badgeColor = [
                                'Selesai' => 'bg-success',
                                'Proses' => 'bg-primary',
                                'Menunggu' => 'bg-warning text-dark',
                                'Batal' => 'bg-danger'
                                ];
                                $currentBadge = $badgeColor[$item->status] ?? 'bg-secondary';
                                @endphp
                                <span class="badge {{ $currentBadge }} fw-normal px-3">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="pe-3">
                                {{-- Form Ganti Status yang Konsisten --}}
                                <form action="{{ route('admin.bookings.update', $item->id) }}" method="POST" class="d-flex justify-content-center align-items-center gap-2">
                                    @csrf
                                    <select name="status" class="form-select form-select-sm" style="width: 125px;">
                                        <option value="Menunggu" {{ $item->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="Proses" {{ $item->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                                        <option value="Selesai" {{ $item->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="Batal" {{ $item->status == 'Batal' ? 'selected' : '' }}>Batal</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary btn-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; padding: 0; flex-shrink: 0;">
                                        {{-- Pakai FontAwesome (fas fa-check) karena di layout kamu pakainya FontAwesome --}}
                                        <i class="fas fa-check text-white" style="font-size: 14px;"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-3 me-3">
                {{ $bookings->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
