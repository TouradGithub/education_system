<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ChatList extends Component
{
    public $selectedConversation;
    public $conversations;
    public $query;

    protected $listeners=['refresh'=>'$refresh'];


    public function render()
    {  $this-> loadConversations();
        return view('livewire.chat.chat-list');
    }

    public function mount()
    {
        $this->loadConversations();
    }

    public function loadConversations()
    {
        $this->conversations =Auth::guard('teacher')->user()->conversations;
    }

    public function selectConversation($conversationId)
    {
        $this->selectedConversation = Conversation::findOrFail($conversationId);

        $this->dispatch('conversationSelected', $this->selectedConversation);

    }

    // #[On('updateLastMessageForConversation')]
    // public function updateLastMessageForConversation()
    // {
    //     dd("tt");
    //     $this->loadConversations();
    // }


}
