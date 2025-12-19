<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifPesananAdminBarang extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Get the message envelope.
     */
    public $transaksi;

    public function __construct($transaksi)
    {
        $this->transaksi = $transaksi;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🚨 PESANAN BARU MASUK! - #' . $this->transaksi->id,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.notif_admin_barang', // Pastikan file view ini ada
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
