@extends('admin.layouts.master')
@section('title')
    {{ __('Edit Customer') }}
@endsection
@section('style')
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
                <li class="breadcrumb-item">{{ __('Edit Customer') }}</li>
            </ol>
            <!-- Breadcrumb end -->

            <!-- App actions start -->
            <div class="app-actions">
                <a href="{{ route('admin.customers') }}" class="btn active">{{ __('All Customers') }}</a>
            </div>
            <!-- App actions end -->

        </div>
        <!-- Page header end -->

        <!-- Row start -->
        <div class="row gutters">
            <form class="col-md-12" action="{{ route('admin.update.customer') }}" method="post"
                  enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $customer->id }}">
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
                        <div class="card-title">{{ __('Customer Information') }}</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="colFormLabelSm"
                                       class="col-sm-12 col-form-label">{{ __('First Name') }}</label>
                                <div class="col-sm-12">
                                    <input type="text"
                                           class="form-control form-control @error('first_name') is-invalid @enderror"
                                           id="colFormLabelSm" placeholder="{{ __('First Name') }}" name="first_name"
                                           required
                                           value="{{ $customer->first_name }}">
                                    @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="colFormLabelSm"
                                       class="col-sm-12 col-form-label">{{ __('Last Name') }}</label>
                                <div class="col-sm-12">
                                    <input type="text"
                                           class="form-control form-control @error('last_name') is-invalid @enderror"
                                           id="colFormLabelSm" placeholder="{{ __('Last Name') }}" name="last_name"
                                           required
                                           value="{{ $customer->last_name }}">
                                    @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="colFormLabelSm"
                                       class="col-sm-12 col-form-label">{{ __('Email') }}</label>
                                <div class="col-sm-12">
                                    <input type="text"
                                           class="form-control form-control @error('email') is-invalid @enderror"
                                           id="colFormLabelSm" placeholder="{{ __('Email') }}" name="email" required
                                           value="{{ $customer->email }}">
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="colFormLabelSm"
                                       class="col-sm-12 col-form-label">{{ __('Mobile Number') }}</label>
                                <div class="col-sm-12">
                                    <input type="text"
                                           class="form-control form-control @error('mobile_number') is-invalid @enderror"
                                           id="colFormLabelSm" placeholder="{{ __('Mobile Number') }}"
                                           name="mobile_number" required
                                           value="{{ $customer->mobile_number }}">
                                    @error('mobile_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="colFormLabelSm"
                                       class="col-sm-12 col-form-label">{{ __('Address Line 1') }}</label>
                                <div class="col-sm-12">
                                    <input type="text"
                                           class="form-control form-control @error('address_line_1') is-invalid @enderror"
                                           id="colFormLabelSm" placeholder="{{ __('Address Line 1') }}"
                                           name="address_line_1" required
                                           value="{{ $customer->address_line_1 }}">
                                    @error('address_line_1')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="colFormLabelSm"
                                       class="col-sm-12 col-form-label">{{ __('Address Line 2') }}</label>
                                <div class="col-sm-12">
                                    <input type="text"
                                           class="form-control form-control @error('address_line_2') is-invalid @enderror"
                                           id="colFormLabelSm" placeholder="{{ __('Address Line 2') }}"
                                           name="address_line_2"
                                           value="{{ $customer->address_line_2 }}">
                                    @error('address_line_2')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="form-group row">
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
                                                    @if($country->id == $customer->country) selected @endif>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 state">
                                <label for="colFormLabelSm"
                                       class="col-sm-12 col-form-label">{{ __('States') }}</label>
                                <div class="col-sm-12">
                                    <select id="state" name="state"
                                            class="form-control @error('state') is-invalid @enderror select2" required>
                                        <option value="">{{ __('Select State') }}</option>
                                        @foreach($states as $state)
                                            <option value="{{ $state->id }}"
                                                    @if($state->id == $customer->state) selected @endif>{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 city">
                                <label for="colFormLabelSm"
                                       class="col-sm-12 col-form-label">{{ __('City') }}</label>
                                <div class="col-sm-12">
                                    <select id="city" name="city"
                                            class="form-control @error('city') is-invalid @enderror select2" required>
                                        <option value="">{{ __('Select City') }}</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}"
                                                    @if($city->id == $customer->city) selected @endif>{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="colFormLabelSm"
                                       class="col-sm-12 col-form-label">{{ __('Pincode') }}</label>
                                <div class="col-sm-12">
                                    <input type="text"
                                           class="form-control form-control @error('pincode') is-invalid @enderror"
                                           id="colFormLabelSm" placeholder="{{ __('Pincode') }}" name="pincode" required
                                           value="{{ $customer->pincode }}">
                                    @error('pincode')
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
                                                @if($customer->status == 1) selected @endif>{{ __('Active') }}</option>
                                        <option value="0"
                                                @if($customer->status == 0) selected @endif>{{ __('Inactive') }}</option>
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
    <script>
        $(document).ready(function () {
            $('.select2').select2();
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
