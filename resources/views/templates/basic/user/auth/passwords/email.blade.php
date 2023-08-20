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
                       Forget Password

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
                        <img src="{{ url('') }}/assets/images/key.png" alt="" style="width: 35px;"><br>
                        <img src="{{ url('') }}/assets/images/forgetp.png" alt="" class="mt-3">
                        <p class="text--accent mt-2">For recover your password, please enter your username or email</p>
                        <form action="{{ route('user.password.email') }}" method="POST"
                            class="row g-4 mt-3 justify-content-center">
                            @csrf
                            {{-- <div class="col-md-10 col-lg-12">
                                <label   class="sm-text"> @lang('Select One') </label>
                                <div class="input-group input--group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <div class="form--select-light flex-grow-1">
                                        <select name="type" class="form-select form--select">
                                            <option value="email">@lang('E-Mail Address')</option>
                                            <option value="username">@lang('Username')</option>
                                        </select>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="col-md-10 col-lg-12">
                                <label class="sm-text my_value"></label>
                                <div class="input-group input--group">
                                    <span class="input-group-text" style="margin-left: 9px;">
                                        <img src="{{ url('') }}/assets/images/icon.png" alt="">
                                    </span>

                                    <input type="text" name="value" value="{{ old('value') }}"
                                        class="form-control form--control placeholder-value" placeholder="Username or Email" required>
                                </div>
                            </div>


                            <div class="col-md-10 col-lg-12">
                                <button class="btn btn--xl btn--base w-100 text--accent"> @lang('Send Password Code') <i class="fas fa-arrow-right"></i> </button>
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
        .input-group{
            border: 1px solid #ddd;padding: 5px;
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
@endpush
@push('script')
    <script>
        // (function($) {
        //     "use strict";

        //     myVal();
        //     $('select[name=type]').on('change', function() {
        //         myVal();
        //     });

        //     function myVal() {
        //         $('.my_value').text($('select[name=type] :selected').text());
        //         $('.placeholder-value').attr('placeholder',
        //             `@lang('Enter') ${$('select[name=type] :selected').text()}`);
        //     }
        // })(jQuery)
    </script>
@endpush
