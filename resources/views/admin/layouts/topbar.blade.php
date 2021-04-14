<!-- Header start -->
<header class="header">
    <div class="toggle-btns">
        <a id="toggle-sidebar" href="#">
            <i class="icon-menu"></i>
        </a>
        <a id="pin-sidebar" href="#">
            <i class="icon-menu"></i>
        </a>
    </div>
    <div class="header-items">

        <!-- Header actions start -->
        <ul class="header-actions">
            <li class="dropdown user-settings">
                <a href="#" id="userSettings" data-toggle="dropdown" aria-haspopup="true">
                    <img src="{{ admin_asset('') }}/img/user2.png" class="user-avatar" alt="Avatar">
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userSettings">
                    <div class="header-profile-actions">
                        <div class="header-user-profile">
                            <div class="header-user">
                                <img src="{{ admin_asset('') }}/img/user2.png" alt="Admin Template">
                            </div>
                            <h5>{{ \Illuminate\Support\Facades\Auth::user()->first_name }} {{ \Illuminate\Support\Facades\Auth::user()->last_name }}</h5>
                        </div>
                        <a href="{{ route('admin-logout') }}"><i class="icon-log-out1"></i> {{ __('Sign Out') }}</a>
                    </div>
                </div>
            </li>
        </ul>
        <!-- Header actions end -->
    </div>
</header>
<!-- Header end -->
