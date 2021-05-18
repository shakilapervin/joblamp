@extends('frontend.layouts.master')
@section('title')
    {{ $job->title }}
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/vendor/rating/dist/star-rating.min.css">
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
@section('content')
    <!-- Titlebar
    ================================================== -->
    <div class="single-page-header" data-background-image="{{ frontend_asset('') }}/images/single-job.jpg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="single-page-header-inner">
                        <div class="left-side">
                            <div class="header-image">
                                <a href="single-company-profile.html">
                                    @if(!empty($job->creatorDetails->profile_pic))
                                        <img src="{{ asset('') }}/{{ $job->creatorDetails->profile_pic }}" alt=""/>
                                    @else
                                        <img
                                            src="{{ asset('assets/frontend') }}/images/user-avatar-placeholder.png"
                                            alt=""/>
                                    @endif
                                </a>
                            </div>
                            <div class="header-details">
                                <h3>{{ $job->title }}</h3>
                                <h5>
                                    {{ __('About the Employer') }}
                                </h5>
                                <ul>
                                    <li>
                                        <a href="single-company-profile.html">
                                            <i class="icon-material-outline-business"></i>
                                            {{ $job->creatorDetails->first_name }} {{ $job->creatorDetails->last_name }}
                                        </a>
                                    </li>
                                    <li>
                                        <div class="star-rating"
                                             data-rating="{{ calculateRating(\App\Rating::where('user_id',$job->creatorDetails->id)->get()) }}"></div>
                                    </li>
                                    <li>
                                        {{ $job->creatorDetails->userCountry->name }}
                                    </li>
                                    <li>
                                        <div class="verified-badge-with-title">Verified</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="right-side">
                            <div class="salary-box">
                                <div class="salary-type">{{ __('Fee Range') }}</div>
                                <div class="salary-amount">${{ $job->fee_range_min }} - ${{ $job->fee_range_max }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Page Content
    ================================================== -->
    <div class="container">
        <div class="row">

            <!-- Content -->
            <div class="col-xl-8 col-lg-8 content-right-offset">

                <div class="single-page-section">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <h3 class="margin-bottom-25">
                        {{ __('Job Description') }}
                    </h3>
                    <p>
                        {{ $job->description }}
                    </p>
                    <div class="messages-container margin-top-0">

                        <div class="messages-container-inner">
                            <!-- Message Content -->
                            <div class="message-content">

                                <!-- Message Content Inner -->
                                <div class="message-content-inner"></div>
                                <!-- Message Content Inner / End -->
                            @if($job->status != 'completed')
                                <!-- Reply Area -->
                                    <div class="message-reply">
                                <textarea cols="1" rows="1" placeholder="Your Message" data-autoresize
                                          class="message-data"></textarea>
                                        <button class="button apply-now-button popup-with-zoom-anim"
                                                style="background: transparent; color: #D5152F;padding: 10px; position: absolute;top: 85%;"
                                                href="#file-dialog">
                                            <i class="icon-feather-paperclip"></i>
                                        </button>
                                        <button class="button ripple-effect"
                                                onclick="postChat();">{{ __('Send') }}</button>
                                    </div>
                                @endif
                            </div>
                            <!-- Message Content -->

                        </div>
                    </div>
                </div>
            </div>


            <!-- Sidebar -->
            <div class="col-xl-4 col-lg-4">
                <div class="sidebar-container">
                    @if ($job->status == 'delivered')
                        <a href="{{ route('approve.job.delivery',encrypt($jobId)) }}"
                           class="apply-now-button bg-success">
                            {{ __('Approve') }}
                            <i class="icon-material-outline-arrow-right-alt"></i>
                        </a>
                        <a href="#small-dialog" class="apply-now-button bg-danger popup-with-zoom-anim">
                            {{ __('Dispute') }}
                            <i class="icon-material-outline-arrow-right-alt"></i>
                        </a>
                        <div class="sidebar-widget">
                            <div class="job-overview">
                                <div class="job-overview-headline">
                                    {{ __('Job Delivery Details') }}
                                </div>
                                <div class="job-overview-inner">
                                    <p>{{ $deliveryData->delivery_text }}</p>
                                    @if(!empty($deliveryData->delivery_file))
                                        <a href="{{ route('download.job.delivery.file',str_replace('job-delivery-file/','',$deliveryData->delivery_file)) }}"
                                           class="apply-now-button">
                                            {{ __('Download Delivery File') }}
                                            <i class="icon-material-outline-arrow-right-alt"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($job->status == 'completed' && $rated == false)
                    <!-- Sidebar Widget -->
                        <div class="sidebar-widget">
                            <div class="job-overview">
                                <div class="job-overview-headline bg-success text-white">
                                    {{ __('Give Service Provider Rating') }}
                                </div>
                                <div class="job-overview-inner">
                                    <form action="{{ route('save.job.feedback') }}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="submit-field">
                                                    <h5 style="margin-bottom: 20px;">{{ __('Service Provider Rating') }}</h5>
                                                    <select
                                                        class="star-rating @error('service_provider_rating') is-invalid @enderror"
                                                        required name="rating">
                                                        <option>{{ __('Service Provider Rating') }}</option>
                                                        <option value="5">{{ __('5 Star') }}</option>
                                                        <option value="4">{{ __('4 Star') }}</option>
                                                        <option value="3">{{ __('3 Star') }}</option>
                                                        <option value="2">{{ __('2 Star') }}</option>
                                                        <option value="1">{{ __('1 Star') }}</option>
                                                    </select>
                                                    @error('service_provider_rating')
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="submit-field">
                                                    <h5>{{ __('Feedback') }}</h5>
                                                    <textarea cols="30" rows="5" class="with-border" name="feedback"
                                                              required></textarea>
                                                    <input type="hidden" name="job_id" value="{{ encrypt($job->id) }}">
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <button class="button ripple-effect big margin-top-30" type="submit">
                                                    <i class="icon-feather-plus"></i>
                                                    {{ __('Submit') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($job->status == 'delivered' || $job->status == 'completed')
                        @if(!empty($deliveryData))
                            <div class="sidebar-widget">
                                <div class="job-overview">
                                    <div class="job-overview-headline">
                                        {{ __('Job Delivery Details') }}
                                    </div>
                                    <div class="job-overview-inner">
                                        <p>{{ $deliveryData->delivery_text }}</p>
                                        @if(!empty($deliveryData->delivery_file))
                                            <a href="{{ route('download.job.delivery.file',str_replace('job-delivery-file/','',$deliveryData->delivery_file)) }}"
                                               class="apply-now-button">
                                                {{ __('Download Delivery File') }}
                                                <i class="icon-material-outline-arrow-right-alt"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                    @if ($job->status == 'completed')
                        <div class="sidebar-widget">
                            <div class="job-overview">
                                <div class="job-overview-headline">
                                    {{ __('Service Provider Feedback') }}
                                </div>
                                <div class="job-overview-inner">
                                    @if(empty($feedback))
                                        {{ __('No feedback given yet') }}
                                    @else
                                        <div class="star-rating" data-rating="{{ $feedback->rating }}"></div>
                                        <p>
                                            {{ $feedback->feedback }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                @endif
                <!-- Sidebar Widget -->
                    <div class="sidebar-widget">
                        <div class="job-overview">
                            <div class="job-overview-headline">
                                {{ __('Job Summary') }}
                            </div>
                            <div class="job-overview-inner">
                                <ul>
                                    <li>
                                        <i class="icon-material-outline-location-on"></i>
                                        <span>{{ __('Location') }}</span>
                                        <h5>
                                            {{ $job->jobCountry->name }}
                                        </h5>
                                    </li>
                                    <li>
                                        <i class="icon-material-outline-local-atm"></i>
                                        <span>{{ __('Fee Range') }}</span>
                                        <h5>${{ $job->fee_range_min }} -
                                            ${{ $job->fee_range_max }}</h5>
                                    </li>
                                    <li>
                                        <i class="icon-material-outline-access-time"></i>
                                        <span>
                                            {{ __('Date Posted') }}
                                        </span>
                                        <h5>
                                            {{ $job->created_at->diffForHumans() }}
                                        </h5>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="small-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
        <!--Tabs -->
        <div class="sign-in-form">
            <ul class="popup-tabs-nav">
                <li>
                    <a href="#tab">
                        {{ __('Dispute') }}
                    </a>
                </li>
            </ul>
            <div class="popup-tabs-container">

                <!-- Tab -->
                <div class="popup-tab-content" id="tab">

                    <!-- Welcome Text -->
                    <div class="welcome-text">
                        <h3>
                            {{ __('Describe dispute reason') }}
                        </h3>
                    </div>

                    <!-- Form -->
                    <form method="post" id="apply-now-form" action="{{ route('dispute.job.delivery') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ encrypt($job->id) }}">
                        <div class="input-with-icon-left">
                            <textarea name="reason"
                                      class="input-text with-border @error('reason') is-invalid @enderror"
                                      cols="30" rows="10" required></textarea>
                            @error('reason')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <!-- Button -->
                        <button class="button margin-top-35 full-width button-sliding-icon ripple-effect" type="submit"
                                form="apply-now-form">{{ __('Submit') }}
                            <i class="icon-material-outline-arrow-right-alt"></i>
                        </button>
                    </form>

                </div>

            </div>
        </div>
    </div>
    <div id="file-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
        <!--Tabs -->
        <div class="sign-in-form">
            <div class="popup-tabs-container">
                <!-- Tab -->
                <div class="popup-tab-content" id="tab">
                    <form method="post" id="send-file-form" action="{{ route('apply-job') }}"
                          enctype="multipart/form-data">
                    @csrf
                    <!-- Welcome Text -->
                        <div class="welcome-text">
                            <input type="file" class="dropify chat-file" style="margin-top: 20px;" name="chat_file"
                                   required>
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
    <script src="{{ asset('assets/frontend') }}/vendor/rating/dist/star-rating.min.js"></script>
    <script src="{{ asset('assets/frontend/vendor/dropify/js/dropify.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.dropify').dropify();
        });
        var starratings = new StarRating('.star-rating', {
            onClick: function (el) {
                console.log('Selected: ' + el[el.selectedIndex].text);
            },
        });
    </script>

    <script>
        const db = firebase.database();
        const url = "job_chat_{{ $jobId }}";

        @if(!empty($receiver->workerDetails->profile_pic))
        let receiver_photo = "{{ asset('profile/'.$receiver->workerDetails->profile_pic) }}";
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
                            "receiver_id": {{ $receiver->workerDetails->id }},
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
                                        receiver_id: {{ $receiver->workerDetails->id }}
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
            const url = "{{ asset('') }}/";
            const messages = snapshot.val();
            if (messages.sender_id == {{ \Illuminate\Support\Facades\Auth::id() }}) {
                let type = messages.type;
                let chatMessage = '';
                if (type == 'text') {
                    chatMessage = `<p>` + messages.message + `</p>`;
                } else if (type == 'image') {
                    chatMessage = `<a href="` + `{{ url('download-message-file') }}` + '/' + messages.message.replace('chat-file/', '') + `"> <img src="` + url + messages.message + `" width="100"></a>`;
                } else {
                    chatMessage = `<a style="color:#ffffff;" href="` + `{{ url('download-message-file') }}` + '/' + messages.message.replace('chat-file/', '') + `">` + messages.message.replace('message/', '') + `</a>`;
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
                if (type == 'text') {
                    chatMessage = `<p>` + messages.message + `</p>`;
                } else if (type == 'image') {
                    chatMessage = `<a href="` + `{{ url('download-message-file') }}` + '/' + messages.message.replace('chat-file/', '') + `"> <img src="` + url + messages.message + `" width="100"></a>`;
                } else {
                    chatMessage = `<a style="color:#000000;" href="` + `{{ url('download-message-file') }}` + '/' + messages.message.replace('chat-file/', '') + `">` + messages.message.replace('message/', '') + `</a>`;
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
        $(document).ready(function () {
            $('#send-file-form').on('submit', function (event) {
                event.preventDefault();
                $.ajax({
                    url: "{{ route('save.chat.file') }}",
                    method: "POST",
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        if (data.status == false) {
                            alert(data.error)
                        } else {
                            db.ref("messages/" + url).push().set({
                                "message": data.file_name,
                                "type": data.file_type,
                                "sender_id": {{ \Illuminate\Support\Facades\Auth::id() }},
                                "receiver_id": {{ $receiver->workerDetails->id }},
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
                                            receiver_id: {{ $receiver->workerDetails->id }}
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


