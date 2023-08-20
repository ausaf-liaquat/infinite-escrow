@extends('admin.layouts.app')
@section('panel')
    <section class="section dashboard-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-12  d-flex justify-content-between">

                    <strong>{{ __($escrow->title) }}</strong>


                    <div class="float-end">
                        @php echo $escrow->escrowStatus @endphp
                    </div>

                </div>
                <hr>
                <div class="col-md-6">
                    <div class="card custom--card">
                        <div class="card-header bg--base d-flex flex-wrap align-items-center justify-content-between">
                            <h6 class="text-white">@lang('Escrow Details')</h6>
                            <a href="{{ route('user.escrow.milestone', encrypt($escrow->id)) }}"
                                class="btn btn-sm btn--dark">@lang('See Milestones') <i class="las la-arrow-right"></i></a>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                {{-- <li class="list-group-item d-flex justify-content-between align-items-start mb-2" style="border: none;">
                                    <div class="ms-2 me-auto ">
                                        <b>@lang('Title')</b>
                                    </div>
                                    <span>{{ __($escrow->title) }}</span>
                                </li> --}}
                                <li class="list-group-item d-flex justify-content-between align-items-start mb-2"
                                    style="border: none;">
                                    <div class="ms-2 me-auto ">
                                        @if ($escrow->buyer_id == auth()->user()->id)
                                            <b>@lang('I\'m Buying from')</b>
                                        @else
                                            <b>@lang('I\'m Selling from')</b>
                                        @endif

                                    </div>
                                    <span>
                                        @if ($escrow->buyer_id == auth()->user()->id)
                                            {{ __(@$escrow->seller->username ?? $escrow->invitation_mail) }}
                                        @else
                                            {{ __(@$escrow->buyer->username ?? $escrow->invitation_mail) }}
                                        @endif
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start mb-2"
                                    style="border: none;">
                                    <div class="ms-2 me-auto ">
                                        <b>@lang('Amount')</b>
                                    </div>
                                    <span><span
                                            style="font-weight: 700;font-size:14px;">{{ showAmount($escrow->amount) }}</span>
                                        {{ $escrow->currency_sym }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start mb-2"
                                    style="border: none;">
                                    <div class="ms-2 me-auto ">
                                        <b>@lang('Charge')</b>
                                    </div>
                                    <span><span
                                            style="font-weight: 700;font-size:14px;">{{ showAmount($escrow->charge) }}</span>
                                        {{ $escrow->currency_sym }} By
                                        @if ($escrow->charge_payer == 1)
                                            <span class="badge badge--dark">@lang('Seller')</span>
                                        @elseif($escrow->charge_payer == 2)
                                            <span class="badge badge--info">@lang('Buyer')</span>
                                        @else
                                            <span class="badge badge--success">@lang('50%-50%')</span>
                                        @endif
                                    </span>
                                </li>
                                {{-- <li class="list-group-item d-flex justify-content-between align-items-start mb-2"
                                    style="border: none;">
                                    <div class="ms-2 me-auto ">
                                        <b>@lang('Charge Payer')</b>
                                    </div>

                                    @if ($escrow->charge_payer == 1)
                                        <span class="badge badge--dark">@lang('Seller')</span>
                                    @elseif($escrow->charge_payer == 2)
                                        <span class="badge badge--info">@lang('Buyer')</span>
                                    @else
                                        <span class="badge badge--success">@lang('50%-50%')</span>
                                    @endif
                                </li> --}}
                                {{-- <li class="list-group-item d-flex justify-content-between align-items-start mb-2"
                                    style="border: none;">
                                    <div class="ms-2 me-auto ">
                                        <b>@lang('Status')</b>
                                    </div>
                                    @php echo $escrow->escrowStatus @endphp
                                </li> --}}
                                <li class="list-group-item d-flex justify-content-between align-items-start mb-2"
                                    style="border: none;">
                                    <div class="ms-2 me-auto ">
                                        <b>@lang('Created Milestone')</b>
                                    </div>
                                    <span><span
                                            style="font-weight: 700;font-size:14px;">{{ showAmount($escrow->milestones->sum('amount')) }}</span>
                                        {{ $escrow->currency_sym }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start mb-2"
                                    style="border: none;">
                                    <div class="ms-2 me-auto ">
                                        <b>@lang('Milestone Funded')</b>
                                    </div>
                                    <span><span
                                            style="font-weight: 700;font-size:14px;">{{ showAmount($escrow->milestones->where('payment_status', 1)->sum('amount')) }}</span>
                                        {{ $escrow->currency_sym }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start mb-2"
                                    style="border: none;">
                                    <div class="ms-2 me-auto ">
                                        <b>@lang('Milestone Unfunded')</b>
                                    </div>
                                    <span>
                                        <span
                                            style="font-weight: 700;font-size:14px;">{{ showAmount($escrow->milestones->where('payment_status', 0)->sum('amount')) }}</span>

                                        {{ $escrow->currency_sym }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start mb-2"
                                    style="border: none;">
                                    <div class="ms-2 me-auto ">
                                        <b>@lang('Rest Amount')</b>
                                    </div>
                                    <span> <span style="font-weight: 700;font-size:14px;">{{ showAmount($restAmount) }}
                                        </span> {{ $escrow->currency_sym }}</span>
                                </li>
                                @if ($escrow->file)
                                    <li class="list-group-item d-flex justify-content-between align-items-start mb-2"
                                        style="border: none;">

                                        {{-- @php
                                                                $mime_type = $escrow->file->getMimeType();
                                                                $is_image = strpos($mime_type, 'image') !== false;
                                                                $is_video = strpos($mime_type, 'video') !== false;
                                                            @endphp --}}
                                        <div class="ms-2 me-auto ">
                                            <b>@lang('File')</b>
                                        </div>
                                        <span>
                                            @if (pathinfo(url('') . '/uploads/' . $escrow->file, PATHINFO_EXTENSION) == 'png' ||
                                                    pathinfo(url('') . '/uploads/' . $escrow->file, PATHINFO_EXTENSION) == 'jpg')
                                                <img class="img-fluid imgUploadCss"
                                                    src="{{ url('') }}/uploads/{{ $escrow->file }}" alt="">
                                            @else
                                                <a href="{{ url('') }}/uploads/{{ $escrow->file }}"
                                                    target="_blank">{{ $escrow->file }}</a>
                                            @endif



                                        </span>
                                    </li>
                                @endif
                                @if ($escrow->status == 8)
                                    <li class="list-group-item d-flex justify-content-between align-items-start mb-2"
                                        style="border: none;">
                                        <div class="ms-2 me-auto ">
                                            <b>@lang('Disputed By')</b>
                                        </div>
                                        <span>{{ $escrow->disputer->username }}</span>
                                    </li>

                                    <h5 class="p-4">@lang('Dispute Reason')</h5>
                                    <p class="p-4">{{ __($escrow->dispute_note) }}</p>
                                @endif



                            </ul>
                            @if ($restAmount <= 0 && $escrow->status == 0)
                                <div class="alert alert-warning mt-1 mx-4" role="alert">
                                    @lang('The full amount has been paid, but the escrow is not accepted yet. To dispatch the payment, the escrow must be accepted')
                                </div>
                            @endif
                        </div>

                        @if ($escrow->status == 2 || $escrow->status == 0)
                            @php
                                $hasSellerAndBuyer = $escrow->seller_id && $escrow->buyer_id;
                            @endphp

                            <div class="card-footer bg-white">
                                @if ($escrow->status == 0)
                                    @if ($escrow->creator_id != auth()->id() && $hasSellerAndBuyer)
                                        <button class="btn  user-action" data-value="2"
                                            data-route="{{ route('user.escrow.accept') }}">@lang('Accept')</button>
                                    @endif

                                    <button class="btn user-action" data-value="9"
                                        data-route="{{ route('user.escrow.cancel') }}"><i class="fas fa-times-circle"></i>
                                        @lang('Cancel Escrow')</button>
                                @else
                                    {{-- If all amount is paid and the escrow is accepted --}}
                                    @if ($restAmount <= 0 && $escrow->buyer_id == auth()->id() && $hasSellerAndBuyer)
                                        <button class="btn user-action" data-value="1"
                                            data-route="{{ route('user.escrow.dispatch') }}">@lang('Dispatch Payment')</button>
                                    @endif
                                    {{-- payment dispute button --}}
                                    @if ($hasSellerAndBuyer)
                                        <button class="btn  user-action" data-value="8"
                                            data-route="{{ route('user.escrow.dispute') }}">@lang('Dispute Escrow')</button>
                                    @endif
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card custom--card">
                        <div class="card-header bg--base d-flex flex-wrap align-items-center justify-content-between">
                            <h6 class="text-white">@lang('Conversations')</h6>
                            <button type="button" class="btn btn-sm btn--dark reloadButton"><i
                                    class="las la-redo-alt"></i></button>
                        </div>
                        <div class="card-body">
                            <div class="messaging msg_history">
                                <div class="inbox_msg">
                                    <ul class="list msg-list d-flex flex-column">
                                        @foreach ($messages as $message)
                                            @php
                                                $classText = $message->sender_id == auth()->user()->id ? 'send' : 'receive';
                                            @endphp
                                            <li class="msg-list__item mt-10">
                                                <div class="msg-{{ $classText }}">
                                                    @if ($escrow->status == 8 && $message->sender_id != auth()->id())
                                                        <p class="mb-0">
                                                            {{ @$message->sender->username ?? $message->admin->username }}
                                                        </p>
                                                    @endif
                                                    <div class="msg-{{ $classText }}__content">
                                                        <p class="msg-{{ $classText }}__text mb-0">
                                                            {{ __($message->message) }}
                                                        </p>
                                                        @if ($message->file)
                                                            {{-- @php
                                                                $mime_type = $message->file->getMimeType();
                                                                $is_image = strpos($mime_type, 'image') !== false;
                                                                $is_video = strpos($mime_type, 'video') !== false;
                                                            @endphp --}}

                                                            @if (pathinfo(url('') . '/uploads/' . $message->file, PATHINFO_EXTENSION) == 'png' ||
                                                                    pathinfo(url('') . '/uploads/' . $message->file, PATHINFO_EXTENSION) == 'jpg')
                                                                <img class="img-fluid imgUploadCss"
                                                                    src="{{ url('') }}/uploads/{{ $message->file }}"
                                                                    alt="">
                                                            @else
                                                                <a href="{{ url('') }}/uploads/{{ $message->file }}"
                                                                    target="_blank">{{ $message->file }}</a>
                                                            @endif
                                                        @endif

                                                    </div>
                                                    <ul
                                                        class="list msg-{{ $classText }}__history @if ($classText == 'send') justify-content-end @endif">
                                                        <li class="msg-receive__history-item">
                                                            {{ $message->created_at->format('h:i A') }}</li>
                                                        <li class="msg-receive__history-item">
                                                            {{ $message->created_at->diffForHumans() }}</li>
                                                    </ul>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($escrow->status != 9 && $escrow->status != 1)
                        <div class="msg-option">
                            <form class="message-form" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                                <div class="msg-option__content">
                                    <div class="msg-option__group ">
                                        {{-- <input class=""   type="file"> --}}
                                        <input id="demo1" class="demo1" type="file" name="file" multiple
                                            placeholder="Select Files" />
                                        <input type="text" class="form-control msg-option__input" name="message"
                                            autocomplete="off" placeholder="@lang('Send Message')">
                                        <button type="submit" class="btn bg--base msg-option__button">
                                            <i class="lab la-telegram-plane text--black"></i>
                                        </button>
                                        <i class="lab la-file-upload"></i>
                                    </div>
                                </div>
                                {{-- <div class="preview_img mt-3">
                                    <div class="main_img">
                                      <picture>
                                             <img src="" id="preview" class="preview" alt="Not Image Selected">
                                      </picture>
                                    </div>
                                  </div> --}}
                                <div>


                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade custom--modal" id="actionModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Confirmation')!</h5>
                    <button type="button" class="close btn btn--danger" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>

                <form class="action-route" method="post">
                    @csrf
                    <input type="hidden" name="escrow_id" value="{{ encrypt($escrow->id) }}">
                    <div class="modal-body">
                        <h5 class="text-center action-msz"></h5>

                        <div class="col-md-12 mt-4 dispute-reason">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--base">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/chat.css') }}">
    <style>
        /* Plugin Style Start */
        .kwt-file {
            max-width: 380px;
            margin: 0 auto;
        }

        .kwt-file__delete {
            display: none !important;
        }

        .kwt-file__drop-area {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
            /* padding: 25px; */
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.07);
            transition: 0.3s;
        }

        .kwt-file__drop-area.is-active {
            background-color: #d1def0;
        }

        .kwt-file__choose-file {
            flex-shrink: 0;
            background-color: #ffffff;
            border-radius: 100%;
            margin-right: 10px;
            color: #202020;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .kwt-file__choose-file.kwt-file_btn-text {
            border-radius: 4px;
            width: auto;
            height: auto;
            padding: 10px 20px;
            font-size: 14px;
        }

        .kwt-file__choose-file svg {
            width: 24px;
            height: 24px;
            display: block;
        }

        .kwt-file__msg {
            color: #1d3557;
            font-size: 16px;
            font-weight: 400;
            line-height: 1.4;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: none;
        }

        .kwt-file__input {
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
            cursor: pointer;
            opacity: 0;
        }

        .kwt-file__input:focus {
            outline: none;
        }

        .kwt-file__delete {
            display: none;
            position: absolute;
            right: 10px;
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .kwt-file__delete:before {
            content: "";
            position: absolute;
            left: 0;
            transition: 0.3s;
            top: 0;
            z-index: 1;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg fill='%231d3557' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 438.5 438.5'%3e%3cpath d='M417.7 75.7A8.9 8.9 0 00411 73H323l-20-47.7c-2.8-7-8-13-15.4-18S272.5 0 264.9 0h-91.3C166 0 158.5 2.5 151 7.4c-7.4 5-12.5 11-15.4 18l-20 47.7H27.4a9 9 0 00-6.6 2.6 9 9 0 00-2.5 6.5v18.3c0 2.7.8 4.8 2.5 6.6a8.9 8.9 0 006.6 2.5h27.4v271.8c0 15.8 4.5 29.3 13.4 40.4a40.2 40.2 0 0032.3 16.7H338c12.6 0 23.4-5.7 32.3-17.2a64.8 64.8 0 0013.4-41V109.6h27.4c2.7 0 4.9-.8 6.6-2.5a8.9 8.9 0 002.6-6.6V82.2a9 9 0 00-2.6-6.5zm-248.4-36a8 8 0 014.9-3.2h90.5a8 8 0 014.8 3.2L283.2 73H155.3l14-33.4zm177.9 340.6a32.4 32.4 0 01-6.2 19.3c-1.4 1.6-2.4 2.4-3 2.4H100.5c-.6 0-1.6-.8-3-2.4a32.5 32.5 0 01-6.1-19.3V109.6h255.8v270.7z'/%3e%3cpath d='M137 347.2h18.3c2.7 0 4.9-.9 6.6-2.6a9 9 0 002.5-6.6V173.6a9 9 0 00-2.5-6.6 8.9 8.9 0 00-6.6-2.6H137c-2.6 0-4.8.9-6.5 2.6a8.9 8.9 0 00-2.6 6.6V338c0 2.7.9 4.9 2.6 6.6a8.9 8.9 0 006.5 2.6zM210.1 347.2h18.3a8.9 8.9 0 009.1-9.1V173.5c0-2.7-.8-4.9-2.5-6.6a8.9 8.9 0 00-6.6-2.6h-18.3a8.9 8.9 0 00-9.1 9.1V338a8.9 8.9 0 009.1 9.1zM283.2 347.2h18.3c2.7 0 4.8-.9 6.6-2.6a8.9 8.9 0 002.5-6.6V173.6c0-2.7-.8-4.9-2.5-6.6a8.9 8.9 0 00-6.6-2.6h-18.3a9 9 0 00-6.6 2.6 8.9 8.9 0 00-2.5 6.6V338a9 9 0 002.5 6.6 9 9 0 006.6 2.6z'/%3e%3c/svg%3e");
        }

        .kwt-file__delete:after {
            content: "";
            position: absolute;
            opacity: 0;
            left: 50%;
            top: 50%;
            width: 100%;
            height: 100%;
            transform: translate(-50%, -50%) scale(0);
            background-color: #1d3557;
            border-radius: 50%;
            transition: 0.3s;
        }

        .kwt-file__delete:hover:after {
            transform: translate(-50%, -50%) scale(2.2);
            opacity: 0.1;
        }

        /* Plugin Style End */

        .msg-send__content::before {
            display: block;
            clear: both;
            content: '';
            position: relative;
            top: -23px;
            left: -24px;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 0 12px 15px 12px;
            border-color: transparent transparent #f5f5f5 transparent;
            -webkit-transform: rotate(-37deg);
            -ms-transform: rotate(-37deg);
            transform: rotate(-37deg);
        }

        .msg-receive__content::before {
            display: block;
            clear: both;
            content: '';
            position: relative;
            bottom: -43px;
            right: -393px;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 0 12px 15px 12px;
            border-color: transparent transparent #e2f5fd transparent;
            -webkit-transform: rotate(37deg);
            -ms-transform: rotate(37deg);
            transform: rotate(37deg);
        }

        .msg-send__content {
            color: #000000;
            padding: 15px;
            font-size: 14px;
            text-align: right;
            border: 1px solid #f5f5f5;
            background: #8d8d8d17;
            border-radius: 10px;
            display: inline-block;
            max-width: 60ch;
            min-width: 29ch;
        }

        .msg-receive__content {
            color: #000000;
            padding: 15px;
            font-size: 14px;
            border: 1px solid rgb(var(--base)/.2);
            background: #E2F5FD;
            border-radius: 10px;
            display: inline-block;
            max-width: 60ch;
            min-width: 29ch;
        }

        .preview_img {
            /* width: 300px; */
            height: 190px;
            background: #e9e9e9;
            border-radius: 10px;
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            -ms-border-radius: 10px;
            -o-border-radius: 10px;
            padding: 20px;
        }

        .preview_img .main_img {
            width: 100%;
            height: 100%;
            overflow: hidden;
            box-shadow: inset 0 0 10px 0 #222222;
            border-radius: 10px;
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            -ms-border-radius: 10px;
            -o-border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .preview_img img {
            width: 100%;
            height: 100%;
            display: block;
        }

        .imgHidden {
            display: none;
        }

        .imgUploadCss {
            display: block;
            /* width: 300px; */
            background: #e9e9e9;
            font-size: 16px;
            font-weight: 400;
            color: #1f1f1f;
            font-family: 'Inter', sans-serif;
            padding: 20px 20px;
            margin-top: 16px;
            border-radius: 6px;
            -webkit-border-radius: 6px;
            -moz-border-radius: 6px;
            -ms-border-radius: 6px;
            -o-border-radius: 6px;
            position: relative;
            overflow: hidden;
            cursor: pointer;

        }

        img[alt="Not Image Selected"] {
            color: #c74444;
        }
    </style>
@endpush

@push('script')
    <script>
        // Image Upload Click Event 


        (function($) {
            /**
             * Create drag and drop element.
             */
            var customDragandDrop = function(element) {
                $(element).addClass("kwt-file__input");
                var element = $(element).wrap(
                    `<div class="kwt-file"><div class="kwt-file__drop-area"><span class='kwt-file__choose-file ${
				element.attributes.data_btn_text
					? "" === element.attributes.data_btn_text.textContent
						? ""
						: "kwt-file_btn-text"
					: ""
			}'>${
				element.attributes.data_btn_text
					? "" === element.attributes.data_btn_text.textContent
						? `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor"><path d="M67.508 468.467c-58.005-58.013-58.016-151.92 0-209.943l225.011-225.04c44.643-44.645 117.279-44.645 161.92 0 44.743 44.749 44.753 117.186 0 161.944l-189.465 189.49c-31.41 31.413-82.518 31.412-113.926.001-31.479-31.482-31.49-82.453 0-113.944L311.51 110.491c4.687-4.687 12.286-4.687 16.972 0l16.967 16.971c4.685 4.686 4.685 12.283 0 16.969L184.983 304.917c-12.724 12.724-12.73 33.328 0 46.058 12.696 12.697 33.356 12.699 46.054-.001l189.465-189.489c25.987-25.989 25.994-68.06.001-94.056-25.931-25.934-68.119-25.932-94.049 0l-225.01 225.039c-39.249 39.252-39.258 102.795-.001 142.057 39.285 39.29 102.885 39.287 142.162-.028A739446.174 739446.174 0 0 1 439.497 238.49c4.686-4.687 12.282-4.684 16.969.004l16.967 16.971c4.685 4.686 4.689 12.279.004 16.965a755654.128 755654.128 0 0 0-195.881 195.996c-58.034 58.092-152.004 58.093-210.048.041z" /></svg>`
						: `${element.attributes.data_btn_text.textContent}`
					: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor"><path d="M67.508 468.467c-58.005-58.013-58.016-151.92 0-209.943l225.011-225.04c44.643-44.645 117.279-44.645 161.92 0 44.743 44.749 44.753 117.186 0 161.944l-189.465 189.49c-31.41 31.413-82.518 31.412-113.926.001-31.479-31.482-31.49-82.453 0-113.944L311.51 110.491c4.687-4.687 12.286-4.687 16.972 0l16.967 16.971c4.685 4.686 4.685 12.283 0 16.969L184.983 304.917c-12.724 12.724-12.73 33.328 0 46.058 12.696 12.697 33.356 12.699 46.054-.001l189.465-189.489c25.987-25.989 25.994-68.06.001-94.056-25.931-25.934-68.119-25.932-94.049 0l-225.01 225.039c-39.249 39.252-39.258 102.795-.001 142.057 39.285 39.29 102.885 39.287 142.162-.028A739446.174 739446.174 0 0 1 439.497 238.49c4.686-4.687 12.282-4.684 16.969.004l16.967 16.971c4.685 4.686 4.689 12.279.004 16.965a755654.128 755654.128 0 0 0-195.881 195.996c-58.034 58.092-152.004 58.093-210.048.041z" /></svg>`
			}</span>${element.outerHTML}</span><span class="kwt-file__msg">${
				"" === element.placeholder ? "or drop files here" : `${element.placeholder}`
			}</span><div class="kwt-file__delete"></div></div></div>`
                );
                var element = element.parents(".kwt-file");

                // Add class on focus and drage enter event.
                element.on("dragenter focus click", ".kwt-file__input", function(e) {
                    $(this).parents(".kwt-file__drop-area").addClass("is-active");
                });

                // Remove class on blur and drage leave event.
                element.on("dragleave blur drop", ".kwt-file__input", function(e) {
                    $(this).parents(".kwt-file__drop-area").removeClass("is-active");
                });

                // Show filename when change file.
                element.on("change", ".kwt-file__input", function(e) {
                    let filesCount = $(this)[0].files.length;
                    let textContainer = $(this).next(".kwt-file__msg");
                    if (1 === filesCount) {
                        let fileName = $(this).val().split("\\").pop();
                        textContainer
                            .text(fileName)
                            .next(".kwt-file__delete")
                            .css("display", "block");
                    } else if (filesCount > 1) {
                        textContainer
                            .text(filesCount + " files selected")
                            .next(".kwt-file__delete")
                            .css("display", "inline-block");
                    } else {
                        textContainer.text(
                            `${
						"" === this[0].placeholder
							? "or drop files here"
							: `${this[0].placeholder}`
					}`
                        );
                        $(this)
                            .parents(".kwt-file")
                            .find(".kwt-file__delete")
                            .css("display", "none");
                    }
                });

                // Delete selected file.
                element.on("click", ".kwt-file__delete", function(e) {
                    let deleteElement = $(this);
                    deleteElement.parents(".kwt-file").find(`.kwt-file__input`).val(null);
                    deleteElement
                        .css("display", "none")
                        .prev(`.kwt-file__msg`)
                        .text(
                            `${
						"" ===
						$(this).parents(".kwt-file").find(".kwt-file__input")[0].placeholder
							? "or drop files here"
							: `${
                									$(this).parents(".kwt-file").find(".kwt-file__input")[0].placeholder
                							  }`
					}`
                        );
                });
            };

            $.fn.kwtFileUpload = function(e) {
                var _this = $(this);
                $.each(_this, function(index, element) {
                    customDragandDrop(element);
                });
                return this;
            };
        })(jQuery);

        // Plugin initialize
        jQuery(document).ready(function($) {
            $(".demo1").kwtFileUpload();
        });


        function ReadUrl(input) {
            let reader = new FileReader();
            reader.onload = function(e) {
                imgUrl = e.target.result
                $('#preview').attr('src', e.target.result)
            }
            reader.readAsDataURL(input)

        }


        (function($) {
            "use strict";
            $(".msg_history").animate({
                scrollTop: $('.msg_history').prop("scrollHeight")
            }, 1);

            var actionModal = $('#actionModal');

            $('.user-action').on('click', function() {
                var value = $(this).data('value');
                var route = $(this).data('route');
                var actionMsz;

                if (value == 1) {
                    actionMsz = `@lang('Are you sure to dispatch this escrow?')`;
                    actionModal.find('.dispute-reason').empty();

                } else if (value == 2) {
                    actionMsz = `@lang('Are you sure to accept this escrow?')`;
                    actionModal.find('.dispute-reason').empty();

                } else if (value == 8) {
                    actionMsz = `@lang('Are you sure to dispute this escrow?')`;
                    actionModal.find('.dispute-reason').html(`
                        <label class="d-block mb-2 sm-text">@lang('Remark')</label>
                        <textarea class="form-control form--control-textarea" name="details" rows="3" placeholder="@lang('Enter the reason')" required></textarea>
                    `);
                } else {
                    actionMsz = `@lang('Are you sure to cancel this escrow?')`;
                    actionModal.find('.dispute-reason').empty();
                }

                actionModal.find('.action-msz').html(actionMsz);
                actionModal.find('.action-route').attr('action', route);
                actionModal.modal('show');
            });

            $('.message-form').submit(function(e) {
                e.preventDefault();
                $(this).find('button[type=submit]').removeAttr('disabled');
                var url = '{{ route('user.escrow.message.reply') }}';

                // var data = {
                //     _token: "{{ csrf_token() }}",
                //     conversation_id: "{{ $conversation->id }}",
                //     message: $(this).find('[name=message]').val(),
                //     file : $('#file')[0].file,

                // }  
                var formData = new FormData(this);

                $.ajax({
                    async: true,
                    type: 'post',
                    url: url,
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,

                    success: function(response) {
                        if (response['error']) {
                            $.each(response['error'], function(i, v) {
                                notify('error', v);
                            });
                            return true;
                        }
                        let file = response['file'];

                        console.log(response['file_type']);
                        let file_message = '';
                        if (response['file_type']) {
                            if (response['file_type'] == 'png' || response['file_type'] == 'jpg') {
                                file_message = `
                                <img class="img-fluid imgUploadCss"
                                                                src="{{ url('') }}/uploads/${response['file'] }"
                                                                alt="">
                                `
                            } else {
                                file_message = `
                                <a href="{{ url('') }}/uploads/${$response['file']}"
                                                                target="_blank">${$response['file']}</a>
                                `
                            }

                        }
                        var html = `
                            <li class="msg-list__item">
                                <div class="msg-send">
                                    <div class="msg-send__content">
                                        <p class="msg-send__text mb-0">
                                            ${response['message']}
                                            <br>
                                            ${file_message}

                                        </p>
                                    </div>
                                    <ul class="list msg-send__history  justify-content-end ">
                                        <li class="msg-receive__history-item">${response['created_time']}</li>
                                        <li class="msg-receive__history-item">${response['created_diff']}</li>
                                    </ul>
                                </div>
                            </li>
                    `;

                        $('.msg-list').append(html);
                        $(".msg_history").animate({
                            scrollTop: $('.msg_history').prop("scrollHeight")
                        }, 1);
                    },
                    error: function(request, status, error) {
                        console.log("error")
                    }
                });


                $(this).find('[name=message]').val('')
                $('#file').val(null)

            });

            $('.reloadButton').click(function() {
                var url = '{{ route('user.escrow.message.get') }}';
                var data = {
                    conversation_id: "{{ $conversation->id }}"
                }
                $.get(url, data, function(response) {
                    if (response['error']) {
                        $.each(response['error'], function(i, v) {
                            notify('error', v);
                        });
                        return true;
                    }
                    // console.log('dd', response)
                    $('.msg-list').html(response);
                    $(".msg_history").animate({
                        scrollTop: $('.msg_history').prop("scrollHeight")
                    }, 1);
                });
            });

        })(jQuery);
    </script>
@endpush
