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
                <a href="{{ route('admin.subscription.plans') }}" class="btn active">{{ __('All Subscription Plans') }}</a>
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
                                   class="col-sm-12 col-form-label">{{ __('Title') }}</label>
                            <div class="col-sm-12">
                                <input type="text"
                                       class="form-control form-control @error('title') is-invalid @enderror"
                                       id="colFormLabelSm" placeholder="{{ __('Plan title') }}" name="title"
                                       required
                                       value="{{ $plan->title }}">
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
                                       id="colFormLabelSm" placeholder="{{ __('Plan default price') }}" name="default_price"
                                       required
                                       value="{{ $plan->default_price }}">
                                @error('default_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('Description') }}</label>
                            <div class="col-sm-12">
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" cols="30" rows="10" required>{{ $plan->description }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('Status') }}</label>
                            <div class="col-sm-12">
                                <select name="status" id="status" class="form-control">
                                    <option value="active" @if($plan->status == 'active') selected @endif>{{ __('Active') }}</option>
                                    <option value="inactive" @if($plan->status == 'inactive') selected @endif>{{ __('Inactive') }}</option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="recommended"
                                   class="col-sm-12 col-form-label">{{ __('Recommended') }}</label>
                            <div class="col-sm-12">
                                <select name="recommended" id="recommended" class="form-control">
                                    <option value="1" @if($plan->recommended == '1') selected @endif>{{ __('Yes') }}</option>
                                    <option value="0" @if($plan->recommended == '0') selected @endif>{{ __('No') }}</option>
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
