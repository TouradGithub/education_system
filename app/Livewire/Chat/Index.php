<?php

namespace App\Livewire\Chat;
use Illuminate\Http\Request;
use Livewire\Component;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
class Index extends Component
{
    public $selectedConversation;
    public $messages =[];

    public $newMessage = '';
    public $body ;

    protected $listeners = ['conversationSelected'];

    public function render()
    {


        return view('livewire.chat.index', [
            'selectedConversation' => $this->selectedConversation,
        ]);

    }



    public function mount()
    {

        $this->loadMessages();
    }

    public function loadMessages()
    {
        // Load messages from database or other data source
        if($this->selectedConversation){
            $conversation =Conversation::find($this->selectedConversation['id']);
            $this->messages=  $conversation->messages;

        }

        // $this->messages = Message::all();
        // dd($this->messages);
    }




    public function sendMessage()
    {
        // dd(getSchool()->id);

        Message::create([
            'body' => $this->newMessage,

            'school_id' => getSchool()->id,
            'session_year' => getYearNow()->id,
            'sender_id' => Auth::guard('teacher')->user()->id,
            'receiver_id' => $this->selectedConversation['receiver_id'],
            'conversation_id' => $this->selectedConversation['id'],
        ]);
        $this->newMessage = '';
        $this->loadMessages();
    }

    #[On('conversationSelected')]
    public function conversationSelected($conversation)
    {
        $this->selectedConversation = $conversation;
        $this->loadMessages();
        // dd($this->selectedConversation);
    }

}
