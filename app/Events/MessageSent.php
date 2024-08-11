<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Message;
use App\Http\Resources\MessageResource;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $receiver;
    public User $sender;
    public string $message;

    /**
     * Create a new event instance.
     */
    public function __construct(User $receiver, User $sender, string $message)
    {
        $this->receiver = $receiver;
        $this->sender = $sender;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new Channel("chat." . $this->receiver->id);
    }

    public function broadcastAs()
    {
        return 'message';
    }

    // public function broadcastWith()
    // {
    //     $messages = Message::where('user_id', $this->receiver->id)->get();
    //     return MessageResource::collection($messages);
    // }
}
