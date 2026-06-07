<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    // Variables ko public rakhna zaroori hai taaki Blade directly access kare
    public $user;
    public $otp;

    public function __construct($user, $otp)
    {
        $this->user = $user;
        $this->otp = $otp;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verify Your Valencia Dial Account',
        );
    }

   public function content(): Content
    {
        return new Content(
            view: 'email.welcome-otp', // 'emails.' hata diya kyunki file direct views folder mein hai
            with: [
                'user' => $this->user,
                'otp' => $this->otp,
            ]
        );
    }
}