@if (auth()->guard('admin')->check())
    <div class="sidebar " style="    background: linear-gradient(170deg, black, #2c2c2c);"
        data-background="{{ getImage('assets/admin/images/sidebar/2.jpg', '400x800') }}">
        <button class="res-sidebar-close-btn"><i class="las la-times"></i></button>
        <div class="sidebar__inner">
            <div class="sidebar__logo">
                <a href="{{ route('admin.dashboard') }}" class="sidebar__main-logo"><img
                        src="{{ url('assets/images/logo-admin.png') }}" alt="@lang('image')"></a>
                <a href="{{ route('admin.dashboard') }}" class="sidebar__logo-shape"><img
                        src="{{ getImage(imagePath()['logoIcon']['path'] . '/favicon.png') }}"
                        alt="@lang('image')"></a>
                <button type="button" class="navbar__expand"><img
                        style="max-width: none;    max-width: none;
           position: absolute;
           bottom: 4px;
           right: 4px;"
                        src="{{ url('assets/images/coins.png') }}" alt=""></button>
            </div>

            <div class="sidebar__menu-wrapper" id="sidebar__menuWrapper">
                <ul class="sidebar__menu">
                    <li class="sidebar-menu-item {{ menuActive('admin.dashboard') }}">

                        <a href="{{ route('admin.dashboard') }}" class="nav-link "
                            style=" border-bottom: 1px solid #2c2c2c;">
                            <i class="menu-icon las la-table"></i>
                            <span class="menu-title">@lang('Dashboard')</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item {{ menuActive('admin.category*') }}">
                        <a href="{{ route('admin.category.index') }}" class="nav-link ">
                            <i class="menu-icon las la-list-ul"></i>
                            <span class="menu-title">@lang('Manage Category')</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item {{ menuActive('admin.charge*') }}">
                        <a href="{{ route('admin.charge.index') }}" class="nav-link ">
                            <i class="menu-icon las la-file-invoice-dollar"></i>
                            <span class="menu-title">@lang('Charge')</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a href="javascript:void(0)" class="{{ menuActive('admin.deposit*', 3) }}">
                            <i class="menu-icon las la-hand-holding-usd"></i>
                            <span class="menu-title">@lang('Escrow')</span>
                            @if (0 < $disputed_escrow_count)
                                <span class="menu-badge pill bg--primary ml-auto">
                                    <i class="fa fa-exclamation"></i>
                                </span>
                            @endif
                        </a>
                        <div class="sidebar-submenu {{ menuActive('admin.escrow*', 2) }} ">
                            <ul>
                                <li class="sidebar-menu-item {{ menuActive('admin.escrow.index') }} ">
                                    <a href="{{ route('admin.escrow.index') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('All')</span>
                                    </a>
                                </li>

                                <li class="sidebar-menu-item {{ menuActive('admin.escrow.accepted') }} ">
                                    <a href="{{ route('admin.escrow.accepted') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Accepted')</span>
                                    </a>
                                </li>

                                <li class="sidebar-menu-item {{ menuActive('admin.escrow.not.accepted') }} ">
                                    <a href="{{ route('admin.escrow.not.accepted') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Not Accepted')</span>
                                    </a>
                                </li>


                                <li class="sidebar-menu-item {{ menuActive('admin.escrow.completed') }} ">
                                    <a href="{{ route('admin.escrow.completed') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Completed')</span>
                                    </a>
                                </li>

                                <li class="sidebar-menu-item {{ menuActive('admin.escrow.disputed') }} ">
                                    <a href="{{ route('admin.escrow.disputed') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Disputed')</span>
                                        @if ($disputed_escrow_count)
                                            <span
                                                class="menu-badge pill bg--primary ml-auto">{{ $disputed_escrow_count }}</span>
                                        @endif
                                    </a>
                                </li>

                                <li class="sidebar-menu-item {{ menuActive('admin.escrow.canceled') }} ">
                                    <a href="{{ route('admin.escrow.canceled') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Canceled')</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a href="javascript:void(0)" class="{{ menuActive('admin.users*', 3) }}">
                            <i class="menu-icon las la-users"></i>
                            <span class="menu-title">@lang('Manage Users')</span>

                            @if ($banned_users_count > 0 || $email_unverified_users_count > 0 || $sms_unverified_users_count > 0)
                                <span class="menu-badge pill bg--primary ml-auto">
                                    <i class="fa fa-exclamation"></i>
                                </span>
                            @endif
                        </a>
                        <div class="sidebar-submenu {{ menuActive('admin.users*', 2) }} ">
                            <ul>
                                <li class="sidebar-menu-item {{ menuActive('admin.users.all') }} ">
                                    <a href="{{ route('admin.users.all') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('All Users')</span>
                                    </a>
                                </li>

                                <li class="sidebar-menu-item {{ menuActive('admin.users.active') }} ">
                                    <a href="{{ route('admin.users.active') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Active Users')</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item {{ menuActive('admin.users.banned') }} ">
                                    <a href="{{ route('admin.users.banned') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Banned Users')</span>
                                        @if ($banned_users_count)
                                            <span
                                                class="menu-badge pill bg--primary ml-auto">{{ $banned_users_count }}</span>
                                        @endif
                                    </a>
                                </li>

                                <li class="sidebar-menu-item  {{ menuActive('admin.users.email.unverified') }}">
                                    <a href="{{ route('admin.users.email.unverified') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Email Unverified')</span>

                                        @if ($email_unverified_users_count)
                                            <span
                                                class="menu-badge pill bg--primary ml-auto">{{ $email_unverified_users_count }}</span>
                                        @endif
                                    </a>
                                </li>

                                <li class="sidebar-menu-item {{ menuActive('admin.users.sms.unverified') }}">
                                    <a href="{{ route('admin.users.sms.unverified') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('SMS Unverified')</span>
                                        @if ($sms_unverified_users_count)
                                            <span
                                                class="menu-badge pill bg--primary ml-auto">{{ $sms_unverified_users_count }}</span>
                                        @endif
                                    </a>
                                </li>

                                <li class="sidebar-menu-item {{ menuActive('admin.users.with.balance') }}">
                                    <a href="{{ route('admin.users.with.balance') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('With Balance')</span>
                                    </a>
                                </li>


                                <li class="sidebar-menu-item {{ menuActive('admin.users.email.all') }}">
                                    <a href="{{ route('admin.users.email.all') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Email to All')</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>

                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a href="javascript:void(0)" class="{{ menuActive('admin.gateway*', 3) }}">
                            <i class="menu-icon las la-credit-card"></i>
                            <span class="menu-title">@lang('Payment Gateways')</span>

                        </a>
                        <div class="sidebar-submenu {{ menuActive('admin.gateway*', 2) }} ">
                            <ul>

                                <li class="sidebar-menu-item {{ menuActive('admin.gateway.automatic.index') }} ">
                                    <a href="{{ route('admin.gateway.automatic.index') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Automatic Gateways')</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item {{ menuActive('admin.gateway.manual.index') }} ">
                                    <a href="{{ route('admin.gateway.manual.index') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Manual Gateways')</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a href="javascript:void(0)" class="{{ menuActive('admin.deposit*', 3) }}">
                            <i class="menu-icon las la-credit-card"></i>
                            <span class="menu-title">@lang('Deposits')</span>
                            @if (0 < $pending_deposits_count)
                                <span class="menu-badge pill bg--primary ml-auto">
                                    <i class="fa fa-exclamation"></i>
                                </span>
                            @endif
                        </a>
                        <div class="sidebar-submenu {{ menuActive('admin.deposit*', 2) }} ">
                            <ul>

                                <li class="sidebar-menu-item {{ menuActive('admin.deposit.pending') }} ">
                                    <a href="{{ route('admin.deposit.pending') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Pending Deposits')</span>
                                        @if ($pending_deposits_count)
                                            <span
                                                class="menu-badge pill bg--primary ml-auto">{{ $pending_deposits_count }}</span>
                                        @endif
                                    </a>
                                </li>

                                <li class="sidebar-menu-item {{ menuActive('admin.deposit.approved') }} ">
                                    <a href="{{ route('admin.deposit.approved') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Approved Deposits')</span>
                                    </a>
                                </li>

                                <li class="sidebar-menu-item {{ menuActive('admin.deposit.successful') }} ">
                                    <a href="{{ route('admin.deposit.successful') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Successful Deposits')</span>
                                    </a>
                                </li>


                                <li class="sidebar-menu-item {{ menuActive('admin.deposit.rejected') }} ">
                                    <a href="{{ route('admin.deposit.rejected') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Rejected Deposits')</span>
                                    </a>
                                </li>

                                <li class="sidebar-menu-item {{ menuActive('admin.deposit.list') }} ">
                                    <a href="{{ route('admin.deposit.list') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('All Deposits')</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a href="javascript:void(0)" class="{{ menuActive('admin.withdraw*', 3) }}">
                            <i class="menu-icon la la-bank"></i>
                            <span class="menu-title">@lang('Withdrawals') </span>
                            @if (0 < $pending_withdraw_count)
                                <span class="menu-badge pill bg--primary ml-auto">
                                    <i class="fa fa-exclamation"></i>
                                </span>
                            @endif
                        </a>
                        <div class="sidebar-submenu {{ menuActive('admin.withdraw*', 2) }} ">
                            <ul>

                                <li class="sidebar-menu-item {{ menuActive('admin.withdraw.method.index') }}">
                                    <a href="{{ route('admin.withdraw.method.index') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Withdrawal Methods')</span>
                                    </a>
                                </li>

                                <li class="sidebar-menu-item {{ menuActive('admin.withdraw.pending') }} ">
                                    <a href="{{ route('admin.withdraw.pending') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Pending Log')</span>

                                        @if ($pending_withdraw_count)
                                            <span
                                                class="menu-badge pill bg--primary ml-auto">{{ $pending_withdraw_count }}</span>
                                        @endif
                                    </a>
                                </li>

                                <li class="sidebar-menu-item {{ menuActive('admin.withdraw.approved') }} ">
                                    <a href="{{ route('admin.withdraw.approved') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Approved Log')</span>
                                    </a>
                                </li>

                                <li class="sidebar-menu-item {{ menuActive('admin.withdraw.rejected') }} ">
                                    <a href="{{ route('admin.withdraw.rejected') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Rejected Log')</span>
                                    </a>
                                </li>

                                <li class="sidebar-menu-item {{ menuActive('admin.withdraw.log') }} ">
                                    <a href="{{ route('admin.withdraw.log') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Withdrawals Log')</span>
                                    </a>
                                </li>


                            </ul>
                        </div>
                    </li>

                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a href="javascript:void(0)" class="{{ menuActive('admin.ticket*', 3) }}">
                            <i class="menu-icon la la-ticket"></i>
                            <span class="menu-title">@lang('Support Ticket') </span>
                            @if (0 < $pending_ticket_count)
                                <span class="menu-badge pill bg--primary ml-auto">
                                    <i class="fa fa-exclamation"></i>
                                </span>
                            @endif
                        </a>
                        <div class="sidebar-submenu {{ menuActive('admin.ticket*', 2) }} ">
                            <ul>

                                <li class="sidebar-menu-item {{ menuActive('admin.ticket') }} ">
                                    <a href="{{ route('admin.ticket') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('All Ticket')</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item {{ menuActive('admin.ticket.pending') }} ">
                                    <a href="{{ route('admin.ticket.pending') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Pending Ticket')</span>
                                        @if ($pending_ticket_count)
                                            <span
                                                class="menu-badge pill bg--primary ml-auto">{{ $pending_ticket_count }}</span>
                                        @endif
                                    </a>
                                </li>
                                <li class="sidebar-menu-item {{ menuActive('admin.ticket.closed') }} ">
                                    <a href="{{ route('admin.ticket.closed') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Closed Ticket')</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item {{ menuActive('admin.ticket.answered') }} ">
                                    <a href="{{ route('admin.ticket.answered') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Answered Ticket')</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>


                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a href="javascript:void(0)" class="{{ menuActive('admin.report*', 3) }}">
                            <i class="menu-icon la la-list"></i>
                            <span class="menu-title">@lang('Report') </span>
                        </a>
                        <div class="sidebar-submenu {{ menuActive('admin.report*', 2) }} ">
                            <ul>
                                <li
                                    class="sidebar-menu-item {{ menuActive(['admin.report.transaction', 'admin.report.transaction.search']) }}">
                                    <a href="{{ route('admin.report.transaction') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Transaction Log')</span>
                                    </a>
                                </li>

                                <li
                                    class="sidebar-menu-item {{ menuActive(['admin.report.login.history', 'admin.report.login.ipHistory']) }}">
                                    <a href="{{ route('admin.report.login.history') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Login History')</span>
                                    </a>
                                </li>

                                <li class="sidebar-menu-item {{ menuActive('admin.report.email.history') }}">
                                    <a href="{{ route('admin.report.email.history') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Email History')</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>

                    <li class="sidebar__menu-header">@lang('Settings')</li>

                    <li class="sidebar-menu-item {{ menuActive('admin.setting.index') }}">
                        <a href="{{ route('admin.setting.index') }}" class="nav-link">
                            <i class="menu-icon las la-life-ring"></i>
                            <span class="menu-title">@lang('General Setting')</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item {{ menuActive('admin.setting.logo.icon') }}">
                        <a href="{{ route('admin.setting.logo.icon') }}" class="nav-link">
                            <i class="menu-icon las la-images"></i>
                            <span class="menu-title">@lang('Logo & Favicon')</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item {{ menuActive('admin.extensions.index') }}">
                        <a href="{{ route('admin.extensions.index') }}" class="nav-link">
                            <i class="menu-icon las la-cogs"></i>
                            <span class="menu-title">@lang('Extensions')</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item  {{ menuActive(['admin.language.manage', 'admin.language.key']) }}">
                        <a href="{{ route('admin.language.manage') }}" class="nav-link"
                            data-default-url="{{ route('admin.language.manage') }}">
                            <i class="menu-icon las la-language"></i>
                            <span class="menu-title">@lang('Language') </span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item {{ menuActive('admin.seo') }}">
                        <a href="{{ route('admin.seo') }}" class="nav-link">
                            <i class="menu-icon las la-globe"></i>
                            <span class="menu-title">@lang('SEO Manager')</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a href="javascript:void(0)" class="{{ menuActive('admin.email.template*', 3) }}">
                            <i class="menu-icon la la-envelope-o"></i>
                            <span class="menu-title">@lang('Email Manager')</span>
                        </a>
                        <div class="sidebar-submenu {{ menuActive('admin.email.template*', 2) }} ">
                            <ul>

                                <li class="sidebar-menu-item {{ menuActive('admin.email.template.global') }} ">
                                    <a href="{{ route('admin.email.template.global') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Global Template')</span>
                                    </a>
                                </li>
                                <li
                                    class="sidebar-menu-item {{ menuActive(['admin.email.template.index', 'admin.email.template.edit']) }} ">
                                    <a href="{{ route('admin.email.template.index') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Email Templates')</span>
                                    </a>
                                </li>

                                <li class="sidebar-menu-item {{ menuActive('admin.email.template.setting') }} ">
                                    <a href="{{ route('admin.email.template.setting') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Email Configure')</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a href="javascript:void(0)" class="{{ menuActive('admin.sms.template*', 3) }}">
                            <i class="menu-icon la la-mobile"></i>
                            <span class="menu-title">@lang('SMS Manager')</span>
                        </a>
                        <div class="sidebar-submenu {{ menuActive('admin.sms.template*', 2) }} ">
                            <ul>
                                <li class="sidebar-menu-item {{ menuActive('admin.sms.template.global') }} ">
                                    <a href="{{ route('admin.sms.template.global') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Global Setting')</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item {{ menuActive('admin.sms.templates.setting') }} ">
                                    <a href="{{ route('admin.sms.templates.setting') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('SMS Gateways')</span>
                                    </a>
                                </li>
                                <li
                                    class="sidebar-menu-item {{ menuActive(['admin.sms.template.index', 'admin.sms.template.edit']) }} ">
                                    <a href="{{ route('admin.sms.template.index') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('SMS Templates')</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="sidebar__menu-header">@lang('Frontend Manager')</li>

                    <li class="sidebar-menu-item {{ menuActive('admin.frontend.templates') }}">
                        <a href="{{ route('admin.frontend.templates') }}" class="nav-link ">
                            <i class="menu-icon la la-html5"></i>
                            <span class="menu-title">@lang('Manage Templates')</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item {{ menuActive('admin.frontend.manage.pages') }}">
                        <a href="{{ route('admin.frontend.manage.pages') }}" class="nav-link ">
                            <i class="menu-icon la la-list"></i>
                            <span class="menu-title">@lang('Manage Pages')</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a href="javascript:void(0)" class="{{ menuActive('admin.frontend.sections*', 3) }}">
                            <i class="menu-icon la la-html5"></i>
                            <span class="menu-title">@lang('Manage Section')</span>
                        </a>
                        <div class="sidebar-submenu {{ menuActive('admin.frontend.sections*', 2) }} ">
                            <ul>
                                @php
                                    $lastSegment = collect(request()->segments())->last();
                                @endphp
                                @foreach (getPageSections(true) as $k => $secs)
                                    @if ($secs['builder'])
                                        <li
                                            class="sidebar-menu-item  @if ($lastSegment == $k) active @endif ">
                                            <a href="{{ route('admin.frontend.sections', $k) }}" class="nav-link">
                                                <i class="menu-icon las la-dot-circle"></i>
                                                <span class="menu-title">{{ __($secs['name']) }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach


                            </ul>
                        </div>
                    </li>

                    <li class="sidebar__menu-header">@lang('Extra')</li>


                    <li class="sidebar-menu-item {{ menuActive('admin.setting.cookie') }}">
                        <a href="{{ route('admin.setting.cookie') }}" class="nav-link">
                            <i class="menu-icon las la-cookie-bite"></i>
                            <span class="menu-title">@lang('GDPR Cookie')</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item  {{ menuActive('admin.system.info') }}">
                        <a href="{{ route('admin.system.info') }}" class="nav-link"
                            data-default-url="{{ route('admin.system.info') }}">
                            <i class="menu-icon las la-server"></i>
                            <span class="menu-title">@lang('System Information') </span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item {{ menuActive('admin.setting.custom.css') }}">
                        <a href="{{ route('admin.setting.custom.css') }}" class="nav-link">
                            <i class="menu-icon lab la-css3-alt"></i>
                            <span class="menu-title">@lang('Custom CSS')</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item {{ menuActive('admin.setting.optimize') }}">
                        <a href="{{ route('admin.setting.optimize') }}" class="nav-link">
                            <i class="menu-icon las la-broom"></i>
                            <span class="menu-title">@lang('Clear Cache')</span>
                        </a>
                    </li>

                    <li class="sidebar-menu-item  {{ menuActive('admin.request.report') }}">
                        <a href="{{ route('admin.request.report') }}" class="nav-link"
                            data-default-url="{{ route('admin.request.report') }}">
                            <i class="menu-icon las la-bug"></i>
                            <span class="menu-title">@lang('Report & Request') </span>
                        </a>
                    </li>
                </ul>
                {{-- <div class="text-center mb-3 text-uppercase">
           <span class="text--primary">{{__(systemDetails()['name'])}}</span>
           <span class="text--success">@lang('V'){{systemDetails()['version']}} </span>
       </div> --}}
            </div>
        </div>
    </div>
    <!-- sidebar end -->
@else
    <div class="sidebar " style="    background: linear-gradient(170deg, black, #2c2c2c);"
        data-background="{{ getImage('assets/admin/images/sidebar/2.jpg', '400x800') }}">
        <button class="res-sidebar-close-btn"><i class="las la-times"></i></button>
        <div class="sidebar__inner">
            <div class="sidebar__logo">
                <a href="{{ route('home') }}" class="sidebar__main-logo"><img
                        src="{{ url('assets/images/logo-admin.png') }}" alt="@lang('image')"></a>
                <a href="{{ route('home') }}" class="sidebar__logo-shape"><img
                        src="{{ getImage(imagePath()['logoIcon']['path'] . '/favicon.png') }}"
                        alt="@lang('image')"></a>
                <button type="button" class="navbar__expand"><img
                        style="max-width: none;    max-width: none;
                        position: absolute;
                        bottom: 4px;
                        right: 4px;"
                        src="{{ url('assets/images/coins.png') }}" alt=""></button>
            </div>

            <div class="sidebar__menu-wrapper" id="sidebar__menuWrapper">
                <ul class="sidebar__menu">
                    <li class="sidebar-menu-item {{ menuActive('user.home') }}">

                        <a href="{{ route('user.home') }}" class="nav-link "
                            style=" border-bottom: 1px solid #2c2c2c;">
                            {{-- <i class="menu-icon las la-table"></i> --}}
                            <img src="{{ url('') }}/assets/images/dash-icon2.png" alt="">
                            <span class="menu-title">@lang('Dashboard')</span>
                        </a>
                    </li>

                    @php
                        $escrow = $escrows = App\Models\Escrow::where(function ($query) {
                            $query->orWhere('buyer_id', auth()->user()->id)->orWhere('seller_id', auth()->user()->id);
                        });
                        
                        $escrow1 = clone $escrow;
                        $escrow2 = clone $escrow;
                        $escrow3 = clone $escrow;
                        $escrow4 = clone $escrow;
                        $escrow5 = clone $escrow;
                        $escrow6 = clone $escrow;
                        
                        $totalEscrow = $escrow1->count();
                        $accepted = $escrow2->where('status', 2)->count();
                        $notAccepted = $escrow3->where('status', 0)->count();
                        $completed = $escrow4->where('status', 1)->count();
                        $cancelled = $escrow5->where('status', 9)->count();
                        $disputed = $escrow6->where('status', 8)->count();
                    @endphp
                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a href="javascript:void(0)" class="{{ menuActive('user.deposit*', 3) }}">
                            {{-- <i class="menu-icon las la-hand-holding-usd"></i> --}}
                            <img src="{{ url('') }}/assets/images/dash-icon1.png" alt="">
                            <span class="menu-title">@lang('Escrow')</span>

                        </a>
                        <div class="sidebar-submenu {{ menuActive('user.escrow*', 2) }} ">
                            <ul>
                                <li
                                    class="sidebar-menu-item {{ request()->route('type') == 'not-accepted' ? 'active' : '' }} ">
                                    @if ($notAccepted > 0)
                                        <span class="icon-button__badge" style="background: #FFD700;">{{ $notAccepted }}</span>
                                    @endif <a
                                        href="{{ route('user.escrow.index', 'not-accepted') }}" class="nav-link">
                                        {{-- <i class="menu-icon las la-dot-circle"></i> --}}
                                        <span class="menu-title">@lang('Awaiting for Accept')</span>
                                    </a>
                                </li>
                                <li
                                    class="sidebar-menu-item {{ request()->route('type') == 'completed' ? 'active' : '' }}">
                                    @if ($completed > 0)
                                        <span class="icon-button__badge" style="background: #32CD32;">{{ $completed }}</span>
                                    @endif <a
                                        href="{{ route('user.escrow.index', 'completed') }}" class="nav-link">
                                        {{-- <i class="menu-icon las la-dot-circle"></i> --}}
                                        <span class="menu-title">@lang('Completed')</span>
                                    </a>
                                </li>
                                <li
                                    class="sidebar-menu-item {{ request()->route('type') == 'disputed' ? 'active' : '' }} ">
                                    @if ($disputed > 0)
                                        <span class="icon-button__badge" style="background: #FF0000;">{{ $disputed }}</span>
                                    @endif <a
                                        href="{{ route('user.escrow.index', 'disputed') }}" class="nav-link">
                                        {{-- <i class="menu-icon las la-dot-circle"></i> --}}
                                        <span class="menu-title">@lang('Disputed')</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item {{ request()->route('type') == 'canceled' ? 'active' : '' }}">
                                    @if ($cancelled > 0)
                                        <span class="icon-button__badge" style="background: #808080;">{{ $cancelled }}</span>
                                    @endif <a
                                        href="{{ route('user.escrow.index', 'canceled') }}" class="nav-link">
                                        {{-- <i class="menu-icon las la-dot-circle"></i> --}}
                                        <span class="menu-title">@lang('Canceled')</span>
                                    </a>
                                </li>
                                <li
                                    class="sidebar-menu-item {{ Route::currentRouteName() == 'user.escrow.index' && request()->route('type') == null ? 'active' : '' }} ">
                                    @if ($totalEscrow > 0)
                                        <span class="icon-button__badge" style="background: #4169E1;">{{ $totalEscrow }}</span>
                                    @endif <a href="{{ route('user.escrow.index') }}"
                                        class="nav-link">
                                        {{-- <i class="menu-icon las la-dot-circle"></i> --}}
                                        <span class="menu-title">@lang('Your Escrow')</span>
                                    </a>
                                </li>

                                <li class="sidebar-menu-item {{ request()->route('type') == 'accepted' ? 'active' : '' }}">
                                    @if ($accepted > 0)
                                        <span class="icon-button__badge" style="background: #FFA500;">{{ $accepted }}</span>
                                    @endif <a
                                        href="{{ route('user.escrow.index', 'accepted') }}" class="nav-link">
                                        {{-- <i class="menu-icon las la-dot-circle"></i> --}}
                                        <span class="menu-title">@lang('Running Escrow')</span>
                                    </a>
                                </li>
                                {{-- <li class="sidebar-menu-item {{ menuActive('user.escrow.new') }} ">
                                    <a href="{{ route('user.escrow.new') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('New Escrow')</span>
                                    </a>
                                </li> --}}
                                {{-- <li class="sidebar-menu-item {{ menuActive('user.escrow.index') }} ">
                                    <a href="{{ route('user.escrow.index') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('All')</span>
                                    </a>
                                </li> --}}

                                {{-- <li class="sidebar-menu-item {{ menuActive('admin.escrow.accepted') }} ">
                                    <a href="{{ route('admin.escrow.accepted') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Accepted')</span>
                                    </a>
                                </li>

                                <li class="sidebar-menu-item {{ menuActive('admin.escrow.not.accepted') }} ">
                                    <a href="{{ route('admin.escrow.not.accepted') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Not Accepted')</span>
                                    </a>
                                </li>


                                <li class="sidebar-menu-item {{ menuActive('admin.escrow.completed') }} ">
                                    <a href="{{ route('admin.escrow.completed') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Completed')</span>
                                    </a>
                                </li>

                                <li class="sidebar-menu-item {{ menuActive('admin.escrow.disputed') }} ">
                                    <a href="{{ route('admin.escrow.disputed') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Disputed')</span>
                                        @if ($disputed_escrow_count)
                                            <span
                                                class="menu-badge pill bg--primary ml-auto">{{ $disputed_escrow_count }}</span>
                                        @endif
                                    </a>
                                </li>

                                <li class="sidebar-menu-item {{ menuActive('admin.escrow.canceled') }} ">
                                    <a href="{{ route('admin.escrow.canceled') }}" class="nav-link">
                                        <i class="menu-icon las la-dot-circle"></i>
                                        <span class="menu-title">@lang('Canceled')</span>
                                    </a>
                                </li> --}}
                            </ul>
                        </div>
                    </li>

                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a href="javascript:void(0)" class="{{ menuActive('user.deposit*', 3) }}">
                            {{-- <i class="menu-icon las la-credit-card"></i> --}}
                            <img src="{{ url('') }}/assets/images/dash-icon3.png" alt="">
                            <span class="menu-title">@lang('Deposits')</span>
                            @if (0 < $pending_deposits_count)
                                <span class="menu-badge pill bg--primary ml-auto">
                                    <i class="fa fa-exclamation"></i>
                                </span>
                            @endif
                        </a>
                        <div class="sidebar-submenu {{ menuActive('user.deposit*', 2) }} ">
                            <ul>

                                <li class="sidebar-menu-item {{ menuActive('user.deposit.history') }} ">
                                    <a href="{{ route('user.deposit.history') }}" class="nav-link">
                                        {{-- <i class="menu-icon las la-dot-circle"></i> --}}
                                        <span class="menu-title">@lang('My Deposit')</span>

                                    </a>
                                </li>

                                <li class="sidebar-menu-item {{ menuActive('user.deposit') }} ">
                                    <a href="{{ route('user.deposit') }}" class="nav-link">
                                        {{-- <i class="menu-icon las la-dot-circle"></i> --}}
                                        <span class="menu-title">@lang('Deposit Now')</span>
                                    </a>
                                </li>


                            </ul>
                        </div>
                    </li>

                    <li class="sidebar-menu-item sidebar-dropdown">
                        <a href="javascript:void(0)" class="{{ menuActive('user.withdraw*', 3) }}">
                            {{-- <i class="menu-icon la la-bank"></i> --}}
                            <img src="{{ url('') }}/assets/images/dash-icon3.png" alt="">
                            <span class="menu-title">@lang('Withdrawals') </span>

                        </a>
                        <div class="sidebar-submenu {{ menuActive('user.withdraw*', 2) }} ">
                            <ul>

                                <li class="sidebar-menu-item {{ menuActive('user.withdraw') }}">
                                    <a href="{{ route('user.withdraw') }}" class="nav-link">
                                        {{-- <i class="menu-icon las la-dot-circle"></i> --}}
                                        <span class="menu-title">@lang('Withdrawal Now')</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item {{ menuActive('user.withdraw.history') }}">
                                    <a href="{{ route('user.withdraw.history') }}" class="nav-link">
                                        {{-- <i class="menu-icon las la-dot-circle"></i> --}}
                                        <span class="menu-title">@lang('Withdrawal Log')</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>
                    <li class="sidebar-menu-item {{ menuActive('user.transactions') }}">

                        <a href="{{ route('user.transactions') }}" class="nav-link "
                            style=" border-top: 1px solid #2c2c2c;">
                            {{-- <i class="menu-icon las la-money-check"></i> --}}
                            <img src="{{ url('') }}/assets/images/dash-icon3.png" alt="">
                            <span class="menu-title">@lang('Transaction')</span>
                        </a>
                    </li>

                </ul>
                <div class="text-center mb-3 text-uppercase">
                    <a class="btn" href="{{route('user.escrow.new')}}" style="    background: #96ff0e;
                    border: none;
                    /* padding: 13px; */
                    border-radius: 0px;
                    font-weight: 700;
                    font-size: 13px;
                    padding-left: 52px;
                    padding-right: 52px;
                    padding-top: 22px;
                    padding-bottom: 21px;">
                      <i class="fas fa-plus"></i>   New Escrow
                    </a>
                </div> 
            </div>
        </div>
    </div>
@endif

<!-- sidebar end -->
