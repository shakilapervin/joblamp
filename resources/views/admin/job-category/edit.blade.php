@extends('admin.layouts.master')
@section('title')
    {{ __('Edit Job Category') }}
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
                <li class="breadcrumb-item">{{ __('Edit Job Category') }}</li>
            </ol>
            <!-- Breadcrumb end -->

            <!-- App actions start -->
            <div class="app-actions">
                <a href="{{ route('admin.job.categories') }}" class="btn active">{{ __('All Job Categories') }}</a>
            </div>
            <!-- App actions end -->

        </div>
        <!-- Page header end -->

        <!-- Row start -->
        <div class="row gutters">
            <form class="col-md-12" action="{{ route('admin.update.job.category') }}" method="post"
                  enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $category->id }}">
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
                        <div class="form-group row">
                            <label for="colFormLabelSm"
                                   class="col-md-2 col-form-label">{{ __('Category Name English') }}</label>
                            <div class="col-md-4">
                                <input type="text"
                                       class="form-control form-control @error('name_en') is-invalid @enderror"
                                       id="colFormLabelSm" name="name_en"
                                       required
                                       value="{{ $category->name_en }}">
                                @error('name_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <label for="colFormLabelSm"
                                   class="col-md-2 col-form-label">{{ __('Category Description English') }}</label>
                            <div class="col-md-4">
                                <textarea name="description_en" class="form-control @error('description_en') is-invalid @enderror" cols="30" rows="10" required>{{ $category->description_en }}</textarea>
                                @error('description_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="colFormLabelSm"
                                   class="col-md-2 col-form-label">{{ __('Category Name Spanish') }}</label>
                            <div class="col-md-4">
                                <input type="text"
                                       class="form-control form-control @error('name_es') is-invalid @enderror"
                                       id="colFormLabelSm" name="name_es"
                                       required
                                       value="{{ $category->name_es }}">
                                @error('name_es')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <label for="colFormLabelSm"
                                   class="col-md-2 col-form-label">{{ __('Category Description Spanish') }}</label>
                            <div class="col-md-4">
                                <textarea name="description_es" class="form-control @error('description_es') is-invalid @enderror" cols="30" rows="10" required>{{ $category->description_es }}</textarea>
                                @error('description_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="colFormLabelSm"
                                   class="col-md-2 col-form-label">{{ __('Category Name French') }}</label>
                            <div class="col-md-4">
                                <input type="text"
                                       class="form-control @error('name_fr') is-invalid @enderror"
                                       id="colFormLabelSm" name="name_fr"
                                       required
                                       value="{{ $category->name_fr }}">
                                @error('name_fr')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <label for="colFormLabelSm"
                                   class="col-md-2 col-form-label">{{ __('Category Description French') }}</label>
                            <div class="col-md-4">
                                <textarea name="description_fr" class="form-control @error('description_fr') is-invalid @enderror" cols="30" rows="10" required>{{ $category->description_fr }}</textarea>
                                @error('description_fr')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="colFormLabelSm"
                                   class="col-md-2 col-form-label">{{ __('Category Name German') }}</label>
                            <div class="col-md-4">
                                <input type="text"
                                       class="form-control @error('name_de') is-invalid @enderror"
                                       id="colFormLabelSm" name="name_de"
                                       required
                                       value="{{ $category->name_de }}">
                                @error('name_de')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <label for="colFormLabelSm"
                                   class="col-md-2 col-form-label">{{ __('Category Description German') }}</label>
                            <div class="col-md-4">
                                <textarea name="description_de" class="form-control @error('description_de') is-invalid @enderror" cols="30" rows="10" required>{{ $category->description_de }}</textarea>
                                @error('description_de')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="colFormLabelSm"
                                   class="col-md-2 col-form-label">{{ __('Category Name Romanian') }}</label>
                            <div class="col-md-4">
                                <input type="text"
                                       class="form-control @error('name_ro') is-invalid @enderror"
                                       id="colFormLabelSm" name="name_ro"
                                       required
                                       value="{{ $category->name_ro }}">
                                @error('name_ro')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <label for="colFormLabelSm"
                                   class="col-md-2 col-form-label">{{ __('Category Description Romanian') }}</label>
                            <div class="col-md-4">
                                <textarea name="description_ro" class="form-control @error('description_ro') is-invalid @enderror" cols="30" rows="10" required>{{ $category->description_ro }}</textarea>
                                @error('description_ro')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="colFormLabelSm"
                                   class="col-md-2 col-form-label">{{ __('Category Name Portuguese') }}</label>
                            <div class="col-md-4">
                                <input type="text"
                                       class="form-control @error('name_pt') is-invalid @enderror"
                                       id="colFormLabelSm" name="name_pt"
                                       required
                                       value="{{ $category->name_pt }}">
                                @error('name_pt')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <label for="colFormLabelSm"
                                   class="col-md-2 col-form-label">{{ __('Category Description Portuguese') }}</label>
                            <div class="col-md-4">
                                <textarea name="description_pt" class="form-control @error('description_pt') is-invalid @enderror" cols="30" rows="10" required>{{ $category->description_pt }}</textarea>
                                @error('description_pt')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('Category Icon') }}</label>
                            <div class="col-sm-12">
                                <input type="text"
                                       class="form-control form-control @error('icon') is-invalid @enderror"
                                       id="colFormLabelSm" placeholder="{{ __('icon-line-awesome-cloud-upload') }}" name="icon"
                                       required
                                       value="{{ $category->icon }}">
                                @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('Status') }}</label>
                            <div class="col-sm-12">
                                <select name="status" id="status" class="form-control">
                                    <option value="1"
                                            @if($category->status == 1) selected @endif>{{ __('Active') }}</option>
                                    <option value="0"
                                            @if($category->status == 0) selected @endif>{{ __('Inactive') }}</option>
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
@section('script')
    <script src="{{ admin_asset('/vendor/select2/dist/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2();
        });
    </script>
    <script>
        function getStates() {
            var country = $('select#country').val();
            $.ajax({
                type: "POST",
                url: '{{ route('admin.get.states') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    country: country
                },
                success: function (data) {
                    console.log(data);
                    $('.state').html(null);
                    $('.state').html(data);
                    getCities();
                }
            });
        }

        function getCities() {
            var state = $('select#state').val();
            var country = $('select#country').val();
            $.ajax({
                type: "POST",
                url: '{{ route('admin.get.cities') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    state: state,
                    country: country,
                },
                success: function (data) {
                    console.log(data);
                    $('.city').html(null);
                    $('.city').html(data);
                }
            });
        }

    </script>
@endsection
