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
                       Login

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
                        <img  src="{{ url('') }}/assets/images/palm.png" /><br>
                        <img src="{{ url('') }}/assets/images/logintext.png" />

                        <form action="{{ route('user.login') }}" method="POST" class="row mt-5 g-4 justify-content-center"
                            onsubmit="return submitUserForm();">
                            @csrf
                            <div class="col-md-10 col-lg-12">
                                <div class="input-group input--group">
                                    <span class="input-group-text" style="margin-left: 9px;">
                                        <img src="{{ url('') }}/assets/images/icon.png" alt="">
                                    </span>
                                    <input type="text" name="username" value="{{ old('username') }}"
                                        placeholder="@lang('Username or email')" class="form-control form--control" required>
                                </div>
                            </div>
                            <div class="col-md-10 col-lg-12">
                                <div class="input-group input--group">
                                    <span class="input-group-text" style="margin-left: 9px;">
                                        <img src="{{ url('') }}/assets/images/key-icon.png" alt="">
                                    </span>
                                    <input type="password" name="password" class="form-control form--control"
                                        placeholder="@lang('Enter password')" required>
                                        <span class="input-group-text pass-toggle">
                                            <img src="{{ url('') }}/assets/images/eye.png" alt="">
                                        </span>
                                </div>
                            </div>

                            <div class="col-md-5 col-sm-6 col-xs-6 col-lg-6">
                                {{-- <div class="form-check">
                                    <input class="form-check-input custom--check" type="checkbox" name="remember"
                                        id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label sm-text" for="remember">
                                        @lang('Remember Me')
                                    </label>
                                </div> --}}
                                <a href="{{ route('user.register') }}"
                                class="t-link t-link--base d-inline-block text--accent sm-text">
                                @lang('Sign Up')
                            </a>
                            </div>

                            <div class="col-md-5 col-sm-6 col-xs-6 col-lg-6 text-end">
                                <a href="{{ route('user.password.request') }}"
                                    class="t-link t-link--base d-block text-clr sm-text text--accent">
                                    @lang('Forgot Password?')
                                </a>
                            </div>

                            <div>
                                @php echo loadReCaptcha() @endphp
                            </div>
                            @include($activeTemplate . 'partials.custom_captcha')

                            <div class="col-12">
                                <button class="btn btn--xl btn--base w-100">@lang('Login')</button>
                            </div>

                            {{-- <div class="col-md-10 col-lg-12">
                                <p class="mb-0">
                                    @lang('Don\'t have an Account?')
                                    <a href="{{ route('user.register') }}"
                                        class="t-link t-link--base d-inline-block text--base">
                                        @lang('Create New')
                                    </a>
                                </p>
                            </div> --}}
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

        .input-group {
            border: 1px solid #ddd;
            padding: 5px;
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
    </script>
@endpush