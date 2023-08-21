@extends('admin.layouts.app')

@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <form action="{{ route('admin.charge.global') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="form-control-label font-weight-bold"> @lang('Charge Cap') <span
                                        class="text-danger">*</span> <code
                                        class="text--primary">(@lang('Keep 0 for no charge cap'))</code></label>

                                <div class="input-group has_append">
                                    <input type="number" step="any" class="form-control" name="charge_cap"
                                        value="{{ getAmount($general->charge_cap) }}" required>
                                    <div class="input-group-append">
                                        <select is="ms-dropdown" class="input-group-text text-accent" name="currency_sym"
                                            id="amount_sym" style="border: none;font-size: 15px;">

                                            <option value="NGN" {{ $general->cur_text == 'NGN' ? 'selected' : '' }}>NGN
                                            </option>
                                            <option value="USD" {{ $general->cur_text == 'USD' ? 'selected' : '' }}>USD
                                            </option>
                                            <option value="USDC" {{ $general->cur_text == 'USDC' ? 'selected' : '' }}> USDC
                                            </option>
                                            <option value="BTC" {{ $general->cur_text == 'BTC' ? 'selected' : '' }}>BTC
                                            </option>
                                            <option value="ETH" {{ $general->cur_text == 'ETH' ? 'selected' : '' }}>ETH
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-control-label font-weight-bold"> @lang('Fixed Charge') <span
                                        class="text-danger">*</span> <code
                                        class="text--primary">(@lang('If the amount doesn\'t match any range'))</code></label>

                                <div class="input-group has_append">
                                    <input type="number" step="any" class="form-control" name="fixed_charge"
                                        value="{{ getAmount($general->fixed_charge) }}" required>
                                    <div class="input-group-append">
                                        <select is="ms-dropdown" class="input-group-text text-accent" name="currency_sym"
                                            id="amount_sym" style="border: none;font-size: 15px;">

                                            <option value="NGN" {{ $general->cur_text == 'NGN' ? 'selected' : '' }}>NGN
                                            </option>
                                            <option value="USD" {{ $general->cur_text == 'USD' ? 'selected' : '' }}>USD
                                            </option>
                                            <option value="USDC" {{ $general->cur_text == 'USDC' ? 'selected' : '' }}> USDC
                                            </option>
                                            <option value="BTC" {{ $general->cur_text == 'BTC' ? 'selected' : '' }}>BTC
                                            </option>
                                            <option value="ETH" {{ $general->cur_text == 'ETH' ? 'selected' : '' }}>ETH
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-control-label font-weight-bold"> @lang('Percent Charge') <span
                                        class="text-danger">*</span> <code
                                        class="text--primary">(@lang('If the amount doesn\'t match any range'))</code></label>

                                <div class="input-group has_append">
                                    <input type="number" step="any" class="form-control" name="percent_charge"
                                        value="{{ getAmount($general->percent_charge) }}" required>
                                    <div class="input-group-append">
                                        <div class="input-group-text"><span>%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn--primary btn-block ">@lang('Update')</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-header">
                    {{-- <button type="button" class="icon-btn addModal"><i class="la la-plus"></i> Add</button> --}}
                    <button type="button" class="btn btn--primary mr-3 mt-2 cuModalBtn" data-modal_title="@lang('Add New Charge Range')">
                        <i class="las la-plus"></i>@lang('Add New')
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two custom-data-table">
                            <thead>
                                <tr>
                                    <th>@lang('SL')</th>
                                    <th>@lang('Minimum')</th>
                                    <th>@lang('Maximum')</th>
                                    <th>@lang('Fixed Charge')</th>
                                    <th>@lang('Percent Charge')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($charges as $charge)
                                    <tr>
                                        <td data-label="@lang('SL')">{{ $loop->iteration }}</td>
                                        <td data-label="@lang('Minimum')">{{ getAmount($charge->minimum) }}
                                            {{ $charge->currency_sym }}</td>
                                        <td data-label="@lang('Maximum')">{{ getAmount($charge->maximum) }}
                                            {{ $charge->currency_sym }}</td>
                                        <td data-label="@lang('Fixed Charge')">{{ getAmount($charge->fixed_charge) }}
                                            {{ $charge->currency_sym }}</td>
                                        <td data-label="@lang('Percent Charge')">{{ getAmount($charge->percent_charge) }} %</td>
                                        <td data-label="@lang('Action')">
                                            <button type="button" class="icon-btn cuModalBtn"
                                                data-resource="{{ $charge }}" data-has_status="1"
                                                data-modal_title="@lang('Update Charge Range')"><i
                                                    class="la la-pencil-alt"></i></button>

                                            <button type="button" class="icon-btn btn--danger removeBtn"
                                                data-id="{{ $charge->id }}"><i class="las la-trash"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Charge MODAL --}}
    <div id="cuModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.charge.store') }}" method="POST">
                    @csrf

                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Minimum Amount') <span
                                    class="text-danger">*</span></label>
                            <div class="input-group has_append">
                                <input type="number" step="any" class="form-control" name="minimum" required>
                                <div class="input-group-append">
                                    <select is="ms-dropdown" class="input-group-text text-accent currency_sym" name="currency_sym"
                                    id="amount_sym" style="border: none;font-size: 15px;" required>

                                    <option value="NGN" {{ $general->cur_text == 'NGN' ? 'selected' : '' }}>NGN
                                    </option>
                                    <option value="USD" {{ $general->cur_text == 'USD' ? 'selected' : '' }}>USD
                                    </option>
                                    <option value="USDC" {{ $general->cur_text == 'USDC' ? 'selected' : '' }}> USDC
                                    </option>
                                    <option value="BTC" {{ $general->cur_text == 'BTC' ? 'selected' : '' }}>BTC
                                    </option>
                                    <option value="ETH" {{ $general->cur_text == 'ETH' ? 'selected' : '' }}>ETH
                                    </option>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Maximum Amount') <span
                                    class="text-danger">*</span></label>
                            <div class="input-group has_append">
                                <input type="number" step="any" class="form-control" name="maximum" required>
                                <div class="input-group-append">
                                    <select is="ms-dropdown" class="input-group-text text-accent currency_sym" name="currency_sym"
                                    id="amount_sym" style="border: none;font-size: 15px;">

                                    <option value="NGN" {{ $general->cur_text == 'NGN' ? 'selected' : '' }}>NGN
                                    </option>
                                    <option value="USD" {{ $general->cur_text == 'USD' ? 'selected' : '' }}>USD
                                    </option>
                                    <option value="USDC" {{ $general->cur_text == 'USDC' ? 'selected' : '' }}> USDC
                                    </option>
                                    <option value="BTC" {{ $general->cur_text == 'BTC' ? 'selected' : '' }}>BTC
                                    </option>
                                    <option value="ETH" {{ $general->cur_text == 'ETH' ? 'selected' : '' }}>ETH
                                    </option>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Fixed Charge') <span
                                    class="text-danger">*</span></label>
                            <div class="input-group has_append">
                                <input type="number" step="any" class="form-control" name="fixed_charge" required>
                                <div class="input-group-append">
                                    <select is="ms-dropdown" class="input-group-text text-accent currency_sym" name="currency_sym"
                                    id="amount_sym" style="border: none;font-size: 15px;">

                                    <option value="NGN" {{ $general->cur_text == 'NGN' ? 'selected' : '' }}>NGN
                                    </option>
                                    <option value="USD" {{ $general->cur_text == 'USD' ? 'selected' : '' }}>USD
                                    </option>
                                    <option value="USDC" {{ $general->cur_text == 'USDC' ? 'selected' : '' }}> USDC
                                    </option>
                                    <option value="BTC" {{ $general->cur_text == 'BTC' ? 'selected' : '' }}>BTC
                                    </option>
                                    <option value="ETH" {{ $general->cur_text == 'ETH' ? 'selected' : '' }}>ETH
                                    </option>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label font-weight-bold">@lang('Percent Charge') <span
                                    class="text-danger">*</span></label>
                            <div class="input-group has_append">
                                <input type="number" step="0.01" class="form-control" name="percent_charge"
                                    required>
                                <div class="input-group-append">
                                    <div class="input-group-text"><span>%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Charge MODAL --}}
    <div id="removeModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Remove Charge Range')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.charge.remove') }}" method="POST">
                    @csrf
                    <input type="hidden" name="remove_id">
                    <div class="modal-body">
                        <h6>@lang('Are you sure to remove this charge?')</h6>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--primary">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <button type="button" class="btn btn--primary mr-3 mt-2 cuModalBtn" data-modal_title="@lang('Add New Charge Range')">
        <i class="las la-plus"></i>@lang('Add New')
    </button>
@endpush

@push('script')
    <script>
        var removeModal = $('#removeModal');

        $('.removeBtn').on('click', function() {
            var id = $(this).data('id');
            removeModal.find('[name=remove_id]').val(id);
            removeModal.modal('show');
        });

        $(document).ready(function () {
            $('.currency_sym').change(function () { 
              
                $('.currency_sym').val($(this).val());
                
            });
        });
    </script>
@endpush
