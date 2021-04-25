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
                            <li><a href="#">Home</a></li>
                            <li><a href="#">Dashboard</a></li>
                            <li>Messages</li>
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
                                    <li>
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
                                                    <span>2 days ago</span>
                                                </div>
                                                <p>Yes, I received payment. Thanks for cooperation!</p>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- Messages / End -->

                        <!-- Message Content -->
                        <div class="message-content">

                            <!-- Message Content Inner -->
                            <div class="message-content-inner">
                                <h3>
                                    {{ __('Please select user to start chat') }}
                                </h3>
                            </div>
                        </div>
                        <!-- Message Content -->

                    </div>
                </div>
                <!-- Messages Container / End -->


                <!-- Footer -->
                <div class="dashboard-footer-spacer"></div>

            </div>
        </div>
        <!-- Dashboard Content / End -->
    </div>
    <!-- Dashboard Container / End -->
@endsection
