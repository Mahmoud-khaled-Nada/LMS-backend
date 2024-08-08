<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ForgetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $code;
    public function __construct( $code )
    {
        $this->code = $code;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Forget Password',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mails.forgetpassword',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
