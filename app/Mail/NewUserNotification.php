<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUserNotification extends Mailable
{
    use Queueable, SerializesModels;

    private $mail;
    private $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Mailable $mail, $user)
    {
        $this->mail = $mail;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): self
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
           ->subject('Quiz Application')
           ->markdown('mails.exmpl')
           ->with([
             'user' => User::where('id', $this->user->id)
           ]);
    }
    
}
