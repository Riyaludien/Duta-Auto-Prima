@extends('layouts.admin') {{-- Pastikan ini sesuai nama layout admin Baginda --}}

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Daftar Pesanan Masuk</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Transaksi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tgl</th>
                            <th>Pelanggan</th>
                            <th>Layanan</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $item)
                        <tr>
                            <td>{{ $item->booking_date }}</td>
                            <td>
                                <strong>{{ $item->customer_name }}</strong><br>
                                <small>{{ $item->customer_phone }}</small>
                            </td>
                            <td>{{ $item->item_name }}</td>
                            <td>{{ $item->item_price }}</td>
                            <td>
                                <span class="badge badge-{{ $item->status == 'Selesai' ? 'success' : ($item->status == 'Proses' ? 'primary' : 'warning') }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td>
                                {{-- Form Ganti Status --}}
                                <form action="{{ route('admin.bookings.update', $item->id) }}" method="POST">
                                    @csrf
                                    <div class="input-group input-group-sm">
                                        <select name="status" class="form-select form-control">
                                            <option value="Menunggu" {{ $item->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                            <option value="Proses" {{ $item->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                                            <option value="Selesai" {{ $item->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                            <option value="Batal" {{ $item->status == 'Batal' ? 'selected' : '' }}>Batal</option>
                                        </select>
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i></button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection