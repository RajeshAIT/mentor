<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $mail_details;

    public function __construct($mail_details)
    {
        $this->mail_details = $mail_details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from("shalinir.ait99@gmail.com", "Sender Name")
        ->subject('Password Reset Link')
        ->markdown('emails.reset_password')
        ->with([ 'test_message' =>  $this->mail_details['token'],
                 'email' =>  $this->mail_details['email'],
                 'name' =>  $this->mail_details['name']]);
    }
}
