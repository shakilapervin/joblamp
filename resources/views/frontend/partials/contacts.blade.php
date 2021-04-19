@foreach($contacts as $contact)
    <li class="@if($contact->receiver->id == $receiver) active-message @endif">
        <a href="{{ route('message',$contact->receiver->id) }}">
            <div class="message-avatar">
                {{--                                            <i class="status-icon status-online"></i>--}}
                @if(!empty($contact->receiver->profile_pic))
                    <img
                        src="{{ asset('public/profile/'.$contact->receiver->profile_pic) }}"
                        alt=""/>
                @else
                    <img
                        src="{{ asset('public/assets/frontend') }}/images/user-avatar-placeholder.png"
                        alt=""/>
                @endif
            </div>

            <div class="message-by">
                <div class="message-by-headline">
                    <h5>{{ $contact->receiver->first_name }} {{ $contact->receiver->last_name }}</h5>
                </div>
            </div>
        </a>
    </li>
@endforeach
