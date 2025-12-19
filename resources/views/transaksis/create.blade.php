@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Tambah Transaksi</h2>

    <form action="{{ route('transaksis.store') }}" method="POST" id="transaksiForm">
        @csrf

        <table class="table table-bordered" id="barangTable">
            <thead class="table-primary">
                <tr>
                    <th>Barang</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select name="barang_id[]" class="form-select barangSelect" required>
                            <option value="">-- Pilih Barang --</option>
                            @foreach($barangs as $barang)
                                <option value="{{ $barang->id }}" data-nama="{{ $barang->nama_barang }}" data-stok="{{ $barang->stok }}">
                                    {{ $barang->nama_barang }} (Stok: {{ $barang->stok }})
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="jumlah[]" class="form-control" value="1" min="1" required></td>
                    <td><button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button></td>
                </tr>
            </tbody>
        </table>

        <button type="button" class="btn btn-secondary mb-3" id="addRow">+ Tambah Barang</button>
        <br>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('transaksis.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const addRowBtn = document.getElementById('addRow');
    const barangTable = document.querySelector('#barangTable tbody');

    // Tambah baris baru
    addRowBtn.addEventListener('click', function() {
        const firstRow = barangTable.querySelector('tr');
        const newRow = firstRow.cloneNode(true);

        // Reset nilai select & input jumlah
        newRow.querySelector('.barangSelect').selectedIndex = 0;
        newRow.querySelector('input[name="jumlah[]"]').value = 1;

        barangTable.appendChild(newRow);
    });

    // Hapus baris
    barangTable.addEventListener('click', function(e) {
        if (e.target.classList.contains('removeRow')) {
            const rows = barangTable.querySelectorAll('tr');
            if (rows.length > 1) {
                e.target.closest('tr').remove();
            } else {
                alert('Minimal harus ada satu barang.');
            }
        }
    });
});
</script>
@endsection
