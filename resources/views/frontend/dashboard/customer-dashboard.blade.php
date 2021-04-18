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
                    <h3>{{ __('Howdy') }}, {{ $user->first_name }}!</h3>
                    <span>{{ __('We are glad to see you again!') }}</span>

                    <!-- Breadcrumbs -->
                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
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
                            <span>{{ __('Job Posted') }}</span>
                            <h4>{{ $totalJob }}</h4>
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
                </div>

                <!-- Row -->
                <div class="row">
                    <div class="col-xl-3">
                        <div class="dashboard-box">
                            <div class="headline bg-primary">
                                <h3 class="text-white">
                                    <i class="icon-line-awesome-book text-white"></i>
                                    {{ __('Posted Jobs') }}
                                </h3>
                            </div>
                            <div class="content">
                                <ul class="dashboard-box-list">
                                    @foreach($notHiredJobs as $myJob)
                                        <li>
                                            <div class="invoice-list-item">
                                                <strong>{{ $myJob->title }}</strong>
                                                <ul>
                                                    <li>{{ __('Fee Range') }}:
                                                        ${{ $myJob->fee_range_min }} {{ $myJob->fee_range_max }}</li>
                                                    <li>{{ __('Posted On') }}
                                                        : {{ $myJob->created_at->toDateString() }}</li>
                                                </ul>
                                            </div>
                                            <!-- Buttons -->
                                            <div class="buttons-to-right">
                                                <a href="{{ route('job.applications',encrypt($myJob->id)) }}"
                                                   class="button">{{ __('View Application') }}</a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3">
                        <div class="dashboard-box">
                            <div class="headline bg-warning">
                                <h3 class="text-white">
                                    <i class="icon-line-awesome-user-plus text-white"></i>
                                    {{ __('Hired Jobs') }}
                                </h3>
                            </div>
                            <div class="content">
                                <ul class="dashboard-box-list">
                                    @foreach($hiredJobs as $myJob)
                                        <li>
                                            <div class="invoice-list-item">
                                                <strong>{{ $myJob->title }}</strong>
                                                <ul>
                                                    <li>{{ __('Fee Range') }}:
                                                        ${{ $myJob->fee_range_min }} {{ $myJob->fee_range_max }}</li>
                                                    <li>{{ __('Posted On') }}
                                                        : {{ $myJob->created_at->toDateString() }}</li>
                                                </ul>
                                            </div>
                                            <!-- Buttons -->
                                            <div class="buttons-to-right">
                                                <a href="{{ route('manage.my.job',encrypt($myJob->id)) }}"
                                                   class="button">{{ __('View Job') }}</a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3">
                        <div class="dashboard-box">
                            <div class="headline bg-danger">
                                <h3 class="text-white">
                                    <i class="icon-line-awesome-user-secret text-white"></i>
                                    {{ __('Delivered Jobs') }}
                                </h3>
                            </div>
                            <div class="content">
                                <ul class="dashboard-box-list">
                                    @foreach($deliveredJobs as $myJob)
                                        <li>
                                            <div class="invoice-list-item">
                                                <strong>{{ $myJob->title }}</strong>
                                                <ul>
                                                    <li>{{ __('Fee Range') }}:
                                                        ${{ $myJob->fee_range_min }} {{ $myJob->fee_range_max }}</li>
                                                    <li>{{ __('Posted On') }}
                                                        : {{ $myJob->created_at->toDateString() }}</li>
                                                </ul>
                                            </div>
                                            <!-- Buttons -->
                                            <div class="buttons-to-right">
                                                <a href="{{ route('manage.my.job',encrypt($myJob->id)) }}"
                                                   class="button">{{ __('View Job') }}</a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3">
                        <div class="dashboard-box">
                            <div class="headline bg-success">
                                <h3 class="text-white">
                                    <i class="icon-line-awesome-check text-white"></i>
                                    {{ __('Completed Jobs') }}
                                </h3>
                            </div>
                            <div class="content">
                                <ul class="dashboard-box-list">
                                    @foreach($completedJobs as $myJob)
                                        <li>
                                            <div class="invoice-list-item">
                                                <strong>{{ $myJob->title }}</strong>
                                                <ul>
                                                    <li>{{ __('Fee Range') }}:
                                                        ${{ $myJob->fee_range_min }} {{ $myJob->fee_range_max }}</li>
                                                    <li>{{ __('Posted On') }}
                                                        : {{ $myJob->created_at->toDateString() }}</li>
                                                </ul>
                                            </div>
                                            <!-- Buttons -->
                                            <div class="buttons-to-right">
                                                <a href="{{ route('manage.my.job',encrypt($myJob->id)) }}"
                                                   class="button">{{ __('View Job') }}</a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Row / End -->

                <!-- Row -->
                <div class="row">

                    <!-- Dashboard Box -->
                    <div class="col-xl-12">
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

                </div>
                <!-- Row / End -->

            </div>
        </div>
        <!-- Dashboard Content / End -->

    </div>
    <!-- Dashboard Container / End -->
    <!-- Apply for a job popup
================================================== -->
    <div id="small-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs">

        <!--Tabs -->
        <div class="sign-in-form">

            <ul class="popup-tabs-nav">
                <li><a href="#tab">Add Note</a></li>
            </ul>

            <div class="popup-tabs-container">

                <!-- Tab -->
                <div class="popup-tab-content" id="tab">

                    <!-- Welcome Text -->
                    <div class="welcome-text">
                        <h3>Do Not Forget 😎</h3>
                    </div>

                    <!-- Form -->
                    <form method="post" id="add-note">

                        <select class="selectpicker with-border default margin-bottom-20" data-size="7"
                                title="Priority">
                            <option>Low Priority</option>
                            <option>Medium Priority</option>
                            <option>High Priority</option>
                        </select>

                        <textarea name="textarea" cols="10" placeholder="Note" class="with-border"></textarea>

                    </form>

                    <!-- Button -->
                    <button class="button full-width button-sliding-icon ripple-effect" type="submit" form="add-note">
                        Add
                        Note <i class="icon-material-outline-arrow-right-alt"></i></button>

                </div>

            </div>
        </div>
    </div>
    <!-- Apply for a job popup / End -->
@endsection
@section('script')
    <!-- Chart.js // documentation: http://www.chartjs.org/docs/latest/ -->
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
