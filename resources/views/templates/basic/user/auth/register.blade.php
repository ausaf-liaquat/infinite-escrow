@extends($activeTemplate . 'layouts.frontend')

@section('content')
    @php
        $authContent = getContent('auth.content', true);
        $policyElements = getContent('policy_pages.element', false, null, true);
    @endphp

    <div class="section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4" style="background: linear-gradient(147deg, #b2f35e, #85F35E);">
                    {{-- <div style="background: #B2F35E;max-height: 344px;">

                </div> --}}
                    <img class="float-end" src="{{ url('') }}/assets/images/eclipse.png" alt=""
                        style="margin-right: -12px;opacity: .5;">

                    <div class="parent">
                        <img class="image1" src="{{ url('') }}/assets/images/img4.png" />
                        <img class="image2" src="{{ url('') }}/assets/images/img1.png" />
                    </div>
                    <p class="text-center" style="font-weight: 600;">
                        Register

                    </p>
                    <p class="text-center" style="font-size: 13px;">With Escrow you can buy and sell anything safely without
                        the risk of chargebacks. Truly secure payments.</p>

                    <p class="text-center" style="font-size: 20px;margin-top: 190px;">
                        Never buy or sell online without using
                    </p>
                    <h4 class="text-center">Infinite Escrow</h4>
                </div>
                <div class="col-md-8" style="vertical-align: middle;display: flex;justify-content: center;align-items: center;">
                    <div style="width: 70%;">
                        <img src="{{ url('') }}/assets/images/palm.png" alt=""><br>
                        <img src="{{ url('') }}/assets/images/create_account.png" alt="">

                        <form action="{{ route('user.register') }}" method="POST" class="row g-4 mt-5 justify-content-center"
                            onsubmit="return submitUserForm();">
                            @csrf
                            <div class="col-md-12">
                                <div class="input-group input--group">
                                    <span class="input-group-text" style="margin-left: 9px;">
                                        <img src="{{ url('') }}/assets/images/icon.png" alt="">
                                    </span>
                                    <input type="text" name="firstname" class="form-control form--control"
                                        value="{{ old('firstname') }}" placeholder="@lang('Your first name')" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="input-group input--group">
                                    <span class="input-group-text" style="margin-left: 9px;">
                                        <img src="{{ url('') }}/assets/images/icon.png" alt="">
                                    </span>
                                    <input type="text" name="lastname" class="form-control form--control"
                                        value="{{ old('lastname') }}" placeholder="@lang('Your last name')" required>
                                </div>
                            </div>

                            <div class="col-md-12">
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

                            <div class="col-md-12">
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

                            <div class="col-md-12">
                                <div class="input-group input--group">
                                    <span class="input-group-text" style="margin-left: 9px;">
                                        <img src="{{ url('') }}/assets/images/icon.png" alt="">
                                    </span>
                                    <input type="text" name="username" class="form-control form--control checkUser"
                                        value="{{ old('username') }}" placeholder="@lang('Your username')" required>
                                </div>
                                <small class="text-danger usernameExist"></small>
                            </div>
                            <div class="col-md-12">
                                <div class="input-group input--group">
                                    <span class="input-group-text" style="margin-left: 9px;">
                                        <img src="{{ url('') }}/assets/images/email-icon.png" alt="">
                                    </span>
                                    <input type="email" name="email" class="form-control form--control checkUser"
                                        value="{{ old('email') }}" placeholder="@lang('Your email')" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="input-group input--group" style="width: 213px;">
                                    <span class="input-group-text" style="margin-left: 13px;">
                                        <i class="fas fa-globe"></i>
                                    </span>
                                    {{-- <div class="form--select-light">
                                        <select name="country" id="country" class="form-select form--select">
                                            @foreach ($countries as $key => $country)
                                                <option data-mobile_code="{{ $country->dial_code }}"
                                                    value="{{ $country->name }}" data-code="{{ $key }}">
                                                    {{ __($country->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                    <div class="form--select-light">
                                        <select name="country" id="country" class="form-select form--select">
                                            @foreach($countries as $key => $country)
                                           
                                                <option data-mobile_code="{{ $country->dial_code }}" value="{{ $country->country }}" data-code="{{ $key }}"
                                                    @if ( $country->country=="Nigeria")
                                                        selected
                                                    @endif
                                                    >{{ __($country->country) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="input-group input--group">
                                    <span class="btn mobile-code">

                                    </span>
                                    <input type="hidden" name="mobile_code">
                                    <input type="hidden" name="country_code">
                                    <input type="number" name="mobile" id="mobile" value="{{ old('mobile') }}"
                                        class="form-control form--control checkUser" placeholder="@lang('Your mobile number')"
                                        required>
                                </div>
                                <small class="text-danger mobileExist"></small>
                            </div>

                           
                            <div>
                                @php echo loadReCaptcha() @endphp
                            </div>

                            @include($activeTemplate . 'partials.custom_captcha')
                            <div class="col-12">
                                <button class="btn btn--xl btn--base w-100 text--accent">@lang('Next') <i class="fas fa-arrow-right"></i></button>
                            </div>
                            @if ($general->agree)
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input custom--check" type="checkbox" name="agree"
                                        id="agree" {{ old('agree') ? 'checked' : '' }} required>
                                    <label class="form-check-label sm-text text--accent" for="remember">
                                        By registering, you aprove that you are Iagree with Privacy Policy , Terms of Service , Payment Policy , Company Rules
                                        {{-- @lang('I agree with')
                                        @foreach ($policyElements as $policy)
                                            <a href="{{ route('policy.details', [$policy->id, slug(@$policy->data_values->title)]) }}"
                                                class="t-link t-link--base d-inline-block text--base"
                                                target="_blank">{{ __(@$policy->data_values->title) }}</a>
                                            @if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach --}}
                                    </label>
                                </div>
                            </div>
                        @endif

                            {{-- <div class="col-12">
                                <p class="mb-0">
                                    @lang('Already Have an account?')
                                    <a href="{{ route('user.login') }}"
                                        class="t-link t-link--base d-inline-block text--base">@lang('Login')</a>
                                </p>
                            </div> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade custom--modal" id="existModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="existModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
                    <button type="button" class="close btn btn--danger" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <h6 class="text-center">@lang('You already have an account please Sign in.')</h6>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('user.login') }}" class="btn btn--base">@lang('Login')</a>
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
        .input-group{
            border: 1px solid #ddd;padding: 5px;
        }
        .country-code .input-group-prepend .input-group-text {
            background: #fff !important;
        }

        .country-code select {
            border: none;
        }

        .country-code select:focus {
            border: none;
            outline: none;
        }

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
        "use strict";

        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML =
                    '<span class="text-danger">@lang('Captcha field is required.')</span>';
                return false;
            }
            return true;
        }
        (function($) {
           
            $('select[name=country]').change(function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text( $('select[name=country] :selected').data('mobile_code'));
            });

            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text( $('select[name=country] :selected').data('mobile_code'));

            @if ($general->secure_password)
                $('input[name=password]').on('input', function() {
                    secure_password($(this));
                });
            @endif

            $('.checkUser').on('focusout', function(e) {
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {
                        mobile: mobile,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'email') {
                    var data = {
                        email: value,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                    if (response['data'] && response['type'] == 'email') {
                        $(document).ready(function() {
                            $('#existModalCenter').modal('show');
                        });
                    } else if (response['data'] != null) {
                        $(`.${response['type']}Exist`).text(`${response['type']} already exist`);
                    } else {
                        $(`.${response['type']}Exist`).text('');
                    }
                });
            });

        })(jQuery);
    </script>
@endpush
