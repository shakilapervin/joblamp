@extends('admin.layouts.master')
@section('style')
    <!-- Data Tables -->
    <link rel="stylesheet" href="{{ admin_asset('') }}/vendor/datatables/dataTables.bs4.css"/>
    <link rel="stylesheet" href="{{ admin_asset('') }}/vendor/datatables/dataTables.bs4-custom.css"/>
    <link href="{{ admin_asset('') }}/vendor/datatables/buttons.bs.css" rel="stylesheet"/>
    <!-- Datepicker css -->
    <link rel="stylesheet" href="{{ admin_asset('') }}/vendor/datepicker/css/classic.css"/>
    <link rel="stylesheet" href="{{ admin_asset('') }}/vendor/datepicker/css/classic.date.css"/>
@endsection
@section('title')
    {{ __('Job List') }}
@endsection
@section('content')
    <!-- Main container start -->
    <div class="main-container">

        <!-- Page header start -->
        <div class="page-header">

            <!-- Breadcrumb start -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">{{ __('Job List') }}</li>
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
                        <form action="{{ route('admin.jobs') }}" method="get" enctype="multipart/form-data">
                            @csrf
                            <div class="row no-gutters">
                                <div class="col-md-4 pl-0">
                                    <div class="form-group row">
                                        <div class="col-sm-12 pl-0">
                                            <input type="text"
                                                   class="form-control form-control datePicker"
                                                   id="colFormLabelSm" placeholder="{{ __('Date') }}" name="date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 pl-0">
                                    <div class="form-group row">
                                        <div class="col-sm-12 pl-0">
                                            <select name="status" class="form-control">
                                                <option value="">Select Job Status</option>
                                                <option value="opened">Pending</option>
                                                <option value="hired">In Progress</option>
                                                <option value="completed">Completed</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 pl-0">
                                    <div class="form-group row">
                                        <div class="col-sm-12 pl-0">
                                            <button type="submit" class="btn btn-primary">{{ __('Filter') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                        <div class="card-title">
                            {{ __('Job List') }}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="datatable table table-bordered">
                                <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>{{ __('Posted By') }}</th>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Category') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Job Charge') }}</th>
                                    <th>{{ __('TG Commission') }}</th>
                                    <th>{{ __('TW Commission') }}</th>
                                    <th>{{ __('TW Payment') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th width="10%">{{ __('Action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $sl = 0;
                                @endphp
                                @if($noJob != true)
                                    @foreach($jobs as $job)
                                        @php
                                            $sl++;
                                        @endphp
                                        <tr>
                                            <td>
                                                {{ $sl }}
                                            </td>
                                            <td>
                                                {{ $job->creatorDetails->first_name }} {{ $job->creatorDetails->last_name }}
                                            </td>
                                            <td>
                                                {{ $job->title }}
                                            </td>
                                            <td>
                                                {{ $job->categoryInfo->name }}
                                            </td>
                                            <td>
                                                {{ $job->created_at->toDateString() }}
                                            </td>
                                            @php
                                                $jobCharge = \App\JobApplication::where('job_id',$job->id)->where('status','completed')->orWhere('status','hired')->first()->bid_amount;
                                                $tgCommission = ($jobCharge*$charge->customer_charge)/100;
                                                $twCommission = ($jobCharge*$charge->worker_charge)/100;
                                            @endphp
                                            <td>
                                                {{ $jobCharge }}
                                            </td>
                                            <td>
                                                {{ $tgCommission }}
                                            </td>
                                            <td>
                                                {{ $twCommission }}
                                            </td>
                                            <td>
                                                {{ $jobCharge-$twCommission }}
                                            </td>
                                            <td>
                                                @if($job->status == 'opened')
                                                    <span class="badge badge-primary">{{ __('Pending') }}</span>
                                                @elseif($job->status == 'hired')
                                                    <span class="badge badge-warning">{{ __('Pending') }}</span>
                                                @elseif($job->status == 'disputed')
                                                    <span class="badge badge-danger">{{ __('Disputed') }}</span>
                                                @else
                                                    <span class="badge badge-success">{{ __('Completed') }}</span>
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
                                                           href="{{route('admin.view.job', $job->id)}}">{{__('Details')}}</a>
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
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">{{ __('No Job Found') }}</td>
                                    </tr>
                                @endif

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
    <!-- Datepickers -->
    <script src="{{ admin_asset('') }}/vendor/datepicker/js/picker.js"></script>
    <script src="{{ admin_asset('') }}/vendor/datepicker/js/picker.date.js"></script>
    <script>
        $(document).ready(function () {
            $('.datatable').dataTable();
            $('.datePicker').pickadate({
                format: 'yyyy-mm-dd',
                formatSubmit: 'yyyy-mm-dd',
                hiddenName: true
            })
        });
    </script>
@endsection
