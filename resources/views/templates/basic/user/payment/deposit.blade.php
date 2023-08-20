@extends('admin.layouts.app')


@section('panel')
    <section class="section dashboard-section">
        <div class="container">
            <div class="row justify-content-center g-4">
                <div class="col-md-8">
                    {{-- <div class="card custom--card">
                        <div class="card-header">
                            <h5 class="card-title">
                                Deposit
                            </h5>
                        </div> --}}
                    <form action="{{ route('user.deposit.insert') }}" method="POST">
                        @csrf
                        <input type="hidden" name="method_code">
                        <input type="hidden" name="currency">
                        <input type="hidden" name="type"
                            value="@if ($amount) checkout @else deposit @endif">

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="d-block mb-2 sm-text">@lang('Select Gateway')</label>
                                    <div class="form--select-light">
                                        <select name="gateway" class="form-select form--select" required>
                                            <option value="">@lang('Select One')</option>
                                            @foreach ($gatewayCurrency as $data)
                                                <option value="{{ $data->method_code }}" data-gateway="{{ $data }}">
                                                    {{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <label class="d-block mb-2 sm-text">@lang('Amount')</label>
                                    <div class="input-group">
                                        <input type="number" step="any" name="amount"
                                            style="border-right: none !important;" class="form-control form--control"
                                            @if ($amount) value="{{ getAmount($amount) }}" readonly @endif
                                            required>
                                        {{-- <span class="input-group-text bg--base text-white currency_sym">{{ __($general->cur_text) }}</span> --}}
                                        <span class="input-group-text bg--base  currency_sym"
                                            style="border-left: none;    font-size: 14px;
                                            font-weight: 700;"></span>
                                        {{-- <select class="input-group-text bg--base " name="" id="amount_sym">
                                                
                                                <option value="NGN">NGN</option>
                                                <option value="USD">USD</option>
                                                <option value="BTC">BTC</option>
                                                <option value="ETH">ETH</option>
                                            </select> --}}
                                    </div>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span class="fw-md">@lang('Limit')</span>
                                            <span><span class="min fw-bold">0</span> <span class="currency_sym"></span> -
                                                <span class="max fw-bold">0</span> <span class="currency_sym"></span></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span class="fw-md">@lang('Charge')</span>
                                            <span><span class="charge fw-bold">0</span> <span
                                                    class="currency_sym"></span></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span class="fw-md">@lang('Payable')</span> <span><span class="payable fw-md">
                                                    0</span> <span class="currency_sym"></span></span>
                                        </li>
                                        <li class="list-group-item justify-content-between d-none rate-element">

                                        </li>
                                        <li class="list-group-item justify-content-between d-none in-site-cur">
                                            <span class="fw-md">@lang('In') <span
                                                    class="base-currency"></span></span>
                                            <span class="final_amo fw-md">0</span>
                                        </li>
                                        <li class="list-group-item text-center crypto_currency d-none">
                                            <span>@lang('Conversion with') <span class="method_currency"></span>
                                                @lang('and final value will show on next step')</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn--md btn--base w-100"
                                style="background: #b2f35e;
                            font-weight: 700;">@lang('Submit')
                                <i class="fas fa-arrow-right"></i></button>
                        </div>
                    </form>
                    {{-- </div>
                </div>
            </div> --}}
                </div>
    </section>
@endsection
@push('style')
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/nice-select.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/magnific-popup.css') }}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/main.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/custom.css') }}">
    <style>
        label {
            font-weight: 500;
        }

        .btn--base:hover {
            color: hsl(var(--white));
            background: rgb(var(--base));
        }

        .btn:hover {
            box-shadow: 0 8px 15px hsl(var(--dark)/0.4);
        }

        .form--select-light {
            position: relative;
            isolation: isolate;
            /* border: 1px solid hsl(var(--border)/0.5); */
            border-radius: 0;

            /* background: hsl(var(--light-400)); */
        }

        .form--select {
            height: 50px;
            border-radius: 0;

            border: none;
            position: relative;
            font-size: 0.875rem;
        }

        .form--select-light .form--select {
            color: hsl(var(--accent));
        }

        .list-group-item {
            position: relative;
            display: block;
            padding: 0.75rem 1.25rem;
            background-color: #fff;
            border: none;
        }

        .form-select {
            display: block;
            width: 100%;
            padding: 0.375rem 2.25rem 0.375rem 0.75rem;
            -moz-padding-start: calc(0.75rem - 3px);
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;

            background-image: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e);
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
            border: 1px solid #ced4da;
            border-radius: 0;

            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        .input-group {
            position: relative;
            display: flex;
            flex-wrap: wrap;
            align-items: stretch;
            width: 100%;
        }

        .form--control {
            height: 50px !important;
            line-height: 40px !important;
            border-radius: 0 !important;
            font-size: 14px !important;
            border: 1px solid hsl(var(--border)/0.5) !important;
            /* background: hsl(var(--light-400)) !important; */
            color: hsl(var(--accent)) !important;
            transition: all 0.3s ease !important;
        }

        .form-control {
            display: block;
            width: 100%;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            /* background-color: #fff; */
            background-clip: padding-box;
            border: 1px solid #ced4da !important;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: 0;

            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .input-group-text {
            border: 1px solid hsl(var(--border)/0.5);
            border-right: none;
            background: hsl(var(--light-600));
            color: hsl(var(--text));
            padding-inline: 20px;
        }

        .input-group>.form-control,
        .input-group>.form-select {
            position: relative;
            flex: 1 1 auto;
            width: 1%;
            min-width: 0;
        }

        .input-group>:not(:first-child):not(.dropdown-menu):not(.valid-tooltip):not(.valid-feedback):not(.invalid-tooltip):not(.invalid-feedback) {
            margin-left: -1px;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        .input-group-text {
            border: 1px solid hsl(var(--border)/0.5);
            border-right: none;
            background: hsl(var(--light-600));
            color: hsl(var(--text));
            padding-inline: 20px;
        }

        .input-group-text {
            display: flex;
            align-items: center;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: center;
            white-space: nowrap;
            background-color: #e9ecef;
            border: 1px solid #ced4da;
            border-radius: 0;

        }

        .bg--base {
            background-color: transparent !important;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            $('select[name=gateway]').change(function() {
                if (!$('select[name=gateway]').val()) {
                    return false;
                }
                var resource = $('select[name=gateway] option:selected').data('gateway');
                console.log(resource);
                var fixed_charge = parseFloat(resource.fixed_charge);
                var percent_charge = parseFloat(resource.percent_charge);
                var rate = parseFloat(resource.rate)
                if (resource.method.crypto == 1) {
                    var toFixedDigit = 8;
                    $('.crypto_currency').removeClass('d-none');
                } else {
                    var toFixedDigit = 2;
                    $('.crypto_currency').addClass('d-none');
                }
                $('.min').text(parseFloat(resource.min_amount).toFixed(2));
                $('.max').text(parseFloat(resource.max_amount).toFixed(2));

                var amount = parseFloat($('input[name=amount]').val());
                if (!amount) {
                    amount = 0;
                }
                var charge = parseFloat(fixed_charge + (amount * percent_charge / 100)).toFixed(2);
                $('.charge').text(charge);
                var payable = parseFloat((parseFloat(amount) + parseFloat(charge))).toFixed(2);
                $('.payable').text(payable);
                var final_amo = (parseFloat((parseFloat(amount) + parseFloat(charge))) * rate).toFixed(
                    toFixedDigit);
                $('.final_amo').text(final_amo);
                $('.currency_sym').html(resource.currency)
                if (resource.currency != '{{ $general->cur_text }}') {
                    var rateElement =
                        `<span class="fw-bold">@lang('Conversion Rate')</span> <span><span  class="fw-bold">1 {{ __($general->cur_text) }} = <span class="rate">${rate}</span>  <span class="base-currency">${resource.currency}</span></span></span>`;
                    $('.rate-element').html(rateElement)
                    $('.rate-element').removeClass('d-none');
                    $('.in-site-cur').removeClass('d-none');
                    $('.rate-element').addClass('d-flex');
                    $('.in-site-cur').addClass('d-flex');
                } else {
                    $('.rate-element').html('')
                    $('.rate-element').addClass('d-none');
                    $('.in-site-cur').addClass('d-none');
                    $('.rate-element').removeClass('d-flex');
                    $('.in-site-cur').removeClass('d-flex');
                }


                $('.base-currency').text(resource.currency);
                $('.method_currency').text(resource.currency);
                $('input[name=currency]').val(resource.currency);
                $('input[name=method_code]').val(resource.method_code);
                $('input[name=amount]').on('input');
            });

            $('#amount_sym').on('change', function() {
                let currency = $(this).val();

                $('.currency_sym').html(currency)
            });
            $('input[name=amount]').on('input', function() {
                $('select[name=gateway]').change();
                $('.amount').text(parseFloat($(this).val()).toFixed(2));
            });
        })(jQuery);
    </script>
@endpush
