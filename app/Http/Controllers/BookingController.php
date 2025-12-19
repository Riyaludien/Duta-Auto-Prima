<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; // Panggil tukang pos
use App\Mail\UserInvoiceMail;        // Panggil surat user
use App\Mail\AdminNotificationMail;  // Panggil surat admin
use Illuminate\Support\Facades\Log;  // Untuk mencatat jika ada error
use App\Models\Booking; 
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi
        $data = $request->validate([
            'item_name' => 'required|string',
            'item_code' => 'nullable|string',
            'item_price' => 'required|string',
            'customer_name' => 'required|string',
            'customer_email' => 'required|email',
            'customer_phone' => 'required',
            'booking_date' => 'required|date',
        ]);

        // 2. SIMPAN KE DATABASE (Langkah Baru)
        Booking::create([
            'user_id' => Auth::id(), // Simpan ID jika user login
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'customer_phone' => $data['customer_phone'],
            'item_name' => $data['item_name'],
            'item_code' => $data['item_code'],
            'item_price' => $data['item_price'],
            'booking_date' => $data['booking_date'],
            'status' => 'Menunggu',
        ]);

        // 3. Kirim Email (Seperti Sebelumnya)
        // try {
            Mail::to($data['customer_email'])->send(new UserInvoiceMail($data));
            Mail::to('novieanramadan@gmail.com')->send(new AdminNotificationMail($data));
        // } catch (\Exception $e) {
        //    Log::error("Gagal kirim email: " . $e->getMessage());
       //  } 

        return back()->with('success', 'Pesanan berhasil disimpan & Invoice dikirim!');
    }
}