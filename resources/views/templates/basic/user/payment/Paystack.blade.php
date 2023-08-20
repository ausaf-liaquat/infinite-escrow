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
                                    <img src="{{ $deposit->gatewayCurrency()->methodImage() }}"
                                        class="card-img-top img-fluid" alt="@lang('Image')" class="w-100">
                                </div>
                                <div class="col-md-8">
                                    <form action="{{ route('ipn.' . $deposit->gateway->alias) }}" method="POST">
                                        @csrf
                                        <h4 class="mt-0">@lang('Please Pay')
                                            {{ showAmount($deposit->final_amo) }}
                                            {{ __($deposit->method_currency) }}</h4>
                                        <h5 class="mt-0">@lang('To Get') {{ showAmount($deposit->amount) }}
                                            {{ __($general->cur_text) }}</h5>
                                        <button type="button" class="btn btn--md btn--base btn-custom2 "
                                            id="btn-confirm">@lang('Pay Now')</button>
                                        <script src="//js.paystack.co/v1/inline.js" data-key="{{ $data->key }}" data-email="{{ $data->email }}"
                                                                                data-amount="{{ $data->amount }}" data-currency="{{ $data->currency }}"
                                                                                data-ref="{{ $data->ref }}" data-custom-button="btn-confirm">
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
