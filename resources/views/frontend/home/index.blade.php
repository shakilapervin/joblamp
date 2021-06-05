@extends('frontend.layouts.master')
@section('content')
    <!-- Intro Banner
    ================================================== -->
    <div class="hero-banner">
        <div class="hero-slider">
            @foreach($banners as $banner)
                <div class="hero-item">
                    <img src="{{ asset($banner->image) }}" alt="" style="width: 100%; object-fit: cover;">
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
                        <h3>{{ __('Popular Job Categories') }}</h3>
                    </div>

                    <!-- Category Boxes Container -->
                    <div class="categories-container">
                    @if (!empty($jobcategories))
                        @foreach($jobcategories as $jobcategory)
                            <!-- Category Box -->
                                <a href="{{ route('job-list') }}/?category_id={{ $jobcategory->id }}"
                                   class="category-box wow bounceInUp" data-wow-duration="2s" data-wow-offset="10">
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
    <div class="section gray margin-top-45 padding-top-65 padding-bottom-75" style="background: #fceff0;">
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
                                   class="job-listing with-apply-button wow slideInLeft" data-wow-duration="2s"
                                   data-wow-offset="10">

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
{{--    <div class="section padding-top-65 padding-bottom-70 full-width-carousel-fix">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-xl-12">--}}
{{--                    <!-- Section Headline -->--}}
{{--                    <div class="section-headline margin-top-0 margin-bottom-25 text-center pr-0">--}}
{{--                        <h3>{{ __('Highest Rated Task Workers') }}</h3>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="col-xl-12">--}}
{{--                    <div class="default-slick-carousel freelancers-container freelancers-grid-layout">--}}
{{--                    @if (!empty($popularWorkers))--}}
{{--                        @foreach($popularWorkers as $popularWorker)--}}
{{--                            <!--Freelancer -->--}}
{{--                                <div class="freelancer wow bounceInDown" data-wow-duration="2s" data-wow-offset="10">--}}
{{--                                    <!-- Overview -->--}}
{{--                                    <div class="freelancer-overview">--}}
{{--                                        <div class="freelancer-overview-inner">--}}
{{--                                            <!-- Avatar -->--}}
{{--                                            <div class="freelancer-avatar">--}}
{{--                                                <div class="verified-badge"></div>--}}
{{--                                                <a href="{{ route('public.profile',encrypt($popularWorker->id)) }}">--}}
{{--                                                    @if(!empty($popularWorker->profile_pic))--}}
{{--                                                        <img--}}
{{--                                                            src="{{ asset('profile') }}/{{ $popularWorker->profile_pic }}"--}}
{{--                                                            alt=""/>--}}
{{--                                                    @else--}}
{{--                                                        <img--}}
{{--                                                            src="{{ asset('assets/frontend') }}/images/user-avatar-placeholder.png"--}}
{{--                                                            alt=""/>--}}
{{--                                                    @endif--}}
{{--                                                </a>--}}
{{--                                            </div>--}}

{{--                                            <!-- Name -->--}}
{{--                                            <div class="freelancer-name">--}}
{{--                                                <h4>--}}
{{--                                                    <a href="{{ route('public.profile',encrypt($popularWorker->id)) }}">--}}
{{--                                                        {{ $popularWorker->first_name }} {{ $popularWorker->last_name }}--}}
{{--                                                    </a>--}}
{{--                                                </h4>--}}
{{--                                            </div>--}}
{{--                                            <!-- Rating -->--}}
{{--                                            <div class="freelancer-rating">--}}
{{--                                                <div class="star-rating"--}}
{{--                                                     data-rating="{{ $popularWorker->userRating }}"></div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <!-- Details -->--}}
{{--                                    <div class="freelancer-details">--}}
{{--                                        <div class="freelancer-details-list">--}}
{{--                                            <ul>--}}
{{--                                                <li>--}}
{{--                                                    {{ __('Location') }}--}}
{{--                                                    <strong>--}}
{{--                                                        <i class="icon-material-outline-location-on"></i>--}}
{{--                                                        {{ $popularWorker->country_name }}--}}
{{--                                                    </strong>--}}
{{--                                                </li>--}}
{{--                                            </ul>--}}
{{--                                        </div>--}}
{{--                                        <a href="{{ route('public.profile',encrypt($popularWorker->id)) }}"--}}
{{--                                           class="button button-sliding-icon ripple-effect">{{ __('View Profile') }} <i--}}
{{--                                                class="icon-material-outline-arrow-right-alt"></i></a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <!-- Freelancer / End -->--}}
{{--                            @endforeach--}}
{{--                        @endif--}}

{{--                    </div>--}}
{{--                </div>--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <!-- Highest Rated Freelancers / End-->

    <!-- Hero Section -->
    <div class="section padding-top-60 padding-bottom-75">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
                    <div class="fr-about-video">
                        <div class="fr-about-container">
                            <img src="{{ asset('assets/frontend/images/space.png') }}" alt=""
                                 class="img-fluid wow pulse" data-wow-iteration="infinite" data-wow-duration="2s">
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12">
                    <div class="fr-about-conrent">
                        <span>Want to build</span>
                        <h2>Amazing Marketplace Website in Minutes ?</h2>
                        <p>Experience state-of-the-art marketplace platform with the Exertio. We combine the experience
                            of our global community around the globe for a best marketplace theme.</p>
                        <p>With Exertio, you can develop a website for remote freelancers that will provide their best
                            to the clients who are looking for remote resources. </p><h4>Key Points</h4>
                        <div class="fr-product-checks">
                            <ul>
                                <li><img
                                        src="https://marketplace.exertiowp.com/wp-content/themes/exertio/images/check-box.png"
                                        alt="" class="img-fluid"> <span>Get commission on project or servies</span></li>
                                <li><img
                                        src="https://marketplace.exertiowp.com/wp-content/themes/exertio/images/check-box.png"
                                        alt="" class="img-fluid"> <span>Services addons and  micro earnings</span></li>
                                <li><img
                                        src="https://marketplace.exertiowp.com/wp-content/themes/exertio/images/check-box.png"
                                        alt="" class="img-fluid"> <span>Communicate easily with live chat</span></li>
                                <li><img
                                        src="https://marketplace.exertiowp.com/wp-content/themes/exertio/images/check-box.png"
                                        alt="" class="img-fluid"> <span>Send media &amp; emoji in chat</span></li>
                            </ul>
                        </div>
                        <a href="https://www.youtube.com/watch?v=S7r23-YvGrc" class="button">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Section / End-->

    <!-- Membership Plans -->
    <div class="section padding-top-60 padding-bottom-75" style="background: #fceff0; background-image: url({{ asset('assets/frontend/images/background.png') }})">
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
                    <div class="pricing-plans-container bg-white">
                    @foreach($subscriptionPlans as $plan)
                        <!-- Plan -->
                            <div class="pricing-plan recommended wow bounceIn" data-wow-duration="2s"
                                 data-wow-offset="10">
                                @php
                                    $lang = session()->get('lang')?: 'en';
                                    $title = 'title_'.$lang;
                                    $description = 'description_'.$lang;
                                    $content = 'content_'.$lang;
                                @endphp
                                <h3>{{ __($plan[$title]) }}</h3>
                                <p class="margin-top-10">
                                    {{ __($plan[$description]) }}
                                </p>
                                <div class="pricing-plan-label billed-monthly-label">
                                    <strong>${{ $plan->default_price }}</strong>/ {{ __('monthly') }}
                                </div>
                                <div class="pricing-plan-label billed-yearly-label">
                                    <strong>${{ $plan->default_price*12 }}</strong>/ {{ __('yearly') }}</div>
                                <div class="pricing-plan-features">
                                    <strong>{{ __('Features of') }} {{ $plan[$title] }}</strong>
                                    <ul>
                                        @foreach($plan->features as  $feature)
                                            <li>{{ $feature[$content] }}</li>
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

    <!-- Join Plans -->
    <div class="section">
        <div class="container-fluid">
            <div class="wt-joinnow">
                <div class="wt-sectiontitle__center">
                    <div class="row">
                        <div class="col-xl-5 col-lg-8 col-md-10 col-sm-11">
                            <div class="wt-sectiontitle wt-sectiontitlevthree">
                                <h2>
                                    Join Now &amp; Start Earning </h2>
                                <p>Consectetur adipisicing elit sed do eiusmod tempor incididunt utnale labore etdolore
                                    magna adminim eniam quis nostrud exercitation ullamco laborisn nisi ut aliquip.</p>
                            </div>
                            <ul class="wt-btnholder">
                                <li>
                                    <a href="{{ route('user-register') }}"
                                       class="button wow swing" data-wow-iteration="infinite" data-wow-duration="2s">{{ __('I want to hire') }}</a>
                                </li>
                                <li>
                                    <a href="{{ route('user-register') }}"
                                       class="button wow swing" data-wow-iteration="infinite" data-wow-duration="2s">{{ __('I want to work') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="wt-joinnow__imgleft hide-under-768px">
                    <figure>
                        <img class="wt-joinnow__imgleft--img wow slideInLeft"
                             src="{{ asset('assets/frontend/images/icon-01-1.png') }}"
                             alt="Joun now">
                    </figure>
                </div>
                <div class="wt-joinnow__imgright hide-under-768px">
                    <figure>
                        <img class="wt-joinnow__imgright--img wow slideInRight"
                             src="{{ asset('assets/frontend/images/img-02-1.png') }}">
                    </figure>
                </div>
            </div>
        </div>
    </div>
    <!-- Join Plans / End-->


@endsection
