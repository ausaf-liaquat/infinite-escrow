@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                @forelse($users as $user)
                    <div class="col-md-12">
                        <div class="col-md-8 mb-4 container">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <span class="font-weight-bold">

                                                {{ $general->cur_sym }}{{ showAmount($user->balance) }}
                                            </span>



                                            <span class="float-right">
                                                {{ showDateTime($user->created_at) }} <br>
                                                {{ diffForHumans($user->created_at) }}
                                            </span>
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <span>

                                                {{ $user->fullname }}

                                                <span class="small">
                                                    <a
                                                        href="{{ route('admin.users.detail', $user->id) }}"><span>@</span>{{ $user->username }}</a>
                                                </span>
                                                <br>
                                                @if ($user->status == 0)
                                                    <span
                                                        class="text--small badge font-weight-normal badge--danger">@lang('Banned')</span>
                                                @else
                                                    <span
                                                        class="text--small badge font-weight-normal badge--success">@lang('Active')</span>
                                                @endif

                                            </span>
                                            <span class="float-right">

                                                <a href="{{ route('admin.users.detail', $user->id) }}" class="icon-btn"
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



@push('breadcrumb-plugins')
    <form
        action="{{ route('admin.users.search',$scope ??str_replace('admin.users.','',request()->route()->getName())) }}"
        method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('Username or email')"
                value="{{ $search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
@endpush
