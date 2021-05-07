@extends('frontend.layouts.master')
@section('title')
    {{ __('About Us') }}
@endsection
@section('content')
    <div class="single-page-header" data-background-image="{{ frontend_asset('') }}/images/single-company.jpg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="single-page-header-inner">
                        <div class="left-side">
                            <div class="header-details">
                                <h3>{{ __('About Us') }}</h3>
                            </div>
                        </div>
                        <div class="right-side">
                            <!-- Breadcrumbs -->
                            <nav id="breadcrumbs" class="white">
                                <ul>
                                    <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                                    <li>{{ __('About Us') }}</li>
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
                <p>{!! $content->data !!}</p>
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
