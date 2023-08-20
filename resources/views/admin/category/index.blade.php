@extends('admin.layouts.app')

@section('panel')

    <div class="row">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('SL')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @forelse ($categories as $category)
                                    <tr>
                                        <td data-label="@lang('SL')">{{ $categories->firstItem() + $loop->index }}</td>
                                        <td data-label="@lang('Name')">{{__($category->name)}}</td>
                                        <td data-label="@lang('Status')">
                                            @if ($category->status == 1)
                                                <span class="badge badge--success">@lang('Active')</span>
                                            @else
                                                <span class="badge badge--danger">@lang('Deactive')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Action')">
                                            <button type="button" class="icon-btn cuModalBtn" data-resource="{{$category}}" data-has_status="1" data-modal_title="@lang('Update Category')"><i class="la la-pencil-alt"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{__($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($categories->hasPages())
                    <div class="card-footer py-4">
                        {{ $categories->links('admin.partials.paginate') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Category MODAL --}}
    <div id="cuModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.category.store')}}"  method="POST">
                    @csrf

                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Name')</label>
                            <input type="text" class="form-control name" name="name" required>
                        </div>

                        <div class="status">

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

@push('breadcrumb-plugins')
    <button type="button" class="btn btn--primary mr-3 mt-2 cuModalBtn" data-modal_title="@lang('Add New Category')"><i class="las la-plus"></i>@lang('Add New')</button>

    <form action="{{ route('admin.category.index') }}" method="GET" class="form-inline float-sm-right bg--white mt-2">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('Name')" value="{{ request()->search }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="las la-search"></i></button>
            </div>
        </div>
    </form>
@endpush

