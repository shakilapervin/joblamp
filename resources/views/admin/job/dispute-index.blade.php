@extends('admin.layouts.master')
@section('style')
    <!-- Data Tables -->
    <link rel="stylesheet" href="{{ admin_asset('') }}/vendor/datatables/dataTables.bs4.css"/>
    <link rel="stylesheet" href="{{ admin_asset('') }}/vendor/datatables/dataTables.bs4-custom.css"/>
    <link href="{{ admin_asset('') }}/vendor/datatables/buttons.bs.css" rel="stylesheet"/>
@endsection
@section('title')
    {{ __('Dispute Job List') }}
@endsection
@section('content')
    <!-- Main container start -->
    <div class="main-container">

        <!-- Page header start -->
        <div class="page-header">

            <!-- Breadcrumb start -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">{{ __('Dispute Job List') }}</li>
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
                            {{ __('Dispute Job List') }}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="datatable table table-bordered">
                                <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Job Owner') }}</th>
                                    <th>{{ __('Job Worker') }}</th>
                                    <th>{{ __('Category') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th width="10%">{{ __('Action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $sl = 0;
                                @endphp
                                @foreach($jobs as $job)
                                    @php
                                        $sl++;
                                    @endphp
                                    <tr>
                                        <td>
                                            {{ $sl }}
                                        </td>
                                        <td>
                                            {{ $job->title }}
                                        </td>
                                        <td>
                                            {{ $job->creatorDetails->first_name }} {{ $job->creatorDetails->last_name }}
                                        </td>
                                        <td>
                                            {{ $job->userJob->workerDetails->first_name }} {{ $job->userJob->workerDetails->last_name }}
                                        </td>

                                        <td>
                                            {{ $job->categoryInfo->name }}
                                        </td>
                                        <td>
                                            {{ $job->created_at->toDateString() }}
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
                                                       href="{{route('admin.view.dispute.job', $job->id)}}">{{__('Details')}}</a>
                                                    <a class="dropdown-item"
                                                       href="{{route('admin.edit.job', $job->id)}}">{{__('Edit')}}</a>
                                                    <a class="dropdown-item"
                                                       href="{{route('admin.delete.job', $job->id)}}"
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
    <script>
        $(document).ready(function () {
            $('.datatable').dataTable();
        });
    </script>
@endsection
