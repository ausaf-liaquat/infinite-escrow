@extends('admin.layouts.app')
@section('panel')
    <section class="section dashboard-section">
        <div class="container">
            {{-- <select class="currency_exchange input-group-text bg--base text-black mb-4"
                style="color:black; background-color:white;" name="" id="amount_sym">
               
                <option value="NGN">NGN</option>
                <option value="USD">USD</option>
                <option value="USDC">USDC</option>
                <option value="BTC">BTC</option>
                <option value="ETH">ETH</option>
            </select> --}}
            <select name='currency_sym' class=" currency_exchange form-control currency_sym form--select" id="amount_sym">
                <option value='NGN' data-src="{{ url('') }}/images/ngn.svg">NGN
                </option>
                <option value='USD' data-src="{{ url('') }}/images/usd.svg">USD
                </option>
                <option value='USDC' data-src="{{ url('') }}/images/usdc.svg">USDC
                </option>
                <option value='BTC' data-src="{{ url('') }}/images/btc.svg">BTC
                </option>
                <option value='ETH' data-src="{{ url('') }}/images/eth.png">Ethereum
                </option>
            </select>
            <div class="row">
                <div class="col-lg-12">
                    <div class="row g-4">
                        <div class="col-md-6 col-lg-6">
                            <a href="{{ route('user.transactions') }}" class="">
                                <div class="dashboard-w1 bg--white b-radius--2 box-shadow dash-card">
                                    <div class="dash-card__header d-flex align-items-center justify-content-between">
                                        <div class="dash-card__icon icon icon--circle icon--md me-3">
                                            <i class="fas fa-wallet"></i>
                                        </div>


                                    </div>
                                    <div class="dash-card__body">
                                        <h5 class="dash-card__title mb-2 text-clr"
                                            style="position: absolute;
                                    left: 23px;
                                    top: 92px;">
                                            @lang('Balance')</h5>
                                        <input type="hidden" name="" id="balanceAmount"
                                            value="{{ $user->balance }}">
                                        <h6 class="my-0 balanceAmount_change"
                                            style="    position: relative;
                                    top: 40px;">
                                            {{ showAmount($user->balance) }}
                                            {{ $general->cur_text }}</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <a href="{{ route('user.deposit.history') }}">
                                <div class="dashboard-w1 bg--white b-radius--2 box-shadow dash-card">
                                    <div class="dash-card__header d-flex align-items-center justify-content-between">
                                        <div class="dash-card__icon icon icon--circle icon--md me-3">
                                            <i class="fas fa-piggy-bank"></i>
                                        </div>
                                    </div>
                                    <div class="dash-card__body">
                                        <input type="hidden" name="" id="depositAmount_total"
                                            value="{{ $user->deposits->where('status', 1)->sum('amount') }}">
                                        <h5 class="dash-card__title mb-2 text-clr">@lang('Deposited')</h5>
                                        <h6 class="my-0 depositAmount_change">
                                            {{ showAmount($user->deposits->where('status', 1)->sum('amount')) }}
                                            {{ $general->cur_text }}</h6>
                                    </div>
                                </div>
                            </a>

                        </div>
                        <div class="col-md-6 col-lg-6 mt-3">
                            <a href="{{ route('user.withdraw.history') }}">
                                <div class="dashboard-w1 bg--white b-radius--2 box-shadow dash-card">
                                    <div class="dash-card__header d-flex align-items-center justify-content-between">
                                        <div class="dash-card__icon icon icon--circle icon--md me-3">
                                            <i class="fas fa-university"></i>
                                        </div>
                                    </div>
                                    <div class="dash-card__body">
                                        <input type="hidden" name="" id="withdrawAmount_total"
                                            value="{{ $user->withdrawals->where('status', 1)->sum('amount') }}">
                                        <h5 class="dash-card__title mb-2 text-clr">@lang('Withdrawn')</h5>
                                        <h6 class="my-0 withdrawAmount_change">
                                            {{ showAmount($user->withdrawals->where('status', 1)->sum('amount')) }}
                                            {{ $general->cur_text }}</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 col-lg-6 mt-3">
                            <a href="{{ route('user.escrow.index') }}">
                                <div class="dashboard-w1 bg--white b-radius--2 box-shadow dash-card">
                                    <div class="dash-card__header d-flex align-items-center justify-content-between">
                                        <div class="dash-card__icon icon icon--circle icon--md me-3">
                                            <i class="fas fa-university"></i>
                                        </div>
                                    </div>
                                    <div class="dash-card__body">
                                        <h5 class="dash-card__title mb-2 text-clr">
                                            @lang('Milestone Funded')
                                        </h5>
                                        <input type="hidden" id="milestoneAmount_total"
                                            value="{{ $user->milestones->where('payment_status', 1)->sum('amount') }}">
                                        <h6 class="my-0 milestoneAmount_change">
                                            {{ showAmount($user->milestones->where('payment_status', 1)->sum('amount')) }}
                                            {{ $general->cur_text }}</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                        {{-- <div class="col-md-6 col-lg-6 mt-3">
                            <div class="dashboard-w1 bg--white b-radius--2 box-shadow dash-card">
                                <div class="dash-card__header d-flex align-items-center justify-content-between">
                                    <div class="dash-card__icon icon icon--circle icon--md me-3">
                                        <i class="fas fa-piggy-bank"></i>
                                    </div>
                                    <a href="{{ route('user.deposit.history', 'pending') }}" class="t-link dash-card__btn">
                                         <i class="fas fa-angle-right"></i> </a>
                                </div>
                                <div class="dash-card__body">
                                    <h5 class="dash-card__title mb-2 text-clr">
                                        @lang('Pending Deposit')
                                    </h5>
                                    <input type="hidden" name="" id="depositAmountPending_total"
                                        value="{{ $user->deposits->where('status', 2)->sum('amount') }}">
                                    <h6 class="my-0 depositAmountPending_change">
                                        {{ showAmount($user->deposits->where('status', 2)->sum('amount')) }}
                                        {{ $general->cur_text }}</h6>
                                </div>
                            </div>
                        </div> --}}
                        {{-- <div class="col-md-4 col-lg-3">
                            <div class="dashboard-w1 bg--white b-radius--2 box-shadow dash-card">
                                <div class="dash-card__header d-flex align-items-center justify-content-between">
                                    <div class="dash-card__icon icon icon--circle icon--md me-3">
                                        <i class="fas fa-university"></i>
                                    </div>
                                    <a href="{{ route('user.withdraw.history', 'pending') }}" class="t-link dash-card__btn">
                                         <i class="fas fa-angle-right"></i> </a>
                                </div>
                                <div class="dash-card__body">
                                    <h5 class="dash-card__title mb-2 text-clr">
                                        @lang('Pending Withdrawal')
                                    </h5>
                                    <input type="hidden" name="" id="withdrawAmountPending_total"
                                        value="{{ $user->withdrawals->where('status', 2)->sum('amount') }}">
                                    <h6 class="my-0 withdrawAmountPending_change">
                                        {{ showAmount($user->withdrawals->where('status', 2)->sum('amount')) }}
                                        {{ $general->cur_text }}</h6>
                                </div>
                            </div>
                        </div>
                       --}}
                        {{-- <div class="col-md-4 col-lg-3">
                            <div class="dashboard-w1 bg--white b-radius--2 box-shadow dash-card">
                                <div class="dash-card__header d-flex align-items-center justify-content-between">
                                    <div class="dash-card__icon icon icon--circle icon--md me-3">
                                        <i class="fas fa-hand-holding-usd"></i>
                                    </div>
                                    <a href="{{ route('user.escrow.index') }}" class="t-link dash-card__btn">
                                         <i class="fas fa-angle-right"></i> </a>
                                </div>
                                <div class="dash-card__body">
                                    <h5 class="dash-card__title mb-2 text-clr">@lang('Your Escrow')</span></h5>
                                    <h6 class="my-0">{{ $totalEscrow }}</h6>
                                </div>
                            </div>
                        </div> --}}





                    </div>
                    <div class="row g-4">
                        <div class="col-12 mt-3 mb-3">
                            <h5 class="m-0">@lang('Escrow')</h5>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('user.escrow.index', 'not-accepted') }}">
                                <div class="dashboard-w1 bg--white b-radius--2 box-shadow dash-card mb-3"
                                    style="background: linear-gradient(119deg, #afff47, #85f35e);">
                                    <div class="dash-card__header d-flex align-items-center justify-content-between">
                                        <div class="dash-card__icon icon icon--circle icon--md me-3"
                                            style="background: linear-gradient(180deg, #42424247, #95959500);">
                                            <i class="fas fa-ban"></i>
                                        </div>
                                    </div>
                                    <div class="dash-card__body">
                                        <h5 class="dash-card__title mb-2 text-clr">
                                            @lang('Awaiting for Accept')
                                        </h5>
                                        <h6 class="my-0">{{ $notAccepted }}</h6>
                                    </div>
                                </div>
                            </a>
                            <a href="{{ route('user.escrow.index', 'completed') }}">
                                <div class="dashboard-w1 bg--white b-radius--2 box-shadow dash-card mb-3">
                                    <div class="dash-card__header d-flex align-items-center justify-content-between">
                                        <div class="dash-card__icon icon icon--circle icon--md me-3">
                                            <i class="fas fa-check"></i>
                                        </div>
                                    </div>
                                    <div class="dash-card__body">
                                        <h5 class="dash-card__title mb-2 text-clr">@lang('Completed')</h5>
                                        <h6 class="my-0">{{ $completed }}</h6>
                                    </div>
                                </div>
                            </a>
                            <a href="{{ route('user.escrow.index', 'disputed') }}">
                                <div class="dashboard-w1 bg--white b-radius--2 box-shadow dash-card mb-3">
                                    <div class="dash-card__header d-flex align-items-center justify-content-between">
                                        <div class="dash-card__icon icon icon--circle icon--md me-3">
                                            <i class="fas fa-skull-crossbones"></i>
                                        </div>
                                    </div>
                                    <div class="dash-card__body">
                                        <h5 class="dash-card__title mb-2 text-clr">@lang('Disputed')</h5>
                                        <h6 class="my-0">{{ $disputed }}</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('user.escrow.index', 'canceled') }}">
                                <div class="dashboard-w1 bg--white b-radius--2 box-shadow dash-card mb-3">
                                    <div class="dash-card__header d-flex align-items-center justify-content-between">
                                        <div class="dash-card__icon icon icon--circle icon--md me-3">
                                            <i class="fas fa-times-circle"></i>
                                        </div>
                                    </div>
                                    <div class="dash-card__body">
                                        <h5 class="dash-card__title mb-2 text-clr">@lang('Canceled')</h5>
                                        <h6 class="my-0">{{ $cancelled }}</h6>
                                    </div>
                                </div>
                            </a>
                            <a href="{{ route('user.escrow.index') }}">
                                <div class="dashboard-w1 bg--white b-radius--2 box-shadow dash-card mb-3">
                                    <div class="dash-card__header d-flex align-items-center justify-content-between">
                                        <div class="dash-card__icon icon icon--circle icon--md me-3">
                                            <i class="fas fa-hand-holding-usd"></i>
                                        </div>
                                    </div>
                                    <div class="dash-card__body">
                                        <h5 class="dash-card__title mb-2 text-clr">@lang('Your Escrow')</span></h5>
                                        <h6 class="my-0">{{ $totalEscrow }}</h6>
                                    </div>
                                </div>
                            </a>
                            <a href="{{ route('user.escrow.index', 'accepted') }}">
                                <div class="dashboard-w1 bg--white b-radius--2 box-shadow dash-card mb-3">
                                    <div class="dash-card__header d-flex align-items-center justify-content-between">
                                        <div class="dash-card__icon icon icon--circle icon--md me-3">
                                            <i class="fas fa-spinner"></i>
                                        </div>
                                    </div>
                                    <div class="dash-card__body">
                                        <h5 class="dash-card__title mb-2 text-clr">@lang('Running Escrow')</h5>
                                        <h6 class="my-0">{{ $accepted }}</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- <div class="col-lg-12">
                    <h5>@lang('Latest Transactions')</h5>
                    <table class="table custom--table table-responsive--md">
                        <thead>
                            <tr>
                                <th>@lang('Trx')</th>
                                <th>@lang('Transacted')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Post Balance')</th>
                                <th>@lang('Detail')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($latestTransactions as $trx)
                                <tr>
                                    <td data-label="@lang('Trx')">{{ $trx->trx }}</td>
                                    <td data-label="@lang('Transacted')">
                                        {{ showDateTime($trx->created_at) }}<br>{{ diffForHumans($trx->created_at) }}
                                    </td>

                                    <td data-label="@lang('Amount')" class="budget">
                                        <span
                                            class="font-weight-bold @if ($trx->trx_type == '+') text--success @else text--danger @endif">
                                            {{ $trx->trx_type }} {{ showAmount($trx->amount) }} {{ $general->cur_text }}
                                        </span>
                                    </td>

                                    <td data-label="@lang('Post Balance')" class="budget">
                                        {{ showAmount($trx->post_balance) }} {{ __($general->cur_text) }}
                                    </td>

                                    <td data-label="@lang('Detail')">{{ __($trx->details) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-center">@lang('No data found')</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div> --}}
            </div>
        </div>
    </section>
@endsection
@push('style')
    <style>
        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: #888 transparent transparent transparent;
            border-style: solid;
            border-width: 5px 4px 0 4px;
            height: 0;
            left: 50%;
            margin-left: -4px;
            margin-top: -9px;
            position: absolute;
            top: 50%;
            width: 0;
        }

        .select2-container {
            width: 38% !important;
        }

        .select2-container--default .select2-selection--single {
            border-color: #fff;
            height: 60px;
            padding: 3.5px 0;
            border-radius: 0;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 58px;
        }

        .select2-dropdown {
            border-radius: 0;
            box-shadow: #444 0px 3px 5px;
            border: 0;
        }

        .select2-container--default .select2-selection--single {
            background-color: transparent;
            border: none;
            border-radius: 4px;
        }
    </style>
@endpush
@push('script')
    <script>
        $(document).ready(function() {
            $('.currency_sym').select2({
                minimumResultsForSearch: Infinity,
                templateResult: formatState,
                templateSelection: formatState,
                dropdownCssClass: "select2-custom"
            });
        });

        function formatState(state) {
            if (!state.id) {
                return state.text;
            }
            var $state = $(
                '<span><img style="padding-bottom: 4px;" width="30"  height="30" src="' + $(state.element).attr(
                    'data-src') + '" class="img-flag" /> ' + state.text +
                '</span>'
            );
            return $state;
        };
    </script>
    <script>
        $(document).ready(function() {
            $('.currency_exchange').change(function(e) {
                e.preventDefault();

                $.ajax({
                    type: "get",
                    url: "{{ route('user.currency_exchange') }}",
                    data: {
                        currency: $(this).val(),
                        balanceAmount: $('#balanceAmount').val(),
                        depositAmount_total: $('#depositAmount_total').val(),
                        withdrawAmount_total: $('#withdrawAmount_total').val(),
                        depositAmountPending_total: $('#depositAmountPending_total').val(),
                        withdrawAmountPending_total: $('#withdrawAmountPending_total').val(),
                        milestoneAmount_total: $('#milestoneAmount_total').val(),



                    },

                    success: function(res) {
                        $('.balanceAmount_change').empty();
                        $('.balanceAmount_change').html(`${res.balanceAmount} ${res.sym}`)
                        $('.depositAmount_change').empty();
                        $('.depositAmount_change').html(`${res.depositAmount_total} ${res.sym}`)
                        $('.withdrawAmount_change').empty();
                        $('.withdrawAmount_change').html(
                            `${res.withdrawAmount_total} ${res.sym}`)
                        $('.depositAmountPending_change').empty();
                        $('.depositAmountPending_change').html(
                            `${res.depositAmountPending_total} ${res.sym}`)
                        $('.withdrawAmountPending_change').empty();
                        $('.withdrawAmountPending_change').html(
                            `${res.withdrawAmountPending_total.toLocaleString()} ${res.sym}`
                        )
                        $('.milestoneAmount_change').empty();
                        $('.milestoneAmount_change').html(
                            `${res.milestoneAmount_total.toLocaleString()} ${res.sym}`)

                    }
                });
            });
            $('.currency_exchange').trigger('change');
        });
    </script>
@endpush
