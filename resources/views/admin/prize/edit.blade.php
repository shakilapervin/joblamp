@extends('admin.layouts.master')
@section('title')
    {{ __('Edit Prize') }}
@endsection
@section('content')
    <!-- Main container start -->
    <div class="main-container">

        <!-- Page header start -->
        <div class="page-header">
            <!-- Breadcrumb start -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">{{ __('Edit Prize') }}</li>
            </ol>
            <!-- Breadcrumb end -->

        </div>
        <!-- Page header end -->

        <!-- Row start -->
        <div class="row gutters">
            <form class="col-md-12" action="{{ route('admin.update.prize') }}" method="post"
                  enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $prize->id }}">
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
                                   class="col-sm-12 col-form-label">{{ __('English Title') }}</label>
                            <div class="col-sm-12">
                                <input type="text"
                                       class="form-control form-control @error('title_en') is-invalid @enderror"
                                       id="colFormLabelSm" name="title_en"
                                       required
                                       value="{{ $prize->title_en }}">
                                @error('title_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('English Details') }}</label>
                            <div class="col-sm-12">
                                <textarea name="details_en" id="" cols="30" rows="10" class="form-control @error('details_en') is-invalid @enderror">{{ $prize->details_en }}</textarea>
                                @error('details_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('Spanish Title') }}</label>
                            <div class="col-sm-12">
                                <input type="text"
                                       class="form-control form-control @error('title_es') is-invalid @enderror"
                                       id="colFormLabelSm" name="title_es"
                                       required
                                       value="{{ $prize->title_es }}">
                                @error('title_es')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('Spanish Details') }}</label>
                            <div class="col-sm-12">
                                <textarea name="details_es" id="" cols="30" rows="10" class="form-control @error('details_es') is-invalid @enderror">{{ $prize->details_es }}</textarea>
                                @error('details_es')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('French Title') }}</label>
                            <div class="col-sm-12">
                                <input type="text"
                                       class="form-control form-control @error('title_fr') is-invalid @enderror"
                                       id="colFormLabelSm" name="title_fr"
                                       required
                                       value="{{ $prize->title_fr }}">
                                @error('title_fr')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('French Details') }}</label>
                            <div class="col-sm-12">
                                <textarea name="details_fr" id="" cols="30" rows="10" class="form-control @error('details_fr') is-invalid @enderror">{{ $prize->details_fr }}</textarea>
                                @error('details_fr')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('German Title') }}</label>
                            <div class="col-sm-12">
                                <input type="text"
                                       class="form-control @error('title_de') is-invalid @enderror"
                                       id="colFormLabelSm" name="title_de"
                                       required
                                       value="{{ $prize->title_de }}">
                                @error('title_de')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('German Details') }}</label>
                            <div class="col-sm-12">
                                <textarea name="details_de" id="" cols="30" rows="10" class="form-control @error('details_de') is-invalid @enderror">{{ $prize->details_de }}</textarea>
                                @error('details_de')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('Romanian Title') }}</label>
                            <div class="col-sm-12">
                                <input type="text"
                                       class="form-control @error('title_ro') is-invalid @enderror"
                                       id="colFormLabelSm" name="title_ro"
                                       required
                                       value="{{ $prize->title_ro }}">
                                @error('title_ro')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('Romanian Details') }}</label>
                            <div class="col-sm-12">
                                <textarea name="details_ro" id="" cols="30" rows="10" class="form-control @error('details_ro') is-invalid @enderror">{{ $prize->details_ro }}</textarea>
                                @error('details_ro')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('Portuguese Title') }}</label>
                            <div class="col-sm-12">
                                <input type="text"
                                       class="form-control @error('title_pt') is-invalid @enderror"
                                       id="colFormLabelSm" name="title_pt"
                                       required
                                       value="{{ $prize->title_pt }}">
                                @error('title_pt')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('Portuguese Details') }}</label>
                            <div class="col-sm-12">
                                <textarea name="details_pt" id="" cols="30" rows="10" class="form-control @error('details_pt') is-invalid @enderror">{{ $prize->details_pt }}</textarea>
                                @error('details_pt')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('Status') }}</label>
                            <div class="col-sm-12">
                                <select name="status" id="status" class="form-control">
                                    <option value="active"
                                            @if($prize->status == 'active') selected @endif>{{ __('Active') }}</option>
                                    <option value="inactive"
                                            @if($prize->status == 'inactive') selected @endif>{{ __('Inactive') }}</option>
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
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/summernote/summernote-bs4.css') }}">
@endsection
@section('script')
    <script src="{{ asset('assets/admin/vendor/summernote/summernote-bs4.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('textarea').summernote({
                height: 200
            });
        });
    </script>
@endsection
