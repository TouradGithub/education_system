<?php

namespace App\Livewire\Chat;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Notifications\MessageRead;
use App\Notifications\MessageSent;
use Livewire\Component;





class ChatBox extends Component
{
    public $selectedConversation;
    public $body;
    public $loadedMessages;

    public $paginate_var = 10;

    protected $listeners = [
        'selectedConversation'
    ];



    // public function render()
    // {
    //     return view('livewire.chat.chat-box');
    // }

}
