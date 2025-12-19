<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Poppins', sans-serif; color: #333; }
        .header { background: #dc3545; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; border: 1px solid #eee; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border-bottom: 1px solid #ddd; padding: 10px; text-align: left; }
        .total { font-weight: bold; color: #dc3545; font-size: 1.2rem; }
        .footer { font-size: 12px; color: #777; margin-top: 30px; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Bengkel Momo</h1>
        <p>Terima kasih atas pesanan Anda!</p>
    </div>

    <div class="content">
        <h3>Halo, {{ $transaksi->user->name }}</h3>
        <p>Pesanan Anda dengan nomor invoice <strong>#{{ $transaksi->id }}</strong> telah kami terima dan sedang menunggu verifikasi.</p>

        <table class="table">
            <thead>
                <tr>
                    <th>Barang</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksi->details as $detail)
                <tr>
                    <td>{{ $detail->barang->nama_barang }}</td>
                    <td>{{ $detail->jumlah }}</td>
                    <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" style="text-align: right; padding-top: 20px;">Total Bayar:</td>
                    <td class="total" style="padding-top: 20px;">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <div style="margin-top: 30px; background: #f8f9fa; padding: 15px; border-radius: 8px;">
            <strong>Status Pesanan:</strong> <span style="color: orange;">{{ $transaksi->status }}</span><br>
            <p>Silakan lakukan pembayaran atau tunggu admin kami menghubungi Anda melalui WhatsApp.</p>
        </div>
    </div>

    <div class="footer">
        &copy; 2025 Bengkel Momo. Semua Hak Dilindungi.<br>
        Jl. Raya Bengkel No. 123, Indonesia.
    </div>
</body>
</html>