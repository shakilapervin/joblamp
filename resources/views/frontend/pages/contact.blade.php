@extends('frontend.layouts.master')
@section('title')
    {{ __('Contact Us') }}
@endsection
@section('content')
    <!-- Titlebar
    ================================================== -->
    <div id="titlebar" class="gradient">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <h2>{{ __('Contact Us') }}</h2>

                    <!-- Breadcrumbs -->
                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li>{{ __('Contact Us') }}</li>
                        </ul>
                    </nav>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <!-- Content
    ================================================== -->


    <!-- Container -->
    <div class="container">
        <div class="row">

            <div class="col-xl-12">
                <div class="contact-location-info margin-bottom-50">
                    <div class="contact-address">
                        <ul>
                            <li class="contact-address-headline">Our Office</li>
                            <li>425 Berry Street, CA 93584</li>
                            <li>Phone (123) 123-456</li>
                            <li><a href="#">mail@example.com</a></li>
                            <li>
                                <div class="freelancer-socials">
                                    <ul>
                                        <li><a href="#" title="Dribbble" data-tippy-placement="top"><i
                                                    class="icon-brand-dribbble"></i></a></li>
                                        <li><a href="#" title="Twitter" data-tippy-placement="top"><i
                                                    class="icon-brand-twitter"></i></a></li>
                                        <li><a href="#" title="Behance" data-tippy-placement="top"><i
                                                    class="icon-brand-behance"></i></a></li>
                                        <li><a href="#" title="GitHub" data-tippy-placement="top"><i
                                                    class="icon-brand-github"></i></a></li>

                                    </ul>
                                </div>
                            </li>
                        </ul>

                    </div>
                    <div id="single-job-map-container">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3680.4241671534814!2d89.06858141551353!3d22.71247048511094!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39ff5e75ff4d1fef%3A0x6c78779063546e1b!2sSatkhira%20New%20Market!5e0!3m2!1sen!2sbd!4v1617512937246!5m2!1sen!2sbd" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>

            <div class="col-xl-8 col-lg-8 offset-xl-2 offset-lg-2">

                <section id="contact" class="margin-bottom-60">
                    <h3 class="headline margin-top-15 margin-bottom-35">Any questions? Feel free to contact us!</h3>

                    <form method="post" name="contactform" id="contactform" autocomplete="on" action="{{ route('submit.contact.form') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-with-icon-left">
                                    <input class="with-border" name="name" type="text" id="name" placeholder="Your Name"
                                           required="required"/>
                                    <i class="icon-material-outline-account-circle"></i>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-with-icon-left">
                                    <input class="with-border" name="email" type="email" id="email"
                                           placeholder="Email Address"
                                           pattern="^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})$"
                                           required="required"/>
                                    <i class="icon-material-outline-email"></i>
                                </div>
                            </div>
                        </div>

                        <div class="input-with-icon-left">
                            <select name="type" id="" required>
                                <option value="">Select One</option>
                                <option value="General Enquiry">General Enquiry</option>
                                <option value="Dispute">Dispute</option>
                                <option value="Payment Issue">Payment Issue</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>

                        <div>
                            <textarea class="with-border" name="description" cols="40" rows="5" id="comments"
                                      placeholder="Message" spellcheck="true" required="required"></textarea>
                        </div>

                        <input type="submit" class="submit button margin-top-15" id="submit" value="Submit Message"/>

                    </form>
                </section>

            </div>

        </div>
    </div>
    <!-- Container / End -->
@endsection
