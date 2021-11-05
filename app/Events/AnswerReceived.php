<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AnswerReceived implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $session;
    protected $response;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($session, $response)
    {
        $this->session = $session;
        $this->response = $response;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("User.Quiz.{$this->session->id}");
    }
    
    /**
     * Return an array from the variable passed
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'response' => $this->response
        ];
    }
}

