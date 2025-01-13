{{-- <div>
    <div id="plist" class="people-list">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-search"></i></span>
            </div>
            <input type="text" class="form-control" placeholder="Search...">
        </div>
        <div wire:poll.1000ms class="chat-list-container">
        <ul class="list-unstyled chat-list mt-2 mb-0">
          @foreach($this->conversations as $conversation)
          {{-- @if ( $conversation->getReceiver()->id==Auth::guard('teacher')->user()->id)

          @else --}}
          <li class="clearfix {{ $selectedConversation && $selectedConversation->id == $conversation->id ? 'active' : '' }}" wire:click="selectConversation({{ $conversation->id }})">
            <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="avatar">
            <div class="about">
                {{-- <div class="name">Test name </div> --}}
                <div class="name">
                {{-- @if ($conversation->getReceiver()->id==Auth::guard('teacher')->user()->id)

                {{  $conversation->getSender()->first_name  }} {{$conversation->getSender()->last_name}}</div>

                @else
                {{  $conversation->getReceiver()->first_name  }} {{$conversation->getReceiver()->last_name}}</div>

                @endif --}}
               <div class="status">
                    {{-- {{$conversation->isLastMessageReadByUser()}} --}}
                    {{-- @if($conversation->isLastMessageReadByUser())
                        <i class="fa fa-check-circle text-success"></i>
                    @else
                        <i class="fa fa-check-circle text-muted"></i>
                    @endif --}}
                    {{-- @if ($conversation->unreadMessagesCount()>0)
                        {{$conversation->unreadMessagesCount()}}
                    @endif --}}
                </div>
            </div>
        </li>
          {{-- @endif --}}

        @endforeach
            {{-- <li class="clearfix">
                <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="avatar">
                <div class="about">
                    <div class="name">Vincent Porter</div>
                    <div class="status"> <i class="fa fa-circle offline"></i> left 7 mins ago </div>
                </div>
            </li> --}}
            {{-- <li class="clearfix active">
                <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="avatar">
                <div class="about">
                    <div class="name">Aiden Chavez</div>
                    <div class="status"> <i class="fa fa-circle online"></i> online </div>
                </div>

            <li class="clearfix">
                <img src="https://bootdey.com/img/Content/avatar/avatar8.png" alt="avatar">
                <div class="about">
                    <div class="name">Monica Ward</div>
                    <div class="status"> <i class="fa fa-circle online"></i> online </div>
                </div>
            </li>
            <li class="clearfix">
                <img src="https://bootdey.com/img/Content/avatar/avatar3.png" alt="avatar">
                <div class="about">
                    <div class="name">Dean Henry</div>
                    <div class="status"> <i class="fa fa-circle offline"></i> offline since Oct 28 </div>
                </div>
            </li> --}}
        </ul>
        </div>
    </div>
</div>
 --}}
