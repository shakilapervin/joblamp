@extends('frontend.layouts.master')
@section('title')
    {{ __('Login') }}
@endsection

@section('content')
    <!-- Titlebar
    ================================================== -->
    <div id="titlebar" class="gradient">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <h2>{{ __('Log In') }}</h2>

                    <!-- Breadcrumbs -->
                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li><a href="#">{{ __('Home') }}</a></li>
                            <li>{{ __('Log In') }}</li>
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
                <div class="login-register-page">
                    <!-- Welcome Text -->
                    <div class="welcome-text">
                        <h3>{{ __("We're glad to see you again!") }}</h3>
                        <span>{{ __("Don't have an account?") }} <a
                                href="{{ route('user-register') }}">{{ __('Sign Up') }}!</a></span>
                    </div>

                    <!-- Form -->
                    <form method="post" action="{{route('check-login')}}">
                        @csrf
                        <div class="input-with-icon-left">
                            <i class="icon-material-baseline-mail-outline"></i>
                            <input type="text" class="input-text with-border" name="email" id="emailaddress"
                                   placeholder="Email Address" required/>
                        </div>

                        <div class="input-with-icon-left">
                            <i class="icon-material-outline-lock"></i>
                            <input type="password" class="input-text with-border" name="password" id="password"
                                   placeholder="Password" required/>
                        </div>
                        <a href="#" class="forgot-password">Forgot Password?</a>
                        <!-- Button -->
                        <button class="button full-width button-sliding-icon ripple-effect margin-top-10" type="submit">
                            {{ __('Log In') }}
                            <i class="icon-material-outline-arrow-right-alt"></i>
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
