<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendCotizacion extends Mailable
{
    use Queueable, SerializesModels;

    protected $productos;
    protected $nombre;

    /**
     * Create a new message instance.
     */
    public function __construct($productos, $nombre)
    {
        $this->productos = $productos;
        $this->nombre = $nombre;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Cotización',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.cotizaciones',
            with: ['productos' => $this->productos, 'nombre' => $this->nombre],
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
