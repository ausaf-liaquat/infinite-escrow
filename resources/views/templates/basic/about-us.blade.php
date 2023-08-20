@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $bannerContent = getContent('banner.content', true);
        $aboutContent = getContent('about.content', true);
        $aboutElements = getContent('about.element', false, null, true);
        $coverageContent = getContent('avsection.content', true);
    @endphp

    <div class="section--sm section--top " style="padding-bottom: clamp(0px, 4vw, 0px);background: #e7e9ea36">
        {{-- <div class="container"> --}}
        <div class="row g-4 justify-content-between">
            <div class="col-lg-6 col-xxl-5">
                <img class="responsive" src="{{ getImage('assets/images/about5.svg') }}" alt="">

            </div>
            <div class="col-lg-6">
                <div class="container aboutHeading" style="    padding-right: 208px;padding-top: 86px;">
                    <h4 class="hero__content-title text-capitalize text--accent mt-0"
                        style="background: -webkit-linear-gradient(#101609, #425a23);
                        -webkit-background-clip: text;
                        -webkit-text-fill-color: transparent;">
                        {{ __(@$aboutContent->data_values->heading) }}
                    </h4>

                    <p class="text-center text-lg-start" style="font-size: 13px;">
                        {{ __(@$aboutContent->data_values->sub_heading) }}
                    </p>
                </div>


            </div>
        </div>
        <div class="container">
            <div class="row g-4 mt-5 text-center">
                @foreach ($aboutElements as $key => $about)
                    <div class="col-md-3">
                        <div class="">
                            @if ($key == 0)
                                <span class="flex-shrink-0 text--accent d-inline-block lg-text me-3">
                                    <img src="{{ url('') }}/assets/images/about6.svg" alt="">
                                </span>
                            @elseif($key == 1)
                                <span class="flex-shrink-0 text--accent d-inline-block lg-text me-3">
                                    <img src="{{ url('') }}/assets/images/about7.svg" alt="">
                                </span>
                            @elseif($key == 2)
                                <span class="flex-shrink-0 text--accent d-inline-block lg-text me-3">
                                    <img src="{{ url('') }}/assets/images/about8.svg" alt="">
                                </span>
                            @elseif($key == 3)
                                <span class="flex-shrink-0 text--accent d-inline-block lg-text me-3">
                                    <img src="{{ url('') }}/assets/images/about9.svg" alt="">
                                </span>
                            @endif

                            <p class="mb-0 lg-text mt-3" style="    font-size: 14px;
                            font-weight: 500;">
                                {{ __(@$about->data_values->details) }}
                            </p>
                        </div>
                    </div>
                @endforeach

                <div class="col-md-12" style="margin-top:90px;">
                    <div class="aboutHeading2" style="padding-left: 168px;padding-right: 134px;">
                        <h4 class="hero__content-title text-capitalize text--accent mt-0"
                            style="background: -webkit-linear-gradient(#101609, #425a23);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;">
                            Welcome to Infinite Escrow, a top-tier provider of secure and reliable escrow services.
                        </h4>
                        <p>Trust us for secure verification, storage, and prompt disbursement of funds across various
                            industries including real estate, e-commerce, mergers, and acquisitions, and more. Transparency,
                            integrity, and professionalism define our approach. We adhere to ethical standards, regulations,
                            and industry guidelines, earning the trust of countless clients who recognize us as a reliable
                            financial partner. Discover the ease and security provided by our cutting-edge technology,
                            personalized solutions, and unwavering commitment to your satisfaction. Regardless of your
                            transaction type, whether it's real estate, e-commerce, mergers and acquisitions, or any other
                            field.</p>
                    </div>

                </div>

            </div>
        </div>
        <div class="row" style="margin-top:70px;">
            <div class="col-md-12">
                <img class="responsive" src="{{ getImage('assets/images/about3.svg') }}" alt="">
            </div>
        </div>
        <div class="container">
            <div class="row" style="margin-top:70px;">
                <div class="col-md-6">
                    <img src="{{ getImage('assets/images/about1.svg', '1800x790') }}" alt="" style="width:100%;">
                </div>
                <div class="col-md-6">
                    <img src="{{ getImage('assets/images/about2.svg', '1800x790') }}" alt="" style="width:100%;">
                </div>
                <div class="col-md-12 text-center">
                    <h5>Watch a video about us</h5>
                    <video
                        src="{{ getImage('assets/images/frontend/avsection/' . @$coverageContent->data_values->video, '') }}"
                        width="550" height="402" style="max-width: 100%;
                        height: auto;"
                        controls></video>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top:70px;">
            <div class="col-md-12">
                <img class="responsive" src="{{ getImage('assets/images/about4.svg') }}" alt="">
            </div>
        </div>
    </div>
@endsection
@push('style')
    <style>
        .responsive {
            width: 100%;
            height: auto;
        }

        .section--top {
            padding-top: clamp(60px, 8vw, 74px);
        }

        @media only screen and (max-width: 480px) {
            .wrapper .option {

                padding: 0 13px !important;

            }

            .aboutHeading {
                padding-right: 17px !important;
            }

            .aboutHeading2 {
                padding-right: 0px !important;
                padding-left: 0px !important;
            }
        }

        @media (min-width: 992px) {
            .d-lg-block {
                display: block !important;
                height: 74vh;
            }
        }

        .select2-container {
            width: auto !important;
        }

        .input-group-text {
            border: none;
            border-right: 1px solid;
            background: hsl(var(--light-600));
            color: hsl(var(--text));
            padding-inline: 20px;
            /* border-left: none; */
        }

        .underlined {
            position: relative;

        }

        .underlined:after {
            content: "";
            position: absolute;
            height: 15px;
            width: 70px;
            left: -11px;
            top: 17px;
            border-top: 3px solid white;
            border-radius: 50%;

        }

        .hero__content-para {
            position: relative;
        }

        .oval-image {
            position: absolute;
            top: 25px;
            left: 108px;
            border-radius: 50%;
        }

        .wrapper {
            display: inline-flex;
            background: #fff;
            height: 100px;
            width: 100%;
            align-items: center;
            justify-content: space-evenly;
            border-radius: 5px;
            padding: 20px 1px;
            /* box-shadow: 5px 5px 30px rgba(0,0,0,0.2); */
        }

        .wrapper .option {
            background: #fff;
            height: 100%;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-evenly;
            margin: 0 10px;
            border-radius: 1px;
            cursor: pointer;
            padding: 0 0px;
            border: 2px solid lightgrey;
            /* border: 1px solid black; */
            transition: all 0.3s ease;
        }

        .wrapper .option .dot {
            height: 20px;
            width: 20px;
            /* background: #d9d9d9; */
            border-radius: 50%;
            position: relative;
            border: 1px solid;
        }

        .wrapper .option .dot::before {
            position: absolute;
            content: "";
            /* top: 4px;
                                                        left: 4px; */
            width: 18px;
            height: 18px;
            background-image: url("{{ url('assets/images/check.png') }}");
            background-size: cover;
            border-radius: 50%;
            opacity: 0;
            transform: scale(1.5);
            transition: all 0.3s ease;
        }

        input[type="radio"] {
            display: none;
        }

        #option-1:checked:checked~.option-1,
        #option-2:checked:checked~.option-2 {

            background: linear-gradient(119deg, #afff47, #85f35e);
        }

        #option-1:checked:checked~.option-1 .dot,
        #option-2:checked:checked~.option-2 .dot {
            background: #fff;
        }

        #option-1:checked:checked~.option-1 .dot::before,
        #option-2:checked:checked~.option-2 .dot::before {
            opacity: 1;
            transform: scale(1);
        }

        .wrapper .option span {
            font-size: 15px;
            color: hsl(var(--accent));
            font-weight: 500
        }

        #option-1:checked:checked~.option-1 span,
        #option-2:checked:checked~.option-2 span {
            color: hsl(var(--accent));
        }

        .hero__content-para {
            max-width: 64ch;
            color: #1c280f;
        }

        .hero__content {

            padding-bottom: 0px;

        }

        .hero::after {
            content: "";
            position: absolute;
            /* top: 0; */
            /* bottom: 0; */
            /* left: 0; */
            /* right: 0; */
            background-image: none;
            mix-blend-mode: multiply;
            z-index: -1;
            box-shadow: none;
        }

        /* .primary-menu__link {
                                                                        color: hsl(var(--white));
                                                                        margin-left: 0;
                                                                        margin-right: 0;
                                                                        font-weight: 500;
                                                                        border-bottom: none;
                                                                        padding-top: 20px;
                                                                        padding-bottom: 20px;
                                                                    } */
        /* .btn--login{
                                                                        color:hsl(var(--white)) !important;
                                                                    } */
        /* .fixed-header .header--primary a.primary-menu__link{
                                                                        color: hsl(var(--accent));
                                                                    }
                                                                    .fixed-header .header--primary a.btn--login{
                                                                        color: hsl(var(--accent)) !important;
                                                                    } */
    </style>
@endpush
