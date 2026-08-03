<?php
namespace App\Mail;

use Illuminate\Mail\Mailable;

class MarketerApprovedMail extends Mailable
{
    public $user;
    public $password;

    public function __construct($user, $password)
    {
        $this->user     = $user;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Your Marketer Application Has Been Approved')
            ->markdown('emails.marketers.approved');
    }
}
