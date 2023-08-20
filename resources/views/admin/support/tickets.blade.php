@extends('admin.layouts.app')

@section('panel')<form action="{{ route('admin.ticket_all.delete') }}" method="POST">
                    @csrf
    <div class="row"> 
        <div class="col-lg-12">
            
            <div class="row">
               
               
                @forelse($items as $item)
                @if ($loop->first)
                    
                <div class="col-md-12">  <div class="col-md-8 mb-4 container"> <button class="btn btn-danger mb-10" type="submit">Delete</button> <br><input type="checkbox" id="check_all"></div></div>
                    
                @endif
                    <div class="col-md-12">
                        <div class="col-md-8 mb-4 container">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12"><input name="idticket[]" type="checkbox" class="checkbox"
                                            value="{{ $item->id }}"></div>
                                        <div class="col-md-12">
                                            <span style="    font-weight: 800;
                                            padding: 5px;
                                            border-left: 4px solid #f00;">
                                                
                                                #{{ $item->ticket }}
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

                                                {{ __($item->subject) }}
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
                                    {{ __($emptyMessage) }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
               
            </div>
            {{-- <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <form action="{{ route('admin.ticket_all.delete') }}" method="POST">
                        @csrf
                     
                        <div class="table-responsive--sm table-responsive">
                            <table class="table table--light">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="check_all"></th>
                                        <th>@lang('Subject')</th>
                                        <th>@lang('Submitted By')</th>
                                        <th>@lang('Status')</th>
                                        <th>@lang('Priority')</th>
                                        <th>@lang('Last Reply')</th>
                                        <th>@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($items as $item)
                                        <tr id="tr_{{ $item->id }}">
                                            <td> <input name="idticket[]" type="checkbox" class="checkbox"
                                                    value="{{ $item->id }}">
                                            </td>
                                            <td data-label="@lang('Subject')">
                                                <a href="{{ route('admin.ticket.view', $item->id) }}"
                                                    class="font-weight-bold">
                                                    [@lang('Ticket')#{{ $item->ticket }}] {{ $item->subject }} </a>
                                            </td>

                                            <td data-label="@lang('Submitted By')">
                                                @if ($item->user_id)
                                                    <a href="{{ route('admin.users.detail', $item->user_id) }}">
                                                        {{ @$item->user->fullname }}</a>
                                                @else
                                                    <p class="font-weight-bold"> {{ $item->name }}</p>
                                                @endif
                                            </td>
                                            <td data-label="@lang('Status')">
                                                @if ($item->status == 0)
                                                    <span class="badge badge--success">@lang('Open')</span>
                                                @elseif($item->status == 1)
                                                    <span class="badge  badge--primary">@lang('Answered')</span>
                                                @elseif($item->status == 2)
                                                    <span class="badge badge--warning">@lang('Customer Reply')</span>
                                                @elseif($item->status == 3)
                                                    <span class="badge badge--dark">@lang('Closed')</span>
                                                @endif
                                            </td>
                                            <td data-label="@lang('Priority')">
                                                @if ($item->priority == 1)
                                                    <span class="badge badge--dark">@lang('Low')</span>
                                                @elseif($item->priority == 2)
                                                    <span class="badge  badge--warning">@lang('Medium')</span>
                                                @elseif($item->priority == 3)
                                                    <span class="badge badge--danger">@lang('High')</span>
                                                @endif
                                            </td>

                                            <td data-label="@lang('Last Reply')">
                                                {{ diffForHumans($item->last_reply) }}
                                            </td>

                                            <td data-label="@lang('Action')">
                                                <a href="{{ route('admin.ticket.view', $item->id) }}"
                                                    class="icon-btn  ml-1" data-toggle="tooltip" title=""
                                                    data-original-title="@lang('Details')">
                                                    <i class="las la-desktop"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table><!-- table end -->
                        </div>
                    </form>
                </div>
                <div class="card-footer py-4">
                    {{ paginateLinks($items) }}
                </div>
            </div><!-- card end --> --}}
        </div>
    
    </div></form>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $('#check_all').on('click', function(e) {
                if ($(this).is(':checked', true)) {
                    $(".checkbox").prop('checked', true);
                } else {
                    $(".checkbox").prop('checked', false);
                }
            });
            $('.checkbox').on('click', function() {
                if ($('.checkbox:checked').length == $('.checkbox').length) {
                    $('#check_all').prop('checked', true);
                } else {
                    $('#check_all').prop('checked', false);
                }
            });
        });
    </script>
@endpush
