@extends('admin.layouts.app')
@section('panel')

    <section class="section dashboard-section">
        <div class="container">
            <div class="row justify-content-center mt-4">
                <div class="col-md-8">
                    @if(Auth::user()->ts)
                        {{-- <div class="card custom--card">
                            <div class="card-header"> --}}
                                <h5 class="card-title">@lang('Two Factor Authenticator')</h5>
                            {{-- </div> --}}
                            {{-- <div class="card-body"> --}}
                                <div class="form-group mx-auto text-center">
                                    <a href="#0"  class="btn btn-block btn-lg btn--danger" data-bs-toggle="modal" data-bs-target="#disableModal">
                                        @lang('Disable Two Factor Authenticator')</a>
                                </div>
                            {{-- </div> --}}
                        {{-- </div> --}}
                    @else
                        {{-- <div class="card custom--card">
                            <div class="card-header">
                                <h5 class="card-title">@lang('Two Factor Authenticator')</h5>
                            </div> --}}
                            {{-- <div class="card-body"> --}}
                                <div class="form-group mb-4">
                                    <div class="input-group">
                                        <input type="text" name="key" value="{{$secret}}" class="form-control form--control" id="referralURL" style="background: #fff;
                                        border: none;" readonly>
                                        <div class="input-group-append">
                                            <span class="input-group-text copytext h-100" style="    background: #fff;
                                            border: none;" id="copyBoard"> <i class="fa fa-copy"></i> </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mx-auto text-center">
                                    <img class="mx-auto" src="{{$qrCodeUrl}}">
                                </div>
                                <div class="form-group mx-auto text-center mt-4">
                                    <a href="#0" class="btn btn--base btn--md w-75 border--dark" style="font-weight: 700;" data-bs-toggle="modal" data-bs-target="#enableModal" >@lang('Enable Two Factor Authenticator')</a>
                                </div>
                            {{-- </div>
                        </div> --}}
                    @endif
                </div>

                <div class="col-lg-6 col-md-6 text-center">
                    <div class="card custom--card" style="background: #ededed;">
                        {{-- <div class="card-header">
                            
                        </div> --}}
                        <div class=" card-body">
                            <h5 class="card-title">@lang('Google Authenticator')</h5>
                            <p>@lang('Google Authenticator is a multifactor app for mobile devices. It generates timed codes used during the 2-step verification process. To use Google Authenticator, install the Google Authenticator application on your mobile device.')</p>
                            <a class="btn btn--base btn--md border--dark" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="_blank">@lang('DOWNLOAD APP')</a>
                        </div>
                    </div><!-- //. single service item -->
                </div>
            </div>
        </div>
    </section>

    <!--Enable Modal -->
    <div id="enableModal" class="modal fade custom--modal" role="dialog">
        <div class="modal-dialog ">
            <!-- Modal content-->
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Verify Your Otp')</h5>
                    <button type="button" class="btn btn--danger close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{route('user.twofactor.enable')}}" method="POST">
                    @csrf
                    <div class="modal-body ">
                        <div class="form-group">
                            <input type="hidden" name="key" value="{{$secret}}">
                            <input type="text" class="form-control form--control" name="code" placeholder="@lang('Enter Google Authenticator Code')">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--base">@lang('Verify')</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!--Disable Modal -->
    <div id="disableModal" class="modal fade custom--modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Verify Your Otp Disable')</h5>
                    <button type="button" class="btn btn--danger close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{route('user.twofactor.disable')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control form--control" name="code" placeholder="@lang('Enter Google Authenticator Code')">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--base">@lang('Verify')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        (function($){
            "use strict";

            $('.copytext').on('click',function(){
                var copyText = document.getElementById("referralURL");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand("copy");
                iziToast.success({message: "Copied: " + copyText.value, position: "topRight"});
            });
        })(jQuery);
    </script>
@endpush


