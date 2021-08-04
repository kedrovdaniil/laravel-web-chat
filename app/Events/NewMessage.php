<?php

namespace App\Events;

use App\Models\Chat;
use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The order instance.
     *
     * @var \App\Models\Message
     */
    public $chatId;
    public $message;
    public $senderId;

    /**
     * Create a new event instance.
     *
     * @param int $chatId
     * @param Message $message
     * @param int $senderId
     */
    public function __construct(int $chatId, Message $message, int $senderId)
    {
        $this->chatId = $chatId;
        $this->message = $message;
        $this->senderId = $senderId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('messenger');
    }

    public function broadcastAs()
    {
        return "NewMessage";
    }

    public function broadcastWith()
    {
        return ['chatId' => $this->chatId, 'message' => $this->message, 'senderId' => $this->senderId];
    }
}
