@extends('frontend.layouts.master')
@section('content')
    <!-- Intro Banner
    ================================================== -->
    <div class="hero-banner">
        <div class="hero-slider">
            @foreach($banners as $banner)
            <div class="hero-item" style="background: url('{{ asset(''.$banner->image) }}');background-size: cover;">
                <div class="hero-title">
                    {{ $banner->title }}
                </div>
                <div class="overlay"></div>
            </div>
            @endforeach
        </div>
    </div>


    <!-- Content
    ================================================== -->
    <!-- Category Boxes -->
    <div class="section margin-top-65">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">

                    <div class="section-headline centered margin-bottom-50">
                        <h3>Popular Job Categories</h3>
                    </div>

                    <!-- Category Boxes Container -->
                    <div class="categories-container">
                    @if (!empty($jobcategories))
                        @foreach($jobcategories as $jobcategory)
                            <!-- Category Box -->
                                <a href="{{ route('job-list') }}/?category_id={{ $jobcategory->id }}"
                                   class="category-box">
                                    <div class="category-box-icon">
                                        <i class="{{ $jobcategory->icon }} "></i>
                                    </div>
                                    <div class="category-box-counter">
                                        {{ number_format($jobcategory->totalJob,0,',',',') }}
                                    </div>
                                    <div class="category-box-content">
                                        <h3>{{ $jobcategory->name }}</h3>
                                        <p>{{ $jobcategory->description }}</p>
                                    </div>
                                </a>
                            @endforeach
                        @endif

                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Category Boxes / End -->


    <!-- Features Jobs -->
    <div class="section gray margin-top-45 padding-top-65 padding-bottom-75">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">

                    <!-- Section Headline -->
                    <div class="section-headline margin-top-0 margin-bottom-35">
                        <h3>{{ __('Latest Jobs') }}</h3>
                        <a href="{{ route('job-list') }}" class="headline-link">{{ __('Browse All Jobs') }}</a>
                    </div>

                    <!-- Jobs Container -->
                    <div class="listings-container compact-list-layout margin-top-35">
                    @if (!empty($jobs))
                        @foreach($jobs as $job)
                            <!-- Job Listing -->
                                <a href="{{ route('job.details',encrypt($job->id)) }}"
                                   class="job-listing with-apply-button">

                                    <!-- Job Listing Details -->
                                    <div class="job-listing-details">

                                        <!-- Logo -->
                                        <div class="job-listing-company-logo">
                                            @if(!empty($job->creatorDetails->profile_pic))
                                                <img src="{{ asset('') }}/{{ $job->creatorDetails->profile_pic }}"
                                                     alt=""/>
                                            @else
                                                <img
                                                    src="{{ asset('assets/frontend') }}/images/user-avatar-placeholder.png"
                                                    alt=""/>
                                            @endif
                                        </div>

                                        <!-- Details -->
                                        <div class="job-listing-description">
                                            <h3 class="job-listing-title">{{ $job->title }}</h3>

                                            <!-- Job Listing Footer -->
                                            <div class="job-listing-footer">
                                                <ul>
                                                    <li>
                                                        <i class="icon-material-outline-business"></i> {{ $job->creatorDetails->first_name }} {{ $job->creatorDetails->last_name }}
                                                        <div class="verified-badge" title="Verified Employer"
                                                             data-tippy-placement="top"></div>
                                                    </li>
                                                    <li>
                                                        <i class="icon-material-outline-location-on"></i> {{ $job->address }}
                                                    </li>
                                                    <li>
                                                        <i class="icon-material-outline-account-balance-wallet"></i>
                                                        ${{ $job->fee_range_min }}-{{ $job->fee_range_max }}
                                                    </li>
                                                    <li>
                                                        <i class="icon-material-outline-access-time"></i>
                                                        {{ $job->created_at->diffForHumans() }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <!-- Apply Button -->
                                        <span class="list-apply-button ripple-effect">{{ __('View Details') }}</span>
                                    </div>
                                </a>
                            @endforeach
                        @endif
                    </div>
                    <!-- Jobs Container / End -->

                </div>
            </div>
        </div>
    </div>
    <!-- Featured Jobs / End -->



    <!-- Highest Rated Freelancers -->
    <div class="section padding-top-65 padding-bottom-70 full-width-carousel-fix">
        <div class="container">
            <div class="row">

                <div class="col-xl-12">
                    <!-- Section Headline -->
                    <div class="section-headline margin-top-0 margin-bottom-25">
                        <h3>{{ __('Highest Rated Task Workers') }}</h3>
                        {{--                        <a href="freelancers-grid-layout.html"--}}
                        {{--                           class="headline-link">{{ __('Browse All Freelancers') }}</a>--}}
                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="default-slick-carousel freelancers-container freelancers-grid-layout">
                    @if (!empty($popularWorkers))
                        @foreach($popularWorkers as $popularWorker)
                            <!--Freelancer -->
                                <div class="freelancer">

                                    <!-- Overview -->
                                    <div class="freelancer-overview">
                                        <div class="freelancer-overview-inner">
                                            <!-- Avatar -->
                                            <div class="freelancer-avatar">
                                                <div class="verified-badge"></div>
                                                <a href="{{ route('public.profile',encrypt($popularWorker->id)) }}">
                                                    @if(!empty($popularWorker->profile_pic))
                                                        <img src="{{ asset('profile') }}/{{ $popularWorker->profile_pic }}"
                                                             alt=""/>
                                                    @else
                                                        <img
                                                            src="{{ asset('assets/frontend') }}/images/user-avatar-placeholder.png"
                                                            alt=""/>
                                                    @endif
                                                </a>
                                            </div>

                                            <!-- Name -->
                                            <div class="freelancer-name">
                                                <h4>
                                                    <a href="{{ route('public.profile',encrypt($popularWorker->id)) }}">
                                                        {{ $popularWorker->first_name }} {{ $popularWorker->last_name }}
                                                    </a>
                                                </h4>
                                            </div>
                                            <!-- Rating -->
                                            <div class="freelancer-rating">
                                                <div class="star-rating"
                                                     data-rating="{{ $popularWorker->userRating }}"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Details -->
                                    <div class="freelancer-details">
                                        <div class="freelancer-details-list">
                                            <ul>
                                                <li>
                                                    {{ __('Location') }}
                                                    <strong>
                                                        <i class="icon-material-outline-location-on"></i>
                                                        {{ $popularWorker->country_name }}
                                                    </strong>
                                                </li>
                                            </ul>
                                        </div>
                                        <a href="{{ route('public.profile',encrypt($popularWorker->id)) }}"
                                           class="button button-sliding-icon ripple-effect">{{ __('View Profile') }} <i
                                                class="icon-material-outline-arrow-right-alt"></i></a>
                                    </div>
                                </div>
                                <!-- Freelancer / End -->
                            @endforeach
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Highest Rated Freelancers / End-->


    <!-- Membership Plans -->
    <div class="section padding-top-60 padding-bottom-75">
        <div class="container">
            <div class="row">

                <div class="col-xl-12">
                    <!-- Section Headline -->
                    <div class="section-headline centered margin-top-0 margin-bottom-35">
                        <h3>{{ __('Membership Plans') }}</h3>
                    </div>
                </div>


                <div class="col-xl-12">
                    <!-- Pricing Plans Container -->
                    <div class="pricing-plans-container">
                    @foreach($subscriptionPlans as $plan)
                        <!-- Plan -->
                            <div class="pricing-plan @if($plan->recommended == 1) recommended @endif">
                                <h3>{{ __($plan->title) }}</h3>
                                <p class="margin-top-10">
                                    {{ __($plan->description) }}
                                </p>
                                <div class="pricing-plan-label billed-monthly-label">
                                    <strong>${{ $plan->default_price }}</strong>/ {{ __('monthly') }}
                                </div>
                                <div class="pricing-plan-label billed-yearly-label">
                                    <strong>${{ $plan->default_price*12 }}</strong>/ {{ __('yearly') }}</div>
                                <div class="pricing-plan-features">
                                    <strong>{{ __('Features of') }} {{ __($plan->title) }}</strong>
                                    <ul>
                                        @foreach($plan->features as  $feature)
                                            <li>{{ __($feature->content) }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <a href="{{ route('subscription.checkout',encrypt($plan->id)) }}"
                                   class="button full-width margin-top-20">
                                    {{ __('Buy Now') }}
                                </a>
                            </div>
                        @endforeach
                    </div>

                </div>

            </div>
        </div>
    </div>
    <!-- Membership Plans / End-->
@endsection
