<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🔔 Pesanan Baru Masuk! - Bengkel Momo',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin_notification', // Nanti kita buat file ini di Bagian C
        );
    }

    public function attachments(): array
    {
        return [];
    }
}