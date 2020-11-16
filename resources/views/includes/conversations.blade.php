<!-- Show Conversations Button -->
<a id="show-conversations" class="btn mt-5" href="#">
    <i class="fas fa-bars"></i>
</a>

<!-- Conversations -->
<nav class="conversations mt-5">
    <!-- Conversations content -->
    <div class="conversations-content">

        <!-- Conversations title  -->
        <div class="conversations-title row justify-content-between p-2">
            <h4>My conversations</h4>
            <div id="close-conversations">
                <i class="fas fa-times mr-2"></i>
            </div>
        </div> <!-- Conversations title End  -->

        <!-- If admin's reply exists -->
        @if (count($replys) > 0)

            <!-- Loop through replys -->
            @foreach ($replys as $reply)
                <a href="{{ route('show-admin-messages', $reply->id) }}">
                    <!-- All conversations  -->
                    <div class="row align-items-center conversation mt-2 
                    {{ (explodeUrl(url()->current()) == 'administration') ? 'active' : '' }}">
                        <div class="d-flex-flex-column">
                            <h4>Administration</h4>
                            <p>{{ conversation_activity($reply->created_at) }}</p>
                        </div>
                        @if ($reply->readed === NULL)
                            <span class="badge badge-warning align-self-start ml-5">NEW</span>
                        @endif
                    </div><!-- All conversations End  -->
                </a>
            @endforeach <hr>
        @endif <!-- If admin's reply exists END -->
            
        <!-- If conversations exists -->
        @if(count($conversations) > 0) 

            <!-- Loop through conversations -->
            @foreach ($conversations as $conv)
                <a href="{{ route('show-messages', $conv->conversation_id) }}"> 
                    <!-- All conversations  -->
                    <div class="row align-items-center conversation mt-2 
                    {{ (explodeUrl(url()->current()) == $conv->conversation_id) ? 'active' : '' }}">
                        <img src="{{ '/storage/avatars/' . $conv->image }}" alt="{{ '/storage/avatars/' . $conv->id . '/' . $conv->image }}">
                        <div class="d-flex-flex-column">
                            <h4>
                                {{ ucfirst($conv->name) . ' ' . ucfirst($conv->lastname) }}
                            </h4>
                            <p>{{ conversation_activity($conv->updated_at) }}</p>
                        </div>
                        @if (count($messages_in_conv) > 0)
                            @foreach ($messages_in_conv as $msg)
                                @if ($msg->conversation_id === $conv->conversation_id)
                                    <span class="badge badge-warning align-self-start ml-5">NEW</span>
                                    @break
                                @endif
                            @endforeach
                        @endif
                    </div><!-- All conversations End  -->
                </a>
            @endforeach
        <!-- If conversations od admins reply doesn't exists, display message -->
        @else
            <p class="text-center mt-5">No conversations</p>
        @endif

    </div> <!-- Conversations Content End -->
</nav> <!-- Conversations End -->