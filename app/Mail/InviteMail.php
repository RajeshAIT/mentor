<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteMAil extends Mailable
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
        return $this->from('shalinir.ait99@gmail.com', 'Invite People')
        ->markdown('emails.invitepeople')
        ->subject($subject)
        ->with(['test_message' => $this->mail_details['invite_link'],'company_id' =>  $this->mail_details['company_id']]);
    }
}