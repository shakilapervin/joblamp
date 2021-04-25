@extends('frontend.layouts.master')
@section('title')
    {{ __('Checkout') }}
@endsection
@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                            <li class="nav-item">
                                <a data-toggle="pill" href="#credit-card" class="nav-link active ">
                                    <i class="icon-brand-cc-stripe mr-2"></i> {{ __('Credit Card') }} </a>
                            </li>
                            <li class="nav-item">
                                <a data-toggle="pill" href="#paypal" class="nav-link ">
                                    <i class="icon-brand-cc-paypal mr-2"></i> {{ __('Paypal') }} </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        @if (Session::has('success'))
                            <div class="alert alert-success text-center">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                <p>{{ Session::get('success') }}</p>
                            </div>

                        @endif
                        <div class="tab-content">
                            <div id="credit-card" class="tab-pane fade show active pt-3">
                                <form role="form" action="{{ route('capture.profile.promote.payment') }}" method="post"
                                      data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                                      id="payment-form" class="require-validation">
                                    @csrf
                                    <div class="form-group required">
                                        <label for="username">
                                            {{ __('Card Owner') }}
                                        </label>
                                        <input type="text" name="username" placeholder="Card Owner Name" required
                                               class="form-control">
                                    </div>
                                    <div class="form-group required">
                                        <label for="cardNumber">
                                            {{ __('Card number') }}
                                        </label>
                                        <div class="input-group">
                                            <input type="text" name="cardNumber" placeholder="Valid card number"
                                                   class="form-control card-number" required>
                                            <div class="input-group-append">
                                        <span class="input-group-text text-muted">
                                            <i class="icon-brand-cc-visa mx-1"></i>
                                            <i class="icon-brand-cc-mastercard mx-1"></i>
                                            <i class="icon-brand-cc-amex mx-1"></i>
                                        </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="form-group required">
                                                <label>
                                                    {{ __('Expiration Date') }}
                                                </label>
                                                <div class="input-group">
                                                    <input type="text" placeholder="MM" name=""
                                                           class="form-control card-expiry-month" required>
                                                    <input type="text" placeholder="YY" name=""
                                                           class="form-control card-expiry-year" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group mb-4 required">
                                                <label>
                                                    {{ __('CVV') }}
                                                </label>
                                                <input type="text" required class="form-control card-cvc">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="subscribe btn btn-primary btn-block shadow-sm">
                                            {{ __('Confirm Payment') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <!-- Paypal info -->
                            <div id="paypal" class="tab-pane fade pt-3">
                                <a href="{{ route('capture.profile.promote.paypal.payment') }}" class="btn btn-primary ">
                                    <i class="icon-brand-cc-paypal mr-2"></i>
                                    {{ __('Log into your Paypal') }}
                                </a>
                            </div> <!-- End -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            {{ __('Total Payable') }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="payable-list">
                            <strong>{{ __('Order Amount') }}</strong> <span
                                class="float-right">${{ $cost }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('assets/frontend/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="https://js.stripe.com/v2"></script>
    <script type="text/javascript">
        $(function () {
            var $form = $(".require-validation");
            $('form.require-validation').bind('submit', function (e) {
                var $form = $(".require-validation"),
                    inputSelector = ['input[type=email]', 'input[type=password]',
                        'input[type=text]', 'input[type=file]',
                        'textarea'].join(', '),
                    $inputs = $form.find('.required').find(inputSelector),
                    $errorMessage = $form.find('div.error'),
                    valid = true;
                $errorMessage.addClass('hide');
                $('.has-error').removeClass('has-error');
                $inputs.each(function (i, el) {
                    var $input = $(el);
                    if ($input.val() === '') {
                        $input.parent().addClass('has-error');
                        $errorMessage.removeClass('hide');
                        e.preventDefault();
                    }
                });
                if (!$form.data('cc-on-file')) {
                    e.preventDefault();
                    Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, stripeResponseHandler);
                }
            });

            function stripeResponseHandler(status, response) {
                if (response.error) {
                    $('.error')
                        .removeClass('hide')
                        .find('.alert')
                        .text(response.error.message);
                } else {
                    // token contains id, last4, and card type
                    var token = response['id'];
                    // insert the token into the form so it gets submitted to the server
                    $form.find('input[type=text]').empty();
                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                    $form.get(0).submit();
                }
            }
        });
    </script>
@endsection
