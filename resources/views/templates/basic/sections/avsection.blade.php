@php
    $coverageContent = getContent('avsection.content',true);
@endphp
<div class="section--sm section--top" data-aos="fade-in">
    <div class="container">
        <div class="row g-4 justify-content-between align-items-center">
            {{-- <div class="col-lg-6 col-xxl-5 order-2 order-lg-1">
                <h3 class="mt-lg-0 text-center text-lg-start">
                    {{__(@$coverageContent->data_values->image_heading)}}
                </h3>
                <p class="text-center text-lg-start">
                    {{__(@$coverageContent->data_values->video_heading)}}
                </p>
                <div class="row g-4">
                    @foreach ($aboutElements as $about)
                        <div class="col-md-6">
                            <div class="d-flex">
                                <span class="flex-shrink-0 text--base d-inline-block lg-text me-3">
                                    @php echo @$about->data_values->icon; @endphp
                                </span>
                                <p class="mb-0 lg-text">
                                    {{__(@$about->data_values->details)}}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div> --}}
            <div class="col-lg-6 order-1">
                <h6 class="mt-lg-0">
                    {{__(@$coverageContent->data_values->image_heading)}}
                </h6>
                <p class="mb-0 lg-text">
                    {!!__(@$coverageContent->data_values->description)!!}
                </p>
                {{-- <video src="{{ getImage('assets/images/frontend/avsection/' . @$coverageContent->data_values->video, '') }}" width="550" height="402" style="max-width: 100%;
                    height: auto;" controls></video> --}}

            </div>
            <div class="col-lg-6 order-1">
                
                <img style="    width: 550px;
                height: 402px;" src="{{ getImage('assets/images/frontend/avsection/'.@$coverageContent->data_values->image,'') }}" alt="image" class="img-fluid">
            </div>
            <div class="col-lg-6 order-1">
                <h3 class="mt-lg-0">
                    {{__(@$coverageContent->data_values->video_heading)}}
                </h3>
                {{-- <p class="mb-0 lg-text">
                    {{__(@$coverageContent->data_values->description)}}
                </p> --}}
                {{-- <video src="{{ getImage('assets/images/frontend/avsection/' . @$coverageContent->data_values->video, '') }}" width="550" height="402" style="max-width: 100%;
                    height: auto;" controls></video> --}}

            </div>
            <div class="col-lg-6 order-1">
                
                <video src="{{ getImage('assets/images/frontend/avsection/' . @$coverageContent->data_values->video, '') }}" width="550" height="402" style="max-width: 100%;
                    height: auto;" controls></video>
            </div>
        </div>
    </div>
</div>