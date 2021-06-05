<!-- Sidebar wrapper start -->
<nav id="sidebar" class="sidebar-wrapper">

    <!-- Sidebar brand start  -->
    <div class="sidebar-brand">
        <a target="_blank" href="{{ route('home') }}" class="logo">JobLamp</a>
    </div>
    <!-- Sidebar brand end  -->

    <!-- User profile start -->
    <div class="sidebar-user-details">
        <div class="user-profile">
            <img src="{{ admin_asset('') }}/img/user2.png" class="profile-thumb" alt="User Thumb">
            <span class="status-label"></span>
        </div>
        <h6 class="profile-name">{{ \Illuminate\Support\Facades\Auth::user()->first_name }} {{ \Illuminate\Support\Facades\Auth::user()->last_name }}</h6>
        <div class="profile-actions">
            <a href="{{ route('admin-logout') }}" class="red" data-toggle="tooltip" data-placement="top" title=""
               data-original-title="{{ __('Logout') }}">
                <i class="icon-power1"></i>
            </a>
        </div>
    </div>
    <!-- User profile end -->

    <!-- Sidebar content start -->
    <div class="sidebar-content">

        <!-- sidebar menu start -->
        <div class="sidebar-menu">
            <ul>
                <li class="{{ Route::is('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}"
                       class="{{ Route::is('admin.dashboard') ? 'current-page' : '' }}">
                        <i class="icon-home2"></i>
                        <span class="menu-text">Dashboards</span>
                    </a>
                </li>
                @if(\Illuminate\Support\Facades\Auth::user()->user_type == 'admin')
                    <li class="sidebar-dropdown {{ Route::is('admin.country') ? 'active' : '' }} {{ Route::is('admin.states') ? 'active' : '' }} {{ Route::is('admin.add.state') ? 'active' : '' }} {{ Route::is('admin.edit.state') ? 'active' : '' }} {{ Route::is('admin.add.country') ? 'active' : '' }} {{ Route::is('admin.edit.country') ? 'active' : '' }} {{ Route::is('admin.cities') ? 'active' : '' }} {{ Route::is('admin.add.city') ? 'active' : '' }} {{ Route::is('admin.edit.city') ? 'active' : '' }} {{ Route::is('admin.cities') ? 'active' : '' }} {{ Route::is('admin.add.city') ? 'active' : '' }} {{ Route::is('admin.edit.city') ? 'active' : '' }}">
                        <a href="javascript:void(0);">
                            <i class="icon-map-pin"></i>
                            <span class="menu-text">{{ __('Locations') }}</span>
                        </a>
                        <div class="sidebar-submenu">
                            <ul>
                                <li>
                                    <a class="{{ Route::is('admin.country') ? 'current-page' : '' }} {{ Route::is('admin.add.country') ? 'active' : '' }} {{ Route::is('admin.edit.country') ? 'active' : '' }}"
                                       href="{{ route('admin.country') }}">{{ __('Countries') }}</a>
                                </li>
                                <li>
                                    <a class="{{ Route::is('admin.states') ? 'current-page' : '' }} {{ Route::is('admin.add.state') ? 'current-page' : '' }} {{ Route::is('admin.edit.state') ? 'current-page' : '' }}"
                                       href="{{ route('admin.states') }} ">{{ __('States') }}</a>
                                </li>

                                <li>
                                    <a class="{{ Route::is('admin.cities') ? 'current-page' : '' }} {{ Route::is('admin.add.city') ? 'current-page' : '' }} {{ Route::is('admin.edit.city') ? 'current-page' : '' }}"
                                       href="{{ route('admin.cities') }} ">{{ __('Cities') }}</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="{{ Route::is('admin.customers') ? 'active' : '' }} {{ Route::is('admin.edit.customer') ? 'active' : '' }}">
                        <a href="{{ route('admin.customers') }}"
                           class="{{ Route::is('admin.customers') ? 'current-page' : '' }} {{ Route::is('admin.edit.customer') ? 'current-page' : '' }}">
                            <i class="icon-users"></i>
                            <span class="menu-text">{{ __('Task Giver') }}</span>
                        </a>
                    </li>

                    <li class="sidebar-dropdown {{ Route::is('admin.job.categories') ? 'active' : '' }} {{ Route::is('admin.edit.job.category') ? 'active' : '' }} {{ Route::is('admin.add.job.category') ? 'active' : '' }}
                    {{ Route::is('admin.job.subcategories') ? 'active' : '' }} {{ Route::is('admin.edit.job.subcategory') ? 'active' : '' }} {{ Route::is('admin.add.job.subcategory') ? 'active' : '' }}
                        ">
                        <a href="javascript:void(0);">
                            <i class="icon-map-pin"></i>
                            <span class="menu-text">{{ __('Job Category') }}</span>
                        </a>
                        <div class="sidebar-submenu">
                            <ul>
                                <li>
                                    <a href="{{ route('admin.job.categories') }}"
                                       class="{{ Route::is('admin.job.categories') ? 'current-page' : '' }} {{ Route::is('admin.edit.job.category') ? 'current-page' : '' }} {{ Route::is('admin.add.job.category') ? 'current-page' : '' }}">
                                        {{ __('Categories') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.job.subcategories') }}"
                                       class="{{ Route::is('admin.job.subcategories') ? 'current-page' : '' }} {{ Route::is('admin.edit.job.subcategory') ? 'current-page' : '' }} {{ Route::is('admin.add.job.subcategory') ? 'current-page' : '' }}">
                                        {{ __('Sub Categories') }}
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </li>

                    <li class="{{ Route::is('admin.contractors') ? 'active' : '' }} {{ Route::is('admin.edit.contractor') ? 'active' : '' }}">
                        <a href="{{ route('admin.contractors') }}"
                           class="{{ Route::is('admin.contractors') ? 'current-page' : '' }} {{ Route::is('admin.edit.contractor') ? 'current-page' : '' }}">
                            <i class="icon-user-plus"></i>
                            <span class="menu-text">{{ __('Task Worker') }}</span>
                        </a>

                    </li>
                @endif
                <li class="sidebar-dropdown {{ Route::is('admin.jobs') ? 'active' : '' }} {{ Route::is('admin.edit.job') ? 'active' : '' }} {{ Route::is('admin.view.job') ? 'active' : '' }} {{ Route::is('admin.disputed.jobs') ? 'active' : '' }} {{ Route::is('admin.view.dispute.job') ? 'active' : '' }}">
                    <a href="javascript:void(0);">
                        <i class="icon-book"></i>
                        <span class="menu-text">{{ __('Jobs') }}</span>
                    </a>

                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('admin.jobs') }}"
                                   class="{{ Route::is('admin.jobs') ? 'current-page' : '' }} {{ Route::is('admin.edit.job') ? 'current-page' : '' }}">
                                    <span class="menu-text">{{ __('All Jobs') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.disputed.jobs') }}"
                                   class="{{ Route::is('admin.disputed.jobs') ? 'current-page' : '' }} {{ Route::is('admin.view.dispute.job') ? 'current-page' : '' }}">
                                    {{ __('Disputed Jobs') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @if(\Illuminate\Support\Facades\Auth::user()->user_type == 'admin')
                    <li class="{{ Route::is('admin.subscription.plans') ? 'active' : '' }} {{ Route::is('admin.subscription.plan.add') ? 'active' : '' }} {{ Route::is('admin.subscription.plan.edit') ? 'active' : '' }}">
                        <a href="{{ route('admin.subscription.plans') }}"
                           class="{{ Route::is('admin.subscription.plans') ? 'current-page' : '' }}  {{ Route::is('admin.subscription.plan.add') ? 'current-page' : '' }} {{ Route::is('admin.subscription.plan.edit') ? 'current-page' : '' }}">
                            <i class="icon-list"></i>
                            <span class="menu-text">{{ __('Subscription Plans') }}</span>
                        </a>
                    </li>
                @endif
                <li class="{{ Route::is('admin.transactions') ? 'active' : '' }}">
                    <a href="{{ route('admin.transactions') }}"
                       class="{{ Route::is('admin.transactions') ? 'current-page' : '' }}">
                        <i class="icon-attach_money"></i>
                        <span class="menu-text">Transactions</span>
                    </a>
                </li>
                @if(\Illuminate\Support\Facades\Auth::user()->user_type == 'admin')
                    <li class="{{ Route::is('edit.charge') ? 'active' : '' }}">
                        <a href="{{ route('edit.charge') }}"
                           class="{{ Route::is('edit.charge') ? 'current-page' : '' }}">
                            <i class="icon-attach_money"></i>
                            <span class="menu-text">{{ __('Charge and Commission') }}</span>
                        </a>
                    </li>
                    <li class="{{ Route::is('admin.cs.persons') ? 'active' : '' }} {{ Route::is('admin.edit.cs.person') ? 'active' : '' }} {{ Route::is('admin.create.cs.person') ? 'active' : '' }}">
                        <a href="{{ route('admin.cs.persons') }}"
                           class="{{ Route::is('admin.cs.persons') ? 'current-page' : '' }} {{ Route::is('admin.edit.cs.person') ? 'current-page' : '' }} {{ Route::is('admin.create.cs.person') ? 'current-page' : '' }}">
                            <i class="icon-user-check"></i>
                            <span class="menu-text">{{ __('Customer Service Person') }}</span>
                        </a>
                    </li>
                @endif
                <li class="{{ Route::is('admin.supports') ? 'active' : '' }}">
                    <a href="{{ route('admin.supports') }}"
                       class="{{ Route::is('admin.supports') ? 'current-page' : '' }}">
                        <i class="icon-help"></i>
                        <span class="menu-text">{{ __('Contact Supports') }}</span>
                    </a>
                </li>
                <li class="sidebar-dropdown {{ Route::is('admin.withdraw.not.paid') ? 'active' : '' }} {{ Route::is('admin.withdraw.paid') ? 'active' : '' }} {{ Route::is('admin.withdraw.pending.payouts') ? 'active' : '' }}">
                    <a href="javascript:void(0);">
                        <i class="icon-attach_money"></i>
                        <span class="menu-text">{{ __('Withdraw Requests') }}</span>
                    </a>

                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('admin.withdraw.not.paid') }}"
                                   class="{{ Route::is('admin.withdraw.not.paid') ? 'current-page' : '' }}">
                                    <span class="menu-text">{{ __('Not Paid') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.withdraw.paid') }}"
                                   class="{{ Route::is('admin.withdraw.paid') ? 'current-page' : '' }}">
                                    {{ __('Paid') }}
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('admin.withdraw.pending.payouts') }}"
                                   class="{{ Route::is('admin.withdraw.pending.payouts') ? 'current-page' : '' }}">
                                    {{ __('Pending Payouts') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @if(\Illuminate\Support\Facades\Auth::user()->user_type == 'admin')
                    <li class="sidebar-dropdown {{ Route::is('admin.banners') ? 'active' : '' }} {{ Route::is('admin.create.banner') ? 'active' : '' }} {{ Route::is('admin.page.privacy.policy') ? 'active' : '' }} {{ Route::is('admin.page.terms.conditions') ? 'active' : '' }} {{ Route::is('admin.page.about.us') ? 'active' : '' }}">
                        <a href="javascript:void(0);">
                            <i class="icon-laptop_mac"></i>
                            <span class="menu-text">{{ __('Frontend') }}</span>
                        </a>

                        <div class="sidebar-submenu">
                            <ul>
                                <li>
                                    <a href="{{ route('admin.banners') }}"
                                       class="{{ Route::is('admin.banners') ? 'current-page' : '' }} {{ Route::is('admin.create.banner') ? 'current-page' : '' }}">
                                        <span class="menu-text">{{ __('Banner Management') }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.page.privacy.policy') }}"
                                       class="{{ Route::is('admin.page.privacy.policy') ? 'current-page' : '' }}">
                                        <span class="menu-text">{{ __('Privacy Policy') }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.page.terms.conditions') }}"
                                       class="{{ Route::is('admin.page.terms.conditions') ? 'current-page' : '' }}">
                                        <span class="menu-text">{{ __('Terms and Conditions') }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.page.about.us') }}"
                                       class="{{ Route::is('admin.page.about.us') ? 'current-page' : '' }}">
                                        <span class="menu-text">{{ __('About Us') }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.page.accessibility') }}"
                                       class="{{ Route::is('admin.page.accessibility') ? 'current-page' : '' }}">
                                        <span class="menu-text">{{ __('Accessibility') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="{{ Route::is('admin.skills') ? 'active' : '' }}">
                        <a href="{{ route('admin.skills') }}"
                           class="{{ Route::is('admin.skills') ? 'current-page' : '' }}">
                            <i class="icon-account_box"></i>
                            <span class="menu-text">Skill Management</span>
                        </a>
                    </li>
                    <li class="{{ Route::is('admin.lotto.users') ? 'active' : '' }}">
                        <a href="{{ route('admin.lotto.users') }}"
                           class="{{ Route::is('admin.lotto.users') ? 'current-page' : '' }}">
                            <i class="icon-user-plus"></i>
                            <span class="menu-text">{{ __('Lotto Users') }}</span>
                        </a>
                    </li>
                    <li class="{{ Route::is('admin.create.notification') ? 'active' : '' }}">
                        <a href="{{ route('admin.create.notification') }}"
                           class="{{ Route::is('admin.create.notification') ? 'current-page' : '' }}">
                            <i class="icon-bell"></i>
                            <span class="menu-text">{{ __('Create Notification') }}</span>
                        </a>
                    </li>
                    <li class="{{ Route::is('admin.lotto.prizes') ? 'active' : '' }}">
                        <a href="{{ route('admin.lotto.prizes') }}"
                           class="{{ Route::is('admin.lotto.prizes') ? 'current-page' : '' }}">
                            <i class="icon-gift"></i>
                            <span class="menu-text">{{ __('Lotto Prizes') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/languages') }}">
                            <i class="icon-attach_money"></i>
                            <span class="menu-text">{{ __('Languages') }}</span>
                        </a>
                    </li>
                @endif

            </ul>
        </div>
        <!-- sidebar menu end -->

    </div>
    <!-- Sidebar content end -->

</nav>
<!-- Sidebar wrapper end -->
<!-- Page content start  -->
<div class="page-content">
