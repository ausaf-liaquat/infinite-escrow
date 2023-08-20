@php
    $testimonialContent = getContent('testimonial.content', true);
    $testimonialElements = getContent('testimonial.element', false, null, true);
@endphp


<section class="section--sm section--top" style="background: #f7f7f7;">
    <div class="section__head"  data-aos="fade-right">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <h5 class="mt-0 text-center">
                        {{ __(@$testimonialContent->data_values->heading) }}
                    </h5>
                    <p class="section__para mb-0 text-center mx-auto">
                        {{ __(@$testimonialContent->data_values->heading) }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="container"  data-aos="fade-left">
        <div class="contain">
            <div id="owl-carousel" class="owl-carousel owl-theme">
                @foreach ($testimonialElements as $testimonial)
                    <div class="item">
                        <div class="testimonial-slider__item item">
                            <div class=" text-center" style="padding: 14px;">
                                <div class="user__img user__img--xl mx-auto mt-3">
                                    <img src="{{ getImage('assets/images/frontend/testimonial/' . @$testimonial->data_values->image, '100x100') }}"
                                        alt="image" class="user__img-is">

                                </div>
                                <i class="fas fa-quote-right"
                                    style="font-size: 22px;
                        color: #000;
                        position: relative;
                        top: -12px;"></i>

                                <p class="testimonial-slider__body-text" style="font-size: 14px;">
                                    {{ __(@$testimonial->data_values->review) }}
                                </p>
                                <h5 class="mb-2">
                                    {{ __(@$testimonial->data_values->name) }} <span class="d-block sm-text">
                                        {{ __(@$testimonial->data_values->location) }}
                                    </span>
                                </h5>

                            </div>

                        </div>
                    </div>
                @endforeach
                
            </div>
            {{-- <div class="owl-controls">
                <div class="owl-nav">
                    <div class="owl-prev">prev</div>
                    <div class="owl-next">next</div>
                </div>
                <div class="owl-dots">
                    <div class="owl-dot active"><span></span></div>
                    <div class="owl-dot"><span></span></div>
                    <div class="owl-dot"><span></span></div>
                </div>
            </div> --}}
        </div>
        {{-- <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="testimonial-slider owl-carousel">
                   
                        <div class="testimonial-slider__item item">
                            <div class="testimonial-slider__icon text-center">
                                <i class="fas fa-quote-right"></i>
                            </div>
                            <div class="testimonial-slider__body text-center">
                                <p class="testimonial-slider__body-text">
                                    {{__(@$testimonial->data_values->review)}}
                                </p>
                            </div>
                            <div class="testimonial-slider__footer text-center">
                                <div class="user__img user__img--xl mx-auto">
                                    <img src="{{ getImage('assets/images/frontend/testimonial/'.@$testimonial->data_values->image,'100x100') }}" alt="image" class="user__img-is">
                                </div>
                                <h5 class="mb-2">
                                    {{__(@$testimonial->data_values->name)}}
                                </h5>
                                <span class="d-block sm-text">
                                    {{__(@$testimonial->data_values->location)}}
                                </span>
                            </div>
                        </div>
                   
                </div>
            </div>
        </div> --}}
    </div>
</section>
