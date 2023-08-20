@extends($activeTemplate.'layouts.master')
@section('content')
    <section class="section dashboard-section">
        <div class="container">
            <div class="row justify-content-center g-4">
                <div class="col-md-8">
                    <div class="card custom--card">
                        <div class="card-header bg--base text-center">
                            <h6 class="text-white">{{__($pageTitle)}}</h6>
                        </div>
                        <form action="{{ route('user.deposit.manual.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="text-center mt-2">@lang('You have requested') <b class="text--base">{{ showAmount($data['amount'])  }} {{__($general->cur_text)}}</b> , @lang('Please pay')
                                            <b class="text--base">{{showAmount($data['final_amo']) .' '.$data['method_currency'] }} </b> @lang('for successful payment')
                                        </p>
                                        <h4 class="text-center mb-4">@lang('Please follow the instruction below')</h4>
                                    </div>

                                    @if($method->gateway_parameter)
                                        @foreach(json_decode($method->gateway_parameter) as $k => $v)
                                            @if($v->type == "text")
                                                <div class="col-md-12 @if(!$loop->first) mt-4 @endif">
                                                    <label class="d-block mb-2 sm-text">{{__(inputTitle($v->field_level))}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</label>

                                                    <input type="text" name="{{$k}}" value="{{ old($k) }}" placeholder="{{__($v->field_level)}}" class="form-control form--control" @if($v->validation == "required") required @endif>

                                                    @if ($errors->has($k))
                                                        <span class="text-danger">{{ __($errors->first($k)) }}</span>
                                                    @endif
                                                </div>
                                            @elseif($v->type == "textarea")
                                                <div class="col-md-12 @if(!$loop->first) mt-4 @endif">
                                                    <label class="d-block mb-2 sm-text">{{__(inputTitle($v->field_level))}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</label>

                                                    <textarea  name="{{$k}}" placeholder="{{__($v->field_level)}}" class="form-control form--control" @if($v->validation == "required") required @endif>{{ old($k) }}</textarea>

                                                    @if ($errors->has($k))
                                                        <span class="text-danger">{{ __($errors->first($k)) }}</span>
                                                    @endif
                                                </div>
                                            @elseif($v->type == "file")
                                                <div class="col-md-12 @if(!$loop->first) mt-4 @endif">
                                                    <label class="d-block mb-2 sm-text">{{__(inputTitle($v->field_level))}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</label>
                                                    <input type="file" name="{{$k}}" accept="image/*" class="form-control form--control" @if($v->validation == "required") required @endif>
                                                </div>
                                            @endif
                                        @endforeach
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
