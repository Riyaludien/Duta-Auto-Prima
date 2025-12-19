<!DOCTYPE html>
<html>
<head>
    <title>Invoice Pesanan</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
    <div style="border: 1px solid #ddd; padding: 20px; max-width: 600px; margin: auto;">
        <h2 style="color: #FF0000;">Bengkel Momo</h2>
        <hr>
        <h3>Halo, {{ $data['customer_name'] }}!</h3>
        <p>Terima kasih telah melakukan pemesanan layanan jasa kami. Berikut adalah detail pesanan Baginda:</p>
        
        <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #ddd;">Layanan</td>
                <td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>{{ $data['item_name'] }}</strong></td>
            </tr>
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #ddd;">Harga Estimasi</td>
                <td style="padding: 8px; border-bottom: 1px solid #ddd; color: #FF0000;"><strong>{{ $data['item_price'] }}</strong></td>
            </tr>
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #ddd;">Tanggal Booking</td>
                <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $data['booking_date'] }}</td>
            </tr>
        </table>

        <p style="margin-top: 20px;">Silakan datang ke bengkel kami pada tanggal tersebut dan tunjukkan email ini kepada petugas.</p>
        
        <br>
        <p style="font-size: 12px; color: #777;">Salam Hormat,<br>Admin Bengkel Momo</p>
    </div>
</body>
</html>