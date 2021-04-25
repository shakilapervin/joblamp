@extends('frontend.layouts.master')
@section('title')
    {{ __('Profile') }}
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
                    <h3>{{ __('My Profile') }}</h3>

                    <!-- Breadcrumbs -->
                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li>
                                <a href="{{ url('') }}">{{ __('Home') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
                            </li>
                            <li>{{ __('My Profile') }}</li>
                        </ul>
                    </nav>
                </div>

                <!-- Row -->
                <div class="row">

                    <!-- Dashboard Box -->
                    <div class="col-xl-12">
                        <div class="dashboard-box margin-top-0">

                            <!-- Headline -->
                            <div class="headline">
                                <h3 class="d-block" style="overflow: hidden">
                                    <i class="icon-material-outline-account-circle"></i>
                                    {{ __('Profile Details') }}
                                    @if(\Illuminate\Support\Facades\Auth::user()->user_type == 'service_provider')
                                        @if(\Illuminate\Support\Facades\Auth::user()->promoted == 'false' || \Illuminate\Support\Facades\Auth::user()->promotion_expire < date('Y-m-d'))
                                            <div class="d-inline-block float-right ml-2 ">
                                                <a href="{{ route('promote.profile') }}"
                                                   class="button">{{ __('Promote Your Profile') }}</a>
                                            </div>
                                        @endif
                                    @endif
                                    <div class="d-inline-block float-right">
                                        <a href="{{ route('edit.profile') }}"
                                           class="button">{{ __('Edit Profile') }}</a>
                                    </div>
                                </h3>

                            </div>

                            <div class="content with-padding padding-bottom-0">
                                <div class="row profile-general text-center">
                                    <div class="col-md-12">
                                        <div class="avatar-wrapper">
                                            @if(!empty($user->profile_pic))
                                                <img class="profile-pic"
                                                     src="{{ asset('profile') }}/{{ $user->profile_pic }}" alt=""/>
                                            @else
                                                <img class="profile-pic"
                                                     src="{{ asset('assets/frontend') }}/images/user-avatar-placeholder.png"
                                                     alt=""/>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <h3>
                                            {{ $user->first_name }}
                                            {{ $user->last_name }}
                                        </h3>
                                    </div>
                                </div>
                                <div class="row details">
                                    <div class="col-md-12">
                                        <b>{{ __('Email Address') }}</b> : {{ $user->email }}
                                    </div>
                                    <div class="col-md-12">
                                        <b>{{ __('Mobile Number') }}</b> : {{ $user->mobile_number }}
                                    </div>
                                    <div class="col-md-12">
                                        <b>{{ __('User Type') }}</b> :
                                        @if($user->user_type == 'service_provider')
                                            {{ __('Service Provider') }}
                                        @else
                                            {{ __('Customer') }}
                                        @endif
                                    </div>
                                    @if(!empty($user->address_line_1))
                                        <div class="col-md-12">
                                            <b>{{ __('Address Line 1') }}</b> : {{ $user->address_line_1 }}
                                        </div>
                                    @endif
                                    @if(!empty($user->address_line_2))
                                        <div class="col-md-12">
                                            <b>{{ __('Address Line 2') }}</b> : {{ $user->address_line_2 }}
                                        </div>
                                    @endif
                                    @if(!empty($user->city))
                                        <div class="col-md-12">
                                            <b>{{ __('City') }}</b> : {{ $user->userCity->name }}
                                        </div>
                                    @endif
                                    @if(!empty($user->state))
                                        <div class="col-md-12">
                                            <b>{{ __('State') }}</b> : {{ $user->userState->name }}
                                        </div>
                                    @endif
                                    @if(!empty($user->country))
                                        <div class="col-md-12">
                                            <b>{{ __('Country') }}</b> : {{ $user->userCountry->name }}
                                        </div>
                                    @endif
                                    @if(!empty($user->pincode))
                                        <div class="col-md-12">
                                            <b>{{ __('Pincode') }}</b> : {{ $user->pincode }}
                                        </div>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <!-- Row / End -->

            </div>
        </div>
        <!-- Dashboard Content / End -->

    </div>
    <!-- Dashboard Container / End -->
@endsection
