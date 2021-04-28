@extends('frontend.layouts.master')
@section('title')
    {{ __('Lotto Prizes') }}
@endsection
@section('content')
    <div class="single-page-header" data-background-image="{{ frontend_asset('') }}/images/single-company.jpg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="single-page-header-inner">
                        <div class="left-side">
                            <div class="header-details">
                                <h3>{{ __('Lotto Prizes') }}</h3>
                            </div>
                        </div>
                        <div class="right-side">
                            <!-- Breadcrumbs -->
                            <nav id="breadcrumbs" class="white">
                                <ul>
                                    <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                                    <li>{{ __('Lotto Prizes') }}</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="background-image-container"
             style="background-image: url({{ frontend_asset('') }}/images/single-company.jpg);"></div>
    </div>
    <div class="margin-top-80"></div>
    <!-- Page Content
    ================================================== -->
    <div class="container">
        <div class="row">

            <div class="col-xl-12">

                <!-- Pricing Plans Container -->
                <div class="pricing-plans-container">
                @foreach($prizes as $prize)
                    <!-- Prize -->
                        <div class="pricing-plan" style="border-left: 1px solid;border-bottom: 1px solid; border-top: 1px solid;">
                            <h3>{{ $prize->title }}</h3>
                            <div class="pricing-plan-features">
                                <p>
                                    {!! $prize->details !!}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>

        </div>
    </div>
    <div class="margin-top-80"></div>
@endsection
@section('style')
    <style>
        .pricing-plan:last-of-type {
            border-right: 1px solid;
        }
    </style>
@endsection
