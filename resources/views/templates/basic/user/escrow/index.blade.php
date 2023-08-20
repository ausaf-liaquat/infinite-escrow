{{-- @extends($activeTemplate.'layouts.master') --}}
@extends('admin.layouts.app')
@section('panel')
<div class="row justify-content-center">
    <div class="col-lg-12 col-md-12 mb-30">
        <div class="row">
            @forelse ($escrows as $escrow)
                <div class="col-md-12">
                    <div class="col-md-8 mb-4 container">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <span style="font-weight: 800;">
                                            {{ $general->cur_sym }}{{ showAmount($escrow->amount) }}
                                        </span>
                                        <span class="float-right">
                                            {{ \Carbon\Carbon::parse($escrow->updated_at)->diffForHumans() }}
                                        </span>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <span>

                                            {{ __($escrow->title) }}

                                            <br>
                                            @php echo $escrow->escrowStatus @endphp


                                        </span>
                                        <span class="float-right">

                                            <a href="{{ route('user.escrow.details',encrypt($escrow->id)) }}" class="icon-btn"
                                                data-toggle="tooltip" title=""
                                                data-original-title="@lang('Details')">
                                                More <i class="las la-angle-right"></i>
                                            </a>
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
     
    </div>
</div>
    {{-- <section class="section dashboard-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-12">
                    
                    <table class="table custom--table table-responsive--md">
                        <thead>
                            <tr>
                                <th>@lang('Title')</th>
                                <th>@lang('Buyer - Seller')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Category')</th>
                                <th>@lang('Charge')</th>
                                <th>@lang('Charge Payer')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($escrows as $escrow)
                                <tr>
                                    <td data-label="@lang('Title')">{{ __($escrow->title) }}</td>
                                    <td data-label="@lang('Buyer - Seller')">
                                        @lang('I\'m') @if($escrow->buyer_id == auth()->user()->id) @lang('buying from') {{ __(@$escrow->seller->username ?? $escrow->invitation_mail) }} @else @lang('selling to') {{ __(@$escrow->buyer->username ?? $escrow->invitation_mail) }} @endif
                                    </td>
                                    <td data-label="@lang('Amount')">{{ $general->cur_sym }}{{ showAmount($escrow->amount) }}</td>
                                    <td data-label="@lang('Category')">{{ $escrow->category->name }}</td>
                                    <td data-label="@lang('Charge')">{{ $general->cur_sym }}{{ showAmount($escrow->charge) }}</td>
                                    <td data-label="@lang('Charge Payer')">
                                        @if($escrow->charge_payer == 1)
                                            <span class="badge badge--dark">@lang('Seller')</span>
                                        @elseif($escrow->charge_payer == 2)
                                            <span class="badge badge--info">@lang('Buyer')</span>
                                        @else
                                            <span class="badge badge--success">@lang('50%-50%')</span>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Status')">
                                        @php echo $escrow->escrowStatus @endphp
                                    </td>
                                    <td data-label="@lang('Action')">
                                        <a href="{{ route('user.escrow.details',encrypt($escrow->id)) }}" class="btn btn--base btn-sm">@lang('Details')</a>
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
                        {{$escrows->links()}}
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
@endsection
