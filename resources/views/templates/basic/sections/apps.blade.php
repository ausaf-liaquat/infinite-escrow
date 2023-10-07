@php
    $appsContent = getContent('apps.content', true);
@endphp

<div class="tilt-in-top-1 animation-element slide-left "
    style="background-image: url({{ url('') }}/assets/images/home.png);background-repeat: repeat-x;;">
    <div class="container aos-init" data-aos="zoom-out">
        <div class="row g-4 justify-content-between align-items-center ">
            <div class="col-md-6">
                {{-- <img src="{{ getImage('assets/images/app-4.png') }}" alt="image" class="" style="
                position: relative;
                top: -181px;
                "> --}}
                
                <img src="https://i.stack.imgur.com/AR3kw.png" class="imgRes" />
                {{-- <iframe class="iframCustom videoCustom"
                src="{{url('')}}/uploads/demo.mp4?autoplay=1&mute=1&enablejsapi=1&controls=0"
                allow="autoplay; fullscreen"
                controls="0"
                controlslist="nodownload"
                allowfullscreen style="   "></iframe> --}}
                <video class="iframCustom videoCustom" loop autoplay muted
                    src="{{ url('') }}/uploads/demo.mp4"></video>
            </div>
            <div class="col-md-6" style="position: relative;top: -104px;">
                <h4 class="mt-lg-0 text-center text-lg-start text--secondary appHeading">
                    {{ __(@$appsContent->data_values->heading) }}
                </h4>
                <p class="text-center text-lg-start text--secondary appPara">
                    {{ __(@$appsContent->data_values->details) }}
                </p>
                <p class="xxl-text fw-light text-center text-lg-start text--secondary appPara " style="font-size: 12px">
                    <img src="{{ url('') }}/assets/images/app-1.png" alt="" style="background: #2d2d2d;">
                    Easy to Use <img src="{{ url('') }}/assets/images/app-2.png" alt=""
                        style="margin-left: 25px;background: #2d2d2d;"> Secured <img
                        src="{{ url('') }}/assets/images/app-3.png" alt=""
                        style="margin-left: 25px;background: #2d2d2d;"> User friendly

                </p>
                <div class="row">
                    <div class="col-md-6 mt-3">
                        <a href="{{ @$appsContent->data_values->play_store_link }}" class="t-link" target="_blank">
                            <img src="{{ getImage('assets/images/frontend/apps/' . @$appsContent->data_values->play_store_image, '200x60') }}"
                                alt="escrow" class="img-fluid bg-white">
                        </a>
                    </div>
                    <div class="col-md-6 mt-3">
                        <a href="{{ @$appsContent->data_values->apple_store_link }}" class="t-link" target="_blank">
                            <img src="{{ getImage('assets/images/frontend/apps/' . @$appsContent->data_values->apple_store_image, '200x60') }}"
                                alt="escrow" class="img-fluid bg-white">
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
