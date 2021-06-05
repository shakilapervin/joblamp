<!doctype html>
<html lang="{{ session()->get('lang')?: 'en' }}">
<head>

    <!-- Basic Page Needs
    ================================================== -->
    <title>@yield('title','JobLamp')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/animate.css">
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/style.css">
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/colors/blue.css">
    @yield('style')
</head>
<body>

<!-- Wrapper -->
<div id="wrapper">

    <!-- Header Container
    ================================================== -->
    <header id="header-container" class="fullwidth">
        <!-- Header -->
        <div id="header">
            <div class="container">

                <!-- Left Side Content -->
                <div class="left-side">

                    <!-- Logo -->
                    <div id="logo">
                        <a href="{{ url('') }}">
                            <img src="{{ asset('assets/frontend') }}/images/joblamp.png" alt="">
                        </a>
                    </div>

                    <!-- Main Navigation -->
                    <nav id="navigation">
                        <ul id="responsive">
                            <li>
                                <a href="{{ route('home') }}" class="current">{{ __('Home') }}</a>
                            </li>

                            @auth
                                @if(\Illuminate\Support\Facades\Auth::user()->user_type == 'customer')
                                    <li>
                                        <a href="{{ route('job-post') }}">{{ __('Post a Job') }}</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('about.us') }}">{{ __('About Us') }}</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('contact.us') }}">{{ __('Contact Us') }}</a>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ route('job-list') }}">
                                            {{ __('Find Work') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('about.us') }}">{{ __('About Us') }}</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('contact.us') }}">{{ __('Contact Us') }}</a>
                                    </li>
                                @endif
                            @else
                                <li>
                                    <a href="{{ route('job-list') }}">
                                        {{ __('Find Work') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('user-register') }}">{{ __('Register') }}</a>
                                </li>
                                <li>
                                    <a href="{{ route('user-login') }}">{{ __('Login') }}</a>
                                </li>
                                <li>
                                    <a href="{{ route('about.us') }}">{{ __('About Us') }}</a>
                                </li>
                                <li>
                                    <a href="{{ route('contact.us') }}">{{ __('Contact Us') }}</a>
                                </li>
                            @endauth

                        </ul>
                    </nav>
                    <!-- Main Navigation End -->
                    <div class="header-search">
                        @auth
                            @if(\Illuminate\Support\Facades\Auth::user()->user_type == 'customer')
                                <form action="{{ route('task-worker-list') }}" method="get">
                                    <div class="intro-banner-search-form">

                                        <!-- Search Field -->
                                        <div class="intro-search-field with-label">
                                            <input id="intro-keywords" type="text" placeholder="{{ __('Task worker name') }}"
                                                   name="keyword">
                                        </div>

                                        <!-- Button -->
                                        <div class="intro-search-button">
                                            <button class="button ripple-effect" type="submit">{{ __('Search') }}</button>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <form action="{{ route('job-list') }}" method="get">
                                    <div class="intro-banner-search-form">

                                        <!-- Search Field -->
                                        <div class="intro-search-field with-label">
                                            <input id="intro-keywords" type="text" placeholder="{{ __('Job Title or Keywords') }}"
                                                   name="keyword">
                                        </div>

                                        <!-- Button -->
                                        <div class="intro-search-button">
                                            <button class="button ripple-effect" type="submit">{{ __('Search') }}</button>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        @else
                            <form action="{{ route('job-list') }}" method="get">
                                <div class="intro-banner-search-form">

                                    <!-- Search Field -->
                                    <div class="intro-search-field with-label">
                                        <input id="intro-keywords" type="text" placeholder="Job Title or Keywords"
                                               name="keyword">
                                    </div>

                                    <!-- Button -->
                                    <div class="intro-search-button">
                                        <button class="button ripple-effect" type="submit">{{ __('Search') }}</button>
                                    </div>
                                </div>
                            </form>
                        @endauth
                    </div>

                    <div class="clearfix"></div>


                </div>
                <!-- Left Side Content / End -->


                <!-- Right Side Content / End -->
                <div class="right-side">
                @auth
                    <!--  User Notifications -->
                        <div class="header-widget hide-on-mobile">

                            <!-- Notifications -->
                            <div class="header-notifications">
                                <!-- Trigger -->
                                <div class="header-notifications-trigger">
                                    <a href="{{ route('dashboard') }}">
                                        <i class="icon-feather-bell"></i>
                                    </a>
                                </div>

                            </div>

                        </div>
                        <!--  User Notifications / End -->

                        <!-- User Menu -->
                        <div class="header-widget">

                            <!-- Messages -->
                            <div class="header-notifications user-menu">
                                <div class="header-notifications-trigger">
                                    <a href="#">
                                        <div class="user-avatar status-online">
                                            @if(!empty(\Illuminate\Support\Facades\Auth::user()->profile_pic))
                                                <img class="profile-pic"
                                                     src="{{ asset('profile') }}/{{ \Illuminate\Support\Facades\Auth::user()->profile_pic }}" alt=""/>
                                            @else
                                                <img class="profile-pic"
                                                     src="{{ asset('assets/frontend') }}/images/user-avatar-placeholder.png"
                                                     alt=""/>
                                            @endif
                                        </div>
                                    </a>
                                </div>

                                <!-- Dropdown -->
                                <div class="header-notifications-dropdown">

                                    <!-- User Status -->
                                    <div class="user-status">

                                        <!-- User Name / Avatar -->
                                        <div class="user-details">
                                            <div class="user-avatar status-online">
                                                @if(!empty(\Illuminate\Support\Facades\Auth::user()->profile_pic))
                                                    <img class="profile-pic"
                                                         src="{{ asset('profile') }}/{{ \Illuminate\Support\Facades\Auth::user()->profile_pic }}" alt=""/>
                                                @else
                                                    <img class="profile-pic"
                                                         src="{{ asset('assets/frontend') }}/images/user-avatar-placeholder.png"
                                                         alt=""/>
                                                @endif
                                            </div>
                                            <div class="user-name">
                                                {{ \Illuminate\Support\Facades\Auth::user()->first_name }} {{ \Illuminate\Support\Facades\Auth::user()->last_name }}
                                            </div>
                                        </div>
                                    </div>

                                    <ul class="user-menu-small-nav">
                                        <li>
                                            <a href="{{ route('dashboard') }}">
                                                <i class="icon-material-outline-dashboard"></i>
                                                {{ __('Dashboard') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('edit.profile') }}">
                                                <i class="icon-material-outline-settings"></i>
                                                {{ __('Edit Profile') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('user-logout') }}">
                                                <i class="icon-material-outline-power-settings-new"></i>
                                                {{ __('Logout') }}
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>

                        </div>
                        <!-- User Menu / End -->
                @endauth
                <!-- Mobile Navigation Button -->
                    <span class="mmenu-trigger">
                            <button class="hamburger hamburger--collapse" type="button">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
				        </span>
                </div>
                <!-- Right Side Content / End -->

            </div>
        </div>
        <!-- Header End -->
    </header>
    <div class="clearfix"></div>
    @if(Route::is('home') || Route::is('job-list') || Route::is('job.details'))
        <div class="job-category">
            <ul>
                @php
                    $jobCategories = jobcategories();
                @endphp
                @foreach($jobCategories as $jobCategory)
                    <li>
                        <a href="{{ route('job-list') }}/?category_id={{ $jobCategory->id }}">
                            {{ $jobCategory->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
<!-- Header Container End -->
