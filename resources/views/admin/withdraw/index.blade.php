@extends('admin.layouts.master')
@section('style')
    <!-- Data Tables -->
    <link rel="stylesheet" href="{{ admin_asset('') }}/vendor/datatables/dataTables.bs4.css"/>
    <link rel="stylesheet" href="{{ admin_asset('') }}/vendor/datatables/dataTables.bs4-custom.css"/>
    <link href="{{ admin_asset('') }}/vendor/datatables/buttons.bs.css" rel="stylesheet"/>
@endsection
@section('title')
    @if(Route::is('admin.withdraw.not.paid'))
        {{ __('New Withdraw Request List') }}
    @else
        {{ __('Paid Withdraw Request List') }}
    @endif
@endsection
@section('content')
    <!-- Main container start -->
    <div class="main-container">

        <!-- Page header start -->
        <div class="page-header">

            <!-- Breadcrumb start -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    @if(Route::is('admin.withdraw.not.paid'))
                        {{ __('New Withdraw Request List') }}
                    @else
                        {{ __('Paid Withdraw Request List') }}
                    @endif
                </li>
            </ol>
            <!-- Breadcrumb end -->
        </div>
        <!-- Page header end -->

        <!-- Row start -->
        <div class="row gutters">
            <div class="col-sm-12">
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            @if(Route::is('admin.withdraw.not.paid'))
                                {{ __('New Withdraw Request List') }}
                            @else
                                {{ __('Paid Withdraw Request List') }}
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="datatable table table-bordered">
                                <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Withdraw Method') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $sl = 0;
                                @endphp
                                @foreach($rows as $row)
                                    @php
                                        $sl++;
                                    @endphp
                                    <tr>
                                        <td>
                                            {{ $sl }}
                                        </td>
                                        <td>
                                            @php
                                                $user = \App\User::where('id',$row->user_id)->first();
                                            @endphp
                                            {{ $user->first_name }} {{ $user->last_name }}
                                        </td>
                                        <td>
                                            {{ $user->email }}
                                        </td>
                                        <td>
                                            {{ ucfirst($row->method) }}
                                        </td>
                                        <td>
                                            {{ $row->amount }}
                                        </td>
                                        <td>
                                            {{ $row->created_at }}
                                        </td>
                                        <td>
                                            <a class="btn btn-info" href="{{route('admin.withdraw.request.view', $row->id)}}">{{ __('Details') }}</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row end -->

    </div>
    <!-- Main container end -->
@endsection
@section('script')
    <!-- Data Tables -->
    <script src="{{ admin_asset('') }}/vendor/datatables/dataTables.min.js"></script>
    <script src="{{ admin_asset('') }}/vendor/datatables/dataTables.bootstrap.min.js"></script>
    <!-- Custom Data tables -->
    <script>
        $(document).ready(function () {
            $('.datatable').dataTable();
        });
    </script>
@endsection
