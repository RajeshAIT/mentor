<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
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
        $subject  = 'Mentor APP';
        return $this->from('shalinir.ait99@gmail.com', 'Mentor APP')
        ->markdown('emails.mails')
        ->subject($subject)
        ->with([ 'test_message' =>  $this->mail_details['token'],
                 'name' =>  $this->mail_details['name']]);
    }
}