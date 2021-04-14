@extends('frontend.layouts.master')
@section('title')
    {{ $job->title }}
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('public/assets/frontend') }}/vendor/rating/dist/star-rating.min.css">
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
                                            src="{{ asset('public/assets/frontend') }}/images/user-avatar-placeholder.png"
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
                                        <div class="star-rating" data-rating="4.9"></div>
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
                                                    <select class="star-rating @error('service_provider_rating') is-invalid @enderror" required name="rating">
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
                                                    <textarea cols="30" rows="5" class="with-border" name="feedback" required></textarea>
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
@endsection
@section('script')
    <script src="{{ asset('public/assets/frontend') }}/vendor/rating/dist/star-rating.min.js"></script>
    <script>
        var starratings = new StarRating('.star-rating', {
            onClick: function (el) {
                console.log('Selected: ' + el[el.selectedIndex].text);
            },
        });
    </script>
@endsection
