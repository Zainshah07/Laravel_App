<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifyRegistrationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public $url;

    /**
     * Create a new message instance.
     *
     * @param  $user  The registered user object
     */
    public function __construct($user)
    {
        $this->user = $user;
        // Generate verification URL containing the unique token
        $this->url = route('verify.email', [
            'token' => $this->user->verification_token,
            'email' => $this->user->email]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verify Registration Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.verify',
            with: ['url' => $this->url, 'user' => $this->user]  // Pass data to Blade view

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
