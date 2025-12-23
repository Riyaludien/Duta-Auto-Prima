<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $transaksi->nomor_invoice }}</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 40px;
            color: #333;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #ddd;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #d32f2f;
        }

        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 5px;
        }

        .total-box {
            border: 2px solid #333;
            padding: 10px;
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }

        /* Tombol Print (Hilang saat diprint) */
        @media print {
            .no-print {
                display: none;
            }
        }

        .btn-print {
            background: #333;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-bottom: 20px;
        }

    </style>
</head>
<body>

    <a href="javascript:window.print()" class="no-print btn-print">🖨️ Cetak / Simpan PDF</a>
    <a href="{{ route('riwayat.index') }}" class="no-print" style="margin-left: 10px; text-decoration: none; color: #555;">Kembali</a>

    <div class="header">
        <div class="logo">BENGKEL MOMO</div>
        <div>Kasihan RT 07 Tamantirto, Kasih, Tamantirto, Kec. Kasihan, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55183</div>
        <div>WhatsApp: 0838-3876-2064</div>
    </div>

    <table class="info-table">
        <tr>
            <td width="15%"><strong>No. Invoice</strong></td>
            <td>: {{ $transaksi->nomor_invoice }}</td>
            <td width="15%"><strong>Tanggal</strong></td>
            <td>: {{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td><strong>Pelanggan</strong></td>
            <td>: {{ Auth::user()->name }}</td>
            <td><strong>Status</strong></td>
            <td>: LUNAS (Selesai)</td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;" border="1" cellpadding="10">
        <tr style="background: #f4f4f4;">
            <th>Daftar Barang</th>
            <th width="10%">Qty</th>
            <th width="20%" style="text-align: right;">Harga</th>
            <th width="20%" style="text-align: right;">Subtotal</th>
        </tr>
        @foreach($transaksi->details as $detail)
        <tr>
            <td>
                <b>{{ $detail->barang->nama_barang }}</b><br>
                <small>Kategori: {{ $detail->barang->kategori->nama_kategori ?? '-' }}</small>
            </td>
            <td style="text-align: center;">{{ $detail->jumlah }}</td>
            <td style="text-align: right;">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
            <td style="text-align: right;">Rp {{ number_format($detail->jumlah * $detail->harga_satuan, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </table>

    <div class="total-box">
        Total Bayar: Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
    </div>

    <div class="footer">
        Terima kasih telah berbelanja suku cadang di Bengkel Momo.<br>
        Barang yang sudah dibeli tidak dapat ditukar kecuali ada perjanjian garansi sebelumnya.
    </div>

    <script>
        // Otomatis muncul dialog print saat dibuka
        window.onload = function() {
            window.print();
        }

    </script>
</body>
</html>
