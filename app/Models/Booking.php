<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    // Izinkan semua kolom diisi
    protected $guarded = [];

    public function review()
    {
        return $this->hasOne(Review::class);
    }
}
