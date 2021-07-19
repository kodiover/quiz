<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SubscribeToMailchimp
{
    private $mailchimp;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(\Mailchimp $mailchimp)
    {
        $this->mailchimp = $mailchimp;
    }

    /**
     * Handle the event.
     *
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $this->mailchimp->lists->subscribe(
            env('MAILCHIMP_LIST_ID'),
            ['email' => $event->user->email],
            null,
            null,
            false
        );
    }
}
