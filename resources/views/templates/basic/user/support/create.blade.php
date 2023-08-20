@extends('admin.layouts.app')
@section('panel')
    <div class="section">
        <div class="container">
            <div class="row justify-content-center mt-4">
                <div class="col-md-8">
                    {{-- <div class="card custom--card"> --}}
                        {{-- <div class="card-header d-flex justify-content-between align-items-center">{{ __($pageTitle) }}
                            <a href="{{route('ticket') }}" class="btn btn--base">
                                @lang('My Support Ticket')
                            </a>
                        </div> --}}

                        {{-- <div class="card-body"> --}}
                            <form  action="{{route('ticket.store')}}"  method="post" enctype="multipart/form-data" onsubmit="return submitUserForm();">
                                @csrf
                                <div class="row g-4">
                                    {{-- <div class="form-group form--group col-md-6"> --}}
                                        {{-- <label for="name" class="form-label sm-text">@lang('Name')</label> --}}
                                        <input type="hidden" name="name" value="{{@$user->firstname . ' '.@$user->lastname}}" class="form-control form--control" placeholder="@lang('Enter your name')" readonly>
                                    {{-- </div> --}}
                                    {{-- <div class="form-group col-md-6"> --}}
                                        {{-- <label for="email" class="form-label sm-text">@lang('Email address')</label> --}}
                                        <input type="hidden"  name="email" value="{{@$user->email}}" class="form-control form--control" placeholder="@lang('Enter your email')" readonly>
                                    {{-- </div> --}}

                                    <div class="form-group col-md-12">
                                        <label for="website" class="form-label sm-text">@lang('Subject')</label>
                                        <input type="text" name="subject" value="{{old('subject')}}" class="form-control form--control" placeholder="@lang('Subject')" >
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="priority" class="form-label sm-text">@lang('Priority')</label>
                                        <div class="form--select-light">
                                            <select name="priority" class="form-select form--select">
                                                <option value="3">@lang('High')</option>
                                                <option value="2">@lang('Medium')</option>
                                                <option value="1">@lang('Low')</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 form-group">
                                        <label for="inputMessage" class="form-label sm-text">@lang('Message')</label>
                                        <textarea name="message" id="inputMessage" rows="6" class="form-control form--control-textarea">{{old('message')}}</textarea>
                                    </div>
                                    <div class="col-12 form-group">
                                        <label for="inputAttachments" class="form-label sm-text">@lang('Attachments')</label>
                                        <div class="input-group mb-3 custom--input-group">
                                            <input type="file" name="attachments[]" id="inputAttachments" class="form-control " style="height: 50px;" />
                                            <span class="btn btn--base btn--sm addFile input-group-text"><i class="fa fa-plus"></i></span>
                                        </div>

                                        <div id="fileUploadsContainer" class="custom--list"></div>
                                        <p class="ticket-attachments-message sm-text text-muted mt-1 mb-0">
                                            @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')
                                        </p>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn--base w-100" type="submit" id="recaptcha" style="background: #96ff0e;border: none;
                                        padding: 15px;
                                        border-radius: 0px;font-weight:700;"><i class="fa fa-paper-plane"></i>&nbsp;@lang('Submit')</button>
                                    </div>
                                </div>
                            </form>
                        {{-- </div> --}}
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </div>
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
            /* line-height: 40px !important; */
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
        (function ($) {
            "use strict";
            $('.addFile').on('click',function(){
                $("#fileUploadsContainer").append(`
                    <div class="input-group custom--input-group mb-3">
                        <input type="file" name="attachments[]" class="form-control form--control" required />
                        <span class="btn btn--sm btn--danger remove-btn input-group-text"><i class="fas fa-times"></i></span>
                    </div>
                `)
            });
            $(document).on('click','.remove-btn',function(){
                $(this).closest('.input-group').remove();
            });
        })(jQuery);
    </script>
@endpush
