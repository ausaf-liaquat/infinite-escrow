@extends('admin.layouts.app')
@section('panel')
    <section class="section dashboard-section">
        <div class="container">
            <div class="row justify-content-center g-4">
                <div class="col-md-6">
                    <div class="card custom--card">
                        <div
                        style="        height: 72vh;
                            /* padding-top: 185px; */
                            margin-top: 18px;
                            padding-top: 16px;
                            background: #fff;    padding-left: 33px;
                            padding-right: 33px;">
                        <h5 style="
                       font-size: 20px;
                        "    > <img
                                src="{{ url('') }}/assets/images/hand.png" alt=""> Start your secure
                            payment now</h5>
                            <form action="" method="POST">
                            @csrf
                            <div class="row g-4">
                                <div class="col-md-12">
                                    {{-- <div class="form--select-light">
                                        <select name="type" class="form-select form--select" required>
                                            <option value="1">@lang('Selling')</option>
                                            <option value="2">@lang('Buying')</option>
                                        </select>
                                    </div> --}}
                                    {{-- <button class="btn text--accent" style="padding: 13px 60px;    background: linear-gradient(119deg, #afff47, #85f35e);">
                                        Buyer
                                    </button> --}}
                                    <div class="wrapper">
                                        <input type="radio" name="type" id="option-1" value="1" checked >
                                        <input type="radio" name="type" id="option-2" value="2" >
                                        <label for="option-1" class="option option-1">
                                            <div class="dot">
                                                {{-- <img src="{{url('assets/images/check.png')}}" alt=""> --}}
                                            </div>
                                            <span>I'm Seller</span>
                                        </label>
                                        <label for="option-2" class="option option-2">
                                            <div class="dot"></div>
                                            <span>I'm Buyer</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-4">
                                    <div class="form--select-light" >
                                        <select name="category_id" class="form-select form--select select2" required>
                                            <option value="">@lang('Escrow type')</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ __($category->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group" style="border: 1px solid;">
                                        <span class="input-group-text bg-white text-accent"
                                            style="font-weight: 600;    border: none !important;">@lang('For')</span>
                                        <input type="number"
                                            style="    border: none !important;
                                        text-align: center;
                                        font-size: 30px;
                                        font-weight: 500;"
                                            step="any" class="form-control form--control" name="amount" required>
                                        {{-- <select class="input-group-text bg-white  text-accent" name="currency_sym"
                                            id="amount_sym" style="border: none;font-size: 30px;">

                                            <option value="NGN" selected>₦</option>
                                            <option value="USD">$</option>
                                            <option value="USDC">USDC</option>
                                            <option value="BTC">฿</option>
                                            <option value="ETH">Ξ</option>
                                        </select> --}}
                                        <select name='currency_sym' class="form-control currency_sym form--select">
                                            <option value='NGN' data-src="{{url('')}}/images/ngn.svg">NGN
                                            </option>
                                            <option value='USD' data-src="{{url('')}}/images/usd.svg">USD
                                            </option>
                                            <option value='USDC' data-src="{{url('')}}/images/usdc.svg">USDC
                                            </option>
                                            <option value='BTC' data-src="{{url('')}}/images/btc.svg">BTC
                                            </option>
                                            <option value='ETH' data-src="{{url('')}}/images/eth.png">Ethereum
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mx-auto mt-4">
                                <button type="submit" class="btn btn--xl btn--base bg--accent w-100"  style="background: #96ff0e;border: none;
                                padding: 15px;
                                border-radius: 0px;font-weight:700;">@lang('Next')
                                    <i class="fas fa-arrow-right text-white"></i></button>
                            </div>
                        </form>
                    </div>
                        {{-- <form action="" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="d-block mb-2 sm-text">@lang('I am')</label>
                                        <div class="form--select-light">
                                            <select name="type" class="form-select form--select" required>
                                                <option value="1">@lang('Selling')</option>
                                                <option value="2">@lang('Buying')</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <label class="d-block mb-2 sm-text">@lang('Escrow Type')</label>
                                        <div class="form--select-light">
                                            <select name="category_id" class="form-select form--select" required>
                                                <option value="">@lang('Select One')</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ __($category->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <label class="d-block mb-2 sm-text">@lang('Amount')</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg--base text-white" style="    border: none !important;">@lang('For')</span>
                                            <input type="number" step="any" class="form-control form--control" name="amount" required>
                                            <select class="input-group-text bg--base text-white" name="currency_sym" id="amount_sym">
                                                
                                                <option value="NGN" selected>NGN</option>
                                                <option value="USD">USD</option>
                                                <option value="USDC">USDC</option>
                                                <option value="BTC">BTC</option>
                                                <option value="ETH">ETH</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn--base w-100">@lang('Next')</button>
                            </div>
                        </form> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('style')
    <style>
        .select2-container {
            width: 30% !important;
            }


        .select2-container--default .select2-selection--single {
            border-color: #fff;
            height: 60px;
            padding: 12.5px 0;
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
        @media only screen and (max-width: 480px) {
            .wrapper .option {

                padding: 0 13px !important;

            }
        }

        .input-group-text {
            border: none;
            border-right: 1px solid;
            background: hsl(var(--light-600));
            color: hsl(var(--text));
            padding-inline: 20px;
            /* border-left: none; */
        }

        .underlined {
            position: relative;

        }

        .underlined:after {
            content: "";
            position: absolute;
            height: 15px;
            width: 70px;
            left: -11px;
            top: 17px;
            border-top: 3px solid white;
            border-radius: 50%;

        }

        .hero__content-para {
            position: relative;
        }

        .oval-image {
            position: absolute;
            top: 25px;
            left: 108px;
            border-radius: 50%;
        }

        .wrapper {
            display: inline-flex;
            background: #fff;
            height: 100px;
            width: 100%;
            align-items: center;
            justify-content: space-evenly;
            border-radius: 5px;
            padding: 20px 1px;
            /* box-shadow: 5px 5px 30px rgba(0,0,0,0.2); */
        }

        .wrapper .option {
            background: #fff;
            height: 100%;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-evenly;
            margin: 0 10px;
            border-radius: 1px;
            cursor: pointer;
            padding: 0 0px;
            border: 2px solid lightgrey;
            /* border: 1px solid black; */
            transition: all 0.3s ease;
        }

        .wrapper .option .dot {
            height: 20px;
            width: 20px;
            /* background: #d9d9d9; */
            border-radius: 50%;
            position: relative;
            border: 1px solid;
        }

        .wrapper .option .dot::before {
            position: absolute;
            content: "";
            /* top: 4px;
                    left: 4px; */
            width: 18px;
            height: 18px;
            background-image: url("{{ url('assets/images/check.png') }}");
            background-size: cover;
            border-radius: 50%;
            opacity: 0;
            transform: scale(1.5);
            transition: all 0.3s ease;
        }

        input[type="radio"] {
            display: none;
        }

        #option-1:checked:checked~.option-1,
        #option-2:checked:checked~.option-2 {

            background: linear-gradient(119deg, #afff47, #85f35e);
        }

        #option-1:checked:checked~.option-1 .dot,
        #option-2:checked:checked~.option-2 .dot {
            background: #fff;
        }

        #option-1:checked:checked~.option-1 .dot::before,
        #option-2:checked:checked~.option-2 .dot::before {
            opacity: 1;
            transform: scale(1);
        }

        .wrapper .option span {
            font-size: 15px;
            color: hsl(var(--accent));
            font-weight: 500
        }

        #option-1:checked:checked~.option-1 span,
        #option-2:checked:checked~.option-2 span {
            color: hsl(var(--accent));
        }

        .hero__content-para {
            max-width: 64ch;
            color: #1c280f;
        }

        .hero__content {

            padding-bottom: 0px;

        }

        .hero::after {
            content: "";
            position: absolute;
            /* top: 0; */
            /* bottom: 0; */
            /* left: 0; */
            /* right: 0; */
            background-image: none;
            mix-blend-mode: multiply;
            z-index: -1;
            box-shadow: none;
        }
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

        /* .primary-menu__link {
                                    color: hsl(var(--white));
                                    margin-left: 0;
                                    margin-right: 0;
                                    font-weight: 500;
                                    border-bottom: none;
                                    padding-top: 20px;
                                    padding-bottom: 20px;
                                } */
        /* .btn--login{
                                    color:hsl(var(--white)) !important;
                                } */
        /* .fixed-header .header--primary a.primary-menu__link{
                                    color: hsl(var(--accent));
                                }
                                .fixed-header .header--primary a.btn--login{
                                    color: hsl(var(--accent)) !important;
                                } */
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
                '<span><img style="padding-bottom: 4px;" width="20"  height="20" src="' + $(state.element).attr('data-src') + '" class="img-flag" /> ' + state.text +
                '</span>'
            );
            return $state;
        };
    </script>
@endpush
