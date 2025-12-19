<!DOCTYPE html>
<html>
<head>
    <title>Order Baru</title>
</head>
<body style="font-family: Arial, sans-serif;">
    <div style="background-color: #f8d7da; padding: 20px; border: 1px solid #f5c6cb; border-radius: 5px;">
        <h2 style="color: #721c24;">🔔 Ada Pesanan Baru!</h2>
        <p>Seorang pelanggan baru saja melakukan booking via website.</p>
        
        <ul>
            <li><strong>Nama Pelanggan:</strong> {{ $data['customer_name'] }}</li>
            <li><strong>No. WhatsApp:</strong> <a href="https://wa.me/{{ $data['customer_phone'] }}">{{ $data['customer_phone'] }}</a></li>
            <li><strong>Layanan:</strong> {{ $data['item_name'] }}</li>
            <li><strong>Tanggal Rencana:</strong> {{ $data['booking_date'] }}</li>
        </ul>

        <p>Segera hubungi pelanggan untuk konfirmasi.</p>
    </div>
</body>
</html>