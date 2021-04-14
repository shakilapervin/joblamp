@extends('admin.layouts.master')
@section('content')
    <style>
        a {
            color: #bcd0f7 !important;
        }
    </style>
    <!-- Main container start -->
    <div class="main-container">

        <!-- Page header start -->
        <div class="page-header">

            <!-- Breadcrumb start -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">{{ __('Welcome') }}
                    , {{ \Illuminate\Support\Facades\Auth::user()->first_name }} {{ \Illuminate\Support\Facades\Auth::user()->last_name }}</li>
            </ol>
            <!-- Breadcrumb end -->

        </div>
        <!-- Page header end -->


        <!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-6">
                <a href="{{ route('admin.contractors') }}">
                    <div class="social-tile h-165">
                        <div class="social-icon bg-info">
                            <i class="icon-users"></i>
                        </div>
                        <div>{{ __('Total Service Providers') }}</div>
                        <h2 class="text-grey">
                            {{ number_format(\App\User::where('user_type','service_provider')->count(),0,'.',',') }}
                        </h2>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-6">
                <a href="{{ route('admin.customers') }}">
                    <div class="social-tile h-165">
                        <div class="social-icon bg-danger">
                            <i class="icon-user1"></i>
                        </div>
                        <div>{{ __('Total Customers') }}</div>
                        <h2 class="text-grey">
                            {{ number_format(\App\User::where('user_type','customer')->count(),0,'.',',') }}
                        </h2>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-6">
                <a href="{{ route('admin.jobs') }}">
                    <div class="social-tile h-165">
                        <div class="social-icon bg-success">
                            <i class="icon-shopping-bag1"></i>
                        </div>
                        <div>{{ __('Active Job') }}</div>
                        <h2 class="text-grey">
                            {{ number_format(\App\Job::where('status','opened')->count(),0,'.',',') }}
                        </h2>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-6">
                <a href="{{ route('admin.jobs') }}">
                    <div class="social-tile h-165">
                        <div class="social-icon bg-warning">
                            <i class="icon-shopping-bag1"></i>
                        </div>
                        <div>{{ __('Completed Jobs') }}</div>
                        <h2 class="text-grey">
                            {{ number_format(\App\Job::where('status','completed')->count(),0,'.',',') }}
                        </h2>
                    </div>
                </a>
            </div>
        </div>
        <!-- Row end -->


    </div>
    <!-- Main container end -->
@endsection
