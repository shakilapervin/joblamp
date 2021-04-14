@extends('frontend.layouts.master')
@section('title')
    {{ __('Dashboard') }}
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
                    <h3>{{ __('Howdy') }}, {{ $user->first_name }} {{ $user->last_name }}!</h3>
                    <span>{{ __('We are glad to see you again') }}!</span>

                    <!-- Breadcrumbs -->
                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li><a href="{{ url('') }}">{{ __('Home') }}</a></li>
                            <li>{{ __('Dashboard') }}</li>
                        </ul>
                    </nav>
                </div>
                @if (Session::has('success'))
                    <div class="alert alert-success text-center">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <p>{{ Session::get('success') }}</p>
                    </div>

            @endif

            <!-- Fun Facts Container -->
                <div class="fun-facts-container">
                    <div class="fun-fact" data-fun-fact-color="#b81b7f">
                        <div class="fun-fact-text">
                            <span>{{ __('Jobs Applied') }}</span>
                            <h4>{{ count($jobsApplied) }}</h4>
                        </div>
                        <div class="fun-fact-icon"><i class="icon-material-outline-business-center"></i></div>
                    </div>
                    <div class="fun-fact" data-fun-fact-color="#efa80f">
                        <div class="fun-fact-text">
                            <span>{{ __('Reviews') }}</span>
                            <h4>{{ $ratings }}</h4>
                        </div>
                        <div class="fun-fact-icon"><i class="icon-material-outline-rate-review"></i></div>
                    </div>

                    <!-- Last one has to be hidden below 1600px, sorry :( -->
                    <div class="fun-fact" data-fun-fact-color="#2a41e6">
                        <div class="fun-fact-text">
                            <span>{{ __('Active Job') }}</span>
                            <h4>{{ count($activeJobs) }}</h4>
                        </div>
                        <div class="fun-fact-icon"><i class="icon-feather-trending-up"></i></div>
                    </div>
                </div>

                <!-- Row -->
                <div class="row">
                    <div class="col-xl-3">
                        <div class="dashboard-box">
                            <div class="headline bg-primary">
                                <h3 class="text-white">
                                    <i class="icon-line-awesome-book text-white"></i>
                                    {{ __('Applied Jobs') }}
                                </h3>
                            </div>
                            <div class="content">
                                <ul class="dashboard-box-list">
                                    @php
                                        $i = 1;
                                    @endphp
                                    @if (!empty($jobsApplied))
                                        @foreach($jobsApplied as $applied)
                                            <li>
                                                <div class="invoice-list-item">
                                                    <strong>{{ $applied->jobDetails->title }}</strong>
                                                    <ul>
                                                        <li>{{ __('Fee Range') }}:
                                                            ${{ $applied->jobDetails->fee_range_min }} {{ $applied->jobDetails->fee_range_max }}</li>
                                                        <li>{{ __('Posted On') }}
                                                            : {{ $applied->jobDetails->created_at->toDateString() }}</li>
                                                    </ul>
                                                </div>
                                                <!-- Buttons -->
                                                <div class="buttons-to-right">
                                                    <a target="_blank"
                                                       href="{{ route('job.details',encrypt($applied->job_id)) }}"
                                                       class="button">{{ __('View Details') }}</a>
                                                </div>
                                            </li>
                                            @php
                                                if ($i++ > 4) break;
                                            @endphp
                                        @endforeach
                                    @endif

                                </ul>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        @if(count($jobsApplied) > 4)
                                            <a href="{{ route('applied.jobs') }}"
                                               class="button mt-2" style="padding: 3px 10px;font-size: 14px;">{{ __('View More') }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3">
                        <div class="dashboard-box">
                            <div class="headline bg-secondary">
                                <h3 class="text-white">
                                    <i class="icon-line-awesome-book text-white"></i>
                                    {{ __('Active Jobs') }}
                                </h3>
                            </div>
                            <div class="content">
                                <ul class="dashboard-box-list">
                                    @if (!empty($activeJobs))
                                        @foreach($activeJobs as $activeJob)
                                            <li>
                                                <div class="invoice-list-item">
                                                    <strong>{{ $activeJob->jobDetails->title }}</strong>
                                                    <ul>
                                                        <li>{{ __('Fee Range') }}:
                                                            ${{ $activeJob->jobDetails->fee_range_min }} {{ $activeJob->jobDetails->fee_range_max }}</li>
                                                        <li>{{ __('Posted On') }}
                                                            : {{ $activeJob->jobDetails->created_at->toDateString() }}</li>
                                                    </ul>
                                                </div>
                                                <!-- Buttons -->
                                                <div class="buttons-to-right">
                                                    <a href="{{ route('manage.job',encrypt($activeJob->job_id)) }}"
                                                       class="button">{{ __('View Details') }}</a>
                                                </div>
                                            </li>
                                            @php
                                                if ($i++ > 4) break;
                                            @endphp
                                        @endforeach
                                    @endif
                                </ul>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        @if(count($activeJobs) > 4)
                                            <a href="{{ route('active.jobs') }}"
                                               class="button mt-2" style="padding: 3px 10px;font-size: 14px;">{{ __('View More') }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3">
                        <div class="dashboard-box">
                            <div class="headline bg-warning">
                                <h3 class="text-white">
                                    <i class="icon-line-awesome-book text-white"></i>
                                    {{ __('Delivered Jobs') }}
                                </h3>
                            </div>
                            <div class="content">
                                <ul class="dashboard-box-list">
                                    @foreach($deliveredJobs as $applied)
                                        <li>
                                            <div class="invoice-list-item">
                                                <strong>{{ $applied->jobDetails->title }}</strong>
                                                <ul>
                                                    <li>{{ __('Fee Range') }}:
                                                        ${{ $applied->jobDetails->fee_range_min }} {{ $applied->jobDetails->fee_range_max }}</li>
                                                    <li>{{ __('Posted On') }}
                                                        : {{ $applied->jobDetails->created_at->toDateString() }}</li>
                                                </ul>
                                            </div>
                                            <!-- Buttons -->
                                            <div class="buttons-to-right">
                                                <a target="_blank"
                                                   href="{{ route('job.details',encrypt($applied->job_id)) }}"
                                                   class="button">{{ __('View Details') }}</a>
                                            </div>
                                        </li>
                                        @php
                                            if ($i++ > 4) break;
                                        @endphp
                                    @endforeach
                                </ul>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        @if(count($deliveredJobs) > 4)
                                            <a href="{{ route('delivered.jobs') }}"
                                               class="button mt-2" style="padding: 3px 10px;font-size: 14px;">{{ __('View More') }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3">
                        <div class="dashboard-box">
                            <div class="headline bg-success">
                                <h3 class="text-white">
                                    <i class="icon-line-awesome-book text-white"></i>
                                    {{ __('Completed Jobs') }}
                                </h3>
                            </div>
                            <div class="content">
                                <ul class="dashboard-box-list">
                                    @foreach($completedJobs as $applied)
                                        <li>
                                            <div class="invoice-list-item">
                                                <strong>{{ $applied->jobDetails->title }}</strong>
                                                <ul>
                                                    <li>{{ __('Fee Range') }}:
                                                        ${{ $applied->jobDetails->fee_range_min }} {{ $applied->jobDetails->fee_range_max }}</li>
                                                    <li>{{ __('Posted On') }}
                                                        : {{ $applied->jobDetails->created_at->toDateString() }}</li>
                                                </ul>
                                            </div>
                                            <!-- Buttons -->
                                            <div class="buttons-to-right">
                                                <a href="{{ route('manage.job',encrypt($applied->job_id)) }}"
                                                   class="button">{{ __('View Details') }}</a>
                                            </div>
                                        </li>
                                        @php
                                            if ($i++ > 4) break;
                                        @endphp
                                    @endforeach
                                </ul>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        @if(count($completedJobs) > 4)
                                            <a href="{{ route('completed.jobs') }}"
                                               class="button mt-2" style="padding: 3px 10px;font-size: 14px;">{{ __('View More') }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Row / End -->
                <!-- Row -->
                <div class="row">

                    <!-- Dashboard Box -->
                    <div class="col-xl-6">
                        <div class="dashboard-box">
                            <div class="headline">
                                <h3><i class="icon-material-baseline-notifications-none"></i> Notifications</h3>
                                <button class="mark-as-read ripple-effect-dark" data-tippy-placement="left"
                                        title="Mark all as read">
                                    <i class="icon-feather-check-square"></i>
                                </button>
                            </div>
                            <div class="content">
                                <ul class="dashboard-box-list">
                                    <li>
                                        <span class="notification-icon"><i
                                                class="icon-material-outline-group"></i></span>
                                        <span class="notification-text">
										<strong>Michael Shannah</strong> applied for a job <a href="#">Full Stack Software Engineer</a>
									</span>
                                        <!-- Buttons -->
                                        <div class="buttons-to-right">
                                            <a href="#" class="button ripple-effect ico" title="Mark as read"
                                               data-tippy-placement="left"><i class="icon-feather-check-square"></i></a>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="notification-icon"><i
                                                class=" icon-material-outline-gavel"></i></span>
                                        <span class="notification-text">
										<strong>Gilber Allanis</strong> placed a bid on your <a href="#">iOS App Development</a> project
									</span>
                                        <!-- Buttons -->
                                        <div class="buttons-to-right">
                                            <a href="#" class="button ripple-effect ico" title="Mark as read"
                                               data-tippy-placement="left"><i class="icon-feather-check-square"></i></a>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="notification-icon"><i class="icon-material-outline-autorenew"></i></span>
                                        <span class="notification-text">
										Your job listing <a href="#">Full Stack Software Engineer</a> is expiring
									</span>
                                        <!-- Buttons -->
                                        <div class="buttons-to-right">
                                            <a href="#" class="button ripple-effect ico" title="Mark as read"
                                               data-tippy-placement="left"><i class="icon-feather-check-square"></i></a>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="notification-icon"><i
                                                class="icon-material-outline-group"></i></span>
                                        <span class="notification-text">
										<strong>Sindy Forrest</strong> applied for a job <a href="#">Full Stack Software Engineer</a>
									</span>
                                        <!-- Buttons -->
                                        <div class="buttons-to-right">
                                            <a href="#" class="button ripple-effect ico" title="Mark as read"
                                               data-tippy-placement="left"><i class="icon-feather-check-square"></i></a>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="notification-icon"><i
                                                class="icon-material-outline-rate-review"></i></span>
                                        <span class="notification-text">
										<strong>David Peterson</strong> left you a <span class="star-rating no-stars"
                                                                                         data-rating="5.0"></span> rating after finishing <a
                                                href="#">Logo Design</a> task
									</span>
                                        <!-- Buttons -->
                                        <div class="buttons-to-right">
                                            <a href="#" class="button ripple-effect ico" title="Mark as read"
                                               data-tippy-placement="left"><i class="icon-feather-check-square"></i></a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Dashboard Box -->
                    <div class="col-xl-6">
                        <div class="dashboard-box">
                            <div class="headline">
                                <h3><i class="icon-material-outline-assignment"></i> Latest Jobs</h3>
                            </div>
                            <div class="content">
                                <ul class="dashboard-box-list">
                                    @foreach($jobs as $job)
                                        <li>
                                            <div class="invoice-list-item">
                                                <strong>{{ $job->title }}</strong>
                                                <ul>
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
                                            <!-- Buttons -->
                                            <div class="buttons-to-right">
                                                <a href="{{ route('job.details',encrypt($job->id)) }}" class="button">Apply
                                                    Job</a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Row / End -->

                <!-- Footer -->
                <div class="dashboard-footer-spacer"></div>
                <!-- Footer / End -->

            </div>
        </div>
        <!-- Dashboard Content / End -->

    </div>
    <!-- Dashboard Container / End -->
@endsection
@section('script')
    <script src="{{ asset('public/assets/frontend') }}/js/chart.min.js"></script>
    <script>
        Chart.defaults.global.defaultFontFamily = "Nunito";
        Chart.defaults.global.defaultFontColor = '#888';
        Chart.defaults.global.defaultFontSize = '14';

        var ctx = document.getElementById('chart').getContext('2d');

        var chart = new Chart(ctx, {
            type: 'line',

            // The data for our dataset
            data: {
                labels: ["January", "February", "March", "April", "May", "June"],
                // Information about the dataset
                datasets: [{
                    label: "Views",
                    backgroundColor: 'rgba(42,65,232,0.08)',
                    borderColor: '#2a41e8',
                    borderWidth: "3",
                    data: [196, 132, 215, 362, 210, 252],
                    pointRadius: 5,
                    pointHoverRadius: 5,
                    pointHitRadius: 10,
                    pointBackgroundColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointBorderWidth: "2",
                }]
            },

            // Configuration options
            options: {

                layout: {
                    padding: 10,
                },

                legend: {display: false},
                title: {display: false},

                scales: {
                    yAxes: [{
                        scaleLabel: {
                            display: false
                        },
                        gridLines: {
                            borderDash: [6, 10],
                            color: "#d8d8d8",
                            lineWidth: 1,
                        },
                    }],
                    xAxes: [{
                        scaleLabel: {display: false},
                        gridLines: {display: false},
                    }],
                },

                tooltips: {
                    backgroundColor: '#333',
                    titleFontSize: 13,
                    titleFontColor: '#fff',
                    bodyFontColor: '#fff',
                    bodyFontSize: 13,
                    displayColors: false,
                    xPadding: 10,
                    yPadding: 10,
                    intersect: false
                }
            },


        });

    </script>
@endsection
