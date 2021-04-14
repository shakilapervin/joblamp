@extends('frontend.layouts.master')
@section('title')
    {{ __('Post a Job') }}
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('public/assets/frontend') }}/vendor/jquery-ui/jquery-ui.min.css">
    <link rel="stylesheet" href="{{ asset('public/assets/frontend') }}/vendor/rating/dist/star-rating.min.css">
@endsection
@section('content')
    <!-- Dashboard Container -->
    <div class="dashboard-container">
        <!-- Dashboard Content
        ================================================== -->
        <div class="dashboard-content-container" data-simplebar>
            <div class="dashboard-content-inner">

                <!-- Dashboard Headline -->
                <div class="dashboard-headline">
                    <h3>Post a Job</h3>

                    <!-- Breadcrumbs -->
                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li><a href="{{ url('') }}">{{ __('Home') }}</a></li>
                            <li>{{ __('Post a Job') }}</li>
                        </ul>
                    </nav>
                </div>
                <!-- Row -->
                <div class="row">
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
                    <form action="{{ route('save-job') }}" method="post">
                        @csrf
                        <!-- Dashboard Box -->
                        <div class="col-xl-12">
                            <div class="dashboard-box margin-top-0">

                                <!-- Headline -->
                                <div class="headline">
                                    <h3><i class="icon-feather-folder-plus"></i> {{ __('Job Details') }}</h3>
                                </div>

                                <div class="content with-padding padding-bottom-10">
                                    <div class="row">

                                        <div class="col-xl-6">
                                            <div class="submit-field">
                                                <h5>{{ __('Job Title') }}</h5>
                                                <input type="text"
                                                       class="with-border @error('title') is-invalid @enderror"
                                                       name="title" required>
                                                @error('title')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="submit-field">
                                                <h5>{{ __('Job Category') }}</h5>
                                                <select class="selectpicker with-border @error('category') is-invalid @enderror" data-size="7"
                                                        title="{{ __('Select Job Category') }}
                                                            " required name="category">
                                                    <option>{{ __('Select Job Category') }}</option>
                                                    @foreach($jobCategories as $jobCategory)
                                                        <option value="{{ $jobCategory->id }}">
                                                            {{ $jobCategory->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('category')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="submit-field">
                                                <h5>{{ __('Start Date') }}</h5>
                                                <input type="text"
                                                       class="with-border startdate @error('start_date') is-invalid @enderror"
                                                       name="start_date" required>
                                                @error('start_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="submit-field">
                                                <h5>{{ __('End Date') }}</h5>
                                                <input type="text"
                                                       class="with-border enddate @error('end_date') is-invalid @enderror"
                                                       name="end_date" required>
                                                @error('end_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="submit-field">
                                                <h5>{{ __('Fee Range') }}</h5>
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <div class="input-with-icon">
                                                            <input class="with-border @error('fee_range_min') is-invalid @enderror" type="text" name="fee_range_min" required placeholder="{{ __('Min') }}">
                                                            <i class="currency">USD</i>
                                                        </div>
                                                        @error('fee_range_min')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="input-with-icon">
                                                            <input class="with-border @error('fee_range_max') is-invalid @enderror" type="text" name="fee_range_max" required placeholder="{{ __('Max') }}">
                                                            <i class="currency">USD</i>
                                                        </div>
                                                        @error('fee_range_max')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="submit-field">
                                                <h5 style="margin-bottom: 20px;">{{ __('Service Provider Rating') }}</h5>
                                                <select class="star-rating @error('service_provider_rating') is-invalid @enderror" required name="service_provider_rating">
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

                                        <div class="col-xl-6">
                                            <div class="submit-field">
                                                <h5>{{ __('Address') }}</h5>
                                                <input type="text"
                                                       class="with-border @error('address') is-invalid @enderror"
                                                       name="address" required>
                                                @error('address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="submit-field">
                                                <h5>{{ __('Country') }}</h5>
                                                <select id="country"
                                                        class="selectpicker with-border @error('country') is-invalid @enderror"
                                                        data-size="7" title="Select Country" data-live-search="true"
                                                        name="country" onchange="getStates();" required>
                                                    @foreach($countries as $country)
                                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 state">
                                            <div class="submit-field">
                                                <h5>{{ __('State') }}</h5>
                                                <select
                                                    class="selectpicker with-border @error('state') is-invalid @enderror"
                                                    data-size="7" title="Select State"
                                                    data-live-search="true" name="state" onchange="getCities()" required>
                                                    @foreach($states as $state)
                                                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 city">
                                            <div class="submit-field">
                                                <h5>{{ __('City') }}</h5>
                                                <select id="city"
                                                        class="selectpicker with-border @error('city') is-invalid @enderror"
                                                        data-size="7" title="Select City" data-live-search="true"
                                                        name="city" required>
                                                    @foreach($cities as $city)
                                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-4">
                                            <div class="submit-field">
                                                <h5>{{ __('Pincode') }}</h5>
                                                <input type="text"
                                                       class="with-border @error('pincode') is-invalid @enderror"
                                                       name="pincode" required>
                                                @error('pincode')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <div class="submit-field">
                                                <h5>{{ __('Job Description') }}</h5>
                                                <textarea cols="30" rows="5" class="with-border" name="description" required></textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <button class="button ripple-effect big margin-top-30" type="submit">
                                <i class="icon-feather-plus"></i>
                                {{ __('Post a Job') }}
                            </button>
                        </div>
                    </form>
                </div>
                <!-- Row / End -->
                <div class="dashboard-footer-spacer"></div>

            </div>
        </div>
        <!-- Dashboard Content / End -->

    </div>
    <!-- Dashboard Container / End -->
@endsection
@section('script')
    <script src="{{ asset('public/assets/frontend') }}/vendor/jquery-ui/jquery-ui.min.js"></script>
    <script src="{{ asset('public/assets/frontend') }}/vendor/rating/dist/star-rating.min.js"></script>
    <script>
        $( function() {
            $( ".startdate" ).datepicker({
                dateFormat : 'yy-mm-dd',
                minDate:0,
                onSelect: function(selected) {
                    $(".enddate").datepicker("option","minDate", selected)
                }
            });
            $( ".enddate" ).datepicker({
                dateFormat : 'yy-mm-dd',
                minDate:0,
                onSelect: function(selected) {
                    $(".startdate").datepicker("option","maxDate", selected)
                }
            });
        } );
    </script>
    <script>
        var starratings = new StarRating('.star-rating', {
            onClick: function (el) {
                console.log('Selected: ' + el[el.selectedIndex].text);
            },
        });
    </script>
    <script>
        function getStates() {
            var country = $('select#country').val();
            $.ajax({
                type: "POST",
                url: '{{ route('get.states') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    country: country
                },
                success: function (data) {
                    console.log(data);
                    $('.state').html(null);
                    $('.state').html(data);
                    getCities();
                }
            });
        }

        function getCities() {
            var state = $('select#state').val();
            var country = $('select#country').val();
            $.ajax({
                type: "POST",
                url: '{{ route('get.cities') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    state: state,
                    country: country,
                },
                success: function (data) {
                    console.log(data);
                    $('.city').html(null);
                    $('.city').html(data);
                }
            });
        }

    </script>
@endsection
