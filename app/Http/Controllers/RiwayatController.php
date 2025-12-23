<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Transaksi;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $type = $request->get('type', 'all');
        $status = $request->get('status');

        $merged = collect();

        // 1. Ambil Jasa (Booking) + Relasi Review
        if ($type == 'all' || $type == 'jasa') {
            $bookings = Booking::with('review') // LOAD REVIEW DI SINI
                ->where('user_id', $userId)
                ->when($status, function ($query) use ($status) {
                    return $query->where('status', $status);
                })
                ->latest()
                ->get();
            $merged = $merged->concat($bookings);
        }

        // 2. Ambil Barang (Transaksi) + Relasi Details
        if ($type == 'all' || $type == 'barang') {
            $transaksis = Transaksi::with('details.barang') // LOAD DETAILS DI SINI
                ->where('user_id', $userId)
                ->when($status, function ($query) use ($status) {
                    return $query->where('status', $status);
                })
                ->latest()
                ->get();
            $merged = $merged->concat($transaksis);
        }

        // Urutkan berdasarkan tanggal terbaru
        $sorted = $merged->sortByDesc('created_at');

        // 3. Manual Pagination
        $perPage = 10;
        $currentPage = $request->input('page', 1);
        $currentItems = $sorted->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $paginatedItems = new LengthAwarePaginator(
            $currentItems,
            $sorted->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('user.riwayat.index', ['bookings' => $paginatedItems]);
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

    public function cetakInvoiceBarang($id)
    {
        $transaksi = Transaksi::with('details.barang')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'Selesai')
            ->firstOrFail();

        return view('user.riwayat.invoice_barang', compact('transaksi'));
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