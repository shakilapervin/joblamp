@extends('frontend.layouts.master')
@section('title')
    {{ __('Registration') }}
@endsection

@section('content')
    <!-- Titlebar
    ================================================== -->
    <div id="titlebar" class="gradient">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <h2>{{ __('Register') }}</h2>

                    <!-- Breadcrumbs -->
                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li><a href="{{ url('') }}">{{ __('Home') }}</a></li>
                            <li>{{ __('Register') }}</li>
                        </ul>
                    </nav>

                </div>
            </div>
        </div>
    </div>

    <!-- Page Content
    ================================================== -->
    <div class="container">
        <div class="row">
            <div class="col-xl-5 offset-xl-3">

                <div class="login-register-page">
                    <!-- Welcome Text -->
                    <div class="welcome-text">
                        <h3 style="font-size: 26px;">
                            {{ __('Let\'s create your account!') }}
                        </h3>
                        <span>
                            {{ __('Already have an account?') }}
                            <a href="{{ route('user-login') }}">{{ __('Log In!') }}</a>
                        </span>
                    </div>

                    <!-- Form -->
                    <form method="post" action="{{ route('save-register') }}">
                    @csrf
                    <!-- Account Type -->
                        <div class="account-type">
                            <div>
                                <input type="radio" name="user_type" id="freelancer-radio"
                                       class="account-type-radio" value="customer" checked/>
                                <label for="freelancer-radio" class="ripple-effect-dark"><i
                                        class="icon-material-outline-account-circle"></i> {{ __('Task Giver') }}</label>
                            </div>

                            <div>
                                <input type="radio" name="user_type" id="employer-radio"
                                       class="account-type-radio" value="service_provider"/>
                                <label for="employer-radio" class="ripple-effect-dark"><i
                                        class="icon-material-outline-business-center"></i> {{ __('Task Worker') }}
                                </label>
                            </div>
                        </div>
                        <div class="input-with-icon-left">
                            <i class="icon-line-awesome-user"></i>
                            <input type="text" class="input-text with-border @error('first_name') is-invalid @enderror"
                                   name="first_name" placeholder="{{ __('First Name') }}" required
                                   value="{{ old('first_name') }}"/>
                            @error('first_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="input-with-icon-left">
                            <i class="icon-line-awesome-user"></i>
                            <input type="text" class="input-text with-border @error('last_name') is-invalid @enderror"
                                   name="last_name" placeholder="{{ __('Last Name') }}" required
                                   value="{{ old('last_name') }}"/>
                            @error('last_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="input-with-icon-left">
                            <i class="icon-material-baseline-mail-outline"></i>
                            <input type="text" class="input-text with-border @error('email') is-invalid @enderror"
                                   name="email" placeholder="{{ __('Email Address') }}" required
                                   value="{{ old('email') }}"/>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="input-with-icon-left">
                            <i class="icon-line-awesome-phone"></i>
                            <input type="text"
                                   class="input-text with-border @error('mobile_number') is-invalid @enderror"
                                   name="mobile_number" placeholder="{{ __('Mobile Number') }}" required
                                   value="{{ old('mobile_number') }}"/>
                            @error('mobile_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="input-with-icon-left" style="margin-bottom: 16px;">
                            <select id="country"
                                    class="selectpicker with-border @error('country') is-invalid @enderror"
                                    data-size="7" title="Select Country" data-live-search="true"
                                    name="country" onchange="getStates();">
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-with-icon-left state" style="margin-bottom: 16px;">
                            <select
                                class="selectpicker with-border @error('state') is-invalid @enderror"
                                data-size="7" title="Select State"
                                data-live-search="true" name="state" onchange="getCities()" id="state">
                                @foreach($states as $state)
                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-with-icon-left city" style="margin-bottom: 16px;">
                            <select id="city"
                                    class="selectpicker with-border @error('city') is-invalid @enderror"
                                    data-size="7" title="Select City" data-live-search="true"
                                    name="city">
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-with-icon-left">
                            <i class="icon-material-outline-lock"></i>
                            <input type="password" class="input-text with-border" name="password"
                                   id="password-register" placeholder="{{ __('Password') }}" required/>
                        </div>
                        <!-- Button -->
                        <button class="button full-width button-sliding-icon ripple-effect margin-top-10" type="submit">
                            {{ __('Register') }} <i class="icon-material-outline-arrow-right-alt"></i>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <!-- Spacer -->
    <div class="margin-top-70"></div>
    <!-- Spacer / End-->
@endsection

@section('script')
    <script>
        function getStates() {
            var country = $('select#country').val();
            $.ajax({
                type: "POST",
                url: '{{ route('get.states') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    country: country,
                    for: 'signup',
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
                    for: 'signup'
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
