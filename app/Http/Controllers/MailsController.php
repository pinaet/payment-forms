<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Mail\ThankYouMail;
use Config;

class MailsController extends Controller
{
    private $mode = '';

    public function __construct()
    {
        $this->mode = config( 'ticket.mode' );
    }

    public function sendMembershipMail($alumnus)
    {
        config(['mail.username' => config('ticket.membership_email')]);
        config(['mail.password' => config('ticket.membership_email_pass')]);
        config(['mail.from'     => ['address' => config('ticket.membership_email'), 'name' => 'IOH Membership']]);
        config(['mail.reply_to' => ['address' => config('ticket.membership_email'), 'name' => 'IOH Membership']]);
        // (new \Illuminate\Mail\MailServiceProvider(app()))->register();
        app()->forgetInstance('swift.transport');
        app()->forgetInstance('swift.mailer');
        app()->forgetInstance('mailer');

        $type = 'membership';
        $to   = $alumnus['email'];
        $bcc  = explode(',', config('ticket.' . config('ticket.mode') . '.membership_bcc'));
        Mail::to($to)
            ->bcc($bcc)
            ->queue(new ThankYouMail($alumnus, $type));
    }

    public function sendEventMail($alumnus)
    {
        config(['mail.username' => config('ticket.event_email')]);
        config(['mail.password' => config('ticket.event_email_pass')]);
        config(['mail.from'     => ['address' => config('ticket.event_email'), 'name' => 'IOH Events']]);
        config(['mail.reply_to' => ['address' => config('ticket.event_email'), 'name' => 'IOH Events']]);
        // (new \Illuminate\Mail\MailServiceProvider(app()))->register();
        app()->forgetInstance('swift.transport');
        app()->forgetInstance('swift.mailer');
        app()->forgetInstance('mailer');

        $type = 'event';
        $to   = $alumnus['email'];
        $bcc  = explode(',', config('ticket.' . config('ticket.mode') . '.event_bcc'));

        Mail::to($to)
            ->bcc($bcc)
            ->queue(new ThankYouMail($alumnus, $type));
    }
}
