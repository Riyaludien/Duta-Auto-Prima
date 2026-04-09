@extends('layouts.user')

@section('title', 'Bengkel Momo - Booking Service Mudah & Terpercaya')

@section('content')
    <!-- 🔥 HERO -->
    <section>
        <h1>Spooring & Balancing</h1>
        <p>Biar mobil lo lurus jalannya, gak getar, dan ban lebih awet.</p>
        <a href="#paket">Lihat Paket</a>
    </section>

    <!-- 🧠 PENJELASAN -->
    <section>
        <h2>Apa itu Spooring & Balancing?</h2>
        <p>
            Spooring adalah proses meluruskan kembali posisi roda agar sesuai standar pabrik,
            sedangkan balancing bertujuan menyeimbangkan putaran roda agar tidak getar saat berkendara.
        </p>
    </section>

    <!-- ⚙️ SPOORING -->
    <section>
        <h2>Spooring</h2>
        <ul>
            <li>Meluruskan sudut roda</li>
            <li>Mengurangi keausan ban</li>
            <li>Meningkatkan kestabilan mobil</li>
        </ul>
    </section>

    <!-- ⚖️ BALANCING -->
    <section>
        <h2>Balancing</h2>
        <ul>
            <li>Menghilangkan getaran saat kecepatan tinggi</li>
            <li>Menyeimbangkan roda</li>
            <li>Meningkatkan kenyamanan berkendara</li>
        </ul>
    </section>

    <!-- 💰 PAKET / HARGA -->
    <section id="paket">
        <h2>Paket Spooring & Balancing</h2>

        {{-- NANTI DIISI DARI DATABASE --}}
        @foreach ($jasa as $item)
            <div>
                <h3>{{ $item->nama_jasa }}</h3>
                <p>{{ $item->deskripsi }}</p>
                <strong>Rp {{ number_format($item->harga) }}</strong>
                <br>
                <button>Booking</button>
            </div>
        @endforeach

    </section>

    <!-- ⭐ KEUNGGULAN -->
    <section>
        <h2>Kenapa Pilih Bengkel Momo?</h2>
        <ul>
            <li>Teknisi berpengalaman</li>
            <li>Alat modern & akurat</li>
            <li>Pengerjaan cepat</li>
            <li>Harga transparan</li>
        </ul>
    </section>

    <!-- 🚀 CTA -->
    <section>
        <h2>Siap Bikin Mobil Lo Nyaman Lagi?</h2>
        <button>Booking Sekarang</button>
    </section>


@endsection