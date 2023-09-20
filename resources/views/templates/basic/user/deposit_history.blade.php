@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        @forelse($logs as $k=>$data)
          
            <div class="col-md-12">
                <div class="col-md-8 mb-4 container">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <span style="font-weight: 800;">
                                        {{ showAmount($data->amount) }} {{ __($data->method_currency) }}
                                    </span>
                                    <span class="float-right">
                                        {{ \Carbon\Carbon::parse($data->updated_at)->diffForHumans() }}
                                    </span>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <span>

                                        Code: {{ __($data->trx) }}

                                        <br>
                                        @if ($data->status == 1)
                                            <span class="badge badge--success">@lang('Complete')</span>
                                            <br>{{ diffForHumans($data->updated_at) }}
                                        @elseif($data->status == 2)
                                            <span class="badge badge--warning">@lang('Pending')</span>
                                            <br>{{ diffForHumans($data->updated_at) }}
                                        @elseif($data->status == 3)
                                            <span class="badge badge--danger">@lang('Cancel')</span>
                                            <br>{{ diffForHumans($data->updated_at) }}
                                        @endif

                                        @if ($data->admin_feedback != null)
                                            <button class="badge badge--info detailBtn"
                                                data-admin_feedback="{{ __($data->admin_feedback) }}"><i
                                                    class="la la-info"></i></button>
                                        @endif

                                    </span>
                                    @php
                                    $details = $data->detail != null ? json_encode($data->detail) : null;
                                    // dd($details);
                                @endphp
                                    <span class="float-right">
                                        <a href="javascript:void(0)" class="btn btn--base btn-sm approveBtn"
                                        data-info="{{ $details }}" data-id="{{ $data->id }}"
                                        data-amount="{{ showAmount($data->amount) }} {{ __($data->method_currency) }}"
                                        data-charge="{{ showAmount($data->charge) }} {{ __($data->method_currency) }}"
                                        data-after_charge="{{ showAmount($data->amount + $data->charge) }} {{ __($data->method_currency) }}"
                                        data-rate="{{ showAmount($data->rate) }} {{ __($data->method_currency) }}"
                                        data-payable="{{ showAmount($data->final_amo) }} {{ __($data->method_currency) }}">
                                        More <i class="las la-angle-right"></i>
                                    </a>
                                        {{-- <a href="{{ route('admin.deposit.details', $deposit->id) }}" class="icon-btn"
                                            data-toggle="tooltip" title="" data-original-title="@lang('Details')">
                                            More <i class="las la-angle-right"></i>
                                        </a> --}}
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        @empty
            <div class="col-md-12">
                <div class="col-md-8 container">
                    <div class="card">
                        <div class="card-body">
                            {{ __($emptyMessage) }}
                        </div>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
    {{-- <section class="section dashboard-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-12">

                    <table class="table custom--table table-responsive--md">
                        <thead>
                            <tr>
                                <th>@lang('Transaction ID')</th>
                                <th>@lang('Gateway')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Date')</th>
                                <th> @lang('More')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $k=>$data)
                                <tr>
                                    <td data-label="#@lang('Trx')">{{ $data->trx }}</td>
                                    <td data-label="@lang('Gateway')">{{ __(@$data->gateway->name) }}</td>
                                    <td data-label="@lang('Amount')">
                                        <strong>{{ showAmount($data->amount) }} {{ __($data->method_currency) }}</strong>
                                    </td>
                                    <td>
                                        @if ($data->status == 1)
                                            <span class="badge badge--success">@lang('Complete')</span>
                                        @elseif($data->status == 2)
                                            <span class="badge badge--warning">@lang('Pending')</span>
                                        @elseif($data->status == 3)
                                            <span class="badge badge--danger">@lang('Cancel')</span>
                                        @endif

                                        @if ($data->admin_feedback != null)
                                            <button class="badge badge--info detailBtn"
                                                data-admin_feedback="{{ __($data->admin_feedback) }}"><i
                                                    class="la la-info"></i></button>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Date')">
                                        {{ showDateTime($data->created_at, 'Y-m-d') }}
                                    </td>

                                    @php
                                        $details = $data->detail != null ? json_encode($data->detail) : null;
                                    @endphp

                                    <td data-label="@lang('Details')">
                                        <a href="javascript:void(0)" class="btn btn--base btn-sm approveBtn"
                                            data-info="{{ $details }}" data-id="{{ $data->id }}"
                                            data-amount="{{ showAmount($data->amount) }} {{ __($data->method_currency) }}"
                                            data-charge="{{ showAmount($data->charge) }} {{ __($data->method_currency) }}"
                                            data-after_charge="{{ showAmount($data->amount + $data->charge) }} {{ __($data->method_currency) }}"
                                            data-rate="{{ showAmount($data->rate) }} {{ __($data->method_currency) }}"
                                            data-payable="{{ showAmount($data->final_amo) }} {{ __($data->method_currency) }}">
                                            <i class="las la-desktop"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    {{-- APPROVE MODAL --}}
    <div id="approveModal" class="modal fade custom--modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                    <button type="button" class="close btn btn--danger" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">@lang('Amount') : <span class="withdraw-amount "></span></li>
                        <li class="list-group-item">@lang('Charge') : <span class="withdraw-charge "></span></li>
                        <li class="list-group-item">@lang('After Charge') : <span class="withdraw-after_charge"></span></li>
                        {{-- <li class="list-group-item">@lang('Conversion Rate') : <span class="withdraw-rate"></span></li> --}}
                        <li class="list-group-item">@lang('Payable Amount') : <span class="withdraw-payable"></span></li>
                    </ul>
                    <ul class="list-group list-group-flush withdraw-detail mt-1">
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Detail MODAL --}}
    <div id="detailModal" class="modal fade custom--modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                    <button type="button" class="close btn btn--danger" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="withdraw-detail"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .detailBtn {
            padding: 3px 5px !important;
            cursor: pointer;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.approveBtn').on('click', function() {
                var modal = $('#approveModal');
                modal.find('.withdraw-amount').text($(this).data('amount'));
                modal.find('.withdraw-charge').text($(this).data('charge'));
                modal.find('.withdraw-after_charge').text($(this).data('after_charge'));
                modal.find('.withdraw-rate').text($(this).data('rate'));
                modal.find('.withdraw-payable').text($(this).data('payable'));
                var list = [];
                var details = $(this).data('info');

                var ImgPath = "{{ asset(imagePath()['verify']['deposit']['path']) }}/";
                var singleInfo = '';
                
                for (var i = 0; i < details.length; i++) {
                  console.log(details[i]);  
                    if (details[i][1] == "" && details[i][1].type == 'file') {
                        singleInfo += `<li class="list-group-item">
                                            <span class="font-weight-bold "> ${details[i][0].replaceAll('_', " ")} </span> : <img src="${ImgPath}/${details[i][1].field_name}" alt="@lang('Image')" class="w-100">
                                        </li>`;
                    } else {
                        singleInfo += `<li class="list-group-item">
                                            <span class="font-weight-bold "> ${details[i][0].replaceAll('_', " ")} </span> : <span class="font-weight-bold ml-3">${details[i][1].field_name}</span>
                                        </li>`;
                    }
                }

                if (singleInfo) {
                    modal.find('.withdraw-detail').html(
                        `<br><strong class="my-3">@lang('Payment Information')</strong>  ${singleInfo}`);
                } else {
                    modal.find('.withdraw-detail').html(`${singleInfo}`);
                }
                modal.modal('show');
            });

            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');
                var feedback = $(this).data('admin_feedback');
                modal.find('.withdraw-detail').html(`<p> ${feedback} </p>`);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
