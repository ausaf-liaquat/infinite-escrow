@extends($activeTemplate.'layouts.master')

@section('content')
    <section class="section dashboard-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card custom--card">
                        <div class="card-header bg--base d-flex flex-wrap align-items-center justify-content-between">
                            <h6 class="text-white">@lang('Withdrawal Details')</h6>
                            <div class="btn btn-sm btn--dark">@lang('Balance: ') {{ showAmount(auth()->user()->balance)}}  {{ __($general->cur_text) }}</div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-start mb-2">
                                    <div class="ms-2 me-auto ">
                                        <b>@lang('Request Amount')</b>
                                    </div>
                                    <span>{{showAmount($withdraw->amount)}} {{__($general->cur_text)}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start mb-2">
                                    <div class="ms-2 me-auto ">
                                        <b>@lang('Withdrawal Charge')</b>
                                    </div>
                                    <span>{{showAmount($withdraw->charge) }} {{__($general->cur_text)}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start mb-2">
                                    <div class="ms-2 me-auto ">
                                        <b>@lang('After Charge')</b>
                                    </div>
                                    <span>{{showAmount($withdraw->after_charge) }} {{__($general->cur_text)}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start mb-2">
                                    <div class="ms-2 me-auto ">
                                        <b>@lang('Conversion Rate')</b>
                                    </div>
                                    <span>1 {{__($general->cur_text)}} = {{showAmount($withdraw->rate)}} {{__($withdraw->currency)}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start mb-2">
                                    <div class="ms-2 me-auto ">
                                        <b>@lang('You Will Get')</b>
                                    </div>
                                    <span>{{showAmount($withdraw->final_amount) }} {{__($withdraw->currency)}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start mb-2">
                                    <div class="ms-2 me-auto ">
                                        <b>@lang('Balance Will be')</b>
                                    </div>
                                    <span>{{showAmount($withdraw->user->balance - ($withdraw->amount))}} {{ __($general->cur_text) }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card custom--card">
                        <form action="{{route('user.withdraw.submit')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-header bg--base d-flex flex-wrap align-items-center">
                                <h6 class="text-white">@lang('Necessary Insturctions')</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-4">
                                        <p class="text-center">@php echo $withdraw->method->description; @endphp</p>
                                    </div>

                                    @if($withdraw->method->user_data)
                                        @foreach($withdraw->method->user_data as $k => $v)
                                            @if($v->type == "text")
                                                <div class="col-md-12 @if(!$loop->first) mt-4 @endif">
                                                    <label class="d-block mb-2 sm-text">{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</label>

                                                    <input type="text" name="{{$k}}" value="{{ old($k) }}" placeholder="{{__($v->field_level)}}" class="form-control form--control" @if($v->validation == "required") required @endif>

                                                    @if ($errors->has($k))
                                                        <span class="text-danger">{{ __($errors->first($k)) }}</span>
                                                    @endif
                                                </div>
                                            @elseif($v->type == "textarea")
                                                <div class="col-md-12 @if(!$loop->first) mt-4 @endif">
                                                    <label class="d-block mb-2 sm-text">{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</label>

                                                    <textarea  name="{{$k}}" placeholder="{{__($v->field_level)}}" class="form-control form--control" @if($v->validation == "required") required @endif>{{ old($k) }}</textarea>

                                                    @if ($errors->has($k))
                                                        <span class="text-danger">{{ __($errors->first($k)) }}</span>
                                                    @endif
                                                </div>
                                            @elseif($v->type == "file")
                                                <div class="col-md-12 @if(!$loop->first) mt-4 @endif">
                                                    <label class="d-block mb-2 sm-text">{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</label>
                                                    <input type="file" name="{{$k}}" accept="image/*" class="form-control form--control" @if($v->validation == "required") required @endif>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif

                                    @if(auth()->user()->ts)
                                        <div class="col-md-12 mt-4">
                                            <label class="d-block mb-2 sm-text">@lang('Google Authenticator Code')</label>
                                            <input type="text" name="authenticator_code" placeholder="@lang('Enter google authenticator code')" class="form-control form--control" required>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn--base w-100">@lang('Confirm')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

