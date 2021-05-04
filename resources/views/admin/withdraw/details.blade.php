@extends('admin.layouts.master')
@section('title')
    {{ __('Withdraw Details') }}
@endsection
@section('content')
    <div class="main-container">

        <!-- Page header start -->
        <div class="page-header">

            <!-- Breadcrumb start -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">{{ __('Withdraw Details') }}</li>
            </ol>
            <!-- Breadcrumb end -->

        </div>
        <!-- Page header end -->

        <!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="invoice-container">
                            <div class="invoice-header">
                                <div class="row gutters">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                        <div class="custom-actions-btns mb-5">
                                            @if($withdrawData->status != 'paid')
                                            <a href="{{ route('admin.mark.withdraw.request.paid',$withdrawData->id) }}" class="btn btn-success">
                                                <i class="icon-check"></i> {{ __('Mark As Paid') }}
                                            </a>
                                            @else
                                                <a href="javascrip:void(0);" class="btn btn-success">
                                                    <i class="icon-check"></i> {{ __('Paid') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- Row start -->
                                <div class="row gutters">
                                    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                                        <div class="invoice-details">
                                            <address>
                                                {{ $userData->first_name }} {{ $userData->last_name }}
                                            </address>
                                            <address>
                                                {{ $userData->email }}
                                            </address>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                                        <div class="invoice-details">
                                            <div class="invoice-num">
                                                <div>{{ __('ID') }} {{ $withdrawData->id }}</div>
                                                <div>{{ $withdrawData->created_at }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Row end -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row end -->
        <!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="invoice-status">
                    <i class="icon-attach_money"></i>
                    <h2 class="status">{{ $withdrawData->amount }}</h2>
                    <h6 class="badge badge-success">{{ __('Withdraw Amount') }}</h6>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="invoice-status">
                    <i class="icon-account_box"></i>
                    <h2 class="status">{{ ucfirst($withdrawData->method) }}</h2>
                    @if($withdrawData->method == 'bank')
                        <p>{{ __('Account Holder Name') }} : {{ $accountData->account_holder_name }}</p>
                        <p>{{ __('Account Type') }} : {{ $accountData->account_holder_type }}</p>
                        <p>{{ __('Routing Number') }} : {{ $accountData->routing_number }}</p>
                        <p>{{ __('Account Number') }} : {{ $accountData->account_number }}</p>
                        <p>{{ __('Currency') }} : {{ $accountData->currency }}</p>
                        <p>{{ __('Country') }} : {{ $countries->where('cca2', $accountData->country)->first()->name->common }}</p>
                    @else
                        <p>{{ __('Account Number') }} : {{ $accountData->account_number }}</p>
                        <p>{{ __('Currency') }} : {{ $accountData->currency }}</p>
                    @endif
                </div>
            </div>
        </div>
        <!-- Row end -->

    </div>
@endsection
