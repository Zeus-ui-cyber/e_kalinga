<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageSent implements ShouldBroadcast
{
    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message->load(['sender', 'receiver']);
    }

    public function broadcastOn()
    {
        return new PrivateChannel('chat.' . $this->message->receiver_id);
    }

    public function broadcastAs()
    {
        return 'message.sent';
    }
}