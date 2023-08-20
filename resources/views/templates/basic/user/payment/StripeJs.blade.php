@extends($activeTemplate.'layouts.master')
@section('content')

    <div class="section">
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
                                    <form action="{{$data->url}}" method="{{$data->method}}">
                                        <h4 class="mt-0">@lang('Please Pay') {{showAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</h4>
                                        <h5 class="mt-0">@lang('To Get') {{showAmount($deposit->amount)}}  {{__($general->cur_text)}}</h5>
                                        <script src="{{$data->src}}"
                                            class="stripe-button"
                                            @foreach($data->val as $key=> $value)
                                            data-{{$key}}="{{$value}}"
                                            @endforeach
                                        >
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
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        (function ($) {
            "use strict";
            $('button[type="submit"]').addClass(" btn-success btn-round custom-success text-center btn-lg");
        })(jQuery);
    </script>
@endpush
