@extends('admin.layouts.master')
@section('title')
    {{ __('Add New Skill') }}
@endsection
@section('content')
    <!-- Main container start -->
    <div class="main-container">

        <!-- Page header start -->
        <div class="page-header">
            <!-- Breadcrumb start -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">{{ __('Add New Skill') }}</li>
            </ol>
            <!-- Breadcrumb end -->

        </div>
        <!-- Page header end -->

        <!-- Row start -->
        <div class="row gutters">
            <form class="col-md-12" action="{{ route('admin.store.skill') }}" method="post"
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
                        <div class="card-title">{{ __('Skill Information') }}</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('English Name') }}</label>
                            <div class="col-sm-12">
                                <input type="text"
                                       class="form-control @error('name_en') is-invalid @enderror"
                                       id="colFormLabelSm" name="name_en"
                                       required
                                       value="{{ old('name_en') }}">
                                @error('name_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('Spanish Name') }}</label>
                            <div class="col-sm-12">
                                <input type="text"
                                       class="form-control @error('name_es') is-invalid @enderror"
                                       id="colFormLabelSm" name="name_es"
                                       required
                                       value="{{ old('name_es') }}">
                                @error('name_es')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('French Name') }}</label>
                            <div class="col-sm-12">
                                <input type="text"
                                       class="form-control @error('name_fr') is-invalid @enderror"
                                       id="colFormLabelSm" name="name_fr"
                                       required
                                       value="{{ old('name_fr') }}">
                                @error('name_fr')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('German Name') }}</label>
                            <div class="col-sm-12">
                                <input type="text"
                                       class="form-control @error('name_de') is-invalid @enderror"
                                       id="colFormLabelSm" name="name_de"
                                       required
                                       value="{{ old('name_de') }}">
                                @error('name_de')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('Romanian Name') }}</label>
                            <div class="col-sm-12">
                                <input type="text"
                                       class="form-control @error('name_ro') is-invalid @enderror"
                                       id="colFormLabelSm" name="name_ro"
                                       required
                                       value="{{ old('name_ro') }}">
                                @error('name_ro')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('Portuguese Name') }}</label>
                            <div class="col-sm-12">
                                <input type="text"
                                       class="form-control @error('name_pt') is-invalid @enderror"
                                       id="colFormLabelSm" name="name_pt"
                                       required
                                       value="{{ old('name_pt') }}">
                                @error('name_pt')
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
