
<!-- Footer
    ================================================== -->
<div id="footer">

    <!-- Footer Top Section -->
    <div class="footer-top-section">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">

                    <!-- Footer Rows Container -->
                    <div class="footer-rows-container">

                        <!-- Left Side -->
                        <div class="footer-rows-left">
                            <div class="footer-row">
                                <div class="footer-row-inner footer-logo">
                                    <img src="{{ asset('assets/frontend') }}/images/footer-logo.png" alt="">
                                </div>
                            </div>
                        </div>

                        <!-- Right Side -->
                        <div class="footer-rows-right">

                            <!-- Social Icons -->
                            <div class="footer-row">
                                <div class="footer-row-inner">
                                    <ul class="footer-social-links">
                                        <li>
                                            <a href="#" title="Facebook" data-tippy-placement="bottom"
                                               data-tippy-theme="light">
                                                <i class="icon-brand-facebook-f"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" title="Twitter" data-tippy-placement="bottom"
                                               data-tippy-theme="light">
                                                <i class="icon-brand-twitter"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" title="Google Plus" data-tippy-placement="bottom"
                                               data-tippy-theme="light">
                                                <i class="icon-brand-google-plus-g"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" title="LinkedIn" data-tippy-placement="bottom"
                                               data-tippy-theme="light">
                                                <i class="icon-brand-linkedin-in"></i>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <!-- Language Switcher -->
                            <div class="footer-row">
                                <div class="footer-row-inner">
                                    <form action="{{ route('change.lang') }}" method="post" class="lang-form">
                                        @csrf
                                        <select class="selectpicker language-switcher" data-selected-text-format="count"
                                                data-size="10" name="lang">
                                            @php
                                                $langs = languages();
                                            @endphp
                                            @foreach($langs as $lang)
                                            <option value="{{ $lang->language }}" @if(session()->get('lang') == $lang->language) selected @endif>{{ $lang->name }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- Footer Rows Container / End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Top Section / End -->

    <!-- Footer Middle Section -->
    <div class="footer-middle-section">
        <div class="container">
            <div class="row">

                <!-- Links -->
                <div class="col-xl-3 col-lg-3 col-md-3">
                    <div class="footer-links">
                        <h3>{{ __('For You') }}</h3>
                        <ul>
                            <li><a href="{{ route('job-list') }}"><span>Browse Jobs</span></a></li>
                            @auth
                                @if (\Illuminate\Support\Facades\Auth::user()->user_type == 'customer')
                                    <li><a href="{{ route('job-post') }}"><span>{{ __('Post a Job') }}</span></a></li>
                                @endif
                            @endauth
                            @auth
                                @if (\Illuminate\Support\Facades\Auth::user()->user_type == 'service_provider')
                                    <li><a href="{{ route('dashboard') }}"><span>{{ __('My Job') }}</span></a></li>
                                @endif
                            @endauth
                        </ul>
                    </div>
                </div>

                <!-- Links -->
                <div class="col-xl-3 col-lg-3 col-md-3">
                    <div class="footer-links">
                        <h3>Helpful Links</h3>
                        <ul>
                            <li><a href="{{ route('contact.us') }}"><span>Contact</span></a></li>
                            <li><a href="#"><span>Privacy Policy</span></a></li>
                            <li><a href="#"><span>Terms of Use</span></a></li>
                            <li><a href="{{ route('lotto.prizes') }}"><span>{{ __('Lotto Prize') }}</span></a></li>
                        </ul>
                    </div>
                </div>

                <!-- Links -->
                <div class="col-xl-3 col-lg-3 col-md-3">
                    <div class="footer-links">
                        <h3>Account</h3>
                        <ul>
                            <li><a href="#"><span>Log In</span></a></li>
                            <li><a href="#"><span>My Account</span></a></li>
                        </ul>
                    </div>
                </div>

                <!-- Newsletter -->
                <div class="col-xl-3 col-lg-3 col-md-12">
                    <h3><i class="icon-feather-mail"></i> Sign Up For a Newsletter</h3>
                    <p>Weekly breaking news, analysis and cutting edge advices on job searching.</p>
                    <form action="#" method="get" class="newsletter">
                        <input type="text" name="fname" placeholder="Enter your email address">
                        <button type="submit"><i class="icon-feather-arrow-right"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Middle Section / End -->

    <!-- Footer Copyrights -->
    <div class="footer-bottom-section">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    © {{ date('Y') }} <strong>Job Lamp</strong>. All Rights Reserved.
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Copyrights / End -->

</div>
<!-- Footer / End -->

</div>
<!-- Wrapper / End -->


<!-- Scripts
================================================== -->
<script src="{{ asset('assets/frontend') }}/js/jquery-3.4.1.min.js"></script>
<script src="{{ asset('assets/frontend') }}/js/jquery-migrate-3.1.0.min.html"></script>
<script src="{{ asset('assets/frontend') }}/js/mmenu.min.js"></script>
<script src="{{ asset('assets/frontend') }}/js/tippy.all.min.js"></script>
<script src="{{ asset('assets/frontend') }}/js/simplebar.min.js"></script>
<script src="{{ asset('assets/frontend') }}/js/bootstrap-slider.min.js"></script>
<script src="{{ asset('assets/frontend') }}/js/bootstrap-select.min.js"></script>
<script src="{{ asset('assets/frontend') }}/js/snackbar.js"></script>
<script src="{{ asset('assets/frontend') }}/js/clipboard.min.js"></script>
<script src="{{ asset('assets/frontend') }}/js/counterup.min.js"></script>
<script src="{{ asset('assets/frontend') }}/js/magnific-popup.min.js"></script>
<script src="{{ asset('assets/frontend') }}/js/slick.min.js"></script>
<script src="{{ asset('assets/frontend') }}/js/custom.js"></script>

<script>
    // Snackbar for user status switcher
    $('#snackbar-user-status label').click(function () {
        Snackbar.show({
            text: 'Your status has been changed!',
            pos: 'bottom-center',
            showAction: false,
            actionText: "Dismiss",
            duration: 3000,
            textColor: '#fff',
            backgroundColor: '#383838'
        });
    });
</script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-database.js"></script>
<script>
    // Your web app's Firebase configuration
    var firebaseConfig = {
        apiKey: "AIzaSyDnxzLj9Iy59RLJTaOW9NbBgIHzwXQM04I",
        authDomain: "joblamp-964ac.firebaseapp.com",
        projectId: "joblamp-964ac",
        storageBucket: "joblamp-964ac.appspot.com",
        messagingSenderId: "719149380094",
        appId: "1:719149380094:web:67081c0bb8250ef2e6d0af",
        measurementId: "G-HF0CPTR6MZ"
    };
    firebase.initializeApp(firebaseConfig);

</script>
<script>
    $(document).ready(function () {
        $('.language-switcher').on('change',function () {
            $('.lang-form').submit();
        });
    });
</script>
@yield('script')

</body>

</html>
