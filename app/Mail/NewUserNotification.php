<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUserNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
        ->to('bonjour@mailtrap.io')
        ->cc('hola@mailtrap.io')
           ->subject('Auf Wiedersehen')
           ->markdown('mails.exmpl')
           ->with([
             'name' => 'New Mailtrap User',
             'link' => '/inboxes/'
           ]);
}
    }
}
