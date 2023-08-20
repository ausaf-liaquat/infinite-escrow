@extends($activeTemplate . 'layouts.frontend')

@section('content')
    @php
        $contactContent = getContent('contact.content', true);
        $contactElements = getContent('contact.element', false, null, true);
    @endphp
@include($activeTemplate.'partials.breadcrumb')
    <div class="section contact-section">
        <div class="section__head">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-12 order-2 bg-white order-lg-1"
                        style="    border-radius: 6px;
                    position: relative;
                    top: -126px;
                    padding: 39px;">
                    
                        <form action="" method="POST" class="row g-4 pe-xxl-5">
                            @csrf
                            <div class="col-12">
                                <h4 class="mt-0">
                                    <img src="{{url('')}}/assets/images/send_msg.png" alt="">  {{ __(@$contactContent->data_values->heading) }}
                                </h4>
                            </div>
                            <div class="col-md-6">
                                <label class="d-block mb-2 sm-text">@lang('Name')</label>
                                <input type="text" name="name" class="form-control form--control"
                                    placeholder="@lang('Your name')"
                                    value="@if (auth()->user()) {{ auth()->user()->fullname }} @endif"
                                    @if (auth()->user()) readonly @endif required>
                            </div>
                            <div class="col-md-6">
                                <label class="d-block mb-2 sm-text">@lang('Email')</label>
                                <input type="email" name="email" class="form-control form--control"
                                    placeholder="@lang('Your email')"
                                    value="@if (auth()->user()) {{ auth()->user()->email }} @endif"
                                    @if (auth()->user()) readonly @endif required>
                            </div>
                            <div class="col-md-12">
                                <label class="d-block mb-2 sm-text">@lang('Subject')</label>
                                <input type="text" name="subject" class="form-control form--control"
                                    placeholder="@lang('Your subject')" value="{{ old('subject') }}" required>
                            </div>
                            <div class="col-12">
                                <label class="d-block mb-2 sm-text">@lang('Messages')</label>
                                <textarea name="message" class="form-control form--control-textarea" rows="5" placeholder="@lang('Your message')">{{ old('message') }}</textarea>
                            </div>
                            <div class="col-12 text-center ">
                                <button class="btn btn--xl text-white  bg--accent w-50">@lang('Send Messages') <i class="fas fa-arrow-right"></i></button>
                            </div>
                        </form>
                    </div>
                    {{-- <div class="col-lg-6 order-1 order-lg-2">
                        <img src="{{ getImage('assets/images/frontend/contact/'.@$contactContent->data_values->image,'600x575') }}" alt="image" class="img-fluid">
                    </div> --}}
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="contact-info-nav">
                        <div class="row g-4 gy-lg-0 gx-lg-4 justify-content-center">
                            @foreach ($contactElements as $contact)
                                <div class="col-md-6 col-lg-4">
                                    <div class="contact-info">
                                        
                                            <div class="contact-info__icon">
                                                @php echo @$contact->data_values->icon @endphp
                                            </div>
                                   
                                        <div class="contact-info__content text-center">
                                          
                                            <p class="mb-0">
                                                {{ __(@$contact->data_values->details) }}
                                            </p>
                                            <h6 class="mt-0 mb-2">
                                                {{ __(@$contact->data_values->heading) }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="map-view container">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-12">
                    <iframe class="map-view__frame"
                        src="https://maps.google.com/maps?q={{ @$contactContent->data_values->latitude }},{{ @$contactContent->data_values->longitude }}&hl=es;z=14&amp;output=embed"></iframe>
                </div>
            </div>
        </div>
    </div>

    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection
@push('style')
    <style>
        .contact-info {
    display: block;
    background: hsl(var(--white));
    padding: 30px 15px;
    border-radius: 5px;
    gap: 1rem;
    align-items: flex-start;
}
        .contact-info__icon {
    display: grid;
    place-items: center;
    padding-inline: 20px;
    aspect-ratio: 1;
    font-size: 24px;
    background: #e9ecef;
    border-radius: 50%;
    color: hsl(var(--black));
    width: 22%;
    margin-left: auto;
    margin-right: auto;
}
    </style>
@endpush