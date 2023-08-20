@php
    $serviceContent = getContent('service.content', true);
    $serviceElements = getContent('service.element', false, null, true);
@endphp

<section class="section bg--base">
    <div class="section__head">
        <div class="container">
            <div class="row g-4 justify-content-center" data-aos="slide-up">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <h4 class="mt-0 text-center">
                        {{ __(@$serviceContent->data_values->heading) }}
                    </h4>
                    <p class="section__para mb-0 text-center mx-auto">
                        {{ __(@$serviceContent->data_values->sub_heading) }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row g-4 justify-content-center" style="font-size: 14px;">
            @foreach ($serviceElements as $service)
                <div class="col-md-6 col-lg-4 col-xl-3" data-aos="flip-up">
                    <div class="service-card text-center"
                        style="
                            height: 325px;
                            border-radius:1px;
                        ">
                        <div class="service-card__icon icon icon--circle icon--md">
                            @php echo @$service->data_values->icon @endphp
                        </div>
                        <div class="service-card__body mt-4">
                            <h6 class="service-card__title">
                                {{ __(@$service->data_values->title) }}
                            </h6>
                            <p class="mb-0">
                                {{ __(@$service->data_values->details) }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
