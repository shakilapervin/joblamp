@extends('frontend.layouts.master')
@section('title')
    {{ __('Find Task Worker') }}
@endsection
@section('content')
    <!-- Spacer -->
    <div class="margin-top-90"></div>
    <!-- Spacer / End-->

    <!-- Page Content
    ================================================== -->
    <div class="container">
        <div class="row">
{{--            <div class="col-xl-3 col-lg-4">--}}
{{--                <div class="sidebar-container">--}}

{{--                    <!-- Location -->--}}
{{--                    <div class="sidebar-widget">--}}
{{--                        <h3>Location</h3>--}}
{{--                        <div class="input-with-icon">--}}
{{--                            <div id="autocomplete-container">--}}
{{--                                <input id="autocomplete-input" type="text" placeholder="Anywhere">--}}
{{--                            </div>--}}
{{--                            <i class="icon-material-outline-location-on"></i>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <!-- Category -->--}}
{{--                    <div class="sidebar-widget">--}}
{{--                        <h3>Category</h3>--}}
{{--                        <select class="selectpicker default" multiple data-selected-text-format="count" data-size="7"--}}
{{--                                title="All Categories">--}}
{{--                            <option>Admin Support</option>--}}
{{--                            <option>Customer Service</option>--}}
{{--                            <option>Data Analytics</option>--}}
{{--                            <option>Design & Creative</option>--}}
{{--                            <option>Legal</option>--}}
{{--                            <option>Software Developing</option>--}}
{{--                            <option>IT & Networking</option>--}}
{{--                            <option>Writing</option>--}}
{{--                            <option>Translation</option>--}}
{{--                            <option>Sales & Marketing</option>--}}
{{--                        </select>--}}
{{--                    </div>--}}

{{--                    <!-- Keywords -->--}}
{{--                    <div class="sidebar-widget">--}}
{{--                        <h3>Keywords</h3>--}}
{{--                        <div class="keywords-container">--}}
{{--                            <div class="keyword-input-container">--}}
{{--                                <input type="text" class="keyword-input" placeholder="e.g. task title"/>--}}
{{--                                <button class="keyword-input-button ripple-effect"><i--}}
{{--                                        class="icon-material-outline-add"></i></button>--}}
{{--                            </div>--}}
{{--                            <div class="keywords-list"><!-- keywords go here --></div>--}}
{{--                            <div class="clearfix"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}


{{--                    <!-- Hourly Rate -->--}}
{{--                    <div class="sidebar-widget">--}}
{{--                        <h3>Hourly Rate</h3>--}}
{{--                        <div class="margin-top-55"></div>--}}

{{--                        <!-- Range Slider -->--}}
{{--                        <input class="range-slider" type="text" value="" data-slider-currency="$" data-slider-min="10"--}}
{{--                               data-slider-max="250" data-slider-step="5" data-slider-value="[10,250]"/>--}}
{{--                    </div>--}}

{{--                    <!-- Tags -->--}}
{{--                    <div class="sidebar-widget">--}}
{{--                        <h3>Skills</h3>--}}

{{--                        <div class="tags-container">--}}
{{--                            <div class="tag">--}}
{{--                                <input type="checkbox" id="tag1"/>--}}
{{--                                <label for="tag1">front-end dev</label>--}}
{{--                            </div>--}}
{{--                            <div class="tag">--}}
{{--                                <input type="checkbox" id="tag2"/>--}}
{{--                                <label for="tag2">angular</label>--}}
{{--                            </div>--}}
{{--                            <div class="tag">--}}
{{--                                <input type="checkbox" id="tag3"/>--}}
{{--                                <label for="tag3">react</label>--}}
{{--                            </div>--}}
{{--                            <div class="tag">--}}
{{--                                <input type="checkbox" id="tag4"/>--}}
{{--                                <label for="tag4">vue js</label>--}}
{{--                            </div>--}}
{{--                            <div class="tag">--}}
{{--                                <input type="checkbox" id="tag5"/>--}}
{{--                                <label for="tag5">web apps</label>--}}
{{--                            </div>--}}
{{--                            <div class="tag">--}}
{{--                                <input type="checkbox" id="tag6"/>--}}
{{--                                <label for="tag6">design</label>--}}
{{--                            </div>--}}
{{--                            <div class="tag">--}}
{{--                                <input type="checkbox" id="tag7"/>--}}
{{--                                <label for="tag7">wordpress</label>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="clearfix"></div>--}}

{{--                        <!-- More Skills -->--}}
{{--                        <div class="keywords-container margin-top-20">--}}
{{--                            <div class="keyword-input-container">--}}
{{--                                <input type="text" class="keyword-input" placeholder="add more skills"/>--}}
{{--                                <button class="keyword-input-button ripple-effect"><i--}}
{{--                                        class="icon-material-outline-add"></i></button>--}}
{{--                            </div>--}}
{{--                            <div class="keywords-list"><!-- keywords go here --></div>--}}
{{--                            <div class="clearfix"></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="clearfix"></div>--}}

{{--                </div>--}}
{{--            </div>--}}
            <div class="col-xl-12 col-lg-12 content-left-offset">

                <h3 class="page-title">Search Results</h3>

{{--                <div class="notify-box margin-top-15">--}}
{{--                    <div class="switch-container">--}}
{{--                        <label class="switch"><input type="checkbox"><span class="switch-button"></span><span--}}
{{--                                class="switch-text">Turn on email alerts for this search</span></label>--}}
{{--                    </div>--}}

{{--                    <div class="sort-by">--}}
{{--                        <span>Sort by:</span>--}}
{{--                        <select class="selectpicker hide-tick">--}}
{{--                            <option>Relevance</option>--}}
{{--                            <option>Newest</option>--}}
{{--                            <option>Oldest</option>--}}
{{--                            <option>Random</option>--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                </div>--}}

                <!-- Freelancers List Container -->
                <div class="freelancers-container freelancers-grid-layout margin-top-35">
                    @foreach($workers as $worker)
                    <!--Freelancer -->
                    <div class="freelancer">

                        <!-- Overview -->
                        <div class="freelancer-overview">
                            <div class="freelancer-overview-inner">
                                <!-- Avatar -->
                                <div class="freelancer-avatar">
                                    <div class="verified-badge"></div>
                                    <a href="{{ route('public.profile',encrypt($worker->id)) }}">
                                        @if(!empty($worker->profile_pic))
                                            <img src="{{ asset('profile') }}/{{ $worker->profile_pic }}"
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
                                        <a href="{{ route('public.profile',encrypt($worker->id)) }}">
                                            {{ $worker->first_name }} {{ $worker->last_name }}
                                        </a>
                                    </h4>
                                </div>

                                <!-- Rating -->
                                <div class="freelancer-rating">
                                    <div class="star-rating" data-rating="{{ calculateRating($worker->userRating) }}"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Details -->
                        <div class="freelancer-details">
                            <div class="freelancer-details-list">
                                <ul>
                                    <li>{{ __('Location') }} <strong><i class="icon-material-outline-location-on"></i>
                                            {{ $worker->country_name }}</strong></li>
                                    <li>{{ __('Total Reviews') }} <strong>{{ count($worker->userRating) }}</strong></li>
                                </ul>
                            </div>
                            <a href="{{ route('public.profile',encrypt($worker->id)) }}" class="button button-sliding-icon ripple-effect"> {{ __('View Profile') }} <i class="icon-material-outline-arrow-right-alt"></i></a>
                        </div>
                    </div>
                    <!-- Freelancer / End -->
                    @endforeach

                </div>
                <!-- Freelancers Container / End -->


                <!-- Pagination -->
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Pagination -->
                        <div class="pagination-container margin-top-40 margin-bottom-60">
                            {{ $workers->links() }}
                        </div>
                    </div>
                </div>
                <!-- Pagination / End -->

            </div>
        </div>
    </div>
@endsection
