<div>
    <div id="plist" class="people-list">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fa fa-search"></i></span>
            </div>
            <input type="text" class="form-control" placeholder="Search...">
        </div>
        <ul class="list-unstyled chat-list mt-2 mb-0">
            @foreach($conversations as $conversation)
            <li class="clearfix {{ $selectedConversation && $selectedConversation->id == $conversation->id ? 'active' : '' }}" wire:click="selectConversation({{ $conversation->id }})">
                <div class="about">
                    {{-- <div class="name">Test name </div> --}}
                    <div class="name">{{  $conversation->getReceiver()->first_name  }} {{$conversation->getReceiver()->last_name}}</div>
                    <div class="status">
                        {{$conversation->isLastMessageReadByUser()}}
                        {{-- @if($conversation->isLastMessageReadByUser())
                            <i class="fa fa-check-circle text-success"></i>
                        @else
                            <i class="fa fa-check-circle text-muted"></i>
                        @endif --}}
                        @if ($conversation->unreadMessagesCount()>0)
                            {{$conversation->unreadMessagesCount()}}
                        @endif
                    </div>
                </div>
            </li>
        @endforeach
            <li class="clearfix">
                <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="avatar">
                <div class="about">
                    <div class="name">Vincent Porter</div>
                    <div class="status"> <i class="fa fa-circle offline"></i> left 7 mins ago </div>
                </div>
            </li>
            {{-- <li class="clearfix active">
                <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="avatar">
                <div class="about">
                    <div class="name">Aiden Chavez</div>
                    <div class="status"> <i class="fa fa-circle online"></i> online </div>
                </div>
            </li>
            <li class="clearfix">
                <img src="https://bootdey.com/img/Content/avatar/avatar3.png" alt="avatar">
                <div class="about">
                    <div class="name">Mike Thomas</div>
                    <div class="status"> <i class="fa fa-circle online"></i> online </div>
                </div>
            </li>
            <li class="clearfix">
                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">
                <div class="about">
                    <div class="name">Christian Kelly</div>
                    <div class="status"> <i class="fa fa-circle offline"></i> left 10 hours ago </div>
                </div>
            </li>
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

