@extends('admin.layouts.app')
@section('panel')
<div class="row">
    @forelse($transactions as $trx)
       
        <div class="col-md-12">
            <div class="col-md-8 mb-4 container">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <span style="font-weight: 800;">
                                    <span class="font-weight-bold @if($trx->trx_type == '+') text--success @else text--danger @endif">
                                        {{ $trx->trx_type }} {{showAmount($trx->amount)}} {{ $trx->currency_sym }}
                                    </span>
                                </span>
                                <span class="float-right">
                                    {{ showDateTime($trx->created_at) }}<br>{{ diffForHumans($trx->created_at) }}
                                </span>
                            </div>
                            <div class="col-md-12 mt-3">
                                <span>

                                    {{-- <span class="font-weight-bold"><a
                                            href="{{ route('admin.withdraw.method', [$withdraw->method->id, 'all']) }}">
                                            {{ __(@$withdraw->method->name) }}</a></span> --}}
                                    <br>
                                    <small>{{ $trx->trx }}</small>

                                    <br>
                                    {{ showAmount($trx->post_balance) }} {{ __($trx->currency_sym) }}

                                </span>
                                <span class="float-right">
                                    {{ __($trx->details) }}
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
                                <th>@lang('Trx')</th>
                                <th>@lang('Transacted')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Post Balance')</th>
                                <th>@lang('Detail')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $trx)
                                <tr>
                                    <td data-label="#@lang('Trx')">{{ $trx->trx }}</td>
                                    <td data-label="@lang('Transacted')">
                                        {{ showDateTime($trx->created_at) }}<br>{{ diffForHumans($trx->created_at) }}
                                    </td>

                                    <td data-label="@lang('Amount')" class="budget">
                                        <span class="font-weight-bold @if($trx->trx_type == '+') text--success @else text--danger @endif">
                                            {{ $trx->trx_type }} {{showAmount($trx->amount)}} {{ $trx->currency_sym }}
                                        </span>
                                    </td>

                                    <td data-label="@lang('Post Balance')" class="budget">
                                        {{ showAmount($trx->post_balance) }} {{ __($trx->currency_sym) }}
                                    </td>


                                    <td data-label="@lang('Detail')">{{ __($trx->details) }}</td>
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
                        {{$transactions->links()}}
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
@endsection
