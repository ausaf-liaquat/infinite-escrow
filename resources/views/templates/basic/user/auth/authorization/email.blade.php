@extends($activeTemplate .'layouts.frontend')
@section('content')
    @php
        $authContent = getContent('auth.content',true);
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
                    <img class="mb-4" src="{{ url('') }}/assets/images/search.png" alt="" style="width: 35px;"><br>
                    {{-- <img src="{{ url('') }}/assets/images/verify.png" alt="" class="mt-3"> --}}
                    <div class="login-form__head">
                        <h4 class="mt-lg-0 ">
                            @lang('Please Verify Your Email to Get Access')
                        </h4>
                        <p class="text-center section__para mx-auto">
                            @lang('Your Email'): <b>{{auth()->user()->email}}</b>
                        </p>
                    </div>
                    <form action="{{route('user.verify.email')}}" method="POST" class="row g-4 justify-content-center">
                        @csrf
                        <div class="col-md-10 col-lg-12">
                            <label   class="sm-text">@lang('Verification Code')</label>
                            <div class="input-group input--group">
                                <span class="input-group-text">
                                    <i class="fas fa-code"></i>
                                </span>
                                <input type="text" name="email_verified_code" placeholder="@lang('Enter the code')"class="form-control form--control" maxlength="7" id="code" required>
                            </div>
                        </div>

                        <div class="col-md-10 col-lg-12">
                            <button class="btn btn--xl btn--base w-100"> @lang('Verify') </button>
                        </div>
                        <div class="col-md-10 col-lg-12">
                            <p class="mb-0">
                                @lang('Please check including your Junk/Spam Folder. if not found, you can')
                                <a href="{{route('user.send.verify.code')}}?type=email" class="t-link t-link--base d-inline-block text--base">
                                    @lang('Resend code')
                                </a>
                            </p>
                            @if ($errors->has('resend'))
                                <br/>
                                <small class="text-danger">{{ $errors->first('resend') }}</small>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    {{-- <div class="section login-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="login-section__content">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="text-center login-section__image">
                                    <img src="{{ getImage('assets/images/frontend/auth/'.@$authContent->data_values->image,'425x600') }}" alt="image" class="img-fluid login-section__image-is">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="login-form">
                                    <div class="login-form__head">
                                        <h4 class="mt-lg-0 text-center">
                                            @lang('Please Verify Your Email to Get Access')
                                        </h4>
                                        <p class="text-center section__para mx-auto">
                                            @lang('Your Email'): <b>{{auth()->user()->email}}</b>
                                        </p>
                                    </div>
                                    <form action="{{route('user.verify.email')}}" method="POST" class="row g-4 justify-content-center">
                                        @csrf
                                        <div class="col-md-10 col-lg-12">
                                            <label   class="sm-text">@lang('Verification Code')</label>
                                            <div class="input-group input--group">
                                                <span class="input-group-text">
                                                    <i class="fas fa-code"></i>
                                                </span>
                                                <input type="text" name="email_verified_code" placeholder="@lang('Enter the code')"class="form-control form--control" maxlength="7" id="code" required>
                                            </div>
                                        </div>

                                        <div class="col-md-10 col-lg-12">
                                            <button class="btn btn--xl btn--base w-100"> @lang('Verify') </button>
                                        </div>
                                        <div class="col-md-10 col-lg-12">
                                            <p class="mb-0">
                                                @lang('Please check including your Junk/Spam Folder. if not found, you can')
                                                <a href="{{route('user.send.verify.code')}}?type=email" class="t-link t-link--base d-inline-block text--base">
                                                    @lang('Resend code')
                                                </a>
                                            </p>
                                            @if ($errors->has('resend'))
                                                <br/>
                                                <small class="text-danger">{{ $errors->first('resend') }}</small>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
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
        (function($){
            "use strict";
            $('#code').on('input change', function () {
                var xx = document.getElementById('code').value;

                $(this).val(function (index, value) {
                    value = value.substr(0,7);
                    return value.replace(/\W/gi, '').replace(/(.{3})/g, '$1 ');
                });
            });
        })(jQuery)
    </script>
@endpush
