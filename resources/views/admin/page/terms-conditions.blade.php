@extends('admin.layouts.master')
@section('title')
    {{ __('Edit Terms and Conditions Page') }}
@endsection
@section('content')
    <!-- Main container start -->
    <div class="main-container">

        <!-- Page header start -->
        <div class="page-header">
            <!-- Breadcrumb start -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">{{ __('Edit Terms and Conditions Page') }}</li>
            </ol>
            <!-- Breadcrumb end -->

        </div>
        <!-- Page header end -->

        <!-- Row start -->
        <div class="row gutters">
            <form class="col-md-12" action="{{ route('admin.update.terms.conditions') }}" method="post"
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
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('English Content') }}</label>
                            <div class="col-sm-12">
                                <textarea name="content_en" id="" cols="30" rows="10" class="form-control @error('content_en') is-invalid @enderror" required>{{ $content->content_en }}</textarea>
                                @error('content_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('Spanish Content') }}</label>
                            <div class="col-sm-12">
                                <textarea name="content_es" id="" cols="30" rows="10" class="form-control @error('content_es') is-invalid @enderror" required>{{ $content->content_es }}</textarea>
                                @error('content_es')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('French Content') }}</label>
                            <div class="col-sm-12">
                                <textarea name="content_fr" id="" cols="30" rows="10" class="form-control @error('content_fr') is-invalid @enderror" required>{{ $content->content_fr }}</textarea>
                                @error('content_fr')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('German Content') }}</label>
                            <div class="col-sm-12">
                                <textarea name="content_de" id="" cols="30" rows="10" class="form-control @error('content_de') is-invalid @enderror" required>{{ $content->content_de }}</textarea>
                                @error('content_de')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('Romanian Content') }}</label>
                            <div class="col-sm-12">
                                <textarea name="content_ro" id="" cols="30" rows="10" class="form-control @error('content_ro') is-invalid @enderror" required>{{ $content->content_ro }}</textarea>
                                @error('content_ro')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('Portuguese Content') }}</label>
                            <div class="col-sm-12">
                                <textarea name="content_pt" id="" cols="30" rows="10" class="form-control @error('content_pt') is-invalid @enderror" required>{{ $content->content_pt }}</textarea>
                                @error('content_pt')
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
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/summernote/summernote-bs4.css') }}">
@endsection
@section('script')
    <script src="{{ asset('assets/admin/vendor/summernote/summernote-bs4.js') }}"></script>
    <script>
        $( document ).ready(function() {
            $('textarea').summernote({
                height : 200
            });
        });
    </script>
@endsection
