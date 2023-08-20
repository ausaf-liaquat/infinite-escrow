@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $authContent = getContent('auth.content', true);
    @endphp

    <div class="section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4" style="background: linear-gradient(147deg, #b2f35e, #85F35E);height: 144vh;">
                    {{-- <div style="background: #B2F35E;max-height: 344px;">

            </div> --}}
                    <img class="float-end" src="{{ url('') }}/assets/images/eclipse.png" alt=""
                        style="margin-right: -12px;opacity: .5;">

                    <div class="parent">
                        <img class="image1" src="{{ url('') }}/assets/images/img4.png" />
                        <img class="image2" src="{{ url('') }}/assets/images/img1.png" />
                    </div>
                    <p class="text-center" style="font-weight: 600;">
                        Reset Password

                    </p>
                    <p class="text-center" style="font-size: 13px;">With Escrow you can buy and sell anything safely without
                        the risk of chargebacks. Truly secure payments.</p>

                    <p class="text-center" style="font-size: 20px;margin-top: 190px;">
                        Never buy or sell online without using
                    </p>
                    <h4 class="text-center">Infinite Escrow</h4>
                </div>
                <div class="col-md-8"
                    style="vertical-align: middle;display: flex;justify-content: center;align-items: center;">
                    <div style="width: 70%;">
                        <img src="{{ url('') }}/assets/images/key.png" alt=""><br>
                        <h4>Reset Password</h4>

                        <form action="{{ route('user.password.update') }}" method="POST"
                            class="row g-4 justify-content-center">
                            @csrf
                            <input type="hidden" name="email" value="{{ $email }}">
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="col-md-10 col-lg-12">
                                {{-- <label class="sm-text"> @lang('Password') </label> --}}
                                <div class="input-group input--group hover-input-popup">
                                    <span class="input-group-text" style="margin-left: 9px;">
                                        <img src="{{ url('') }}/assets/images/key-icon.png" alt="">
                                    </span>
                                    <input type="password" name="password" class="form-control form--control"
                                        placeholder="@lang('Enter password')" required>

                                    @if ($general->secure_password)
                                        <div class="input-popup">
                                            <p class="error lower">@lang('1 small letter minimum')</p>
                                            <p class="error capital">@lang('1 capital letter minimum')</p>
                                            <p class="error number">@lang('1 number minimum')</p>
                                            <p class="error special">@lang('1 special character minimum')</p>
                                            <p class="error minimum">@lang('6 character password')</p>
                                        </div>
                                    @endif

                                    <span class="input-group-text pass-toggle">
                                        <img src="{{ url('') }}/assets/images/eye.png" alt="">
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-10 col-lg-12">
                                {{-- <label class="sm-text"> @lang('Retype Password') </label> --}}
                                <div class="input-group input--group">
                                    <span class="input-group-text" style="margin-left: 9px;">
                                        <img src="{{ url('') }}/assets/images/key-icon.png" alt="">
                                    </span>
                                    <input type="password" name="password_confirmation" class="form-control form--control"
                                        placeholder="@lang('Retype password')" required>

                                        <span class="input-group-text pass-toggle">
                                            <img src="{{ url('') }}/assets/images/eye.png" alt="">
                                        </span>
                                </div>
                            </div>
                            <div class="col-md-10 col-lg-12">
                                <a href="{{ route('user.login') }}"
                                    class="t-link t-link--base d-block text-clr sm-text text--base">
                                    @lang('Login Here')
                                </a>
                            </div>
                            <div class="col-md-10 col-lg-12">
                                <button class="btn btn--xl btn--base w-100"> @lang('Reset Password') </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .float-container {
            border: 3px solid #fff;
            padding: 20px;
        }

        .float-child {
            width: 50%;
            float: left;
            padding: 20px;
            border: 2px solid red;
        }
        .input-group{
            border: 1px solid #ddd;padding: 5px;
        }
        .section {

            padding-bottom: clamp(0px, 12vw, 0px);
            padding-top: clamp(60px, 8vw, 83px);
        }

        .login-text {
            font-size: 32px;
            font-weight: 600;
        }

        .parent {
            position: relative;
            top: 0;
            left: 0;
            margin: auto;
            width: fit-content;
            height: 58vh;
        }

        .image1 {
            bottom: 117px;
            position: relative;

            left: 0;
            width: 260px;
        }

        .image2 {
            position: absolute;
            top: 68px;
            left: 43px;
            mix-blend-mode: multiply;
        }
    </style>
    <style>
        .hover-input-popup {
            position: relative;
        }

        .hover-input-popup:hover .input-popup {
            opacity: 1;
            visibility: visible;
        }

        .input-popup {
            position: absolute;
            bottom: 130%;
            left: 50%;
            width: 280px;
            background-color: #1a1a1a;
            color: #fff;
            padding: 20px;
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            -ms-border-radius: 5px;
            -o-border-radius: 5px;
            -webkit-transform: translateX(-50%);
            -ms-transform: translateX(-50%);
            transform: translateX(-50%);
            opacity: 0;
            visibility: hidden;
            -webkit-transition: all 0.3s;
            -o-transition: all 0.3s;
            transition: all 0.3s;
        }

        .input-popup::after {
            position: absolute;
            content: '';
            bottom: -19px;
            left: 50%;
            margin-left: -5px;
            border-width: 10px 10px 10px 10px;
            border-style: solid;
            border-color: transparent transparent #1a1a1a transparent;
            -webkit-transform: rotate(180deg);
            -ms-transform: rotate(180deg);
            transform: rotate(180deg);
        }

        .input-popup p {
            padding-left: 20px;
            position: relative;
        }

        .input-popup p::before {
            position: absolute;
            content: '';
            font-family: 'Line Awesome Free';
            font-weight: 900;
            left: 0;
            top: 4px;
            line-height: 1;
            font-size: 18px;
        }

        .input-popup p.error {
            text-decoration: line-through;
        }

        .input-popup p.error::before {
            content: "\f057";
            color: #ea5455;
        }

        .input-popup p.success::before {
            content: "\f058";
            color: #28c76f;
        }
    </style>
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            @if ($general->secure_password)
                $('input[name=password]').on('input', function() {
                    secure_password($(this));
                });
            @endif
        })(jQuery);
    </script>
@endpush
