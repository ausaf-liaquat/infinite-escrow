@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $bannerContent = getContent('banner.content', true);
    @endphp

    <section class="hero" style="background-image:url({{ getImage('assets/images/splash_2.png', '1800x790') }});">
        <div class="hero__content aos-init aos-animate" data-aos="fade-right">
            <div class="container">
                <div class="row g-4 justify-content-center align-items-center justify-xxl-between">
                    <div class="col-md-9 col-lg-7 col-xxl-6 text-center text-lg-start tilt-in-fwd-tr"
                        style="      position: relative;
                        top: -45px;">
=>
                        <h4 class="hero__content-title text-capitalize text--accent mt-0"
                            style="background: -webkit-linear-gradient(#101609, #425a23);
                        -webkit-background-clip: text;
                        -webkit-text-fill-color: transparent;">
                            {{ __(@$bannerContent->data_values->heading) }}
                        </h4>
                        <img src="{{ url('') }}/assets/images/title.png" alt="" style="width: 75%;">
                        <p class="hero__content-para text--white mx-auto ms-lg-0" style="top: 44px;position: relative;">
                            {{-- <img class="oval-image" src="{{ url('') }}/assets/images/eclipse.png" alt="Oval Image"> --}}
                            {{-- <img src="{{ url('') }}/assets/images/heading1.png" alt=""> --}}
                            {{-- {{__(@$bannerContent->data_values->sub_heading)}} --}}
                            With Infiniteescrow.com you can buy and sell anything <span
                                class="underlined"><strong>safely</strong></span> without the risks.
                            Truly <span
                                style="    border: 1px solid #fff;
                            border-radius: 100%;
                            border-width: 3px;
                            padding: 2px;"><strong>
                                    secure </strong> </span> <span>payments.</span>
                        </p>
                        <a href="{{ route('user.register') }}"
                            style="   position: relative;
                            top: 56px;
                            border: 2px solid;
                            border-radius: 1px;
                            width: 29%; "
                            class="t-link d-inline-block text--accent sm-text btn btn-md">
                            @lang('Register') <i class="fas fa-arrow-right"></i>
                        </a>

                    </div>

                    <div class="col-lg-5 col-xxl-6 d-lg-block tilt-in-fwd-tr">
                        {{-- <img src="{{ getImage('assets/images/frontend/banner/'.@$bannerContent->data_values->front_image,'665x575') }}" alt="image" class="img-fluid"> --}}
                        <div
                            style="        height: 72vh;
                                /* padding-top: 185px; */
                                margin-top: 18px;
                                padding-top: 16px;
                                background: #fff;    padding-left: 33px;
                                padding-right: 33px;">
                            <h5 style="
                           font-size: 20px;
                            "> <img
                                    src="{{ url('') }}/assets/images/hand.png" alt=""> Start your secure
                                payment now</h5>
                            <form action="{{ route('user.escrow.new') }}" method="POST">
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
                                            <input type="radio" name="select" id="option-1" checked>
                                            <input type="radio" name="select" id="option-2">
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

                                    <div class="col-md-12 mt-1">
                                        <div class="form--select-light">
                                            <select name="category_id" class="form-select form--select selectCategory"
                                                required>
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
                                                style="font-weight: 600;">@lang('For')</span>
                                            <input type="number"
                                                style="border: none;
                                            text-align: center;
                                            font-size: 30px;
                                            font-weight: 500;"
                                                step="any" class="form-control form--control" name="amount" required>
                                            {{-- <select is="ms-dropdown" class="input-group-text bg-white  text-accent" name="currency_sym"
                                                id="amount_sym" style="border: none;font-size: 30px;">

                                                <option value="NGN" selected>₦</option>
                                                <option value="USD">$</option>
                                                <option value="USDC" data-image="{{url('')}}/assets/images/usdc.svg"> <i class="fas fa-check"></i> USDC</option>
                                                <option value="BTC">฿</option>
                                                <option value="ETH">Ξ</option>
                                            </select> --}}

                                            <select name='currency_sym' class="form-control currency_sym form--select">
                                                <option value='NGN' data-src="{{ url('') }}/images/ngn.svg">NGN
                                                </option>
                                                <option value='USD' data-src="{{ url('') }}/images/usd.svg">USD
                                                </option>
                                                <option value='USDC' data-src="{{ url('') }}/images/usdc.svg">USDC
                                                </option>
                                                <option value='BTC' data-src="{{ url('') }}/images/btc.svg">BTC
                                                </option>
                                                <option value='ETH' data-src="{{ url('') }}/images/eth.png">
                                                    Ethereum
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="mx-auto mt-3">
                                    <button type="submit" class="btn btn--xl btn--base bg--base w-100">@lang('Continue')
                                        <i class="fas fa-arrow-right text-white"></i></button>
                                </div>
                            </form>
                        </div>


                    </div>
                </div>

            </div>

        </div>

    </section>

    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection
@push('style')
    {{-- <link rel="stylesheet" href="{{url('')}}/assets/dd.css"> --}}
    <style>
        .select2-container--default .select2-selection--single {
            border-color: #fff;
            height: 60px;
            padding: 7.5px 0;
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

        .vodiapicker {
            display: none;
        }

        #a {
            padding-left: 0px;
        }

        #a img,
        .btn-select img {
            width: 12px;

        }

        #a li {
            list-style: none;
            padding-top: 5px;
            padding-bottom: 5px;
        }

        #a li:hover {
            background-color: #F4F3F3;
        }

        #a li img {
            margin: 5px;
        }

        #a li span,
        .btn-select li span {
            margin-left: 30px;
        }

        /* item list */

        .b {
            display: none;
            width: 100%;
            max-width: 350px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
            border: 1px solid rgba(0, 0, 0, .15);
            border-radius: 5px;

        }

        .open {
            display: show !important;
        }

        .btn-select {
            margin-top: 10px;
            width: 100%;
            max-width: 350px;
            height: 34px;
            border-radius: 5px;
            background-color: #fff;
            border: 1px solid #ccc;

        }

        .btn-select li {
            list-style: none;
            float: left;
            padding-bottom: 0px;
        }

        .btn-select:hover li {
            margin-left: 0px;
        }

        .btn-select:hover {
            background-color: #F4F3F3;
            border: 1px solid transparent;
            box-shadow: inset 0 0px 0px 1px #ccc;


        }

        .btn-select:focus {
            outline: none;
        }

        .lang-select {
            margin-left: 50px;
        }

        @media only screen and (max-width: 480px) {
            .wrapper .option {

                padding: 0 13px !important;

            }

            .appHeading,
            .appPara {
                color: #1c280f !important;
            }

        }

        @media (min-width: 992px) {
            .d-lg-block {
                display: block !important;
                height: 74vh;
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
            height: 98%;
            width: 112px;
            display: flex;
            align-items: center;
            justify-content: space-evenly;
            margin: 0 1px;
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
                '<span><img style="padding-bottom: 4px;" width="40"  height="40" src="' + $(state.element).attr(
                    'data-src') + '" class="img-flag" /> ' + state.text +
                '</span>'
            );
            return $state;
        };
    </script>
@endpush
