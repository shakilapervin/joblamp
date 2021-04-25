@extends('frontend.layouts.master')
@section('title')
    {{ $job->title }}
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
                @if(count($similarJobs) > 0)
                    <div class="single-page-section">
                        <h3 class="margin-bottom-25">
                            {{ __('Similar Jobs') }}
                        </h3>
                        <!-- Listings Container -->
                        <div class="listings-container grid-layout">
                        @foreach($similarJobs as $similarJob)
                            <!-- Job Listing -->
                                <a href="#" class="job-listing">

                                    <!-- Job Listing Details -->
                                    <div class="job-listing-details">
                                        <!-- Logo -->
                                        <div class="job-listing-company-logo">
                                            @if(!empty($similarJob->creatorDetails->profile_pic))
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
                                            <h4 class="job-listing-company">
                                                {{ $similarJob->creatorDetails->first_name }} {{ $similarJob->creatorDetails->last_name }}
                                            </h4>
                                            <h3 class="job-listing-title">
                                                {{ $similarJob->title }}
                                            </h3>
                                        </div>
                                    </div>

                                    <!-- Job Listing Footer -->
                                    <div class="job-listing-footer">
                                        <ul>
                                            <li>
                                                <i class="icon-material-outline-location-on"></i>
                                                {{ $similarJob->jobCountry->name }}
                                            </li>
                                            <li>
                                                <i class="icon-material-outline-account-balance-wallet"></i>
                                                ${{ $similarJob->fee_range_min }} - ${{ $similarJob->fee_range_max }}
                                            </li>
                                            <li>
                                                <i class="icon-material-outline-access-time"></i>
                                                {{ $similarJob->created_at->diffForHumans() }}
                                            </li>
                                        </ul>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <!-- Listings Container / End -->

                    </div>
                @endif
            </div>


            <!-- Sidebar -->
            <div class="col-xl-4 col-lg-4">
                <div class="sidebar-container">
                    @auth
                        @if(\Illuminate\Support\Facades\Auth::user()->user_type == 'service_provider' && \App\JobApplication::where('job_id',$job->id)->where('candidate_id',\Illuminate\Support\Facades\Auth::user()->id)->count() <= 0)
                            <a href="#small-dialog" class="apply-now-button popup-with-zoom-anim">
                                {{ __('Apply Now ') }}
                                <i class="icon-material-outline-arrow-right-alt"></i>
                            </a>
                        @endif
                        @if(\App\JobApplication::where('job_id',$job->id)->where('candidate_id',\Illuminate\Support\Facades\Auth::user()->id)->count() > 0)
                                <a href="javascript:void(0);" class="apply-now-button popup-with-zoom-anim">
                                    {{ __('Already Applied') }}
                                    <i class="icon-material-outline-arrow-right-alt"></i>
                                </a>
                        @endif
                    @endauth
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
                                        <h5>${{ $job->fee_range_min }} - ${{ $job->fee_range_max }}</h5>
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

                    <!-- Sidebar Widget -->
                    <div class="sidebar-widget">
                        <h3>{{ __('Share Job') }}</h3>

                        <!-- Copy URL -->
                        <div class="copy-url">
                            <input id="copy-url" type="text" value="" class="with-border">
                            <button class="copy-url-button ripple-effect" data-clipboard-target="#copy-url"
                                    title="Copy to Clipboard" data-tippy-placement="top"><i
                                    class="icon-material-outline-file-copy"></i></button>
                        </div>

                        <!-- Share Buttons -->
                        <div class="share-buttons margin-top-25">
                            <div class="share-buttons-trigger"><i class="icon-feather-share-2"></i></div>
                            <div class="share-buttons-content">
                                <span>{{ __('Interesting') }}? <strong>{{ __('Share It') }}!</strong></span>
                                <ul class="share-buttons-icons">
                                    <li><a href="#" data-button-color="#3b5998" title="Share on Facebook"
                                           data-tippy-placement="top"><i class="icon-brand-facebook-f"></i></a></li>
                                    <li><a href="#" data-button-color="#1da1f2" title="Share on Twitter"
                                           data-tippy-placement="top"><i class="icon-brand-twitter"></i></a></li>
                                    <li><a href="#" data-button-color="#dd4b39" title="Share on Google Plus"
                                           data-tippy-placement="top"><i class="icon-brand-google-plus-g"></i></a></li>
                                    <li><a href="#" data-button-color="#0077b5" title="Share on LinkedIn"
                                           data-tippy-placement="top"><i class="icon-brand-linkedin-in"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <!--
    Apply for a job popup
    ==================================================
    -->
    @auth
        @if(\Illuminate\Support\Facades\Auth::user()->user_type == 'service_provider' && \App\JobApplication::where('job_id',$job->id)->where('candidate_id',\Illuminate\Support\Facades\Auth::user()->id)->count() <= 0)
    <div id="small-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
        <!--Tabs -->
        <div class="sign-in-form">
            <ul class="popup-tabs-nav">
                <li>
                    <a href="#tab">
                        {{ __('Apply Now') }}
                    </a>
                </li>
            </ul>
            <div class="popup-tabs-container">

                <!-- Tab -->
                <div class="popup-tab-content" id="tab">

                    <!-- Welcome Text -->
                    <div class="welcome-text">
                        <h3>
                            {{ __('Write Your Cover Letter') }}
                        </h3>
                    </div>

                    <!-- Form -->
                    <form method="post" id="apply-now-form" action="{{ route('apply-job') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ encrypt($job->id) }}">
                        <input type="hidden" name="candidate_id"
                               value="{{ encrypt(\Illuminate\Support\Facades\Auth::user()->id) }}">
                        <div class="input-with-icon-left">
                            <textarea name="cover_letter"
                                      class="input-text with-border @error('cover_letter') is-invalid @enderror"
                                      cols="30" rows="10" required></textarea>
                            @error('cover_letter')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="input-with-icon-left">
                            <input class="input-text with-border @error('bid_amount') is-invalid @enderror" type="text" name="bid_amount" placeholder="{{ __('Offer Amount') }}" style="padding-left: 20px;">
                            @error('bid_amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <!-- Button -->
                        @if (\Illuminate\Support\Facades\Auth::user()->remain_job > 0 || \Illuminate\Support\Facades\Auth::user()->remain_job != 'unlimited')
                            <button class="button margin-top-35 full-width button-sliding-icon ripple-effect" type="submit"
                                    form="apply-now-form">{{ __('Apply Now') }}
                                <i class="icon-material-outline-arrow-right-alt"></i>
                            </button>
                        @else
                            <button class="button margin-top-35 full-width button-sliding-icon ripple-effect" type="submit"
                                    form="apply-now-form">{{ __('Apply Now') }} {{ __('and Pay') }} $2
                                <i class="icon-material-outline-arrow-right-alt"></i>
                            </button>
                        @endif
                    </form>

                </div>

            </div>
        </div>
    </div>
    <!-- Apply for a job popup / End -->
        @endif
    @endauth
@endsection
@section('script')
    <script>
        // Snackbar for copy to clipboard button
        $('.copy-url-button').click(function () {
            Snackbar.show({
                text: '{{ __('Copied to clipboard!') }}',
            });
        });
    </script>
@endsection
