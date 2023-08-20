@php
    $breadcrumbContent = getContent('breadcrumb.content',true);
@endphp

<div class="banner" style="background-image: url({{ url('assets/images/splash_3.png') }})">
  <div class="banner__content">
    <div class="container">
      <div class="row g-3 justify-content-center">
        <div class="col-lg-10 text-center">
            <h2 class="mt-0 text--accent">{{__($pageTitle)}}</h2>
        </div>
      </div>
    </div>
  </div>
</div>
