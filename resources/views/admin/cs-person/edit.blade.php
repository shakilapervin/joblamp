@extends('admin.layouts.master')
@section('title')
    {{ __('Edit Customer Service Person') }}
@endsection
@section('content')
    <!-- Main container start -->
    <div class="main-container">

        <!-- Page header start -->
        <div class="page-header">
            <!-- Breadcrumb start -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">{{ __('Edit Customer Service Person') }}</li>
            </ol>
            <!-- Breadcrumb end -->

        </div>
        <!-- Page header end -->

        <!-- Row start -->
        <div class="row gutters">
            <form class="col-md-12" action="{{ route('admin.update.cs.person') }}" method="post"
                  enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $user->id }}">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
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
                        <div class="card-title">{{ __('Job Category Information') }}</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="colFormLabelSm"
                                           class="col-sm-12 col-form-label">{{ __('First Name') }}</label>
                                    <div class="col-sm-12">
                                        <input type="text"
                                               class="form-control form-control @error('first_name') is-invalid @enderror"
                                               id="colFormLabelSm" name="first_name"
                                               required
                                               value="{{ $user->first_name }}">
                                        @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="colFormLabelSm"
                                           class="col-sm-12 col-form-label">{{ __('Last Name') }}</label>
                                    <div class="col-sm-12">
                                        <input type="text"
                                               class="form-control form-control @error('last_name') is-invalid @enderror"
                                               id="colFormLabelSm" name="last_name"
                                               required
                                               value="{{ $user->last_name }}">
                                        @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="colFormLabelSm"
                                           class="col-sm-12 col-form-label">{{ __('Email') }}</label>
                                    <div class="col-sm-12">
                                        <input type="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               id="colFormLabelSm" name="email"
                                               required
                                               value="{{ $user->email }}">
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="colFormLabelSm"
                                           class="col-sm-12 col-form-label">{{ __('New Password') }}</label>
                                    <div class="col-sm-12">
                                        <input type="text"
                                               class="form-control @error('password') is-invalid @enderror"
                                               id="colFormLabelSm" name="password">
                                        @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="colFormLabelSm"
                                           class="col-sm-12 col-form-label">{{ __('Status') }}</label>
                                    <div class="col-sm-12">
                                        <select name="status" id="status" class="form-control">
                                            <option value="active"
                                                    @if($user->status == 'active') selected @endif>{{ __('Active') }}</option>
                                            <option value="inactive"
                                                    @if($user->status == 'inactive') selected @endif>{{ __('Inactive') }}</option>
                                        </select>
                                        @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary my-1 btn-lg">{{ __('Update') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- Row end -->
    </div>
@endsection
