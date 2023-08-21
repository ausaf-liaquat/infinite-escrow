@extends('admin.layouts.app')
@section('panel')
    <section class="section dashboard-section">
        <div class="container">
            <div class="row justify-content-center g-4">
                <div class="col-md-12">
                    <div class="card custom--card">
                        <form action="" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="d-block mb-2 sm-text">@lang('First Name')</label>
                                        <input type="text" name="firstname" placeholder="@lang('Enter first name')" value="{{$user->firstname}}" class="form-control form--control" readonly required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-block mb-2 sm-text">@lang('Last Name')</label>
                                        <input type="text" name="lastname" placeholder="@lang('Enter last name')" value="{{$user->lastname}}" class="form-control form--control" readonly required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-block mb-2 sm-text">@lang('E-mail Address')</label>
                                        <input type="text" value="{{$user->email}}" class="form-control form--control" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-block mb-2 sm-text">@lang('Mobile Number')</label>
                                        <div class="input-group">
                                            <span class="input-group-text">{{__($dialCode)}}</span>
                                            <input type="text" value="{{$user->mobile}}" class="form-control form--control user-mobile" readonly>
                                          </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="d-block mb-2 sm-text">@lang('Address')</label>
                                        <input type="text" name="address" placeholder="@lang('Enter your address')" value="{{@$user->address->address}}" class="form-control form--control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-block mb-2 sm-text">@lang('State')</label>
                                        <input type="text" name="state" placeholder="@lang('Enter state')" value="{{@$user->address->state}}" class="form-control form--control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-block mb-2 sm-text">@lang('Zip')</label>
                                        <input type="text" name="zip" placeholder="@lang('Enter zip code')" value="{{@$user->address->zip}}" class="form-control form--control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-block mb-2 sm-text">@lang('City')</label>
                                        <input type="text" name="city" placeholder="@lang('Enter city')" value="{{@$user->address->city}}" class="form-control form--control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="d-block mb-2 sm-text">@lang('City')</label>
                                        <input type="text" name="city" placeholder="@lang('Enter city')" value="{{@$user->address->city}}" class="form-control form--control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn--md btn--base w-100"
                                style="background: #b2f35e;
                            font-weight: 700;">@lang('Update Profile')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('style')
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/nice-select.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/magnific-popup.css') }}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/main.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/custom.css') }}">
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
@endpush
@push('script')
    <script>
        let dialCode = `{{ $dialCode }}`;
        let mobileNumber = `{{ $user->mobile }}`;
        mobileNumber = mobileNumber.replace(dialCode,'');
        $('.user-mobile').val(mobileNumber);
    </script>
@endpush
