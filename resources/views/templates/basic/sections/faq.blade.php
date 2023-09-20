@php
    $faqContent = getContent('faq.content', true);
    $faqElements = getContent('faq.element', false, null, true);
@endphp

<section class="section--sm">
    <div class="container">
        <div class="row g-4 justify-content-xl-between align-items-center">
            <div class="col-lg-4">
                <h3 class="mt-lg-0 text-center text-lg-start" data-aos="zoom-in">
                    FAQ
                </h3>
                <p class=" fw-light text-center text-lg-start" style="font-size: 19px;" data-aos="example-anim1">
                    {{ __(@$faqContent->data_values->sub_heading) }}
                </p>
                {{-- <img src="{{ getImage('assets/images/frontend/faq/'.@$faqContent->data_values->image,'645x580') }}" alt="image" class="img-fluid" /> --}}
            </div>
            <div class="col-lg-8">
                <div class="ms-xxl-5">

                    <div class="accordion custom--accordion" id="accordionExample"  data-aos="fade-left">
                        @foreach ($faqElements as $key => $faq)
                            <div class="accordion-item" style="box-shadow: 0 0 30px hsl(var(--dark)/0.1);"
                               >

                                <h2 class="accordion-header p-3">

                                    <button style="border-bottom: none;"
                                        class="accordion-button @if (!$loop->first) collapsed @endif"
                                        type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse-{{ $loop->index }}"
                                        @if ($loop->first) aria-expanded="true" @endif>
                                        @if ($key == 0)
                                            <img src="{{ url('assets/images/c1.png') }}" alt=""
                                                style="padding-right: 10px;">
                                        @elseif($key == 1)
                                            <img src="{{ url('assets/images/c2.png') }}" alt=""
                                                style="padding-right: 10px;">
                                        @else
                                            <img src="{{ url('assets/images/c3.png') }}" alt=""
                                                style="padding-right: 10px;">
                                        @endif
                                        {{ __(@$faq->data_values->question) }}
                                    </button>
                                </h2>
                                <div id="collapse-{{ $loop->index }}"
                                    class="accordion-collapse collapse @if ($loop->first) show @endif"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        @php echo @$faq->data_values->answer @endphp
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
