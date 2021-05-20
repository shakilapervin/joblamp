@extends('admin.layouts.master')
@section('style')
    <!-- Data Tables -->
    <link rel="stylesheet" href="{{ admin_asset('') }}/vendor/datatables/dataTables.bs4.css"/>
    <link rel="stylesheet" href="{{ admin_asset('') }}/vendor/datatables/dataTables.bs4-custom.css"/>
    <link href="{{ admin_asset('') }}/vendor/datatables/buttons.bs.css" rel="stylesheet"/>
@endsection
@section('title')
    {{ __('Contractor List') }}
@endsection
@section('content')
    <!-- Main container start -->
    <div class="main-container">

        <!-- Page header start -->
        <div class="page-header">

            <!-- Breadcrumb start -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">{{ __('Contractor List') }}</li>
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
                            {{ __('Contractor List') }}
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
                                    <th>{{ __('Phone') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Subscription Plan') }}</th>
                                    <th width="10%">{{ __('Action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $sl = 0;
                                @endphp
                                @foreach($contractors as $contractor)
                                    @php
                                        $sl++;
                                    @endphp
                                    <tr>
                                        <td>
                                            {{ $sl }}
                                        </td>
                                        <td>
                                            {{ $contractor->first_name }} {{ $contractor->last_name }}
                                        </td>
                                        <td>
                                            {{ $contractor->email }}
                                        </td>
                                        <td>
                                            {{ $contractor->mobile_number }}
                                        </td>
                                        <td>
                                            @if($contractor->status == 'active')
                                                <span class="badge badge-success">{{ __('Approved') }}</span>
                                            @elseif($contractor->status == 'rejected')
                                                <span class="badge badge-danger">{{ __('Rejected') }}</span>
                                            @else
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a href="{{route('admin.update.contractor.status', [$contractor->id,'active'])}}" class="btn btn-success">
                                                        <i class="icon-check"></i> {{ __('Approve') }}
                                                    </a>
                                                    <a href="{{route('admin.update.contractor.status', [$contractor->id,'rejected'])}}" class="btn btn-danger">
                                                        <i class="icon-close"></i> {{ __('Reject') }}
                                                    </a>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if (!empty($contractor->plan_id))
                                                {{ \App\SubscriptionPlan::where('id',$contractor->plan_id)->first()->title }}
                                            @else
                                                No Subscription Plan
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button"
                                                        id="dropdownMenuButton" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                    {{__('Actions')}}
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item"
                                                       href="{{route('admin.edit.contractor', $contractor->id)}}">{{__('Edit')}}</a>
                                                    <a class="dropdown-item"
                                                       href="{{route('admin.delete.contractor', $contractor->id)}}"
                                                       onclick="return confirm('Are you sure?')">{{__('Delete')}}</a>
                                                </div>
                                            </div>
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
