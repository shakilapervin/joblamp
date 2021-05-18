@extends('frontend.layouts.master')
@section('content')
    <div class="single-page-header freelancer-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="single-page-header-inner">
                        <div class="left-side">
                            <div class="header-image freelancer-avatar">
                                @if(!empty($user->profile_pic))
                                    <img src="{{ asset('profile') }}/{{ $user->profile_pic }}"
                                         alt=""/>
                                @else
                                    <img
                                        src="{{ asset('assets/frontend') }}/images/user-avatar-placeholder.png"
                                        alt=""/>
                                @endif
                            </div>
                            <div class="header-details">
                                <h3>{{ $user->first_name }} {{ $user->last_name }}</h3>
                                <ul>
                                    <li>
                                        <div class="star-rating"
                                             data-rating="{{ $user->userRating }}"></div>
                                    </li>
                                    <li>
                                        {{ $user->country_name }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">

            <!-- Content -->
            <div class="col-xl-8 col-lg-8 content-right-offset">

                <!-- Boxed List -->
                <div class="boxed-list margin-bottom-60">
                    <div class="boxed-list-headline">
                        <h3><i class="icon-material-outline-thumb-up"></i> {{ __('Work History and Feedback') }}</h3>
                    </div>
                    <ul class="boxed-list-ul">
                        @foreach($userFeedbacks as $feedback)
                            <li>
                                <div class="boxed-list-item">
                                    <!-- Content -->
                                    <div class="item-content">
                                        <h4>
                                            {{ $feedback->first_name }} {{ $feedback->last_name }}
                                            <span>{{ __('Rated as Freelancer') }}</span>
                                        </h4>
                                        <div class="item-details margin-top-10">
                                            <div class="star-rating" data-rating="{{ $feedback->rating }}"></div>
                                            <div class="detail-item"><i class="icon-material-outline-date-range"></i>
                                                {{ \Carbon\Carbon::parse($feedback->created_at)->format('Y-m-d')}}
                                            </div>
                                        </div>
                                        <div class="item-description">
                                            <p>{{ $feedback->feedback }}</p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                </div>
                <!-- Boxed List / End -->

            </div>

            <!-- Sidebar -->
            <div class="col-xl-4 col-lg-4">
                <div class="sidebar-container">

                    <!-- Profile Overview -->
                    <div class="profile-overview">
                        <div class="overview-item"><strong>{{ $jobDone }}</strong><span>{{ __('Jobs Done') }}</span></div>
                        <div class="overview-item"><strong>{{ count($userFeedbacks) }}</strong><span>{{ __('Reviews') }}</span></div>
                    </div>

                    <!-- Button -->
                    <a href="{{ route('message',$user->id) }}" class="apply-now-button margin-bottom-50">
                        {{ __('Contact Me') }}
                        <i class="icon-material-outline-arrow-right-alt"></i>
                    </a>


                    <!-- Widget -->
                    <div class="sidebar-widget">
                        <h3>{{ __('Skills') }}</h3>
                        <div class="task-tags">
                            @php
                                $lang = session()->get('lang')?: 'en';
                                $skillName = 'name_'.$lang;
                            @endphp
                            @foreach(json_decode($user->skill) as $skill)
                                @php
                                    $skillDetails = \App\Skill::select("$skillName as name")->where('id',$skill)->first();
                                @endphp
                            <span>{{ $skillDetails->name }}</span>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
