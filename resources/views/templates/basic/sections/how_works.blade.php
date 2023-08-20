@php
    $workContent = getContent('how_works.content',true);
    $workElements = getContent('how_works.element',false,null,true);
@endphp

<section class="section--sm" data-aos="fade-in">
    <div class="section__head">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <h4 class="mt-0 text-center">
                        {{__(@$workContent->data_values->heading)}}
                    </h4>
                    <p class="section__para mb-0 text-center mx-auto">
                        {{__(@$workContent->data_values->sub_heading)}}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row g-4 justify-content-center">
            @foreach ($workElements as $work)
                <div class="col-md-6 col-lg-3">
                    <div class="process text-center">
                        <div class="icon icon--circle icon--xxl process__icon  @if(!$loop->last) process__icon-shape @endif"  data-aos="zoom-in">
                            @php echo @$work->data_values->icon; @endphp
                        </div>
                        <h5 class="mb-0" data-aos="fade-right">
                            {{__(@$work->data_values->details)}}
                        </h5>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
