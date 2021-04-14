<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="Responsive Bootstrap4 Dashboard Template">
    <meta name="author" content="ParkerThemes">
    <link rel="shortcut icon" href="{{ admin_asset('') }}/img/fav.png"/>

    <!-- Title -->
    <title>{{ __('JobLamp Admin Login') }}</title>

    <!-- *************
        ************ Common Css Files *************
    ************ -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ admin_asset('') }}/css/bootstrap.min.css"/>

    <!-- Master CSS -->
    <link rel="stylesheet" href="{{ admin_asset('') }}/css/main.css"/>

</head>

<body class="authentication">

<!-- Container start -->
<div class="container">

    <form action="{{ route('admin.check.login') }}" method="post">
        @csrf
        <div class="row justify-content-md-center">
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
                <div class="login-screen">
                    <div class="login-box">
                        <a href="{{ route('home') }}" class="login-logo">
                            JobLamp
                        </a>
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
                        <h5>{{ __('Welcome back') }},<br/>{{ __('Please Login to your Account.') }}</h5>
                        <div class="form-group @error('email') is-invalid @enderror">
                            <input type="text" class="form-control" placeholder="{{ __('Email Address') }}" name="email"/>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('Password') }}" name="password"/>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="actions mb-4">
                            <button type="submit" class="btn btn-success btn-block ml-0">{{ __('Login') }}</button>
                        </div>
                        <div class="forgot-pwd">
                            <a class="link" href="forgot-pwd.html">Forgot password?</a>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
<!-- Container end -->

</body>
</html>
