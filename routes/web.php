<?php

use App\Models\Review;
use App\Models\Barang;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\LogStokController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DetailTransaksiController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\Admin\OrderBarangController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ====================================================
// HALAMAN UTAMA (PUBLIC & USER JADI SATU)
// ====================================================

Route::get('/', function () {
    return view('welcome');
})->name('landing');

Route::get('/beranda', function () {
    $reviews = Review::with('user')->latest()->take(6)->get();
    $barangs = Barang::all();
    return view('user.beranda', compact('reviews', 'barangs'));
})->name('beranda');

Route::redirect('/home', '/beranda');
Route::redirect('/welcome', '/');

// Route::get('/beranda', function () {
//     // 1. Ambil 6 Ulasan Terbaru (Beserta data User-nya)
//     $reviews = Review::with('user')->latest()->take(6)->get();

//     // 2. Tampilkan Halaman Beranda
//     return view('user.beranda', compact('reviews'));
// })->name('beranda');

// // Redirect /home agar lari ke / juga
// Route::redirect('/home', '/');

// // Redirect /welcome agar lari ke / juga (jaga-jaga kalau ada link lama)
// Route::redirect('/welcome', '/');

// // Tambahan Redirect agar tidak 404 saat akses /beranda
// Route::redirect('/beranda', '/');


// --- MENU NAVBAR LAINNYA ---
Route::get('/bengkel', function () {
    return view('user.bengkel.index');
})->name('bengkel.index');

Route::get('/promo', function () {
    return view('user.promo.index');
})->name('promo.index');

Route::get('/mitra', function () {
    return view('user.mitra.index');
})->name('mitra.join');

// --- KATALOG / MARKETPLACE ---
Route::get('/katalog', function () {
    return view('user.katalog.index');
})->name('katalog.index');

Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog');

Route::get('/katalog/{id}', function ($id) {
    return view('user.katalog.detail', ['id' => $id]);
})->name('katalog.detail');

// --- JASA ---
Route::get('/jasa', function () {
    return view('user.jasa.index');
})->name('jasa.index');

// --- LAYANAN (Dinamis) ---
Route::get('/layanan/{kategori}', function ($kategori) {
    return "Halaman Layanan: " . $kategori;
})->name('layanan.kategori');

// --- FOOTER (Lokasi & Artikel) ---
Route::get('/lokasi', function () {
    return view('user.lokasi.index');
})->name('lokasi.index');

Route::get('/artikel', function () {
    return view('user.artikel.index');
})->name('artikel.index');

Route::get('/artikel/{slug}', function ($slug) {
    return "Baca Artikel: $slug";
})->name('artikel.detail');

// Rute Riwayat Transaksi
Route::get('/riwayat-transaksi', function () {
    return view('user.riwayat.index'); // Pastikan file view ini nanti dibuat
})->name('riwayat.index');

Route::put('/riwayat/{id}/cancel', [RiwayatController::class, 'cancel'])->name('riwayat.cancel');

Route::get('/riwayat/{id}/invoice', [RiwayatController::class, 'cetakInvoice'])->name('riwayat.invoice');
// Route untuk Invoice Barang (Tambahkan jika belum ada)
Route::get('/riwayat/invoice-barang/{id}', [RiwayatController::class, 'cetakInvoiceBarang'])->name('riwayat.invoice.barang');

// Rute untuk memproses booking
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

Route::get('/kirim-test', function () {
    try {
        Mail::raw('Halo Baginda, ini tes email dari Bengkel Momo!', function ($message) {
            $message->to('novianbimarmd11@gmail.com')
                ->subject('Tes Koneksi Email Berhasil');
        });
        return '<h1>SUKSES! Email terkirim. Pengaturan sudah benar.</h1>';
    } catch (\Exception $e) {
        return '<h1>GAGAL!</h1> <br>' . $e->getMessage();
    }
});

Route::post('/riwayat/review', [RiwayatController::class, 'storeReview'])->name('riwayat.review.store');

// Rute Katalog
Route::get('/katalog', [KatalogController::class, 'index'])
    ->name('katalog.index');

Route::get('/tentang-kami', [DashboardController::class, 'about'])->name('about');

// ====================================================
// 2. LOGIKA REDIRECT SETELAH LOGIN
// ====================================================
Route::get('/dashboard', function () {
    // Jika Admin, ke dashboard Admin
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    // Jika User biasa, kembalikan ke Beranda
    return redirect()->route('beranda');
})->middleware(['auth', 'verified'])->name('dashboard');


// ====================================================
// 3. RUTE ADMIN (Wilayah Terlarang / Wajib Login Admin)
// ====================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('barangs', BarangController::class);
    Route::resource('kategoris', KategoriBarangController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::get('log-stoks', [LogStokController::class, 'index'])->name('log_stoks.index');
    Route::resource('transaksis', TransaksiController::class);

    Route::prefix('transaksis/{transaksi}')->group(function () {
        Route::resource('detail_transaksis', DetailTransaksiController::class);
    });

    // Rute Booking Admin
    Route::get('/pesanan', [AdminBookingController::class, 'index'])->name('admin.bookings.index');
    Route::post('/pesanan/{id}/update', [AdminBookingController::class, 'updateStatus'])->name('admin.bookings.update');

    // Route Dashboard Pesanan Barang
    Route::get('/pesanan-barang', [OrderBarangController::class, 'index'])->name('transaksi.index');

    // Route Update Status
    Route::put('/pesanan-barang/{id}/update', [OrderBarangController::class, 'updateStatus'])->name('transaksi.update');
});


// ====================================================
// 4. RUTE KHUSUS USER (Wajib Login)
// ====================================================
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/riwayat-transaksi', [RiwayatController::class, 'index'])->name('riwayat.index');

    // Cart
    Route::middleware(['auth'])->group(function () {
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
        Route::delete('/cart/delete/{id}', [CartController::class, 'destroy'])->name('cart.delete');
        Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
    });

    // Tempatkan fitur yang BENAR-BENAR butuh login di sini.
    // Contoh: Booking Service, Riwayat Transaksi, Edit Profil.
    // Beranda sudah hamba pindahkan ke atas (Publik).

});


// ====================================================
// 5. PROFILE & AUTH
// ====================================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';