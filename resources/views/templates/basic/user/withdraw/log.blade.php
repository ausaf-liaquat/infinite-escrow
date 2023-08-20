@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        @forelse($withdraws as $withdraw)
            @php
                $details = $withdraw->withdraw_information != null ? json_encode($withdraw->withdraw_information) : null;
            @endphp
            <div class="col-md-12">
                <div class="col-md-8 mb-4 container">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <span style="font-weight: 800;">
                                        {{ __($general->cur_sym) }}{{ showAmount($withdraw->amount) }} - <span
                                            class="text-danger" data-toggle="tooltip"
                                            data-original-title="@lang('charge')">{{ showAmount($withdraw->charge) }}
                                        </span>
                                        <br>
                                        <strong data-toggle="tooltip" data-original-title="@lang('Amount after charge')">
                                            {{ showAmount($withdraw->amount - $withdraw->charge) }}
                                            {{ __($general->cur_text) }}
                                        </strong>
                                    </span>
                                    <span class="float-right">
                                        {{ showDateTime($withdraw->created_at) }} <br>
                                        {{ diffForHumans($withdraw->created_at) }}
                                    </span>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <span>

                                        <span class="font-weight-bold"><a
                                                href="#">
                                                {{ __(@$withdraw->method->name) }}</a></span>
                                        <br>
                                        <small>{{ $withdraw->trx }}</small>

                                        <br>
                                        @if ($withdraw->status == 2)
                                            <span
                                                class="text--small badge font-weight-normal badge--warning">@lang('Pending')</span>
                                        @elseif($withdraw->status == 1)
                                            <span
                                                class="text--small badge font-weight-normal badge--success">@lang('Approved')</span>
                                            <span class="badge badge--info approveBtn"
                                                data-admin_feedback="{{ __($withdraw->admin_feedback) }}"><i
                                                    class="la la-info"></i></span>

                                            <br>{{ diffForHumans($withdraw->updated_at) }}
                                        @elseif($withdraw->status == 3)
                                            <span
                                                class="text--small badge font-weight-normal badge--danger">@lang('Rejected')</span>
                                            <span class="badge badge--info approveBtn"
                                                data-admin_feedback="{{ __($withdraw->admin_feedback) }}"><i
                                                    class="la la-info"></i></span>
                                            <br>{{ diffForHumans($withdraw->updated_at) }}
                                        @endif


                                    </span>
                                    <span class="float-right">

                                        {{-- <a href="{{ route('admin.withdraw.details', $withdraw->id) }}"
                                        class="icon-btn" data-toggle="tooltip" title=""
                                        data-original-title="@lang('Details')">
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
                                <th>@lang('Charge')</th>
                                <th>@lang('After Charge')</th>
                                <th>@lang('Rate')</th>
                                <th>@lang('Receivable')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Date')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($withdraws as $k=>$data)
                                <tr>
                                    <td data-label="#@lang('Trx')">{{$data->trx}}</td>
                                    <td data-label="@lang('Gateway')">{{ __($data->method->name) }}</td>
                                    <td data-label="@lang('Amount')">
                                        <strong>{{showAmount($data->amount)}} {{__($general->cur_text)}}</strong>
                                    </td>
                                    <td data-label="@lang('Charge')" class="text-danger">
                                        {{showAmount($data->charge)}} {{__($general->cur_text)}}
                                    </td>
                                    <td data-label="@lang('After Charge')">
                                        {{showAmount($data->after_charge)}} {{__($general->cur_text)}}
                                    </td>
                                    <td data-label="@lang('Rate')">
                                        {{showAmount($data->rate)}} {{__($data->currency)}}
                                    </td>
                                    <td data-label="@lang('Receivable')" class="text-success">
                                        <span class="text--success">{{showAmount($data->final_amount)}} {{__($data->currency)}}</span>
                                    </td>
                                    <td data-label="@lang('Status')">
                                        @if ($data->status == 2)
                                            <span class="badge badge--warning">@lang('Pending')</span>
                                        @elseif($data->status == 1)
                                            <span class="badge badge--success">@lang('Completed')</span>
                                            <span class="badge badge--info approveBtn" data-admin_feedback="{{__($data->admin_feedback)}}"><i class="la la-info"></i></span>
                                        @elseif($data->status == 3)
                                            <span class="badge badge--danger">@lang('Rejected')</span>
                                            <span class="badge badge--info approveBtn" data-admin_feedback="{{__($data->admin_feedback)}}"><i class="la la-info"></i></span>
                                        @endif

                                    </td>
                                    <td data-label="@lang('Date')">
                                        {{showDateTime($data->created_at,'Y-m-d')}}
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
                        {{$withdraws->links()}}
                    </div>
                </div>
            </div>
        </div>
    </section> --}}


    {{-- Detail MODAL --}}
    <div id="detailModal" class="modal fade custom--modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                    <button type="button" class="close btn btn--danger" data-bs-dismiss="modal" aria-label="Close">
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
        .approveBtn {
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
                var modal = $('#detailModal');
                var feedback = $(this).data('admin_feedback');
                modal.find('.withdraw-detail').html(`<p> ${feedback} </p>`);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
