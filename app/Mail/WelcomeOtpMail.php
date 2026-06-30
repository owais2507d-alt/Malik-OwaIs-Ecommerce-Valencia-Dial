<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeOtpMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    
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
            view: 'email.welcome-otp', 
            with: [
                'user' => $this->user,
                'otp' => $this->otp,
            ]
        );
    }
}