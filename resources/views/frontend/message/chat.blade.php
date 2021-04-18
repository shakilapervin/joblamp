@extends('frontend.layouts.master')
@section('title')
    {{ __('Messages') }}
@endsection

@section('content')
    <!-- Dashboard Container -->
    <div class="dashboard-container">
    @include('frontend.layouts.dashboard-sidebar')
    <!-- Dashboard Content
        ================================================== -->
        <div class="dashboard-content-container" data-simplebar>
            <div class="dashboard-content-inner">

                <!-- Dashboard Headline -->
                <div class="dashboard-headline">
                    <h3>Messages</h3>

                    <!-- Breadcrumbs -->
                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                            <li><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                            <li>{{ __('Messages') }}</li>
                        </ul>
                    </nav>
                </div>

                <div class="messages-container margin-top-0">

                    <div class="messages-container-inner">

                        <!-- Messages -->
                        <div class="messages-inbox">
                            <div class="messages-headline">
                                <div class="input-with-icon">
                                    <input id="autocomplete-input" type="text" placeholder="Search">
                                    <i class="icon-material-outline-search"></i>
                                </div>
                            </div>

                            <ul>
                                @foreach($contacts as $contact)
                                    <li class="@if($contact->receiver->id == $receiver->receiver->id) active-message @endif">
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
{{--                                                    <span>2 days ago</span>--}}
                                                </div>
{{--                                                <p>Yes, I received payment. Thanks for cooperation!</p>--}}
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- Messages / End -->

                        <!-- Message Content -->
                        <div class="message-content">

                            <div class="messages-headline">
                                <h4>{{ $receiver->receiver->first_name }} {{ $receiver->receiver->last_name }}</h4>
                            </div>

                            <!-- Message Content Inner -->
                            <div class="message-content-inner"></div>
                            <!-- Message Content Inner / End -->

                            <!-- Reply Area -->
                            <div class="message-reply">
                                <textarea cols="1" rows="1" placeholder="Your Message" data-autoresize
                                          class="message-data"></textarea>
{{--                                <ul class="message-picker">--}}
{{--                                    <li>--}}
{{--                                        <span class="icon-line-awesome-smile-o emoji-picker"></span>--}}
{{--                                    </li>--}}
{{--                                </ul>--}}
                                <button class="button ripple-effect" onclick="postChat();">Send</button>
                            </div>

                        </div>
                        <!-- Message Content -->

                    </div>
                </div>
                <!-- Messages Container / End -->

            </div>
        </div>
        <!-- Dashboard Content / End -->
    </div>
    <!-- Dashboard Container / End -->
@endsection
@section('script')
    <script>
        const db = firebase.database();
        const url = "{{ $receiver->url }}";

        @if(!empty($receiver->receiver->profile_pic))
            let receiver_photo = "{{ asset('public/profile/'.$receiver->receiver->profile_pic) }}";
        @else
            let receiver_photo = "{{ asset('public/assets/frontend') }}/images/user-avatar-placeholder.png";
        @endif

        @if(!empty(\Illuminate\Support\Facades\Auth::user()->profile_pic))
            let sender_photo = "{{ asset('public/profile/'.\Illuminate\Support\Facades\Auth::user()->profile_pic) }}";
        @else
            let sender_photo = "{{ asset('public/assets/frontend') }}/images/user-avatar-placeholder.png";
        @endif

        function postChat() {
            let message = $('.message-data').val();
            db.ref("messages/" + url).push().set({
                "message": message,
                "type": 'text',
                "sender_id": {{ \Illuminate\Support\Facades\Auth::id() }},
                "receiver_id": {{ $receiver->receiver->id }}
            }, function (error) {
                if (error) {
                    console.log(error);
                } else {
                    $('.message-data').val('');
                }
            });
        }

        db.ref('messages/' + url).on("child_added", function (snapshot) {
            const messages = snapshot.val();
            if (messages.sender_id == {{ \Illuminate\Support\Facades\Auth::id() }}) {
                const msg = `<div class="message-bubble me">
                            <div class="message-bubble-inner">
                                <div class="message-avatar"><img src="` + sender_photo + `" alt=""/>
                                </div>
                                <div class="message-text"><p>` + messages.message + `</p></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>`;
                $('.message-content-inner').append(msg);
            } else {
                const msg = `<div class="message-bubble">
                            <div class="message-bubble-inner">
                                <div class="message-avatar"><img src="` + receiver_photo + `" alt=""/>
                                </div>
                                <div class="message-text"><p>` + messages.message + `</p></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>`;
                $('.message-content-inner').append(msg);
            }
        });
    </script>
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('public/assets/frontend/vendor/emoji/css/emojis.css') }}">
    <style>
        .message-reply{
            position: relative;
        }
        .message-picker{
            list-style: none;
            position: absolute;
            bottom: 10px;
            left: 0;
            margin: 0;
        }
        .message-picker li span{
            font-size: 20px !important;
            color: #f39c12;
            cursor: pointer;
        }
    </style>
@endsection
