<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MensagemEmprestimoDevolvido extends Mailable
{
    use Queueable, SerializesModels;

    /**
    * Create a new message instance.
    */
    public function __construct($emprestimo)
    {
        $this->emprestimo = $emprestimo;
    }

    /**
    * Get the message envelope.
    */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Você devolveu um livro!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.mensagem_emprestimo_devolvido',
            with: [
                'emprestimo' => $this->emprestimo,
            ],
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
