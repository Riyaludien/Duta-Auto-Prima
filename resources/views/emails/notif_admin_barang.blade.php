<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .header { background: #333; color: #FFD700; padding: 20px; text-align: center; font-size: 20px; font-weight: bold; border-bottom: 4px solid #dc3545; }
        .content { padding: 20px; }
        .info-box { background: #f9f9f9; padding: 15px; border-left: 5px solid #dc3545; margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .table th, .table td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        .table th { background: #eee; }
        .btn-wa { display: inline-block; background: #25D366; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        🚨 PESANAN BARU MASUK - BENGKEL MOMO
    </div>

    <div class="content">
        <p>Halo Admin, ada pesanan barang baru yang perlu diproses.</p>

        @php
            // Logika konversi nomor ke format internasional WhatsApp
            $no_wa = $transaksi->no_wa;
            // Hapus karakter selain angka
            $clean_wa = preg_replace('/[^0-9]/', '', $no_wa);
            // Jika diawali 0, ganti jadi 62
            if (substr($clean_wa, 0, 1) === '0') {
                $wa_ready = '62' . substr($clean_wa, 1);
            } elseif (substr($clean_wa, 0, 2) === '62') {
                $wa_ready = $clean_wa;
            } else {
                $wa_ready = '62' . $clean_wa;
            }
        @endphp

        <div class="info-box">
            <strong>Detail Pelanggan:</strong><br>
            Nama: {{ $transaksi->user->name }}<br>
            Metode Bayar: <strong>{{ $transaksi->metode_pembayaran }}</strong><br>
            Waktu Order: {{ $transaksi->created_at->format('d M Y H:i') }}<br>
            
            <a href="https://wa.me/{{ $wa_ready }}" class="btn-wa">
                📱 Chat WhatsApp: +{{ $wa_ready }}
            </a>
        </div>

        <h3>Daftar Belanjaan:</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksi->details as $detail)
                <tr>
                    <td>{{ $detail->barang->nama_barang }}</td>
                    <td>{{ $detail->jumlah }} x</td>
                    <td>Rp {{ number_format($detail->harga * $detail->jumlah, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="font-weight: bold; background: #fffde7;">
                    <td colspan="2" style="text-align: right;">Total Transaksi:</td>
                    <td style="color: #dc3545;">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <p style="margin-top: 30px; font-size: 12px; color: #888;">
            Email ini dikirim otomatis oleh sistem Bengkel Momo. Silakan login ke Dashboard Admin untuk memproses pesanan.
        </p>
    </div>
</body>
</html>