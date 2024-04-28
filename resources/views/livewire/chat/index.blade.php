
<div>
    <div class="card chat-app">
        <livewire:chat.chat-list >
       @if ($selectedConversation && $selectedConversation['id'])
       @php
        $conversation=   App\Models\Conversation::find($selectedConversation['id']);
       @endphp
       <div class="chat ">
        <div class="chat-header clearfix">
            <div class="row">
                <div class="col-lg-6">
                    <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                        <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="avatar">
                    </a>
                    <div class="chat-about">
                        @if ($conversation->getReceiver()->id==Auth::guard('teacher')->user()->id)
                        <h6 class="m-b-0">    {{  $conversation->getSender()->first_name  }} {{$conversation->getSender()->last_name}}</h6>
                        @else
                        <h6 class="m-b-0">{{  $conversation->getReceiver()->first_name  }} {{$conversation->getReceiver()->last_name}}</h6>

                        @endif
                       <small>Last seen: 2 hours ago</small>
                    </div>
                </div>
                <div class="col-lg-6 hidden-sm text-right">
                  <a href="javascript:void(0);" class="btn btn-outline-info"><i class="fa fa-cogs"></i></a>
               </div>
            </div>
        </div>
        <div class="chat-history h-100 ">
            <div class="chat-list-container">
                <ul class="m-b-0 ">
                    @foreach ($messages as $message)
                        @if ($message->sender_id==Auth::guard('teacher')->user()->id)
                            <li class="clearfix">
                                <div class="message-data text-right">
                                    <span class="message-data-time">{{ $message->created_at->format('h:i A, M d, Y') }}</span>
                            </div>
                                <div class="message other-message float-right">{{$message->body}}</div>
                            </li>
                        @else
                            <li class="clearfix">
                                <div class="message-data">
                                    <span class="message-data-time">{{ $message->created_at->format('h:i A, M d, Y') }}</span>
                                </div>
                                <div class="message my-message">{{$message->body}}</div>
                            </li>
                        @endif
                    @endforeach

                </ul>
            </div>
        </div>
        <div class="chat-message clearfix">
        <div class="input-group mb-0 " >
        <div class="input-group-prepend">
        </div>
        <input type="text" class="form-control" placeholder="Enter text here..." wire:model="newMessage">
        <div class="input-group-append">
            <button class="btn btn-primary" wire:click="sendMessage">Send</button>
        </div>
    </div>
       @endif
    </div>

        </div>
    </div>
</div>




