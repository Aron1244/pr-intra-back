<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable,
        InteractsWithSockets,
        SerializesModels;

    public Message $message;

    /**
     * Create event
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Channel to broadcast
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel(
                'conversation.' .
                $this->message->conversation_id
            ),
        ];
    }

    /**
     * Event name (optional but good)
     */
    public function broadcastAs(): string
    {
        return 'message.sent';
    }
}