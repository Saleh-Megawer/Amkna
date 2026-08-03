<?php
namespace App\Mail;

use Illuminate\Mail\Mailable;

class MarketerRejectedMail extends Mailable
{
    public $user;
    public $messageText;

    public function __construct($user, $message)
    {
        $this->user        = $user;
        $this->messageText = $message;
    }

    public function build()
    {
        return $this->subject('Your Marketer Application Status')
            ->markdown('emails.marketers.rejected');
    }
}
