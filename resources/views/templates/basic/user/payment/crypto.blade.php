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
                                 <img src="{{$data->img}}" class="card-img-top img-fluid" alt="@lang('Image')" class="w-100">
                             </div>
                             <div class="col-md-8">
                                 <h4 class="mt-0">@lang('PLEASE SEND EXACTLY') {{ $data->amount }} {{__($data->currency)}}</h4>
                                 <h5 class="mt-0">@lang('To') {{ $data->sendto }}</h5>
                                 <span class="btn btn--md btn--base" >@lang('SCAN TO SEND')</span>
                             </div>
                         </div>
                     </div>
                 </div>
                </div>
            </div>
         </div>
    </div>

@endsection
