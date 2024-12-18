<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PusherBroadcast implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $message;
    public $customer_id;
    public $seller_id;

    public function __construct($message, $customer_id, $seller_id)
    {
        $this->message = $message;
        $this->customer_id = $customer_id;
        $this->seller_id = $seller_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): Channel
    {
        $channelName = "chat.{$this->seller_id}_{$this->customer_id}";
        return new Channel($channelName);
    }

    public function broadcastAs(): string
    {
        return 'chat';
    }

    public function broadcastWith()
    {
        return [
            'message' => [
                'message_text' => $this->message->message_text,
            ],
            'customer_id' => $this->customer_id,
            'seller_id' => $this->seller_id
        ];
    }
}
