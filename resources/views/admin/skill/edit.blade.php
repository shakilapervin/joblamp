@extends('admin.layouts.master')
@section('title')
    {{ __('Edit Skill') }}
@endsection
@section('content')
    <!-- Main container start -->
    <div class="main-container">

        <!-- Page header start -->
        <div class="page-header">
            <!-- Breadcrumb start -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">{{ __('Edit Skill') }}</li>
            </ol>
            <!-- Breadcrumb end -->

        </div>
        <!-- Page header end -->

        <!-- Row start -->
        <div class="row gutters">
            <form class="col-md-12" action="{{ route('admin.update.skill') }}" method="post"
                  enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $skill->id }}">
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
                        <div class="card-title">{{ __('Skill Information') }}</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('Name') }}</label>
                            <div class="col-sm-12">
                                <input type="text"
                                       class="form-control form-control @error('name') is-invalid @enderror"
                                       id="colFormLabelSm" name="name"
                                       required
                                       value="{{ $skill->name }}">
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('Status') }}</label>
                            <div class="col-sm-12">
                                <select name="status" id="status" class="form-control">
                                    <option value="active" @if($skill->status == 'active') selected @endif>{{ __('Active') }}</option>
                                    <option value="inactive" @if($skill->status == 'inactive') selected @endif>{{ __('Inactive') }}</option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
