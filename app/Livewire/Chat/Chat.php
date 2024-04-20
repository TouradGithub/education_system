<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Message;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
class Chat extends Component
{

    public $query;
    public $selectedConversation;

    public function mount()
    {

        // $this->selectedConversation= Conversation::findOrFail($this->query);
       /// dd($selectedConversation);
    //    #mark message belogning to receiver as read
    //    Message::where('conversation_id',$this->selectedConversation->id)
    //             ->where('receiver_id',Auth::guard('teacher')->id())
    //             ->whereNull('read_at')
    //             ->update(['read_at'=>now()]);


    }


    public function render()
    {
        // return view('livewire.chat.chat');
    }
}
