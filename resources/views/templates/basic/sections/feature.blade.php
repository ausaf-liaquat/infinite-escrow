@php
    $featureContent = getContent('feature.content', true);
    $featureElements = getContent('feature.element', false, null, true);
@endphp

<div class="section--sm section--bottom">
    <div class="container">
        <div class="row g-4 justify-content-between align-items-center">
            <div class="col-lg-12" data-aos="fade-left">
                <h5 class="mt-lg-0 text-center">
                    {{ __(@$featureContent->data_values->heading) }}
                </h5>
                <p class="xxl-text fw-light text-center">
                    {{ __(@$featureContent->data_values->sub_heading) }}
                </p>
            </div>
            @foreach ($featureElements as $key => $feature)
            @if ($key==0)
                 <div class="col-lg-4 text-center" style="height: 54vh;background: #F6FFF2;" data-aos="fade-down">
                    <div class="icon icon--md icon--circle text--accent flex-shrink-0 me-3 mb-4 mt-4">
                        
                        <img src="{{url('assets/images/feature1.png')}}" alt="">
                    </div>
                    <div class="d-flex mt-4">

                        <div class="flex-grow-1">
                            <h5 class="mt-0" style="color: #00AA6D;">
                                {{ __(@$feature->data_values->title) }}
                            </h5>
                            <p class="mb-0" style="font-size: 14px;">
                                {{ __(@$feature->data_values->details) }}
                            </p>
                        </div>
                    </div>


                </div>
            @elseif($key==1)
            <div class="col-lg-4 text-center" style="height: 54vh;background: #F2FDFF;"data-aos="fade-up">
                <div class="icon icon--md icon--circle text--accent flex-shrink-0 me-3 mb-4 mt-4">
                    
                    <img src="{{url('assets/images/feature2.png')}}" alt="">
                </div>
                <div class="d-flex mt-4">

                    <div class="flex-grow-1">
                        <h5 class="mt-0" style="color: #2867E0;">
                            {{ __(@$feature->data_values->title) }}
                        </h5>
                        <p class="mb-0" style="font-size: 14px;">
                            {{ __(@$feature->data_values->details) }}
                        </p>
                    </div>
                </div>


            </div>
            @else
            <div class="col-lg-4 text-center" style="height: 54vh;background: #FFF2FE;"data-aos="fade-down">
                <div class="icon icon--md icon--circle text--accent flex-shrink-0 me-3 mb-4 mt-4">
                    
                    <img src="{{url('assets/images/feature3.png')}}" alt="">
                </div>
                <div class="d-flex mt-4">

                    <div class="flex-grow-1">
                        <h5 class="mt-0" style="color: #8F28E0;">
                            {{ __(@$feature->data_values->title) }}
                        </h5>
                        <p class="mb-0" style="font-size: 14px;">
                            {{ __(@$feature->data_values->details) }}
                        </p>
                    </div>
                </div>


            </div>
            @endif
           
            @endforeach
        </div>
    </div>
</div>
