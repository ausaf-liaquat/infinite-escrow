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
                      Verification

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
                        <img src="{{ url('') }}/assets/images/search.png" alt="" style="width: 35px;"><br>
                        <img src="{{ url('') }}/assets/images/verify.png" alt="" class="mt-3">
                        <p class="text--accent mt-2">The verification code has been sent to
                            <strong>{{ $email }}</strong>
                        </p>
                        <form action="{{ route('user.password.verify.code') }}" method="POST"
                            class="row g-4 justify-content-center">
                            @csrf
                            <input type="hidden" name="email" value="{{ $email }}">
                            <div class="col-md-10 col-lg-12">
                                {{-- <label class="sm-text">@lang('Verification Code')</label> --}}
                                <div class="otp-input-fields">
                                    <input type="number" class="otp__digit otp__field__1">
                                    <input type="number" class="otp__digit otp__field__2">
                                    <input type="number" class="otp__digit otp__field__3">
                                    <input type="number" class="otp__digit otp__field__4">
                                    <input type="number" class="otp__digit otp__field__5">
                                    <input type="number" class="otp__digit otp__field__6">
                                </div>
                                {{-- <div class="input-group input--group">
                                <span class="input-group-text">
                                    <i class="fas fa-code"></i>
                                </span>
                                <input type="text" name="code" placeholder="@lang('Enter the code')"class="form-control form--control" maxlength="7" id="code" required>
                            </div> --}}
                                <input type="hidden" name="code"
                                    placeholder="@lang('Enter the code')"class="form-control form--control" maxlength="7"
                                    id="_otp" required>

                            </div>

                            <div class="col-md-10 col-lg-12">
                                <button class="btn btn--xl btn--base w-75 text--accent"> @lang('Verify') <i class="fas fa-arrow-right"></i> </button>
                            </div>
                            <div class="col-md-10 col-lg-12">
                                <div id="resend-link-container">

                                    <div id="resend-link-container" class=" w-75 text-center">
                                        <p id="countdown-container" style="color: #afafaf;">Send again (<span
                                                id="countdown"></span>)</p>
                                        <p id="resend-container"> <a href="{{ route('user.password.request') }}"
                                                id="resend-link" class="t-link t-link--base d-inline-block text--accent">
                                                @lang('Send again')
                                            </a></p>
                                    </div>
                                    {{-- <p>Send again <span id="countdown"></span></p> --}}
                                    {{-- <a href="#" id="resend-link">Resend</a> --}}

                                </div>
                                {{-- <p class="mb-0">
                                    @lang('Please check including your Junk/Spam Folder. if not found, you can')
                                    <a href="{{ route('user.password.request') }}"
                                        class="t-link t-link--base d-inline-block text--base">
                                        @lang('Try to send again')
                                    </a>
                                </p> --}}
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

        .input-group {
            border: 1px solid #ddd;
            padding: 5px;
        }

        .float-child {
            width: 50%;
            float: left;
            padding: 20px;
            border: 2px solid red;
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

        /* .otp-input-fields {
                                margin: auto;
                                background-color: white;
                                box-shadow: 0px 0px 8px 0px #02025044;
                                max-width: 400px;
                                width: auto;
                                display: flex;
                                justify-content: center;
                                gap: 10px;
                                padding: 40px;
                            } */

        .otp-input-fields input {
            height: 40px;
            width: 73px;
            background-color: transparent;
            border-radius: 2px;
            border: 1px solid #cdcdcd;
            text-align: center;
            outline: none;
            font-size: 16px;

            &::-webkit-outer-spin-button,
            &::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            /* Firefox */
            &[type=number] {
                -moz-appearance: textfield;
            }

            &:focus {
                border-width: 2px;
                border-color: darken(#2f8f1f, 5%);
                font-size: 20px;
            }
        }
    </style>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";
            $('#_otp').on('input change', function() {
                var xx = document.getElementById('_otp').value;
                $(this).val(function(index, value) {
                    value = value.substr(0, 7);
                    return value.replace(/\W/gi, '').replace(/(.{3})/g, '$1 ');
                });
            });
        })(jQuery)

        var otp_inputs = document.querySelectorAll(".otp__digit")
        var mykey = "0123456789".split("")
        otp_inputs.forEach((_) => {
            _.addEventListener("keyup", handle_next_input)
        })

        function handle_next_input(event) {
            let current = event.target
            let index = parseInt(current.classList[1].split("__")[2])
            current.value = event.key

            if (event.keyCode == 8 && index > 1) {
                current.previousElementSibling.focus()
            }
            if (index < 6 && mykey.indexOf("" + event.key + "") != -1) {
                var next = current.nextElementSibling;
                next.focus()
            }
            var _finalKey = ""
            for (let {
                    value
                } of otp_inputs) {
                _finalKey += value
            }
            if (_finalKey.length == 6) {
                document.querySelector("#_otp").classList.replace("_notok", "_ok")
                document.querySelector("#_otp").value = _finalKey
            } else {
                document.querySelector("#_otp").classList.replace("_ok", "_notok")
                document.querySelector("#_otp").value = _finalKey
            }
        }
        $(document).ready(function() {
            var countdownElement = $('#countdown');
            var countdownContainer = $('#countdown-container');
            var resendContainer = $('#resend-container');
            var countdownSeconds = 93; // Total countdown time in seconds

            // Initially hide the countdown and resend container
            countdownContainer.hide();
            resendContainer.hide();

            // Start the countdown timer
            function startCountdown() {
                countdownContainer.show();

                var interval = setInterval(function() {
                    countdownSeconds--;
                    updateCountdown();

                    if (countdownSeconds <= 0) {
                        clearInterval(interval);
                        countdownContainer.hide();
                        resendContainer.show();
                    }
                }, 1000);
            }

            // Update the countdown timer
            function updateCountdown() {
                var minutes = Math.floor(countdownSeconds / 60);
                var seconds = countdownSeconds % 60;

                countdownElement.text(minutes + ':' + (seconds < 10 ? '0' : '') + seconds);
            }

            // Start the timer for 1 minute
            setTimeout(function() {
                startCountdown();
            }, 10);
        });
    </script>
@endpush
