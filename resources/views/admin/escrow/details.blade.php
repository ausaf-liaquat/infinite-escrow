@extends('admin.layouts.app')

@section('panel')

    <div class="row">
        <div class="col-md-12 border-bottom mb-15">
           <h6 class="mb-2">{{ __($escrow->title) }}
        
        <span class="float-right">
                @php echo $escrow->escrowStatus @endphp
            </span>
        </h6>
            
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="text-right">
                        <a href="{{ route('admin.escrow.milestone', $escrow->id) }}" class="btn btn-sm btn--primary">@lang('See Milestones') <i class="las la-arrow-right"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="mb-2">{{ __($escrow->details) }}</h6>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">@lang('Buyer')</span>
                            <span>{{ __(@$escrow->buyer->username ?? $escrow->invitation_mail) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">@lang('Seller')</span>
                            <span>{{ __(@$escrow->seller->username ?? $escrow->invitation_mail) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">@lang('Amount')</span>
                            <span>{{ showAmount($escrow->amount) }} {{ $general->cur_text }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">@lang('Charge')</span>
                            <span>{{ showAmount($escrow->charge) }} {{ $general->cur_text }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">@lang('Charge Payer')</span>
                            <span>
                                @if($escrow->charge_payer == 1)
                                    <span class="badge badge--primary">@lang('Seller')</span>
                                @elseif($escrow->charge_payer == 2)
                                    <span class="badge badge--info">@lang('Buyer')</span>
                                @else
                                    <span class="badge badge--success">@lang('50% - 50%')</span>
                                @endif
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">@lang('Status')</span>
                            <span>
                                @php echo $escrow->escrowStatus @endphp
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">@lang('Milestone Created')</span>
                            <span>{{ showAmount($escrow->milestones->sum('amount')) }} {{ $general->cur_text }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">@lang('Milestone Funded')</span>
                            <span>{{ showAmount($escrow->milestones->where('payment_status', 1)->sum('amount')) }} {{ $general->cur_text }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">@lang('Milestone Unfunded')</span>
                            <span>{{ showAmount($escrow->milestones->where('payment_status',0)->sum('amount')) }} {{ $general->cur_text }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">@lang('Rest Amount')</span>
                            <span>{{ showAmount($restAmount) }} {{ $general->cur_text }}</span>
                        </li>

                        @if($escrow->status == 8)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="font-weight-bold">@lang('Disputed By')</span>
                                <span>{{ $escrow->disputer->username }}</span>
                            </li>
                        @endif
                    </ul>
                    
                    @if($escrow->status == 8)
                        <div class="mt-4">
                            <h5 class="mb-2">@lang('Dispute Reason')</h5>
                            <p class="border p-3">{{ __($escrow->dispute_note) }}</p>
                        </div>
                    @endif
                </div>
                @if($escrow->status == 8)
                    <div class="card-footer">
                        <button class="btn btn--primary btn-sm btn-block h--50" data-toggle="modal" data-target="#actionModal">@lang('Take Action')</button>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="msg-container">
                <div class="card">
                    <div class="card-header">
                        <div class="text-right">
                            <button class="btn btn--primary btn-sm reloadButton"><i class="las la-redo-alt me-0"></i></button>
                        </div>
                    </div>
                    <div class="card-body p-0 msg_history">
                        <div class="messaging p-3">
                            <div class="inbox_msg">
                                <ul class="msg-list d-flex flex-column">
                                    @foreach($messages as $message)
                                    @php
                                        $classText = $message->admin_id != 0 ? 'send' : 'receive';
                                    @endphp
                                    <li class="msg-list__item">
                                        <div class="msg-{{ $classText }}">
                                            @if(($escrow->status == 8) && ($message->admin_id == 0))
                                                <p>{{ @$message->sender->username ?? $message->admin->username }}</p>
                                            @endif
                                            <div class="msg-{{ $classText }}__content">
                                                <p class="msg-{{ $classText }}__text mb-0">
                                                    {{ __($message->message) }}
                                                    <br>
                                                    @if ($message->file)
                                                            {{-- @php
                                                                $mime_type = $message->file->getMimeType();
                                                                $is_image = strpos($mime_type, 'image') !== false;
                                                                $is_video = strpos($mime_type, 'video') !== false;
                                                            @endphp --}}

                                                            @if (pathinfo(url('').'/uploads/'. $message->file , PATHINFO_EXTENSION) == 'png' || pathinfo(url('').'/uploads/'. $message->file , PATHINFO_EXTENSION) == 'jpg')
                                                                <img class="img-fluid imgUploadCss"
                                                                src="{{ url('') }}/uploads/{{ $message->file }}"
                                                                alt="">
                                                           
                                                            @else
                                                               <a href="{{ url('') }}/uploads/{{ $message->file }}"
                                                                target="_blank">{{ $message->file }}</a>
                                                            @endif
                                                       
                                                        @endif  
                                                </p>
                                            </div>
                                            <ul class="msg-{{ $classText }}__history @if($classText == 'send') justify-content-end @endif">
                                                <li class="msg-receive__history-item">{{ $message->created_at->format('h:i A') }}</li>
                                                <li class="msg-receive__history-item">{{ $message->created_at->diffForHumans() }}</li>
                                            </ul>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @if($escrow->status == 8)
                <div class="msg-option">
                    <form class="message-form">
                        <div class="msg-option__content rounded-pill">
                            <div class="msg-option__group ">
                                <input type="text" class="form-control msg-option__input" name="message" autocomplete="off" placeholder="@lang('Send Message')">
                                <button type="submit" class="btn msg-option__button rounded-pill">
                                    <i class="lab la-telegram-plane"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div id="actionModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Escrow Action')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.escrow.action') }}"  method="POST">
                    @csrf
                    <input type="hidden" name="escrow_id" value="{{ $escrow->id }}">

                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Total Funded Amount')</label>
                            <div class="input-group has_append">
                                <input type="text" class="form-control funded-amo" value="{{ showAmount($escrow->milestones->where('payment_status',1)->sum('amount')) }}" readonly>
                                <div class="input-group-append">
                                    <div class="input-group-text"><span>{{__($general->cur_text)}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Amount Send to Buyer')</label>
                            <div class="input-group has_append">
                                <input type="number" step="any" name="buyer_amount" class="form-control range-calc"  required>
                                <div class="input-group-append">
                                    <div class="input-group-text"><span>{{__($general->cur_text)}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Amount Send to Seller')</label>
                            <div class="input-group has_append">
                                <input type="number" step="any" name="seller_amount" class="form-control range-calc"  required>
                                <div class="input-group-append">
                                    <div class="input-group-text"><span>{{__($general->cur_text)}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Charge')</label>
                            <div class="input-group has_append">
                                <input type="text" class="form-control charge" readonly>
                                <div class="input-group-append">
                                    <div class="input-group-text"><span>{{__($general->cur_text)}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Select Status')</label>
                            <select name="status" class="form-control" required>
                                <option value="1">@lang('Completed')</option>
                                <option value="9">@lang('Cancelled')</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/chat.css') }}">
@endpush

@push('style')
    <style>
        .msg-option__input:focus {
            box-shadow: none;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($){
        "use strict"
            $(".msg_history").animate({ scrollTop: $('.msg_history').prop("scrollHeight")}, 1);


            $('.message-form').submit(function (e) {
                 e.preventDefault();
                $(this).find('button[type=submit]').removeAttr('disabled');
                var url = "{{ route('admin.escrow.message.reply') }}";

                var data = {
                    _token:"{{ csrf_token() }}",
                    conversation_id:"{{ $conversation->id }}",
                    message:$(this).find('[name=message]').val()
                }

                $.post(url, data, function (response) {
                    if(response['error']){
                        $.each(response['error'], function (i, v) {
                            notify('error',v);
                        });
                        return true;
                    }

                    var html = `
                            <li class="msg-list__item">
                                <div class="msg-send">
                                    <div class="msg-send__content">
                                        <p class="msg-send__text mb-0">
                                            ${response['message']}
                                        </p>
                                    </div>
                                    <ul class="msg-send__history  justify-content-end ">
                                        <li class="msg-receive__history-item">${response['created_time']}</li>
                                        <li class="msg-receive__history-item">${response['created_diff']}</li>
                                    </ul>
                                </div>
                            </li>
                    `;

                    $('.msg-list').append(html);
                    $(".msg_history").animate({ scrollTop: $('.msg_history').prop("scrollHeight")}, 1);
                });
                $(this).find('[name=message]').val('')

            });

            $('.reloadButton').click(function () {
                var url = '{{ route('admin.escrow.message.get') }}';
                var data = {
                    conversation_id:"{{ $conversation->id }}"
                }
                $.get(url, data,function(response) {
                    if(response['error']){
                        $.each(response['error'], function (i, v) {
                            notify('error',v);
                        });
                        return true;
                    }
                    $('.msg-list').html(response);
                    $(".msg_history").animate({ scrollTop: $('.msg_history').prop("scrollHeight")}, 1);

                });

            });

            $('.range-calc').on('input',function () {
                var buyerAmo = $('[name=buyer_amount]').val();
                if(!buyerAmo){
                    buyerAmo = 0;
                }
                var sellerAmo = $('[name=seller_amount]').val();

                if(!sellerAmo){
                    sellerAmo = 0;
                }
                chargeCalculator(buyerAmo,sellerAmo)
            });

            function chargeCalculator(buyerAmo,sellerAmo) {
                var fundedAmo = $('.funded-amo').val();
                var charge = fundedAmo - (parseFloat(buyerAmo) + parseFloat(sellerAmo));
                if(charge < 0){
                    notify('error','You couldn\'t transact greater than funded amount');
                    return false;
                }
                $('.charge').val(charge);
            }

        })(jQuery);
    </script>
@endpush
