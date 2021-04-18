<!-- Dashboard Sidebar
        ================================================== -->
<div class="dashboard-sidebar">
    <div class="dashboard-sidebar-inner" data-simplebar>
        <div class="dashboard-nav-container">

            <!-- Responsive Navigation Trigger -->
            <a href="#" class="dashboard-responsive-nav-trigger">
					<span class="hamburger hamburger--collapse">
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</span>
                <span class="trigger-title">{{ __('Dashboard') }}</span>
            </a>

            <!-- Navigation -->
            <div class="dashboard-nav">
                <div class="dashboard-nav-inner">

                    <ul data-submenu-title="Start">
                        <li class="{{ Route::is('dashboard') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}">
                                <i class="icon-material-outline-dashboard"></i>
                                {{ __('Dashboard') }}
                            </a>
                        </li>
                        <li class="{{ Route::is('my.profile') ? 'active' : '' }}">
                            <a href="{{ route('my.profile') }}">
                                <i class="icon-material-outline-dashboard"></i>
                                {{ __('My Profile') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('messages') }}">
                                <i class="icon-material-outline-question-answer"></i>
                                {{ __('Messages') }}
{{--                                <span class="nav-tag">2</span>--}}
                            </a>
                        </li>
                        @if (\Illuminate\Support\Facades\Auth::user()->user_type == 'service_provider')
                            <li class="{{ Route::is('withdraw') ? 'active' : '' }}">
                                <a href="{{ route('withdraw') }}">
                                    <i class="icon-material-outline-account-balance"></i>
                                    {{ __('Withdraw') }}
                                </a>
                            </li>
                        @endif
                    </ul>
                    @auth
                        @if(\Illuminate\Support\Facades\Auth::user()->user_type == 'service_provider')
                            <ul data-submenu-title="Organize and Manage">
                                <li class="{{ Route::is('applied.jobs') ? 'active-submenu' : '' }} {{ Route::is('active.jobs') ? 'active-submenu' : '' }} {{ Route::is('delivered.jobs') ? 'active-submenu' : '' }} {{ Route::is('completed.jobs') ? 'active-submenu' : '' }}">
                                    <a href="#"><i class="icon-material-outline-business-center"></i> Jobs</a>
                                    <ul>
                                        <li>
                                            <a href="{{ route('applied.jobs') }}">
                                                {{ __('Applied Jobs') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('active.jobs') }}">
                                                {{ __('Active Jobs') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('delivered.jobs') }}">
                                                {{ __('Delivered Jobs') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('completed.jobs') }}">
                                                {{ __('Completed Jobs') }}
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        @else
                            <ul data-submenu-title="Organize and Manage">
                                <li class="{{ Route::is('posted.jobs') ? 'active-submenu' : '' }} {{ Route::is('hired.jobs') ? 'active-submenu' : '' }} {{ Route::is('customer.delivered.jobs') ? 'active-submenu' : '' }} {{ Route::is('customer.completed.jobs') ? 'active-submenu' : '' }}">
                                    <a href="#"><i class="icon-material-outline-business-center"></i> Jobs</a>
                                    <ul>
                                        <li>
                                            <a href="{{ route('posted.jobs') }}">
                                                {{ __('Posted Jobs') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('hired.jobs') }}">
                                                {{ __('Hired Jobs') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('customer.delivered.jobs') }}">
                                                {{ __('Delivered Jobs') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('customer.completed.jobs') }}">
                                                {{ __('Completed Jobs') }}
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        @endif
                    @endauth
                    <ul data-submenu-title="Account">
                        <li>
                            <a href="{{ route('user-logout') }}">
                                <i class="icon-material-outline-power-settings-new"></i>
                                {{ __('Logout') }}
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
            <!-- Navigation / End -->

        </div>
    </div>
</div>
<!-- Dashboard Sidebar / End -->
