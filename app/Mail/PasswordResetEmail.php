<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data; // email and token

    public function __construct($data)
    {
        $this->data = $data; // ['email' => ..., 'token' => ...]
    }

    public function build()
    {
        return $this->markdown('emails.password-reset')
            ->subject('Reset Your Password')
            ->with([
                'email' => $this->data['email'],
                'token' => $this->data['token'],
            ]);
    }
}
