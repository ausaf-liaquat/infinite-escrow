@extends('admin.layouts.app')

@section('panel')
    <section class="section dashboard-section">
        <div class="container">
            <div class="row justify-content-center g-4">
                <div class="col-md-6">
                    {{-- <div class="card custom--card"> --}}
                        <form action="" method="POST">
                            @csrf
                            {{-- <div class="card-body"> --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="d-block mb-2 sm-text">@lang('Current Password')</label>
                                        <input type="password" name="current_password" placeholder="@lang('Enter current password')" class="form-control form--control" required>
                                    </div>
                                    <div class="col-md-12 mt-4 hover-input-popup">
                                        <label class="d-block mb-2 sm-text">@lang('Password')</label>
                                        <input type="password" name="password" placeholder="@lang('Enter new password')" class="form-control form--control" required>

                                        @if($general->secure_password)
                                            <div class="input-popup">
                                            <p class="error lower">@lang('1 small letter minimum')</p>
                                            <p class="error capital">@lang('1 capital letter minimum')</p>
                                            <p class="error number">@lang('1 number minimum')</p>
                                            <p class="error special">@lang('1 special character minimum')</p>
                                            <p class="error minimum">@lang('6 character password')</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <label class="d-block mb-2 sm-text">@lang('Confirm Password')</label>
                                        <input type="password" name="password_confirmation" placeholder="@lang('Re-type password')" class="form-control form--control" required>
                                    </div>
                                </div>
                            {{-- </div> --}}
                            {{-- <div class="card-footer">
                                <button type="submit" class="btn btn--base w-100">@lang('Change Password')</button>
                            </div> --}}
                        </form>
                    </div>
                {{-- </div> --}}
            </div>
        </div>
    </section>
@endsection

@push('style')
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
        (function ($) {
            "use strict";
            @if($general->secure_password)
                $('input[name=password]').on('input',function(){
                    secure_password($(this));
                });
            @endif
        })(jQuery);
    </script>
@endpush
