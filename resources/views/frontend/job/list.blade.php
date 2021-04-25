@extends('frontend.layouts.master')
@section('title')
    {{ __('Find Jobs') }}
@endsection
@section('content')
    <!-- Spacer -->
    <div class="margin-top-90"></div>
    <!-- Spacer / End-->
    <!-- Page Content
    ================================================== -->
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-4">
                <div class="sidebar-container">
                    <form action="{{ route('job-list') }}" method="get">
                        <!-- Location -->
                        <div class="sidebar-widget">
                            <h3>{{ __('Location') }}</h3>
                            <div class="input-with-icon">
                                <div id="autocomplete-container">
                                    <input type="text" placeholder="{{ __('Location') }}" name="location" value="{{ $location }}">
                                </div>
                                <i class="icon-material-outline-location-on"></i>
                            </div>
                        </div>


                        <!-- Keywords -->
                        <div class="sidebar-widget">
                            <h3>Keywords</h3>
                            <div class="keywords-container">
                                <div class="keyword-input-container">
                                    <input name="keyword" type="text" class="keyword-input" placeholder="{{ __('e.g. job title') }}" value="{{ $keyword }}"/>
                                </div>
                            </div>
                        </div>

                        <!-- Category -->
                        <div class="sidebar-widget">
                            <h3>Category</h3>
                            <select class="selectpicker default" data-selected-text-format="count"
                                    data-size="7"
                                    title="{{ __('All Categories') }}" name="category_id">
                                @foreach($jobCategories as $jobCategory)
                                    <option value="{{ $jobCategory->id }}" @if($category_id == $jobCategory->id) selected @endif>
                                        {{ $jobCategory->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="sidebar-widget">
                            <button class="btn btn-primary theme-bg btn-block" type="submit">{{ __('Search') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8 content-left-offset">

                <h3 class="page-title">{{ __('Search Results') }}</h3>

                <div class="notify-box margin-top-15">
                    {{--                    <div class="switch-container">--}}
                    {{--                        <label class="switch"><input type="checkbox"><span class="switch-button"></span><span--}}
                    {{--                                class="switch-text">Turn on email alerts for this search</span></label>--}}
                    {{--                    </div>--}}

                    <div class="sort-by">
                        <span>Sort by:</span>
                        <select class="selectpicker hide-tick">
                            <option>Relevance</option>
                            <option>Newest</option>
                            <option>Oldest</option>
                            <option>Random</option>
                        </select>
                    </div>
                </div>

                <div class="listings-container margin-top-35">
                    @if($noJob == true)
                        <p class="text-center">{{ __('No Job Found') }}</p>
                    @else
                        @foreach($jobs as $job)
                            <!-- Job Listing -->
                                <a href="{{ route('job.details',encrypt($job->id)) }}"
                                   class="job-listing with-apply-button">
                                    <div class="job-listing">

                                        <!-- Job Listing Details -->
                                        <div class="job-listing-details">
                                            <!-- Logo -->
                                            <div class="job-listing-company-logo">
                                                @if(!empty($job->creatorDetails->profile_pic))
                                                    <img class="circle-image"
                                                         src="{{ asset('') }}/{{ $job->creatorDetails->profile_pic }}"
                                                         alt=""/>
                                                @else
                                                    <img class="circle-image"
                                                         src="{{ asset('assets/frontend') }}/images/user-avatar-placeholder.png"
                                                         alt=""/>
                                                @endif
                                            </div>

                                            <!-- Details -->
                                            <div class="job-listing-description">
                                                <h4 class="job-listing-company">{{ $job->creatorDetails->first_name }} {{ $job->creatorDetails->last_name }}
                                                    <span class="verified-badge" title="Verified Employer"
                                                          data-tippy-placement="top"></span>
                                                </h4>
                                                <h3 class="job-listing-title">{{ $job->title }}</h3>
                                                <p class="job-listing-text">{{ substr($job->description,0,250) }}...</p>
                                            </div>

                                            <!-- Apply Button -->
                                            <span class="list-apply-button ripple-effect">
                                    {{ __('View Details') }}
                                </span>
                                        </div>

                                        <!-- Job Listing Footer -->
                                        <div class="job-listing-footer">
                                            <ul>
                                                <li><i class="icon-material-outline-location-on"></i> {{ $job->address }}
                                                </li>
                                                {{--                                <li><i class="icon-material-outline-business-center"></i> Full Time</li>--}}
                                                <li><i class="icon-material-outline-account-balance-wallet"></i>
                                                    ${{ $job->fee_range_min }}-{{ $job->fee_range_max }}</li>
                                                <li>
                                                    <i class="icon-material-outline-access-time"></i> {{ $job->created_at->diffForHumans() }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </a>
                        @endforeach
                    @endif
                <!-- Pagination -->
                {{--                    <div class="clearfix"></div>--}}
                {{--                    <div class="row">--}}
                {{--                        <div class="col-md-12">--}}
                {{--                            <!-- Pagination -->--}}
                {{--                            <div class="pagination-container margin-top-30 margin-bottom-60">--}}
                {{--                                <nav class="pagination">--}}
                {{--                                    <ul>--}}
                {{--                                        <li class="pagination-arrow"><a href="#"><i--}}
                {{--                                                    class="icon-material-outline-keyboard-arrow-left"></i></a></li>--}}
                {{--                                        <li><a href="#">1</a></li>--}}
                {{--                                        <li><a href="#" class="current-page">2</a></li>--}}
                {{--                                        <li><a href="#">3</a></li>--}}
                {{--                                        <li><a href="#">4</a></li>--}}
                {{--                                        <li class="pagination-arrow"><a href="#"><i--}}
                {{--                                                    class="icon-material-outline-keyboard-arrow-right"></i></a></li>--}}
                {{--                                    </ul>--}}
                {{--                                </nav>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                <!-- Pagination / End -->

                </div>

            </div>
        </div>
    </div>
@endsection
