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
{{--                            <div class="messages-headline">--}}
{{--                                <div class="input-with-icon">--}}
{{--                                    <input id="autocomplete-input" type="text" placeholder="Search">--}}
{{--                                    <i class="icon-material-outline-search"></i>--}}
{{--                                </div>--}}
{{--                            </div>--}}

                            <ul class="contact-list">
                                @foreach($contacts as $contact)
                                    <li class="@if($contact->receiver->id == $receiver->receiver->id) active-message @endif">
                                        <a href="{{ route('message',$contact->receiver->id) }}">
                                            <div class="message-avatar">
                                                {{--                                            <i class="status-icon status-online"></i>--}}
                                                @if(!empty($contact->receiver->profile_pic))
                                                    <img
                                                        src="{{ asset('profile/'.$contact->receiver->profile_pic) }}"
                                                        alt=""/>
                                                @else
                                                    <img
                                                        src="{{ asset('assets/frontend') }}/images/user-avatar-placeholder.png"
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
                                <button class="button apply-now-button popup-with-zoom-anim"
                                        style="background: transparent; color: #D5152F;padding: 10px; position: absolute;top: 85%;"
                                        href="#small-dialog">
                                    <i class="icon-feather-paperclip"></i>
                                </button>
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

    <div id="small-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
        <!--Tabs -->
        <div class="sign-in-form">
            <div class="popup-tabs-container">
                <!-- Tab -->
                <div class="popup-tab-content" id="tab">
                    <form method="post" id="send-file-form" action="{{ route('apply-job') }}" enctype="multipart/form-data">
                        @csrf
                        <!-- Welcome Text -->
                        <div class="welcome-text">
                            <input type="file" class="dropify chat-file" style="margin-top: 20px;" name="chat_file" required>
                        </div>
                        <button class="button margin-top-35 full-width button-sliding-icon ripple-effect" type="submit">
                            {{ __('Send') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/frontend/vendor/dropify/js/dropify.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.dropify').dropify();
        });
        const db = firebase.database();
        const url = "{{ $receiver->url }}";

        @if(!empty($receiver->receiver->profile_pic))
        let receiver_photo = "{{ asset('profile/'.$receiver->receiver->profile_pic) }}";
        @else
        let receiver_photo = "{{ asset('assets/frontend') }}/images/user-avatar-placeholder.png";
        @endif

        @if(!empty(\Illuminate\Support\Facades\Auth::user()->profile_pic))
        let sender_photo = "{{ asset('profile/'.\Illuminate\Support\Facades\Auth::user()->profile_pic) }}";
        @else
        let sender_photo = "{{ asset('assets/frontend') }}/images/user-avatar-placeholder.png";
        @endif

        function postChat() {
            $.ajax({
                type: "GET",
                url: '{{ route('get.current.time') }}',
                success: function (data) {
                    let message = $('.message-data').val();
                    if (message != '') {
                        db.ref("messages/" + url).push().set({
                            "message": message,
                            "type": 'text',
                            "sender_id": {{ \Illuminate\Support\Facades\Auth::id() }},
                            "receiver_id": {{ $receiver->receiver->id }},
                            "date": data.date,
                            "time": data.time,
                        }, function (error) {
                            if (error) {
                                console.log(error);
                            } else {
                                $.ajax({
                                    type: "POST",
                                    url: '{{ route('chat.update.time') }}',
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        sender_id: {{ \Illuminate\Support\Facades\Auth::id() }},
                                        receiver_id: {{ $receiver->receiver->id }}
                                    },
                                    success: function (data) {
                                        $('.message-data').val('');
                                        $('.contact-list').html(null);
                                        $('.contact-list').html(data);
                                    }
                                });
                            }
                        });
                    }
                }
            });
        }

        db.ref('messages/' + url).on("child_added", function (snapshot) {
            const messages = snapshot.val();
            const url = "{{ asset('') }}/";
            if (messages.sender_id == {{ \Illuminate\Support\Facades\Auth::id() }}) {
                let type = messages.type;
                let chatMessage = '';
                if (type == 'text'){
                    chatMessage = `<p>`+messages.message+`</p>`;
                }else if(type == 'image'){
                    chatMessage = `<a href="`+`{{ url('download-message-file') }}`+'/'+messages.message.replace('chat-file/','')+`"> <img src="`+url+messages.message+`" width="100"></a>`;
                }else{
                    chatMessage = `<a style="color:#ffffff;" href="`+`{{ url('download-message-file') }}`+'/'+messages.message.replace('chat-file/','')+`">`+messages.message.replace('message/','')+`</a>`;
                }
                const msg = `<div class="message-bubble me">
                            <div class="message-bubble-inner">
                                <div class="message-avatar"><img src="` + sender_photo + `" alt=""/>
                                </div>
                                <div class="message-text">` + chatMessage + `
                                    <p class="message-time">` + messages.date + ', ' + messages.time + `</p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>`;
                $('.message-content-inner').append(msg);
            } else {
                let type = messages.type;
                let chatMessage = '';
                if (type == 'text'){
                    chatMessage = `<p>`+messages.message+`</p>`;
                }else if(type == 'image'){
                    chatMessage = `<a href="`+`{{ url('download-message-file') }}`+'/'+messages.message.replace('chat-file/','')+`"> <img src="`+url+messages.message+`" width="100"></a>`;
                }else{
                    chatMessage = `<a style="color:#000000;" href="`+`{{ url('download-message-file') }}`+'/'+messages.message.replace('chat-file/','')+`">`+messages.message.replace('message/','')+`</a>`;
                }
                const msg = `<div class="message-bubble">
                            <div class="message-bubble-inner">
                                <div class="message-avatar"><img src="` + receiver_photo + `" alt=""/>
                                </div>
                                <div class="message-text">` + chatMessage + `
                                    <p class="message-time">` + messages.date + ', ' + messages.time + `</p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>`;
                $('.message-content-inner').append(msg);
            }
        });
    </script>
    <script>
        $(document).ready(function(){
            $('#send-file-form').on('submit', function(event){
                event.preventDefault();
                $.ajax({
                    url:"{{ route('save.chat.file') }}",
                    method:"POST",
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success:function(data)
                    {
                        if(data.status == false){
                            alert(data.error)
                        }else {
                            db.ref("messages/" + url).push().set({
                                "message": data.file_name,
                                "type": data.file_type,
                                "sender_id": {{ \Illuminate\Support\Facades\Auth::id() }},
                                "receiver_id": {{ $receiver->receiver->id }},
                                "date": data.date,
                                "time": data.time,
                            }, function (error) {
                                if (error) {
                                    console.log(error);
                                } else {
                                    $.ajax({
                                        type: "POST",
                                        url: '{{ route('chat.update.time') }}',
                                        data: {
                                            _token: '{{ csrf_token() }}',
                                            sender_id: {{ \Illuminate\Support\Facades\Auth::id() }},
                                            receiver_id: {{ $receiver->receiver->id }}
                                        },
                                        success: function (data) {
                                            $('.message-data').val('');
                                            $('.contact-list').html(null);
                                            $('.contact-list').html(data);
                                            $('#send-file-form').trigger("reset");
                                            $('.mfp-close').trigger("click");
                                            $('.dropify-clear').trigger("click");
                                        }
                                    });
                                }
                            });
                        }
                    }
                })
            });

        });
    </script>
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/frontend/vendor/dropify/css/dropify.min.css') }}">
    <style>
        .message-reply {
            position: relative;
            display: flex;
            margin-bottom: 40px;
        }

        .message-picker {
            list-style: none;
            position: absolute;
            bottom: 10px;
            left: 0;
            margin: 0;
        }

        .message-picker li span {
            font-size: 20px !important;
            color: #f39c12;
            cursor: pointer;
        }

        .message-text {
            position: relative;
        }

        .message-time {
            position: absolute;
            width: 200px;
            bottom: -30px;
            left: 0;
            color: grey;
            font-size: 12px !important;
        }

        .me .message-time {
            right: 0;
            text-align: right;
            left: inherit;
        }

        .message-bubble {
            margin-bottom: 35px !important;
        }

        .dropify-wrapper {
            height: 250px;
            margin-top: 24px;
        }
    </style>
@endsection
