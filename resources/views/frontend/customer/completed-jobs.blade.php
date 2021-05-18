@extends('frontend.layouts.master')
@section('title')
    {{ __('Completed Jobs') }}
@endsection

@section('content')
    <!-- Dashboard Container -->
    <div class="dashboard-container">
        @include('frontend.layouts.dashboard-sidebar')
        <div class="dashboard-content-container">
            <div class="dashboard-content-inner" style="min-height: 523px;">

                <!-- Dashboard Headline -->
                <div class="dashboard-headline">
                    <h3>{{ __('Completed Jobs') }}</h3>

                    <!-- Breadcrumbs -->
                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                            <li><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                            <li>{{ __('Completed Jobs') }}</li>
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
                                <h3><i class="icon-material-outline-business-center"></i> {{ __('Completed Job List') }}
                                </h3>
                            </div>

                            <div class="content">
                                <ul class="dashboard-box-list">
                                    @if (!empty($jobs))
                                        @foreach($jobs as $applied)
                                            <li>
                                                <!-- Job Listing -->
                                                <div class="job-listing">
                                                    <!-- Job Listing Details -->
                                                    <div class="job-listing-details">
                                                        <!-- Details -->
                                                        <div class="job-listing-description">
                                                            <h3 class="job-listing-title">
                                                                <a href="{{ route('job.details',encrypt($applied->id)) }}">
                                                                    {{ $applied->title }}
                                                                </a>
                                                            </h3>

                                                            <!-- Job Listing Footer -->
                                                            <div class="job-listing-footer">
                                                                <ul>
                                                                    <li>
                                                                        <i class="icon-material-outline-date-range"></i>
                                                                        {{ __('Posted On') }}
                                                                        : {{ $applied->created_at->toDateString() }}
                                                                    </li>
                                                                    <li>
                                                                        {{ __('Job ID') }}
                                                                        : {{ $applied->job_id }}
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Buttons -->
                                                <div class="buttons-to-right always-visible">
                                                    <a href="{{ route('manage.my.job',encrypt($applied->id)) }}"
                                                       class="button ripple-effect"><i
                                                            class="icon-feather-eye"></i> {{ __('View Details') }}</a>
                                                </div>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Row / End -->

            </div>
        </div>
    </div>
@endsection
