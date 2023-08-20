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

                                                <a href="{{ route('admin.escrow.details', $escrow->id) }}" class="icon-btn"
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
@endsection
