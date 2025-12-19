<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //
    protected $guarded = [];

    // ✅ TAMBAHKAN INI (Relasi ke User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ✅ TAMBAHKAN INI (Relasi ke Booking - Opsional jika perlu info layanan)
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
