<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ThankYouMail extends Mailable
{
    use Queueable, SerializesModels;

    public $alumnus;
    public $type;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($alumnus, $type)
    {
        $this->alumnus    = $alumnus;  
        $this->type       = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject     = '';
        
        if( $this->type=='membership' ) 
        {
            $subject = 'Successful Registration to IOH CONNECT';

            return $this->subject( $subject )
                ->replyTo(config('ticket.membership_email'), 'IOH Membership')
                ->view('emails.membership');
        }
        else if( $this->type=='event' ) 
        {
            $subject = 'Harrow Alumni Gathering event on 16 January 2020';
            return $this->subject( $subject )
                ->replyTo(config('ticket.event_email'), 'IOH Events')
                ->view('emails.event');
        }
    }
}
