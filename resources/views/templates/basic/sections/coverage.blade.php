@php
    $coverageContent = getContent('coverage.content',true);
@endphp

<section class="section--sm section--bottom">
    <div class="section__head">
        <div class="container" data-aos="fade-down">
            <div class="row g-4 justify-content-center">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <h3 class="mt-0 text-center">
                        {{__(@$coverageContent->data_values->heading)}}
                    </h3>
                    <p class="section__para mb-0 text-center mx-auto">
                        {{__(@$coverageContent->data_values->heading)}}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12" >
                <div class="container">
                    <div class="map-container" id="pot">
                      <img style="width: 100%;" src="{{url('')}}/assets/images/map1.png">
                      {{-- <div class="point venezuela tippy" title="Venezuela"></div> --}}
                      {{-- <div class="point brasil tippy" title="Brasil"></div> --}}
                      {{-- <div class="point argentina tippy" title="Argentina"></div> --}}
                      <div class="point colombia" data-bs-toggle="tooltip" data-bs-placement="top" title="GHANA"></div>
                      {{-- <div class="point panama tippy" title="Panamá"></div> --}}
                      {{-- <div class="point mexico tippy" title="Mexico"></div> --}}
                      <div class="point usa" data-bs-toggle="tooltip" data-bs-placement="top" title="USA"></div>
                      <div class="point arabia" data-bs-toggle="tooltip" data-bs-placement="top" title="SOUTH AFRICA"></div>
                      <div class="point turquia" data-bs-toggle="tooltip" data-bs-placement="top" title="NIGERIA"></div>     
                      {{-- <div class="point rusia tippy" title="Rusia"></div> --}}
                      {{-- <div class="point china tippy" title="China"></div> --}}
                      {{-- <div class="point japon tippy" title="Japon"></div> --}}
                      <div class="point australia" data-bs-toggle="tooltip" data-bs-placement="top" title="United Kingdom"></div>
                    </div>
                  </div>
            </div>
        </div>
    </div>
</section>
