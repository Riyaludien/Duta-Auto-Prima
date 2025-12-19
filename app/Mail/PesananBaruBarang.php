<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PesananBaruBarang extends Mailable
{
    use Queueable, SerializesModels;

    // Tambahkan variabel publik agar otomatis terlempar ke view
    public $transaksi;

    /**
     * Create a new message instance.
     */
    public function __construct($transaksi)
    {
        // Tangkap data transaksi dari Controller
        $this->transaksi = $transaksi;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Konfirmasi Pesanan - Bengkel Momo (#' . $this->transaksi->id . ')',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.pesanan_barang', // Nama file view yang akan kita buat
        );
    }

    public function attachments(): array
    {
        return [];
    }
}