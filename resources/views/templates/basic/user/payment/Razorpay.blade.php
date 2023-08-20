@extends($activeTemplate.'layouts.master')

@section('content')
    <div class="section--sm section--bottom">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-md-10 col-xl-6">
                    <div class="card custom--card">
                        <div class="card-body">
                            <div class="row g-4 align-items-center">
                                <div class="col-md-4">
                                    <img src="{{$deposit->gatewayCurrency()->methodImage()}}" class="card-img-top" alt="@lang('Image')" class="w-100">
                                </div>
                                <div class="col-md-8">
                                        <h4 class="mt-0">@lang('Please Pay') {{showAmount($deposit->final_amo)}} {{$deposit->method_currency}}</h4>
                                        <h5 class="mt-0">@lang('To Get') {{showAmount($deposit->amount)}}  {{__($general->cur_text)}}</h5>
                                    <form action="{{$data->url}}" method="{{$data->method}}">
                                        <input type="hidden" custom="{{$data->custom}}" name="hidden">
                                        <script src="{{$data->checkout_js}}"
                                                @foreach($data->val as $key=>$value)
                                                data-{{$key}}="{{$value}}"
                                            @endforeach >
                                        </script>
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
        (function ($) {
            "use strict";
            $('input[type="submit"]').addClass("ml-4 mt-4 btn-custom2 text-center btn-lg");
        })(jQuery);
    </script>
@endpush
