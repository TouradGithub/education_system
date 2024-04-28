<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $message;
    public $conversation;
    public $receiverId;


    public function __construct($user,$message,$conversation,$receiverId)
    {
        $this->user= $user;
        $this->message= $message;
        $this->conversation= $conversation;
        $this->receiverId= $receiverId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        $users='';


        if(Auth::guard('teacher')->id()){
            $id=Auth::guard('teacher')->id();
            $users='teachers.'.$id;
        }
        if(Auth::guard('web')->id()){
            $id=Auth::guard('web')->id();
            $users='users.'.$id;
        }
        return [
            new PrivateChannel($users),

            ];
    }

    public function broadcastAs(): string
    {
        return "chat";
    }
}
