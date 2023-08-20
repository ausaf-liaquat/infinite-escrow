@php
    $aboutContent = getContent('about.content',true);
    $aboutElements = getContent('about.element',false,null,true);
@endphp

<div class="section--sm section--top "   style="padding-bottom: clamp(249px, 4vw, 55px);padding-top: clamp(60px, 8vw, 50px);">
    <div class="container">
        <div class="row g-4 justify-content-between align-items-center ">
            <div class="col-lg-6 col-xxl-5 order-2 order-lg-1 text-center aos-init" data-aos="fade-right">
                <h5 class="mt-lg-0 text-center text-lg-start">
                    {{__(@$aboutContent->data_values->heading)}}
                </h5>
                <p class="text-center text-lg-start" style="font-size: 13px;">
                    {{__(@$aboutContent->data_values->sub_heading)}}
                </p>
                <div class="row g-4">
                    @foreach ($aboutElements as $about)
                        <div class="col-md-6">
                            <div class="d-flex">
                                <span class="flex-shrink-0 text--accent d-inline-block lg-text me-3">
                                    @php echo @$about->data_values->icon; @endphp
                                </span>
                                <p class="mb-0 lg-text" style="font-size: 11px;font-weight:600">
                                    {{__(@$about->data_values->details)}}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-6 order-1 text-center aos-init" data-aos="fade-left">
                <img src="{{ getImage('assets/images/frontend/about/'.@$aboutContent->data_values->image,'645x475') }}" alt="image" class="img-fluid">
            </div>
        </div>
    </div>
</div>
