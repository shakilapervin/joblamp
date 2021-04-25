@extends('frontend.layouts.master')
@section('title')
    {{ $job->title }}
@endsection
@section('content')
    <!-- Titlebar
    ================================================== -->
    <div class="single-page-header" data-background-image="{{ frontend_asset('') }}/images/single-task.jpg">
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
        <div class="row">

            <!-- Content -->
            <div class="col-xl-12 col-lg-12 content-right-offset">

                <!-- Description -->
                <div class="single-page-section">
                    <h3 class="margin-bottom-25">
                        {{ __('Job Description') }}
                    </h3>
                    <p>{{ $job->description }}</p>
                </div>
                <div class="clearfix"></div>

                <!-- Freelancers Bidding -->
                <div class="boxed-list margin-bottom-60">
                    <div class="boxed-list-headline">
                        <h3>
                            <i class="icon-material-outline-group"></i>
                            {{ __('Applications') }}
                        </h3>
                    </div>
                    <ul class="boxed-list-ul">
                        @foreach($applications as $application)
                        <li>
                            <div class="bid">
                                <!-- Avatar -->
                                <div class="bids-avatar">
                                    <div class="freelancer-avatar">
                                        <div class="verified-badge"></div>
                                        <a href="{{ route('public.profile',encrypt($application->id)) }}">
                                            @if(!empty($application->candidateDetails->profile_pic))
                                                <img src="{{ asset('profile/'.$application->candidateDetails->profile_pic) }}" alt=""/>
                                            @else
                                                <img
                                                    src="{{ asset('assets/frontend') }}/images/user-avatar-placeholder.png"
                                                    alt=""/>
                                            @endif
                                        </a>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="bids-content">
                                    <!-- Name -->
                                    <div class="freelancer-name">
                                        <h4>
                                            <a href="{{ route('public.profile',encrypt($application->id)) }}">
                                                {{ $application->candidateDetails->first_name }} {{ $application->candidateDetails->last_name }}
                                            </a>

                                        </h4>
                                        {{ $application->candidateDetails->userCountry->name }}
                                        @php
                                            $rating = calculateRating($application->candidateDetails->userRating);
                                        @endphp
                                        @if ($rating > 0)
                                            <div class="star-rating" data-rating="{{ $rating }}"></div>
                                        @else
                                            <div>{{ __('No Rating') }}</div>
                                        @endif
                                    </div>
                                    <div class="application-details">
                                        <p class="show-read-more">
                                            {{ $application->cover_letter }}
                                        </p>
                                        <div class="seller-contact">
                                            <a href="{{ route('message',$application->candidateDetails->id) }}" class="apply-now-button d-inline-block">
                                                {{ __('Send Message') }}
                                                <i class="icon-material-outline-arrow-right-alt"></i>
                                            </a>
                                            @if ($jobStatus == false)
                                                <a href="{{ route('job.checkout',[encrypt($jobId),encrypt($application->candidateDetails->id)]) }}" class="apply-now-button d-inline-block">
                                                    {{ __('Accept Application') }}
                                                    <i class="icon-material-outline-arrow-right-alt"></i>
                                                </a>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                <div class="bids-bid">
                                    <div class="bid-rate">
                                        <span>{{ __('Bid Amount') }}</span>
                                        <div class="rate">${{ $application->bid_amount }}</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>

            </div>

        </div>
    </div>


    <!-- Spacer -->
    <div class="margin-top-15"></div>
    <!-- Spacer / End-->
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            var maxLength = 300;
            $(".show-read-more").each(function(){
                var myStr = $(this).text();
                if($.trim(myStr).length > maxLength){
                    var newStr = myStr.substring(0, maxLength);
                    var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
                    $(this).empty().html(newStr);
                    $(this).append(' <a href="javascript:void(0);" class="read-more">read more...</a>');
                    $(this).append('<span class="more-text">' + removedStr + '</span>');
                }
            });
            $(".read-more").click(function(){
                $(this).siblings(".more-text").contents().unwrap();
                $(this).remove();
            });
        });
    </script>
@endsection
