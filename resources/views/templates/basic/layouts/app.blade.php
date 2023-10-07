<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> {{ $general->sitename(__($pageTitle)) }}</title>
    @include('partials.seo')
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/line-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/main.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/color.php?color1=' . $general->base_color) }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
        integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        #pot {
            animation-name: run;
            animation-duration: 3s;
            animation-timing-function: cubic-bezier(0.645, 0.045, 0.355, 1);
            animation-delay: 0s;
            animation-direction: alternate;
            animation-iteration-count: infinite;
            animation-fill-mode: none;
            animation-play-state: running;
        }

        @-webkit-keyframes run {
            0% {
                left: 0;
            }

            50% {
                left: calc(2% - 2px);
            }

            100% {
                left: 0;
            }
        }

        .tooltip-inner {
            background-color: #fff;
            box-shadow: 0px 0px 4px black;
            opacity: 1 !important;
            color: #84ce23;
        }

        .tooltip.bs-tooltip-right .tooltip-arrow::before {
            border-right-color: #84ce23 !important;
        }

        .tooltip.bs-tooltip-left .tooltip-arrow::before {
            border-left-color: #84ce23 !important;
        }

        .tooltip.bs-tooltip-bottom .tooltip-arrow::before {
            border-bottom-color: #84ce23 !important;
        }

        .tooltip.bs-tooltip-top .tooltip-arrow::before {
            border-top-color: #84ce23 !important;
        }

        .map-container .pointTip {
            cursor: pointer;
            position: absolute;
            width: 1.6rem;
            height: 1.6rem;
            background-color: #89d723;
            border-radius: 50%;
            transition: all 0.3s ease;
            will-change: transform, box-shadow;
            transform: translate(-50%, -50%);
            box-shadow: 0 0 0 rgba(0, 172, 193, 0.4);
            animation: pulse 3s infinite;
        }

        html,
        body {

            overflow-x: hidden;
        }

        .map-container {
            padding: 3.2rem 0.8rem;
            position: relative;
            display: inline-block;
        }

        .map-container img {
            width: 100%;
        }

        .map-container .point {
            cursor: pointer;
            position: absolute;
            width: 1.6rem;
            height: 1.6rem;
            background-color: #89d723;
            border-radius: 50%;
            transition: all 0.3s ease;
            will-change: transform, box-shadow;
            transform: translate(-50%, -50%);
            box-shadow: 0 0 0 rgba(0, 172, 193, 0.4);
            animation: pulse 3s infinite;
        }

        .map-container .point:hover {
            animation: none;
            transform: translate(-50%, -50%) scale3D(1.35, 1.35, 1);
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
        }

        .map-container .venezuela {
            top: 54%;
            left: 24%;
        }

        .map-container .brasil {
            top: 64%;
            left: 28%;
        }

        .map-container .argentina {
            top: 77%;
            left: 27%;
        }

        .map-container .colombia {
            top: 69%;
            left: 32%;
        }

        .map-container .panama {
            top: 51%;
            left: 18%;
        }

        .map-container .mexico {
            top: 38%;
            left: 12%;
        }

        .map-container .usa {
            top: 41%;
            left: 22%;
        }

        .map-container .arabia {
            top: 39%;
            left: 69%;
        }

        .map-container .turquia {
            top: 59%;
            left: 53%;
        }


        .map-container .rusia {
            top: 16%;
            left: 67%;
        }

        .map-container .china {
            top: 40%;
            left: 72%;
        }

        .map-container .japon {
            top: 34%;
            left: 86%;
        }

        .map-container .australia {
            top: 71%;
            left: 83%;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(0, 172, 193, 0.5);
            }

            70% {
                box-shadow: 0 0 0 25px rgba(0, 172, 193, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(0, 172, 193, 0);
            }
        }
    </style>

    <style>
        ::-webkit-scrollbar {
            width: 2px;
        }

        ::-webkit-scrollbar-track {
            background-color: #ebebeb;
            -webkit-border-radius: 10px;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            -webkit-border-radius: 10px;
            border-radius: 10px;
            background: #515151;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(#00acc1, 0.5);
            }

            70% {
                box-shadow: 0 0 0 25px rgba(#00acc1, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(#00acc1, 0);
            }
        }

        .tilt-in-top-1 {
            animation: tilt-in-top-1 1s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
        }

        [data-aos="example-anim1"] {
            transform: skewX(45deg);
            opacity: 0;
            transition-property: transform, opacity;

            &.aos-animate {
                transform: skewX(0);
                opacity: 1;
            }
        }

        @keyframes tilt-in-top-1 {
            0% {
                transform: rotateY(30deg) translateY(-300px) skewY(-30deg);
                opacity: 0;
            }

            100% {
                transform: rotateY(0deg) translateY(0) skewY(0deg);
                opacity: 1;
            }
        }

        .tilt-in-right-1 {
            animation: tilt-in-right-1 0.6s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
        }

        .tilt-in-fwd-tr {
            animation: tilt-in-fwd-tr 2s cubic-bezier(0.445, 0.050, 0.550, 0.950) both;
        }

        @keyframes tilt-in-fwd-tr {
            0% {
                transform: rotateY(20deg) rotateX(35deg) translate(300px, -300px) skew(-35deg, 10deg);
                opacity: 0;
            }

            100% {
                transform: rotateY(0) rotateX(0deg) translate(0, 0) skew(0deg, 0deg);
                opacity: 1;
            }
        }

        .slide-in-elliptic-left-fwd {
            animation: slide-in-elliptic-left-fwd 2s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
        }

        @keyframes slide-in-elliptic-left-fwd {
            0% {
                transform: translateX(-800px) rotateY(30deg) scale(0);
                transform-origin: -100% 50%;
                opacity: 0;
            }

            100% {
                transform: translateX(0) rotateY(0) scale(1);
                transform-origin: 1800px 50%;
                opacity: 1;
            }
        }

        /* Hide the default video controls */
        .videoCustom::-webkit-media-controls {
            display: none !important;
        }

        .videoCustom::-webkit-media-controls-enclosure {
            display: none !important;
        }

        .videoCustom::-webkit-media-controls-panel {
            display: none !important;
        }

        .videoCustom::-webkit-media-controls-play-button {
            display: none !important;
        }


        @keyframes tilt-in-right-1 {
            0% {
                transform: rotateX(-30deg) translateX(300px) skewX(30deg);
                opacity: 0;
            }

            100% {
                transform: rotateX(0deg) translateX(0) skewX(0deg);
                opacity: 1;
            }
        }

        .flip-in-ver-left {
            animation: flip-in-ver-left 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
        }


        @keyframes flip-in-ver-left {
            0% {
                transform: rotateY(80deg);
                opacity: 0;
            }

            100% {
                transform: rotateY(0);
                opacity: 1;
            }
        }

        .primary-menu__link:hover {
            text-decoration: none;
            color: #000000 !important;
        }

        .select2-container .select2-selection--single .select2-selection__arrow {
            display: none;
        }

        .select2-selection__rendered {
            line-height: 40px !important;
        }

        .select2-container .select2-selection--single {
            height: 50px !important;
        }

        .select2-selection__arrow {
            height: 50px !important;
        }

        .select2-container--default .select2-selection--single {
            border: none
        }

        .fixed-header .header--primary {
            background: #fff;
        }

        .primary-menu__link {
            color: hsl(var(--accent));
            margin-left: 15px;
            margin-right: 0;
            font-weight: 500;
            border-bottom: none;
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .form--select-dark .form--select-sm {
            color: hsl(var(--accent));
            background: rgb(var(--base));
        }

        .form--select-dark::after {
            content: "\f107";
            font-family: "Line Awesome Free";
            font-weight: 900;
            position: absolute;
            color: hsl(var(--accent));
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.75rem;
            z-index: 1;
            pointer-events: none;
        }

        .contact-info-nav {
            background: none;
            border-radius: 15px;
            box-shadow: 0 0 30px hsl(var(--black)/0.01);
        }

        .btn--login {
            padding-top: 4px;
            padding-bottom: 4px;
            padding-left: 30px;
            padding-right: 30px;
            border: 1px solid #000;
            background: transparent;
            border-radius: 1px;
        }

        .footer {
            background: linear-gradient(178deg, black, #343434);
        }

        .footer__copyright {
            background: hsl(var(--black));
        }

        .section {
            padding-top: clamp(50px, 8vw, 3px);
            padding-bottom: clamp(16px, 8vw, 11px);
        }

        .banner::after {
            content: "";
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background: none;
            mix-blend-mode: darken;
            z-index: -1;
        }

        .service-card__icon {
            border-radius: 25px;
            background: #cfcfcf;
            color: #000;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .contain {
            margin: 0 auto;
            max-width: 1200px;
            width: 100%;
        }

        .item {
            align-items: center;
            background-color: rgb(255, 255, 255);
            color: white;
            /* display: flex; */
            height: 300px;
            justify-content: center;
        }

        .testimonial-slider__body-text {
            font-size: var(--h6);
            color: hsl(var(--black-50));
            max-width: 66ch;
            margin-left: auto;
            margin-right: auto;
        }


        .owl-carousel .nav-button {
            height: 50px;
            width: 25px;
            cursor: pointer;
            position: absolute;
            top: 27px !important;
        }

        .owl-carousel .owl-prev.disabled,
        .owl-carousel .owl-next.disabled {
            pointer-events: none;
            opacity: 0.25;
        }

        .owl-carousel .owl-prev {
            left: -14px;
        }

        .owl-carousel .owl-next {
            right: 5px;
        }

        .owl-theme .owl-nav [class*=owl-] {
            color: #dfdfdf;
            font-size: 139px;
            /* background: #000000; */
            border-radius: 3px;
        }

        @media only screen and (max-width: 480px) {
            .owl-carousel .nav-button {
                height: 50px;
                width: 26px;
                cursor: pointer;
                position: relative !important;
                top: -268px !important;
            }

            .owl-carousel .owl-next {
                right: -313px;
            }
        }

        .custom--accordion .accordion-body {
            padding-inline: 35px;
            padding-bottom: 0;
            background: hsl(var(--white));
            color: hsl(var(--text));
        }

        .blog-post__body {
            padding: 30px 15px;
            background: hsl(var(--white));
            border-radius: 0 0 10px 10px;
            box-shadow: none;
        }

        span.select2.select2-container.select2-container--default {
            width: auto;
        }

        .imgRes {
            z-index: 1;
            position: relative;
            top: -236px;
            height: 558px;
            left: 54px;
        }

        /* .iframCustom {
            z-index: -1;
            width: 240px;
            left: 88px;
            height: 506px;
            top: -216px;
            position: absolute;
        } */
        .iframCustom {
            z-index: -1;
            width: 248px;
            left: 95px;
            height: 506px;
            top: -191px;
            position: absolute;
        }

        @media (max-width: 425px) {
            .imgRes {
                /* z-index: 1; */
                position: absolute !important;
                top: -143px !important;
                height: 58% !important;
            }

            .iframCustom {
                /* z-index: -1 !important;
                width: 227px !important;
                left: 76px !important;
                height: 480px !important;
                top: -146px !important;
                position: relative !important; */
                z-index: -1 !important;
                width: 236px !important;
                left: 81px !important;
                height: 503px !important;
                top: -146px !important;
                position: relative !important;
            }
        }



        @media (max-width: 768px) {
            .imgRes {
                /* z-index: 1; */
                /* position: relative;
                top: -223px;
                height: 90%; */
                position: relative;
                top: -236px;
                height: 90%;
            }

            .iframCustom {
                z-index: -1;
                width: 125px;
                left: 73px;
                height: 506px;
                top: -332px;
                position: absolute;
            }
        }

        @media (max-width: 800px) {
            /* .imgRes {

                position: absolute;
                top: -223px;
                height: 107%;
            } */

            .imgRes {
                /* position: relative;
                top: -223px;
                height: 115%; */
                width: 308px;
            }

            /* .iframCustom { */
            /* z-index: -1;
                width: 125px;
                left: 73px;
                height: 506px;
                top: -332px;
                position: absolute; */
            /* z-index: -1;
                width: 172px;
                left: 79px;
                height: 506px;
                top: -277px;
                position: absolute; */
            /* } */

            .iframCustom {
                z-index: -1;
                width: 288px;
                left: 79px;
                height: 507px;
                top: -192px;
                position: absolute;
            }

        }

        @media (max-width: 375px) {
            .imgRes {
                /* z-index: 1; */
                position: absolute !important;
                top: -143px !important;
                height: 56% !important;
            }

            .iframCustom {
                z-index: -1 !important;
                width: 237px !important;
                left: 76px !important;
                height: 503px !important;
                top: -146px !important;
                position: relative !important;
            }
        }

        @media (max-width: 320px) {
            .imgRes {
                /* z-index: 1; */
                position: absolute !important;
                top: -143px !important;
                height: 54% !important;
                left: 17px;
            }

            .iframCustom {
                /* z-index: -1 !important;
                width: 227px !important;
                left: 33px !important;
                height: 454px !important;
                top: -147px !important;
                position: relative !important; */
                z-index: -1 !important;
                width: 238px !important;
                left: 42px !important;
                height: 494px !important;
                top: -146px !important;
                position: relative !important;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ url('') }}/assets/dd.css">
    @stack('style-lib')
    @stack('style')
    <style>
        .fixed-header .header-fixed {
            position: fixed;
            top: inherit !important;
            left: 0;
            box-shadow: 0 15px 30px hsl(var(--black)/0.1);
        }


        .goog-te-gadget-icon {
            display: none;
        }

        .form--select-dark .form--select-sm {
            color: hsl(var(--accent)) !important;
            background: transparent !important;
        }

        .form--select-dark {
            position: relative;
            isolation: isolate;
            border-radius: 3px;
            border: none !important;
            background: transparent !important;
        }

        .goog-te-gadget-simple {
            background-color: #ecebf0 !important;
            border: 0 !important;
            font-size: 10pt;
            font-weight: 800;
            display: inline-block;
            padding: 10px 10px !important;
            cursor: pointer;
            zoom: 1;
        }

        .goog-te-gadget-simple span {
            color: #3e3065 !important;

        }

        @media (min-width: 700px) .topDiv {
            z-index: -1;
            width: 172px;
            left: 79px;
            height: 506px;
            top: -277px;
            position: absolute;
        }
    </style>
</head>

<body>

    {{-- <div class="preloader">
        <div class="preloader__loader">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div> --}}

    <div class="back-to-top">
        <span class="back-top">
            <i class="las la-angle-double-up"></i>
        </span>
    </div>

    @include($activeTemplate . 'partials.header')
    <main class="main-wrapper">
        {{-- @if (!Request::routeIs('home'))
                    @include($activeTemplate.'partials.breadcrumb')
                @endif --}}

        @yield('content')

        @php
            $cookie = App\Models\Frontend::where('data_keys', 'cookie.data')->first();
        @endphp

        @if (@$cookie->data_values->status && !session('cookie_accepted'))
            <div class="cookie-remove">
                <div class="cookie__wrapper bg--section">
                    <div class="container">
                        <div class="flex-wrap align-items-center justify-content-between">
                            <h4 class="title">@lang('Cookie Policy')</h4>
                            <div class="txt my-2">
                                @php echo @$cookie->data_values->description @endphp
                            </div>
                            <div class="button-wrapper">
                                <button class="btn btn--base policy cookie">@lang('Accept')</button>
                                <a class="btn btn--base" href="{{ @$cookie->data_values->link }}" target="_blank"
                                    class=" mt-2">@lang('Read Policy')</a>
                                <a href="javascript:void(0)" class="btn--close cookie-close"><i
                                        class="las la-times"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </main>
    @include($activeTemplate . 'partials.footer')

    <script src="{{ asset('assets/global/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/jquery.validate.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/slick.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/jquery.nice-select.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/jquery.magnific-popup.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @stack('script-lib')

    @stack('script')

    @include('partials.plugins')

    @include('partials.notify')


    <script>
        (function($) {
            "use strict";
            $(".langSel").on("change", function() {
                window.location.href = "{{ route('home') }}/change/" + $(this).val();
            });

            $('.cookie').on('click', function() {
                var url = "{{ route('cookie.accept') }}";

                $.get(url, function(response) {

                    if (response.success) {
                        notify('success', response.success);
                        $('.cookie-remove').html('');
                    }
                });
            });

            $('.cookie-close').on('click', function() {
                $('.cookie-remove').html('');
            });
        })(jQuery);
    </script>

    <script>
        $(document).ready(function() {
            $('.selectCategory').select2({
                tags: true,
                dropdownCssClass: "select2-custom"
            });

            $(document).ready(function() {
                $(".owl-carousel").owlCarousel({
                    loop: true,
                    margin: 30,
                    dots: true,
                    nav: true,
                    items: 2,
                    navText: ["<div class='nav-button owl-prev'>‹</div>",
                        "<div class='nav-button owl-next'>›</div>"
                    ],
                })
            });
        });
    </script>
    <!-- Development -->
    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
    <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1200,
        });
        $(document).ready(function() {
            tippy('.tippy', {


                arrow: true
            })
        });
    </script>
    <script>
        $(document).ready(function() {
            $('[data-bs-toggle="tooltip"]').tooltip('show');
        });
    </script>

    <script src="{{ url('') }}/assets/dd.min.js"></script>
    <script></script>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en'
            }, 'google_translate_element');
        }
    </script>

    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
    </script>
    <script>
        $(document).ready(function() {
            setInterval(() => {
                $('#google_translate_element').find(".goog-te-combo").addClass(
                    "form-select form--select-sm langSel");

                $(".skiptranslate").removeData("data")
                $(".skiptranslate").contents().filter(function() {
                    return this.nodeType === 3; // Select text nodes (nodeType 3)
                }).remove();
                $(".skiptranslate").contents().filter(function() {
                    return this.nodeType === 3; // Select text nodes (nodeType 3)
                }).remove();
                $(".skiptranslate").find('span').remove();
            }, 100);

            // 
        });

        console.log('dddwedwed');
    </script>

</body>

</html>
