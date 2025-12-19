<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking; // Panggil Model Booking
use Illuminate\Support\Facades\Auth;
use App\Models\Review;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil ID User
        $userId = Auth::id();

        // 2. Siapkan Query Dasar (Milik user ini)
        $query = Booking::where('user_id', $userId);

        // 3. CEK FILTER: Jika ada request 'status', tambahkan filter
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // 4. Eksekusi (Urutkan dari terbaru)
        $bookings = $query->latest()->get();

        // 5. Kirim ke View
        return view('user.riwayat.index', compact('bookings'));
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