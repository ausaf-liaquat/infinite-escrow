<li class="primary-menu__list has-sub">
    <a href="javascript:void(0)" class="primary-menu__link">@lang('Deposit')</a>

    <ul class="primary-menu__sub">
        <li class="primary-menu__sub-list">
            <a href="{{route('user.deposit')}}" class="t-link primary-menu__sub-link">@lang('Deposit Now')</a>
        </li>
        <li class="primary-menu__sub-list">
            <a href="{{route('user.deposit.history')}}" class="t-link primary-menu__sub-link">@lang('Deposit Log')</a>
        </li>
    </ul>
</li>
<li class="primary-menu__list has-sub">
    <a href="javascript:void(0)" class="primary-menu__link">@lang('Escrow')</a>

    <ul class="primary-menu__sub">
        <li class="primary-menu__sub-list">
            <a href="{{route('user.escrow.new')}}" class="t-link primary-menu__sub-link">@lang('New Escrow')</a>
        </li>
        <li class="primary-menu__sub-list">
            <a href="{{route('user.escrow.index')}}" class="t-link primary-menu__sub-link">@lang('My Escrow')</a>
        </li>
    </ul>
</li>
<li class="primary-menu__list has-sub">
    <a href="javascript:void(0)" class="primary-menu__link">@lang('Withdrawal')</a>

    <ul class="primary-menu__sub">
        <li class="primary-menu__sub-list">
            <a href="{{route('user.withdraw')}}" class="t-link primary-menu__sub-link">@lang('Withdraw Now')</a>
        </li>
        <li class="primary-menu__sub-list">
            <a href="{{route('user.withdraw.history')}}" class="t-link primary-menu__sub-link">@lang('Withdrawal Log')</a>
        </li>
    </ul>
</li>
<li class="primary-menu__list">
    <a href="{{route('user.transactions')}}" class="primary-menu__link">@lang('Transactions')</a>
  </li>

<li class="primary-menu__list has-sub">
    <a href="javascript:void(0)" class="primary-menu__link">{{auth()->user()->username}}</a>

    <ul class="primary-menu__sub">
        <li class="primary-menu__sub-list">
            <a href="{{route('ticket.open')}}" class="t-link primary-menu__sub-link">@lang('New Ticket')</a>
        </li>
        <li class="primary-menu__sub-list">
            <a href="{{route('ticket')}}" class="t-link primary-menu__sub-link">@lang('My Tickets')</a>
        </li>
        <li class="primary-menu__sub-list">
            <a href="{{ route('user.change.password') }}" class="t-link primary-menu__sub-link">@lang('Change Password')</a>
        </li>
        <li class="primary-menu__sub-list">
            <a href="{{ route('user.profile.setting') }}" class="t-link primary-menu__sub-link">@lang('Profile Setting')</a>
        </li>
        <li class="primary-menu__sub-list">
            <a href="{{ route('user.twofactor') }}" class="t-link primary-menu__sub-link">@lang('2FA Security')</a>
        </li>
        <li class="primary-menu__sub-list">
            <a href="{{ route('user.logout') }}" class="t-link primary-menu__sub-link">@lang('Logout')</a>
        </li>
    </ul>
</li>
