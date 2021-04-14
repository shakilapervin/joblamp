@extends('frontend.layouts.master')
@section('title')
    {{ __('Withdraw') }}
@endsection

@section('content')
    <!-- Dashboard Container -->
    <div class="dashboard-container">
    @include('frontend.layouts.dashboard-sidebar')
    <!-- Dashboard Content
        ================================================== -->
        <div class="dashboard-content-container" data-simplebar>
            <div class="dashboard-content-inner">

                <!-- Dashboard Headline -->
                <div class="dashboard-headline">
                    <h3>{{ __('Withdraw') }}</h3>

                    <!-- Breadcrumbs -->
                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li>
                                <a href="{{ url('') }}">{{ __('Home') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
                            </li>
                            <li>{{ __('Withdraw') }}</li>
                        </ul>
                    </nav>
                </div>

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

            <!-- Row -->
                <div class="row">

                    <!-- Dashboard Box -->
                    <div class="col-xl-12">
                        <div class="dashboard-box margin-top-0">

                            <!-- Headline -->
                            <div class="headline">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="method-tab" data-toggle="tab" href="#bank"
                                           role="tab">{{ __('Bank Details') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="paypal-tab" data-toggle="tab" href="#paypal"
                                           role="tab">{{ __('Paypal Details') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="withdraw-tab" data-toggle="tab" href="#withdraw-request"
                                           role="tab">{{ __('Withdraw') }}</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="bank" role="tabpanel">
                                    <form action="{{ route('update.withdraw.method') }}" method="post"
                                          enctype="multipart/form-data">
                                    @csrf
                                        <input type="hidden" name="type" value="stripe">
                                    <!-- Row -->
                                        <div class="row">

                                            <!-- Dashboard Box -->
                                            <div class="col-xl-12">
                                                <div class="dashboard-box margin-top-0">
                                                    <!-- Headline -->
                                                    <div class="headline">
                                                        <h3>
                                                            <i class="icon-line-awesome-bank"></i>
                                                            {{ __('Bank Information') }}
                                                        </h3>
                                                    </div>

                                                    <div class="content with-padding padding-bottom-0">

                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="row">
                                                                    <div class="col-xl-6">
                                                                        <div class="submit-field">
                                                                            <h5>{{ __('Country') }}</h5>
                                                                            <select id="country"
                                                                                    class="selectpicker with-border @error('country') is-invalid @enderror"
                                                                                    data-size="7" title="Select Country"
                                                                                    data-live-search="true"
                                                                                    name="country"
                                                                                    onchange="getStates();">
                                                                                @foreach($countries as $country)
                                                                                    <option
                                                                                        value="{{ $country['cca2'] }}"
                                                                                    @if (!empty($bank))
                                                                                        @if ($bank->country == $country['cca2'])
                                                                                            selected

                                                                                        @endif
                                                                                    @endif
                                                                                    >
                                                                                        {{ $country['name']['common'] }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            @error('country')
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}
                                                                            </div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <div class="submit-field">
                                                                            <h5>{{ __('Currency') }}</h5>
                                                                            <select id="currency"
                                                                                    class="selectpicker with-border @error('currency') is-invalid @enderror"
                                                                                    data-size="7" title="Select Currency"
                                                                                    data-live-search="true"
                                                                                    name="currency">
                                                                                @foreach($currencies as $key => $currency)
                                                                                    <option
                                                                                        value="{{ $key }}"
                                                                                        @if (!empty($bank))
                                                                                            @if (strtoupper($bank->currency) == $key) selected @endif
                                                                                        @endif
                                                                                    >
                                                                                        {{ $key }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            @error('currency')
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}
                                                                            </div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <div class="submit-field">
                                                                            <h5>{{ __('Account Holder Name') }}</h5>
                                                                            <input name="account_holder_name"
                                                                                   type="text"
                                                                                   class="with-border @error('account_holder_name') is-invalid @enderror"
                                                                                   value="@if (!empty($bank->account_holder_name)) {{ $bank->account_holder_name }} @endif">
                                                                            @error('account_holder_name')
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}
                                                                            </div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-xl-6">
                                                                        <div class="submit-field">
                                                                            <h5>{{ __('Routing Number') }}</h5>
                                                                            <input name="routing_number"
                                                                                   type="text"
                                                                                   class="with-border @error('routing_number') is-invalid @enderror"
                                                                                   value="@if (!empty($bank->routing_number)) {{ $bank->routing_number }} @endif">
                                                                            @error('routing_number')
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}
                                                                            </div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <div class="submit-field">
                                                                            <h5>{{ __('Account Number') }}</h5>
                                                                            <input name="account_number"
                                                                                   type="text"
                                                                                   class="with-border @error('account_number') is-invalid @enderror"
                                                                                   value="@if (!empty($bank->account_number)) {{ $bank->account_number }} @endif">
                                                                            @error('account_number')
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}
                                                                            </div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <div class="submit-field">
                                                                            <h5>{{ __('Account Type') }}</h5>
                                                                            <select id="account_holder_type"
                                                                                    class="selectpicker with-border @error('account_holder_type') is-invalid @enderror"
                                                                                    data-size="7"
                                                                                    title="Select Account Type"
                                                                                    data-live-search="true"
                                                                                    name="account_holder_type">
                                                                                <option value="">
                                                                                    {{ __('Select Account Type') }}
                                                                                </option>
                                                                                <option value="individual"
                                                                                @if (!empty($bank))
                                                                                    @if ($bank->account_holder_type == 'individual') selected @endif
                                                                                @endif
                                                                                >
                                                                                    {{ __('Individual') }}
                                                                                </option>
                                                                                <option value="company"
                                                                                    @if (!empty($bank))
                                                                                        @if ($bank->account_holder_type == 'company') selected @endif
                                                                                    @endif
                                                                                >
                                                                                    {{ __('Company') }}
                                                                                </option>
                                                                            </select>
                                                                            @error('account_holder_type')
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}
                                                                            </div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Dashboard Box -->
                                            <div class="col-xl-12">
                                                <input type="hidden" name="id" value="{{ $user->id }}">
                                                <button type="submit" class="button ripple-effect big margin-top-30">
                                                    Save Changes
                                                </button>
                                            </div>

                                        </div>
                                        <!-- Row / End -->
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="paypal" role="tabpanel">
                                    <form action="{{ route('update.withdraw.method') }}" method="post"
                                          enctype="multipart/form-data">
                                    @csrf
                                    <!-- Row -->
                                        <div class="row">

                                            <!-- Dashboard Box -->
                                            <div class="col-xl-12">
                                                <div class="dashboard-box margin-top-0">
                                                    <!-- Headline -->
                                                    <div class="headline">
                                                        <h3>
                                                            <i class="icon-line-awesome-bank"></i>
                                                            {{ __('Paypal Information') }}
                                                        </h3>
                                                    </div>

                                                    <div class="content with-padding padding-bottom-0">

                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="row">
                                                                    <div class="col-xl-6">
                                                                        <div class="submit-field">
                                                                            <h5>{{ __('Paypal Account Email Address') }}</h5>
                                                                            <input name="paypal_email"
                                                                                   type="text"
                                                                                   class="with-border @error('paypal_email') is-invalid @enderror"
                                                                                   value="@if (!empty($bank->account_number)) {{ $bank->account_number }} @endif">
                                                                            @error('paypal_email')
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}
                                                                            </div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <div class="submit-field">
                                                                            <h5>{{ __('Currency') }}</h5>
                                                                            <select id="currency"
                                                                                    class="selectpicker with-border @error('currency') is-invalid @enderror"
                                                                                    data-size="7" title="Select Currency"
                                                                                    data-live-search="true"
                                                                                    name="currency">
                                                                                @foreach($currencies as $key => $currency)
                                                                                    <option
                                                                                        value="{{ $key }}"
                                                                                        @if (!empty($bank))
                                                                                        @if (strtoupper($bank->currency) == $key) selected @endif
                                                                                        @endif
                                                                                    >
                                                                                        {{ $key }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            @error('currency')
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}
                                                                            </div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Dashboard Box -->
                                            <div class="col-xl-12">
                                                <input type="hidden" name="type" value="paypal">
                                                <button type="submit" class="button ripple-effect big margin-top-30">
                                                    Save Changes
                                                </button>
                                            </div>

                                        </div>
                                        <!-- Row / End -->
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="withdraw-request" role="tabpanel">
                                    <form action="{{ route('withdraw.request') }}" method="post"
                                          enctype="multipart/form-data">
                                    @csrf
                                    <!-- Row -->
                                        <div class="row">

                                            <!-- Dashboard Box -->
                                            <div class="col-xl-12">
                                                <div class="dashboard-box margin-top-0">
                                                    <!-- Headline -->
                                                    <div class="headline">
                                                        <h3>
                                                            <i class="icon-line-awesome-money"></i>
                                                            {{ __('Your Balance') }} ${{ $balance }}
                                                        </h3>
                                                    </div>

                                                    <div class="content with-padding padding-bottom-0">

                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="row">
                                                                    <div class="col-xl-6">
                                                                        <div class="submit-field">
                                                                            <h5>{{ __('Withdraw Method') }}</h5>
                                                                            <select id="country"
                                                                                    class="selectpicker with-border @error('withdraw_method') is-invalid @enderror"
                                                                                    data-size="7" title="Select Withdraw Method"
                                                                                    data-live-search="true"
                                                                                    name="withdraw_method">
                                                                                <option value="bank_account">
                                                                                    {{ __('Bank Account') }}
                                                                                </option>
                                                                                <option value="paypal">
                                                                                    {{ __('Paypal') }}
                                                                                </option>
                                                                            </select>
                                                                            @error('withdraw_method')
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}
                                                                            </div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <div class="submit-field">
                                                                            <h5>{{ __('Amount') }}</h5>
                                                                            <input name="amount"
                                                                                   type="text"
                                                                                   class="with-border @error('amount') is-invalid @enderror"
                                                                                   value="{{ $balance }}">
                                                                            @error('amount')
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}
                                                                            </div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Dashboard Box -->
                                            <div class="col-xl-12">
                                                <button type="submit" class="button ripple-effect big margin-top-30">
                                                    {{ __('Withdraw') }}
                                                </button>
                                            </div>

                                        </div>
                                        <!-- Row / End -->
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Row / End -->
                <!-- Footer -->
                <div class="dashboard-footer-spacer"></div>
            </div>
        </div>
        <!-- Dashboard Content / End -->

    </div>
    <!-- Dashboard Container / End -->
@endsection
@section('script')
    <script src="{{ asset('public/assets/frontend') }}/js/bootstrap.min.js"></script>
@endsection
