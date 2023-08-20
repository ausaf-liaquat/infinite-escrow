@extends('admin.layouts.app')

@section('panel')
    <section class="section dashboard-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-8 container mb-2">
                                <div class="card">
                                    <div class="card-body text-center"
                                        style="background: #ededed;padding-top: 5px;padding-bottom: 5px;border-radius:5px;">
                                        <div class="row">
                                            <div class="col-md-6 {{ Route::currentRouteName() == 'ticket' ? 'active-route' : '' }}"
                                                style="border-radius:5px;">
                                                <a href="{{ route('ticket') }}"
                                                    style="color: #000;
                                                font-size: 14px;
                                                font-weight: 700;">
                                                    All
                                                </a>

                                            </div>
                                            <div class="col-md-6 {{ Route::currentRouteName() == 'ticket.open.status' ? 'active-route' : '' }}"
                                                style="border-radius:5px;">
                                                <a href="{{ route('ticket.open.status') }}"
                                                    style="color: #000;
                                                font-size: 14px;
                                                font-weight: 700;">Only
                                                    Opens</a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        @forelse($supports as $item)
                            <div class="col-md-12">
                                <div class="col-md-8 mb-4 container">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">

                                                <div class="col-md-12">
                                                    <span
                                                        style="    font-weight: 800;
                                                padding: 5px;
                                                border-left: 4px solid #f00;">

                                                        Ticket #{{ $item->ticket }}
                                                    </span>
                                                    <span class="float-right">
                                                        @if ($item->status == 0)
                                                            <span class="badge badge--success">@lang('Open')</span>
                                                        @elseif($item->status == 1)
                                                            <span class="badge  badge--primary">@lang('Answered')</span>
                                                        @elseif($item->status == 2)
                                                            <span class="badge badge--warning">@lang('Customer Reply')</span>
                                                        @elseif($item->status == 3)
                                                            <span class="badge badge--dark">@lang('Closed')</span>
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="col-md-12 mt-3">
                                                    <span>

                                                        <strong>{{ __($item->subject) }}</strong>
                                                        <br>
                                                        {{ \Carbon\Carbon::parse($item->last_reply)->diffForHumans() }} Last
                                                        Reply


                                                    </span>
                                                    <span class="float-right">

                                                        <a href="{{ route('ticket.view', $item->ticket) }}"
                                                            class="icon-btn activateBtn  ml-1" data-toggle="tooltip">
                                                            Details <i class="las la-angle-right"></i>
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
                                            No Data Found
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforelse

                       
                    </div>
                    <a class="btn float-lg-right" href="{{route('ticket.open')}}" style="background: #96ff0e;
                    border: none;
                    padding: 15px;
                    border-radius: 0px;font-weight:700;">
                      <i class="fas fa-plus"></i>   New Ticket
                    </a>
                    {{-- <table class="table custom--table table-responsive--md">
                        <thead>
                            <tr>
                                <th></th>
                                <th>@lang('Subject')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Priority')</th>
                                <th>@lang('Last Reply')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($supports as $support)
                                <tr id="tr_{{$support->id}}">
                                    <td>                                    <input type="checkbox" class="checkbox" data-id="{{$support->id}}">
                                    </td>
                                    <td data-label="@lang('Subject')"> <a href="{{ route('ticket.view', $support->ticket) }}" class="font-weight-bold"> [@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }} </a></td>
                                    <td data-label="@lang('Status')">
                                        @if ($support->status == 0)
                                            <span class="badge badge--success">@lang('Open')</span>
                                        @elseif($support->status == 1)
                                            <span class="badge badge--primary">@lang('Answered')</span>
                                        @elseif($support->status == 2)
                                            <span class="badge badge--warning">@lang('Customer Reply')</span>
                                        @elseif($support->status == 3)
                                            <span class="badge badge--dark">@lang('Closed')</span>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Priority')">
                                        @if ($support->priority == 1)
                                            <span class="badge badge--dark">@lang('Low')</span>
                                        @elseif($support->priority == 2)
                                            <span class="badge badge--success">@lang('Medium')</span>
                                        @elseif($support->priority == 3)
                                            <span class="badge badge--primary">@lang('High')</span>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Last Reply')">{{ \Carbon\Carbon::parse($support->last_reply)->diffForHumans() }} </td>

                                    <td data-label="@lang('Action')">
                                        <a href="{{ route('ticket.view', $support->ticket) }}" class="btn btn--base btn-sm"><i class="fa fa-desktop"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-center">@lang('No ticket found')</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table> --}}
                </div>
            </div>

            {{-- <div class="row">
                <div class="col-md-12">
                    <div class="mt-5">
                        {{$supports->links()}}
                    </div>
                </div>
            </div> --}}
        </div>
    </section>
@endsection
@push('style')
    <style>
        .active-route {
            background: #fff;
        }
    </style>
@endpush
