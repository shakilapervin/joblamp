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
                            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
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
                                <li>
                                    <a href="#">
                                        <div class="message-avatar"><i class="status-icon status-online"></i><img
                                                src="images/user-avatar-placeholder.png" alt=""/></div>

                                        <div class="message-by">
                                            <div class="message-by-headline">
                                                <h5>Marcin Kowalski</h5>
                                                <span>2 days ago</span>
                                            </div>
                                            <p>Yes, I received payment. Thanks for cooperation!</p>
                                        </div>
                                    </a>
                                </li>

                            </ul>
                        </div>
                        <!-- Messages / End -->

                        <!-- Message Content -->
                        <div class="message-content">

                            <div class="messages-headline">
                                <h4>Sindy Forest</h4>
                            </div>

                            <!-- Message Content Inner -->
                            <div class="message-content-inner">

                                <!-- Time Sign -->
                                <div class="message-time-sign">
                                    <span>28 June, 2019</span>
                                </div>

                                <div class="message-bubble me">
                                    <div class="message-bubble-inner">
                                        <div class="message-avatar"><img src="images/user-avatar-small-01.jpg" alt=""/>
                                        </div>
                                        <div class="message-text"><p>Thanks for choosing my offer. I will start working
                                                on your project tomorrow.</p></div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="message-bubble">
                                    <div class="message-bubble-inner">
                                        <div class="message-avatar"><img src="images/user-avatar-small-02.jpg" alt=""/>
                                        </div>
                                        <div class="message-text"><p>Great. If you need any further clarification let me
                                                know. 👍</p></div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <!-- Message Content Inner / End -->

                            <!-- Reply Area -->
                            <div class="message-reply">
                                <textarea cols="1" rows="1" placeholder="Your Message" data-autoresize></textarea>
                                <button class="button ripple-effect">Send</button>
                            </div>

                        </div>
                        <!-- Message Content -->

                    </div>
                </div>
                <!-- Messages Container / End -->


                <!-- Footer -->
                <div class="dashboard-footer-spacer"></div>
                <div class="small-footer margin-top-15">
                    <div class="small-footer-copyrights">
                        © 2019 <strong>Hireo</strong>. All Rights Reserved.
                    </div>
                    <ul class="footer-social-links">
                        <li>
                            <a href="#" title="Facebook" data-tippy-placement="top">
                                <i class="icon-brand-facebook-f"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" title="Twitter" data-tippy-placement="top">
                                <i class="icon-brand-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" title="Google Plus" data-tippy-placement="top">
                                <i class="icon-brand-google-plus-g"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" title="LinkedIn" data-tippy-placement="top">
                                <i class="icon-brand-linkedin-in"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <!-- Footer / End -->

            </div>
        </div>
        <!-- Dashboard Content / End -->
    </div>
    <!-- Dashboard Container / End -->
@endsection
