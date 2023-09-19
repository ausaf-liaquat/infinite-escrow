@extends($activeTemplate.'layouts.master')

@section('content')

    <div class="section">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-md-10 col-xl-6">
                 <div class="card custom--card">
                     <div class="card-header">
                        <h5 class="card-title"><span>@lang('Payment Preview')</span></h5>
                     </div>
                     <div class="card-body">
                         <div class="row g-4 align-items-center">
                             <div class="col-md-4">
                                 <img src="{{$deposit->gatewayCurrency()->methodImage()}}" class="card-img-top img-fluid" alt="@lang('Image')" class="w-100">
                             </div>
                             <div class="col-md-8">
                                 <h4 class="mt-0">@lang('Please Pay') {{showAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</h4>
                                 <h5 class="mt-0">@lang('To Get') {{showAmount($deposit->amount)}}  {{__($deposit->method_currency)}}</h5>
                                 <button type="button" class="btn btn--md btn--base btn-custom2 " id="btn-confirm" onClick="payWithRave()">@lang('Pay Now')</button>
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
    <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
    <script>
        "use strict"
        var btn = document.querySelector("#btn-confirm");
        btn.setAttribute("type", "button");
        const API_publicKey = "{{$data->API_publicKey}}";

        function payWithRave() {
            var x = getpaidSetup({
                PBFPubKey: API_publicKey,
                customer_email: "{{$data->customer_email}}",
                amount: "{{$data->amount }}",
                customer_phone: "{{$data->customer_phone}}",
                currency: "{{$data->currency}}",
                txref: "{{$data->txref}}",
                onclose: function () {
                },
                callback: function (response) {
                    var txref = response.tx.txRef;
                    var status = response.tx.status;
                    var chargeResponse = response.tx.chargeResponseCode;
                    if (chargeResponse == "00" || chargeResponse == "0") {
                        window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                    } else {
                        window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                    }
                        // x.close(); // use this to close the modal immediately after payment.
                    }
                });
        }
    </script>
@endpush
