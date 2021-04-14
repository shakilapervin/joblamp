@extends('admin.layouts.master')
@section('title')
    {{ __('Edit Charge and Commission.') }}
@endsection
@section('content')
    <!-- Main container start -->
    <div class="main-container">

        <!-- Page header start -->
        <div class="page-header">
            <!-- Breadcrumb start -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">{{ __('Edit Charge and Commission.') }}</li>
            </ol>
            <!-- Breadcrumb end -->


        </div>
        <!-- Page header end -->

        <!-- Row start -->
        <div class="row gutters">
            <form class="col-md-12" action="{{ route('update.charge') }}" method="post"
                  enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $charge->id }}">
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
                        <div class="card-title">{{ __('Charge and Commission') }}</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('Withdraw Charge') }}</label>
                            <div class="col-sm-12">
                                <input type="text"
                                       class="form-control form-control @error('withdraw_charge') is-invalid @enderror"
                                       id="colFormLabelSm" placeholder="5" name="withdraw_charge"
                                       required
                                       value="{{ $charge->withdraw_charge }}">
                                @error('withdraw_charge')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('Customer Charge') }}</label>
                            <div class="col-sm-12">
                                <input type="text"
                                       class="form-control form-control @error('customer_charge') is-invalid @enderror"
                                       id="colFormLabelSm" placeholder="5" name="customer_charge"
                                       required
                                       value="{{ $charge->customer_charge }}">
                                @error('customer_charge')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('Service Provider Charge') }}</label>
                            <div class="col-sm-12">
                                <input type="text"
                                       class="form-control @error('worker_charge') is-invalid @enderror"
                                       id="colFormLabelSm" placeholder="5" name="worker_charge"
                                       required
                                       value="{{ $charge->worker_charge }}">
                                @error('worker_charge')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="colFormLabelSm"
                                   class="col-sm-12 col-form-label">{{ __('Promote Charge') }}</label>
                            <div class="col-sm-12">
                                <input type="text"
                                       class="form-control @error('promote') is-invalid @enderror"
                                       id="colFormLabelSm" placeholder="5" name="promote"
                                       required
                                       value="{{ $charge->promote }}">
                                @error('promote')
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
