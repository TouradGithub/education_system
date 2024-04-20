<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ChatList extends Component
{
    public $selectedConversation;
    public $query;




    public function render()
    {
        $conversations = Conversation::all();
        return view('livewire.chat.chat-list', ['conversations' => $conversations]);
    }

    public function selectConversation($conversationId)
    {
        $this->selectedConversation = Conversation::findOrFail($conversationId);

        $this->dispatch('conversationSelected', $this->selectedConversation);

        // $this->emit('conversationSelected', $conversationId);
    }


}
