<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking; // Panggil Model Booking
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil ID User
        $userId = Auth::id();

        // 2. Query untuk Jasa (Booking)
        $queryBooking = Booking::where('user_id', $userId);
        if ($request->filled('status')) {
            $queryBooking->where('status', $request->status);
        }
        $bookings = $queryBooking->latest()->get();

        // 3. Query untuk Barang (Transaksi) - TAMBAHKAN INI
        $queryTransaksi = Transaksi::with('details.barang')->where('user_id', $userId);
        if ($request->filled('status')) {
            $queryTransaksi->where('status', $request->status);
        }
        $transaksis = $queryTransaksi->latest()->get(); // Variabel ini yang dicari oleh Blade

        // 4. Kirim KEDUA variabel ke View dengan compact
        return view('user.riwayat.index', compact('bookings', 'transaksis'));
    }

    public function cancel($id)
    {
        // 1. Cari Booking milik user yang sedang login
        $booking = Booking::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail(); // Error 404 jika bukan miliknya

        // 2. Cek apakah status masih 'Menunggu'
        if ($booking->status == 'Menunggu') {
            $booking->update(['status' => 'Batal']);
            return back()->with('success', 'Pesanan berhasil dibatalkan.');
        }

        // 3. Jika status sudah 'Proses' atau lainnya
        return back()->with('error', 'Pesanan tidak bisa dibatalkan karena sudah diproses.');
    }

    public function cancelBarang($id)
    {
        $transaksi = Transaksi::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'Menunggu') // Hanya bisa batal jika masih menunggu
            ->firstOrFail();

        // Kembalikan stok barang jika dibatalkan
        foreach ($transaksi->details as $detail) {
            $detail->barang->increment('stok', $detail->jumlah);
        }

        $transaksi->update(['status' => 'Batal']);

        return back()->with('success', 'Pesanan barang berhasil dibatalkan dan stok dikembalikan.');
    }

    public function cetakInvoice($id)
    {
        // Cari booking milik user, pastikan status Selesai
        $booking = Booking::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'Selesai')
            ->firstOrFail();

        return view('user.riwayat.invoice', compact('booking'));
    }

    public function storeReview(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        // Cek apakah user ini pemilik booking
        $booking = Booking::where('id', $request->booking_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Cek apakah sudah pernah review (agar tidak double)
        if (Review::where('booking_id', $booking->id)->exists()) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk pesanan ini.');
        }

        Review::create([
            'booking_id' => $booking->id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return back()->with('success', 'Terima kasih atas ulasan Anda!');
    }
}