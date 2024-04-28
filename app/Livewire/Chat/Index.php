<?php

namespace App\Livewire\Chat;
use Illuminate\Http\Request;
use Livewire\Component;
use App\Models\Conversation;
use App\Models\Message;
// use App\Notifications\MessageSent;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
class Index extends Component
{
    public $selectedConversation;
    public $messages =[];
    public $query;
    public $newMessage = '';
    public $body ;

    protected $listeners = ['conversationSelected'];

    public function getListeners()
    {

        $auth_id = Auth::guard('teacher')->id();
        $user='';


        if(Auth::guard('teacher')->id()){
            $auth_id=Auth::guard('teacher')->id();
            $user='teachers';
        }
        if(Auth::guard('web')->id()){
            $auth_id=Auth::guard('web')->id();
            $user='users';
        }

        return [

            'conversationSelected',
            "echo-private:private-teachers.1,chat" => 'broadcastedNotifications'

        ];
    }
    public function broadcastedNotifications($event)
    {
        dd($event);
    // if ($event['type'] == MessageSent::class) {

        // if ($event['conversation_id'] == $this->selectedConversation->id) {

        //     $this->dispatchBrowserEvent('scroll-bottom');

        //     $newMessage = Message::find($event['message_id']);


        //     #push message
        //     $this->loadedMessages->push($newMessage);


        //     #mark as read
        //     $newMessage->read_at = now();
        //     $newMessage->save();

        //     #broadcast
        //     $this->selectedConversation->getReceiver()
        //         ->notify(new MessageRead($this->selectedConversation->id));
        // }

    }

    public function render()
    {

        // dd($this->query);
        return view('livewire.chat.index', [
            'selectedConversation' => $this->selectedConversation,
        ]);

    }



    public function mount()
    {
        $loggedInUserId = Auth::guard('teacher')->id();




        if($this->query){
            // dd($this->query);
            $this->selectedConversation=  Conversation::where(['sender_id'=>$this->query,'receiver_id'=>Auth::guard('teacher')->user()->id ])
            ->orWhere(['receiver_id'=>$this->query,'sender_id'=>Auth::guard('teacher')->user()->id ])->first();
            if(!$this->selectedConversation){
                $this->selectedConversation=   Conversation::create([
                    'receiver_id'=>$this->query,
                    'sender_id'=>Auth::guard('teacher')->user()->id,
                    'school_id' => getSchool()->id,
                    'session_year' => getYearNow()->id,
                ]);
            }
            // Conversation::find($this->query);
            // dd( $this->selectedConversation);
        }
            // dd($this->selectedConversation);

            // $this->loadMessages();
            #mark message belogning to receiver as read
            if($this->selectedConversation){
                // dd($this->selectedConversation);
                $unreadMessages = $this->selectedConversation->messages()
                ->where('receiver_id', $loggedInUserId)
                ->whereNull('read_at')
                ->get();

            foreach ($unreadMessages as $message) {
                $message->update(['read_at' => now()]);
            }
            }

            // Echo.private(`messages${this.user.id}`).listen('NewMessage', (e) => {
            //     this.handleIncoming(e.message)
            // });
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

        $createdMessage =   Message::create([
            'body' => $this->newMessage,
            'school_id' => getSchool()->id,
            'session_year' => getYearNow()->id,
            'sender_id' => Auth::guard('teacher')->user()->id,
            'receiver_id' => $this->selectedConversation['receiver_id'],
            'conversation_id' => $this->selectedConversation['id'],
        ]);
        $this->newMessage = '';

       $con= Conversation::find($this->selectedConversation['id']);

        // $receiver = $this->selectedConversationgetReceiver;
        // dd($con->getReceiver());
        broadcast(new MessageSent(
            Auth::guard('teacher')->user(),
            $createdMessage,
            $this->selectedConversation['id'],
            $con->getReceiver()->id
        ))->toOthers();


        $this->dispatch('refresh');
        $this->loadMessages();
    }

    //    #broadcast
    //    Conversation::find( $this->selectedConversation['id']);


    #[On('conversationSelected')]
    public function conversationSelected($conversation)
    {
        $this->selectedConversation = $conversation;
        $this->loadMessages();
    }

}
