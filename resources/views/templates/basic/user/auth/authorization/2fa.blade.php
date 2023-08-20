@extends($activeTemplate .'layouts.frontend')
@section('content')
    @php
        $authContent = getContent('auth.content',true);
    @endphp

    <div class="section login-section">
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
                                            @lang('2FA Verification')
                                        </h4>
                                        <p class="text-center section__para mx-auto">
                                            @lang('Current Time'): <b>{{\Carbon\Carbon::now()}}</b>
                                        </p>
                                    </div>
                                    <form action="{{route('user.go2fa.verify')}}" method="POST" class="row g-4 justify-content-center">
                                        @csrf
                                        <div class="col-md-10 col-lg-12">
                                            <label   class="sm-text">@lang('Verification Code')</label>
                                            <div class="input-group input--group">
                                                <span class="input-group-text">
                                                    <i class="fas fa-code"></i>
                                                </span>
                                                <input type="text" name="code" placeholder="@lang('Enter the code')"class="form-control form--control" maxlength="7" id="code" required>
                                            </div>
                                        </div>

                                        <div class="col-md-10 col-lg-12">
                                            <button class="btn btn--xl btn--base w-100"> @lang('Verify') </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

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
