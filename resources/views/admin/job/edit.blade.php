@extends('admin.layouts.master')
@section('title')
    {{ __('Edit Job') }}
@endsection
@section('style')
    <!-- Datepicker css -->
    <link rel="stylesheet" href="{{ admin_asset('') }}/vendor/datepicker/css/classic.css"/>
    <link rel="stylesheet" href="{{ admin_asset('') }}/vendor/datepicker/css/classic.date.css"/>
    <link rel="stylesheet" href="{{ admin_asset('/vendor/select2/dist/css/select2.min.css') }}">
    <style>
        .select2-results__options {
            color: #1A233A;
        }

        body .select2-container--default .select2-selection--multiple .select2-selection__choice {
            border-color: #2c3036;
        }

        body .select2-container--default .select2-results__option[aria-selected="true"]:hover, body .select2-container--default .select2-selection--multiple .select2-selection__choice, body .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #2c3036;
            color: #fff;
        }
    </style>
@endsection
@section('content')
    <!-- Main container start -->
    <div class="main-container">

        <!-- Page header start -->
        <div class="page-header">
            <!-- Breadcrumb start -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">{{ __('Edit Job') }}</li>
            </ol>
            <!-- Breadcrumb end -->

            <!-- App actions start -->
            <div class="app-actions">
                <a href="{{ route('admin.jobs') }}" class="btn active">{{ __('All Jobs') }}</a>
            </div>
            <!-- App actions end -->

        </div>
        <!-- Page header end -->

        <!-- Row start -->
        <div class="row gutters">
            <form class="col-md-12" action="{{ route('admin.update.job') }}" method="post"
                  enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $job->id }}">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            @if (Session::has('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert"
                                     style="width: 100%;">
                                    {{ Session::get('error') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            @endif
                            @if (Session::has('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert"
                                     style="width: 100%;">
                                    {{ Session::get('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <div class="card-title">{{ __('Job Details') }}</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="colFormLabelSm"
                                       class="col-sm-12 col-form-label">{{ __('Job Title') }}</label>
                                <div class="col-sm-12">
                                    <input type="text"
                                           class="form-control form-control @error('title') is-invalid @enderror"
                                           id="colFormLabelSm" placeholder="{{ __('Job Title') }}" name="title" required
                                           value="{{ $job->title }}">
                                    @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="colFormLabelSm"
                                       class="col-sm-12 col-form-label">{{ __('Job Category') }}</label>
                                <div class="col-sm-12">
                                    <select id="category" name="category"
                                            class="form-control @error('category') is-invalid @enderror select2"
                                            required>
                                        <option value="">{{ __('Select Job Category') }}</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                    @if($category->id == $job->category) selected @endif>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="colFormLabelSm"
                                       class="col-sm-12 col-form-label">{{ __('Start Date') }}</label>
                                <div class="col-sm-12">
                                    <input type="text"
                                           class="form-control startdate form-control @error('start_date') is-invalid @enderror"
                                           id="colFormLabelSm" placeholder="{{ __('Start Date') }}" name="start_date"
                                           required
                                           value="{{ $job->start_date }}">
                                    @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="colFormLabelSm"
                                       class="col-sm-12 col-form-label">{{ __('End Date') }}</label>
                                <div class="col-sm-12">
                                    <input type="text"
                                           class="form-control enddate form-control @error('end_date') is-invalid @enderror"
                                           id="colFormLabelSm" placeholder="{{ __('Start Date') }}" name="end_date"
                                           required
                                           value="{{ $job->end_date }}">
                                    @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="colFormLabelSm"
                                       class="col-sm-12 col-form-label">{{ __('Address') }}</label>
                                <div class="col-sm-12">
                                    <input type="text"
                                           class="form-control form-control @error('address') is-invalid @enderror"
                                           id="colFormLabelSm" placeholder="{{ __('Address') }}" name="address" required
                                           value="{{ $job->address }}">
                                    @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="colFormLabelSm"
                                       class="col-sm-12 col-form-label">{{ __('Country') }}</label>
                                <div class="col-sm-12">
                                    <select name="country"
                                            class="form-control @error('country') is-invalid @enderror select2" required
                                            onchange="getStates();" id="country">
                                        <option value="">{{ __('Select Country') }}</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}"
                                                    @if($country->id == $job->country) selected @endif>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 state">
                                <label for="colFormLabelSm"
                                       class="col-sm-12 col-form-label">{{ __('States') }}</label>
                                <div class="col-sm-12">
                                    <select id="state" name="state"
                                            class="form-control @error('state') is-invalid @enderror select2" required>
                                        <option value="">{{ __('Select State') }}</option>
                                        @foreach($states as $state)
                                            <option value="{{ $state->id }}"
                                                    @if($state->id == $job->state) selected @endif>{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 city">
                                <label for="colFormLabelSm"
                                       class="col-sm-12 col-form-label">{{ __('City') }}</label>
                                <div class="col-sm-12">
                                    <select id="city" name="city"
                                            class="form-control @error('city') is-invalid @enderror select2" required>
                                        <option value="">{{ __('Select City') }}</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}"
                                                    @if($city->id == $job->city) selected @endif>{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="colFormLabelSm"
                                       class="col-sm-12 col-form-label">{{ __('Pincode') }}</label>
                                <div class="col-sm-12">
                                    <input type="text"
                                           class="form-control form-control @error('pincode') is-invalid @enderror"
                                           id="colFormLabelSm" placeholder="{{ __('Pincode') }}" name="pincode" required
                                           value="{{ $job->pincode }}">
                                    @error('pincode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="colFormLabelSm"
                                       class="col-sm-12 col-form-label">{{ __('Service Provider Rating') }}</label>
                                <div class="col-sm-12">
                                    <select name="service_provider_rating" id="service_provider_rating"
                                            class="form-control" required>
                                        <option value="1"
                                                @if($job->service_provider_rating == 1) selected @endif>{{ __('1 Star') }}</option>
                                        <option value="2"
                                                @if($job->service_provider_rating == 2) selected @endif>{{ __('2 Star') }}</option>
                                        <option value="3"
                                                @if($job->service_provider_rating == 3) selected @endif>{{ __('3 Star') }}</option>
                                        <option value="4"
                                                @if($job->service_provider_rating == 4) selected @endif>{{ __('4 Star') }}</option>
                                        <option value="5"
                                                @if($job->service_provider_rating == 5) selected @endif>{{ __('5 Star') }}</option>
                                    </select>
                                    @error('service_provider_rating')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="colFormLabelSm"
                                       class="col-sm-12 col-form-label">{{ __('Free Range Min') }}</label>
                                <div class="col-sm-12">
                                    <input type="text"
                                           class="form-control form-control @error('fee_range_min') is-invalid @enderror"
                                           id="colFormLabelSm" placeholder="{{ __('Free Range Min') }}" name="fee_range_min" required
                                           value="{{ $job->fee_range_min }}">
                                    @error('fee_range_min')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="colFormLabelSm"
                                       class="col-sm-12 col-form-label">{{ __('Free Range Max') }}</label>
                                <div class="col-sm-12">
                                    <input type="text"
                                           class="form-control form-control @error('fee_range_max') is-invalid @enderror"
                                           id="colFormLabelSm" placeholder="{{ __('Free Range Max') }}" name="fee_range_max" required
                                           value="{{ $job->fee_range_max }}">
                                    @error('fee_range_max')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="colFormLabelSm"
                                       class="col-sm-12 col-form-label">{{ __('Status') }}</label>
                                <div class="col-sm-12">
                                    <select name="status" id="status" class="form-control">
                                        <option value="1"
                                                @if($job->status == 1) selected @endif>{{ __('Active') }}</option>
                                        <option value="0"
                                                @if($job->status == 0) selected @endif>{{ __('Inactive') }}</option>
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary my-1 btn-lg">{{ __('Update') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- Row end -->

    </div>
@endsection
@section('script')
    <script src="{{ admin_asset('/vendor/select2/dist/js/select2.min.js') }}"></script>
    <!-- Datepickers -->
    <script src="{{ admin_asset('') }}/vendor/datepicker/js/picker.js"></script>
    <script src="{{ admin_asset('') }}/vendor/datepicker/js/picker.date.js"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2();
            $('.startdate').pickadate({
                format: 'yyyy-mm-dd',
            })
            $('.enddate').pickadate({
                format: 'yyyy-mmm-dddd',
            })
        });
    </script>
    <script>
        function getStates() {
            var country = $('select#country').val();
            $.ajax({
                type: "POST",
                url: '{{ route('admin.get.states') }}',
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
                url: '{{ route('admin.get.cities') }}',
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
