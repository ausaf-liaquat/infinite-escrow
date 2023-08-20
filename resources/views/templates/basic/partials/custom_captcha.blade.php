@php
	$captcha = loadCustomCaptcha();
@endphp

@if($captcha)
    <div class="col-md-10 col-lg-12">
        @php echo $captcha @endphp
        <div class="input-group input--group">
            <span class="input-group-text">
                <i class="fas fa-code"></i>
            </span>
            <input type="text" name="captcha" placeholder="@lang('Enter Code')" class="form-control form--control" required>
        </div>
    </div>
@endif
