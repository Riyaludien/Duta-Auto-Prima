<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data; // Ini keranjang untuk membawa data pesanan

    // Konstruktor: Menerima data dari Controller
    public function __construct($data)
    {
        $this->data = $data;
    }

    // Amplop Surat (Subjek Email)
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invoice Pemesanan Jasa - Bengkel Momo',
        );
    }

    // Isi Surat (Menunjuk ke File View)
    public function content(): Content
    {
        return new Content(
            view: 'emails.user_invoice', // Nanti kita buat file ini di Bagian C
        );
    }

    public function attachments(): array
    {
        return [];
    }
}