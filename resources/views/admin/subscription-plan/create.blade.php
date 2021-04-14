@extends('admin.layouts.master')
@section('title')
    {{ __('Add Subscription Plan') }}
@endsection
@section('content')
    <!-- Main container start -->
    <div class="main-container">

        <!-- Page header start -->
        <div class="page-header">
            <!-- Breadcrumb start -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">{{ __('Add Subscription Plan') }}</li>
            </ol>
            <!-- Breadcrumb end -->

            <!-- App actions start -->
            <div class="app-actions">
                <a href="{{ route('admin.subscription.plans') }}"
                   class="btn active">{{ __('All Subscription Plans') }}</a>
            </div>
            <!-- App actions end -->

        </div>
        <!-- Page header end -->

        <!-- Row start -->
        <div class="row gutters">
            <form class="col-md-12" action="{{ route('admin.subscription.plan.save') }}" method="post"
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
                        <div class="card-title">{{ __('Plan Information') }}</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('Title') }}</label>
                            <div class="col-sm-12">
                                <input type="text"
                                       class="form-control form-control @error('title') is-invalid @enderror"
                                       id="colFormLabelSm" placeholder="{{ __('Plan title') }}" name="title"
                                       required
                                       value="{{ old('title') }}">
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('Default Price') }}</label>
                            <div class="col-sm-12">
                                <input type="text"
                                       class="form-control @error('default_price') is-invalid @enderror"
                                       id="colFormLabelSm" placeholder="{{ __('Plan default price') }}"
                                       name="default_price"
                                       required
                                       value="{{ old('default_price') }}">
                                @error('default_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('Numbers of Job Can Apply') }}</label>
                            <div class="col-sm-12">
                                <input type="text"
                                       class="form-control @error('number_of_jobs') is-invalid @enderror"
                                       id="colFormLabelSm"
                                       name="number_of_jobs"
                                       required
                                       value="{{ old('number_of_jobs') }}">
                                @error('number_of_jobs')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('Description') }}</label>
                            <div class="col-sm-12">
                                <textarea name="description"
                                          class="form-control @error('description') is-invalid @enderror" cols="30"
                                          rows="10" required>{{ old('description') }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="recommended"
                                   class="col-sm-12 col-form-label">{{ __('Recommended') }}</label>
                            <div class="col-sm-12">
                                <select name="recommended" id="recommended" class="form-control">
                                    <option value="1">{{ __('Yes') }}</option>
                                    <option value="0">{{ __('No') }}</option>
                                </select>
                                @error('recommended')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('Plan Pricing') }}</label>
                        </div>
                        @foreach($countries as $country)
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <input type="text"
                                           class="form-control"
                                           id="colFormLabelSm"
                                           readonly
                                           value="{{ $country->name }}">
                                    <input type="hidden" name="country_id[]" value="{{ $country->id }}">
                                </div>
                                <div class="col-sm-4">
                                    <input type="text"
                                           class="form-control form-control @error('price') is-invalid @enderror"
                                           id="colFormLabelSm" name="price[]"
                                           required
                                           value="{{ old('price') }}">
                                    @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @endforeach

                        <div class="form-group row">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('Plan Features') }}</label>
                        </div>
                        <div class="feature-list">

                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-success my-1 btn-lg" onclick="addFeature();">{{ __('Add Feature') }}</button>
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
        function addFeature(){
            var html = `<div class="form-group row">
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="colFormLabelSm" name="feature[]">
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-danger btn-lg" onclick="removeFeature(this);">{{ __('Remove Feature') }}</button>
                            </div>
                        </div>`;
            $('.feature-list').append(html);
        }
        function removeFeature(){
            $(event.currentTarget).closest('.form-group').remove();
        }
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
