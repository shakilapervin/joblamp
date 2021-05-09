@extends('admin.layouts.master')
@section('title')
    {{ __('Edit Subscription Plan') }}
@endsection
@section('content')
    <!-- Main container start -->
    <div class="main-container">

        <!-- Page header start -->
        <div class="page-header">
            <!-- Breadcrumb start -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">{{ __('Edit Subscription Plan') }}</li>
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
            <form class="col-md-12" action="{{ route('admin.subscription.plan.update') }}" method="post"
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
                                   class="col-md-2 col-form-label">{{ __('Title English') }}</label>
                            <div class="col-sm-4">
                                <input type="text"
                                       class="form-control form-control @error('title_en') is-invalid @enderror"
                                       id="colFormLabelSm" name="title_en"
                                       required
                                       value="{{ $plan->title_en }}">
                                @error('title_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <label for="colFormLabelSm"
                                   class="col-md-2 col-form-label">{{ __('Description English') }}</label>
                            <div class="col-md-4">
                                <textarea name="description_en"
                                          class="form-control @error('description_en') is-invalid @enderror" cols="30"
                                          rows="10" required>{{ $plan->description_en }}</textarea>
                                @error('description_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="colFormLabelSm"
                                   class="col-md-2 col-form-label">{{ __('Title Spanish') }}</label>
                            <div class="col-sm-4">
                                <input type="text"
                                       class="form-control form-control @error('title_es') is-invalid @enderror"
                                       id="colFormLabelSm" name="title_es"
                                       required
                                       value="{{ $plan->title_es }}">
                                @error('title_es')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <label for="colFormLabelSm"
                                   class="col-md-2 col-form-label">{{ __('Description English') }}</label>
                            <div class="col-md-4">
                                <textarea name="description_es"
                                          class="form-control @error('description_es') is-invalid @enderror" cols="30"
                                          rows="10" required>{{ $plan->description_es }}</textarea>
                                @error('description_es')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="colFormLabelSm"
                                   class="col-md-2 col-form-label">{{ __('Title German') }}</label>
                            <div class="col-sm-4">
                                <input type="text"
                                       class="form-control form-control @error('title_de') is-invalid @enderror"
                                       id="colFormLabelSm" name="title_de"
                                       required
                                       value="{{ $plan->title_de }}">
                                @error('title_de')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <label for="colFormLabelSm"
                                   class="col-md-2 col-form-label">{{ __('Description German') }}</label>
                            <div class="col-md-4">
                                <textarea name="description_de"
                                          class="form-control @error('description_de') is-invalid @enderror" cols="30"
                                          rows="10" required>{{ $plan->description_de }}</textarea>
                                @error('description_de')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="colFormLabelSm"
                                   class="col-md-2 col-form-label">{{ __('Title French') }}</label>
                            <div class="col-sm-4">
                                <input type="text"
                                       class="form-control form-control @error('title_fr') is-invalid @enderror"
                                       id="colFormLabelSm" name="title_fr"
                                       required
                                       value="{{ $plan->title_fr }}">
                                @error('title_fr')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <label for="colFormLabelSm"
                                   class="col-md-2 col-form-label">{{ __('Description French') }}</label>
                            <div class="col-md-4">
                                <textarea name="description_fr"
                                          class="form-control @error('description_fr') is-invalid @enderror" cols="30"
                                          rows="10" required>{{ $plan->description_fr }}</textarea>
                                @error('description_fr')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="colFormLabelSm"
                                   class="col-md-2 col-form-label">{{ __('Title Romania') }}</label>
                            <div class="col-sm-4">
                                <input type="text"
                                       class="form-control form-control @error('title_ro') is-invalid @enderror"
                                       id="colFormLabelSm" name="title_ro"
                                       required
                                       value="{{ $plan->title_ro }}">
                                @error('title_ro')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <label for="colFormLabelSm"
                                   class="col-md-2 col-form-label">{{ __('Description Romania') }}</label>
                            <div class="col-md-4">
                                <textarea name="description_ro"
                                          class="form-control @error('description_ro') is-invalid @enderror" cols="30"
                                          rows="10" required>{{ $plan->description_ro }}</textarea>
                                @error('description_ro')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="colFormLabelSm"
                                   class="col-md-2 col-form-label">{{ __('Title Portuguese') }}</label>
                            <div class="col-sm-4">
                                <input type="text"
                                       class="form-control form-control @error('title_pt') is-invalid @enderror"
                                       id="colFormLabelSm" name="title_pt"
                                       required
                                       value="{{ $plan->title_pt }}">
                                @error('title_pt')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <label for="colFormLabelSm"
                                   class="col-md-2 col-form-label">{{ __('Description Portuguese') }}</label>
                            <div class="col-md-4">
                                <textarea name="description_pt"
                                          class="form-control @error('description_pt') is-invalid @enderror" cols="30"
                                          rows="10" required>{{ $plan->description_pt }}</textarea>
                                @error('description_pt')
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
                                       value="{{ $plan->default_price }}">
                                @error('default_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="recommended"
                                   class="col-sm-12 col-form-label">{{ __('Recommended') }}</label>
                            <div class="col-sm-12">
                                <select name="recommended" id="recommended" class="form-control">
                                    <option value="1"
                                            @if($plan->recommended == '1') selected @endif>{{ __('Yes') }}</option>
                                    <option value="0"
                                            @if($plan->recommended == '0') selected @endif>{{ __('No') }}</option>
                                </select>
                                @error('recommended')
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
                                       value="{{ $plan->number_of_jobs }}">
                                @error('number_of_jobs')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('Plan Pricing') }}</label>
                        </div>
                        @foreach($prices as $price)
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <input type="text"
                                           class="form-control"
                                           id="colFormLabelSm"
                                           readonly
                                           value="{{ $price->country->name }}">
                                    <input type="hidden" name="country_id[]" value="{{ $price->country_id }}">
                                </div>
                                <div class="col-sm-4">
                                    <input type="text"
                                           class="form-control form-control @error('price') is-invalid @enderror"
                                           id="colFormLabelSm" name="price[]"
                                           required
                                           value="{{ $price->price }}">
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
                            @foreach($features as $feature)
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group row">
                                        <label for="colFormLabelSm"
                                               class="col-sm-2 col-form-label">{{ __('Feature English') }}</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="colFormLabelSm"
                                                   name="feature_en[]" value="{{ $feature->content_en }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="colFormLabelSm"
                                               class="col-sm-2 col-form-label">{{ __('Feature Spanish') }}</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="colFormLabelSm"
                                                   name="feature_es[]" value="{{ $feature->content_es }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="colFormLabelSm"
                                               class="col-sm-2 col-form-label">{{ __('Feature German') }}</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="colFormLabelSm"
                                                   name="feature_de[]" value="{{ $feature->content_de }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="colFormLabelSm"
                                               class="col-sm-2 col-form-label">{{ __('Feature French') }}</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="colFormLabelSm"
                                                   name="feature_fr[]" value="{{ $feature->content_fr }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="colFormLabelSm"
                                               class="col-sm-2 col-form-label">{{ __('Feature Romania') }}</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="colFormLabelSm"
                                                   name="feature_ro[]" value="{{ $feature->content_ro }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="colFormLabelSm"
                                               class="col-sm-2 col-form-label">{{ __('Feature Portuguese') }}</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="colFormLabelSm"
                                                   name="feature_pt[]" value="{{ $feature->content_pt }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger btn-lg"
                                            onclick="removeFeature(this);">{{ __('Remove Feature') }}</button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-success my-1 btn-lg" onclick="addFeature();">{{ __('Add Feature') }}</button>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('Status') }}</label>
                            <div class="col-sm-12">
                                <select name="status" id="status" class="form-control">
                                    <option value="active"
                                            @if($plan->status == 'active') selected @endif>{{ __('Active') }}</option>
                                    <option value="inactive"
                                            @if($plan->status == 'inactive') selected @endif>{{ __('Inactive') }}</option>
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
                                <input type="hidden" name="id" value="{{ $plan->id }}">
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
        function addFeature(){
            var html = `<div class="row">
                            <div class="col-md-8">
                                <div class="form-group row">
                                    <label for="colFormLabelSm"
                                           class="col-sm-2 col-form-label">{{ __('Feature English') }}</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="colFormLabelSm" name="feature_en[]" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="colFormLabelSm"
                                           class="col-sm-2 col-form-label">{{ __('Feature Spanish') }}</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="colFormLabelSm" name="feature_es[]" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="colFormLabelSm"
                                           class="col-sm-2 col-form-label">{{ __('Feature German') }}</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="colFormLabelSm" name="feature_de[]" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="colFormLabelSm"
                                           class="col-sm-2 col-form-label">{{ __('Feature French') }}</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="colFormLabelSm" name="feature_fr[]" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="colFormLabelSm"
                                           class="col-sm-2 col-form-label">{{ __('Feature Romania') }}</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="colFormLabelSm" name="feature_ro[]" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="colFormLabelSm"
                                           class="col-sm-2 col-form-label">{{ __('Feature Portuguese') }}</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="colFormLabelSm" name="feature_pt[]" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger btn-lg" onclick="removeFeature(this);">{{ __('Remove Feature') }}</button>
                            </div>
                        </div>`;
            $('.feature-list').append(html);
        }
        function removeFeature(){
            $(event.currentTarget).closest('.row').remove();
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
