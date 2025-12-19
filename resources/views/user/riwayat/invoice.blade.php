<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $booking->id }}</title>
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
            <td>: INV/{{ $booking->created_at->format('Ymd') }}/{{ $booking->id }}</td>
            <td width="15%"><strong>Tanggal</strong></td>
            <td>: {{ $booking->booking_date }}</td>
        </tr>
        <tr>
            <td><strong>Pelanggan</strong></td>
            <td>: {{ $booking->customer_name }}</td>
            <td><strong>Status</strong></td>
            <td>: LUNAS (Selesai)</td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;" border="1" cellpadding="10">
        <tr style="background: #f4f4f4;">
            <th>Deskripsi Layanan</th>
            <th width="30%" style="text-align: right;">Harga</th>
        </tr>
        <tr>
            <td>
                <b>{{ $booking->item_name }}</b><br>
                <small>Kode: {{ $booking->item_code ?? '-' }}</small>
            </td>
            <td style="text-align: right;">{{ $booking->item_price }}</td>
        </tr>
    </table>

    <div class="total-box">
        Total Bayar: {{ $booking->item_price }}
    </div>

    <div class="footer">
        Terima kasih telah mempercayakan kendaraan Anda kepada Bengkel Momo.<br>
        Simpan bukti ini sebagai garansi servis (jika berlaku).
    </div>

    <script>
        // Otomatis muncul dialog print saat dibuka
        window.onload = function() {
            window.print();
        }

    </script>
</body>
</html>
