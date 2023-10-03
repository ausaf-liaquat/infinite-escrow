@extends('admin.layouts.app')
@section('panel')
    <section class="section dashboard-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-12">
                    @if ($escrow->status != 1 && $escrow->status != 8 && $escrow->status != 9)
                        <div class="text-end mb-4">
                            @if ($escrow->buyer_id == auth()->user()->id && $restAmount > 0)
                                <button class="btn btn--dark btn-sm" data-toggle="modal"
                                    data-target="#newModal">@lang('Create Milestone')</button>
                            @endif
                        </div>
                    @endif
                    <table class="table custom--table table-responsive--md">
                        <thead>
                            <tr>
                                <th>@lang('Date')</th>
                                <th>@lang('Note')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Payment Status')</th>
                                @if ($escrow->buyer_id == auth()->user()->id && $restAmount > 0)
                                    <th>@lang('Action')</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($milestones as $milestone)
                                <tr>
                                    <td data-label="@lang('Date')">{{ showDateTime($milestone->created_at, 'Y-m-d') }}
                                    </td>
                                    <td data-label="@lang('Note')">{{ __($milestone->note) }}</td>
                                    <td data-label="@lang('Amount')">
                                        {{ $milestone->currency }} {{ showAmount($milestone->amount) }}</td>
                                    <td data-label="@lang('Payment Status')">
                                        @if ($milestone->payment_status == 1)
                                            <span class="badge badge--success">@lang('Funded')</span>
                                        @else
                                            <span class="badge badge--danger">@lang('Unfunded')</span>
                                        @endif
                                    </td>
                                    @if ($escrow->buyer_id == auth()->user()->id && $restAmount > 0)
                                        @php
                                            $user = auth()->user();
                                            $balance = $user->userBalance->where('currency_sym', $milestone->currency)->first()?->balance ?? 0;
                                        @endphp
                                        <td data-label="@lang('Action')">
                                            <button
                                                class="btn btn--primary btn-sm @if ($milestone->payment_status == 1) disabled @else payBtn @endif"
                                                data-milestone_id="{{ $milestone->id }}"
                                                data-balance="{{ number_format($balance, 2) }}"
                                                data-currency_sym="{{ $milestone->currency }}">@lang('Pay Now')</button>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5">
                        {{ $milestones->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade custom--modal" id="newModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('New Milestone')</h5>
                    <button type="button" class="close btn btn--danger" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>

                <form action="{{ route('user.escrow.milestone.create') }}" method="POST">
                    @csrf
                    <input type="hidden" name="escrow_id" value="{{ encrypt($escrow->id) }}">

                    <div class="modal-body">
                        <div class="col-md-12">
                            <label class="d-block mb-2 sm-text">@lang('Title')</label>
                            <input type="text" name="note" placeholder="@lang('Enter note')"
                                class="form-control form--control" required>
                        </div>
                        <div class="col-md-12 mt-4">
                            <label class="d-block mb-2 sm-text">@lang('Amount')</label>
                            <div class="input-group">
                                <input type="number" step="any" class="form-control form--control" name="amount"
                                    required>
                                {{-- <select class="input-group-text bg--base text-white" name="currency_sym" id="amount_sym">
                                                
                                    <option value="NGN" selected>NGN</option>
                                    <option value="USD">USD</option>
                                    <option value="USDC">USDC</option>
                                    <option value="BTC">BTC</option>
                                    <option value="ETH">ETH</option>
                                </select>                             --}}
                                <select name='currency_sym' class="form-control currency_sym form--select">
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
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade custom--modal" id="payModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Pay Milestone')</h5>
                    <button type="button" class="close btn btn--danger" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>

                <form action="{{ route('user.escrow.milestone.pay') }}" method="POST">
                    @csrf
                    <input type="hidden" name="milestone_id">

                    <div class="modal-body">
                        <div class="col-md-12">
                            <label class="d-block mb-2 sm-text">@lang('Select Payment Type')</label>
                            <div class="form--select-light">
                                <select name="pay_via" class="form-select form--select" required>
                                    {{-- <option value="1">@lang('Wallet') - {{ showAmount(auth()->user()->balance) }}
                                        {{ $general->cur_text }}</option>
                                    <option value="2">@lang('Checkout')</option> --}}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict"

            $('.payBtn').on('click', function() {
                var modal = $('#payModal');
                var options = [{
                        value: '1',
                        text: `Wallet - ${$(this).data('balance')} ${$(this).data('currency_sym')}`
                    },
                    {
                        value: '2',
                        text: 'Checkout'
                    },
                ];
                options.forEach(function(option) {
                    modal.find('[name=pay_via]').append($('<option>', {
                        value: option.value,
                        text: option.text
                    }));
                });
                console.log('abc');
                
                modal.find('[name=milestone_id]').val($(this).data('milestone_id'));
                // modal.find('[name=pay_via]').val($(this).data('milestone_id'))
                modal.modal('show');
            })
        })(jQuery);
    </script>
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
@endpush
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
            width: auto !important;
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
    </style>
@endpush
