@extends('admin.layouts.master')
@section('title')
    {{ __('Add New Sub Category') }}
@endsection
@section('style')
    <link rel="stylesheet" href="{{ admin_asset('/vendor/select2/dist/css/select2.min.css') }}">
    <style>
        .select2-results__options {
            color: #1A233A;
        }

        body .select2-container--default .select2-selection--multiple .select2-selection__choice {
            border-color: #2c3036;
        }

        body .select2-container--default .select2-results__option[aria-selected="true"]:hover, body .select2-container--default .select2-selection--multiple .select2-selection__choice, body .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #2c3036;
            color: #fff;
        }
    </style>
@endsection
@section('content')
    <!-- Main container start -->
    <div class="main-container">

        <!-- Page header start -->
        <div class="page-header">
            <!-- Breadcrumb start -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">{{ __('Add New Sub Category') }}</li>
            </ol>
            <!-- Breadcrumb end -->

            <!-- App actions start -->
            <div class="app-actions">
                <a href="{{ route('admin.job.subcategories') }}" class="btn active">{{ __('All Sub Categories') }}</a>
            </div>
            <!-- App actions end -->

        </div>
        <!-- Page header end -->

        <!-- Row start -->
        <div class="row gutters">
            <form class="col-md-12" action="{{ route('admin.save.job.subcategory') }}" method="post"
                  enctype="multipart/form-data">
                @csrf
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
                        <div class="card-title">{{ __('Category Information') }}</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('Parent Category') }}</label>
                            <div class="col-sm-12">
                                <select name="parent_id" class="form-control select2 @error('name') is-invalid @enderror" required>
                                    <option value="">{{ __('Select Category') }}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('Category Name') }}</label>
                            <div class="col-sm-12">
                                <input type="text"
                                       class="form-control form-control @error('name') is-invalid @enderror"
                                       id="colFormLabelSm" placeholder="{{ __('Category Name') }}" name="name"
                                       required
                                       value="{{ old('name') }}">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary my-1 btn-lg">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- Row end -->

    </div>
@endsection
@section('script')
    <script src="{{ admin_asset('/vendor/select2/dist/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2();
        });
    </script>
@endsection
