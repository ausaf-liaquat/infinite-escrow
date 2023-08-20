@php
    $partnerContent = getContent('partner.content',true);
    $socialContent = getContent('social_icon.content',true);
    $partnerElements = getContent('partner.element',false,null,true);
    $socialElements = getContent('social_icon.element',false,null,true);
    $contactElements = getContent('contact.element',false,null,true);
    $policyElements = getContent('policy_pages.element',false,null,true);
@endphp

<footer class="footer">
    {{-- @if(Request::routeIs('home'))
        <div class="container">
            <div class="row g-4 g-md-0 align-items-center">
                <div class="col-12">
                    <div class="client-section">
                        <div class="row g-4 g-md-0 align-items-center">
                            <div class="col-md-4 col-xxl-4">
                                <div class="client-section__head">
                                    <span class="client-section__sub-title text-center text-md-end">
                                        {{__(@$partnerContent->data_values->heading)}}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-8 col-xxl-8">
                                <div class="client-slider">
                                    @foreach ($partnerElements as $partner)
                                        <div class="client-slider__item">
                                            <img src="{{ getImage('assets/images/frontend/partner/'.@$partner->data_values->image,'130x50') }}" alt="image" class="client-slider__img">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif --}}

    <div class="section" style="font-size: 13px;">
        <div class="container">
            <div class="row g-4 justify-content-xl-between">
                <div class="col-md-6">
                    <a href="{{route('home')}}" class="logo mt-0">
                        <img src="{{url('')}}/assets/images/logofooter.png" alt="" style="width:100%">
                        {{-- <img src="{{ getImage(imagePath()['logoIcon']['path'] .'/logo.png') }}" alt="image" class="img-fluid logo__is"> --}}
                    </a>
                 
                    <!--<p class="text--white">{{__(@$socialContent->data_values->footer_text)}}</p>-->

                    <p class="text--white">Infinite Escrow provides a legal arrangement that temporarily holds money or cryptocurrency until a particular condition has been met.</p>
                    <img src="{{url('')}}/assets/images/app_store.png" alt="">
                    <img src="{{url('')}}/assets/images/play.png" alt="">
                  
                </div>

                <div class="col-md-2 ">
                    <h6 class="mt-0 text--white">@lang('Quick Links')</h6>
                 
                    <ul class="list list--column">
                        <li class="list--column__item">
                            <a href="{{route('home')}}" class="t-link t-link--base text--white d-inline-block">
                                @lang('Home')
                            </a>
                        </li>

                        @foreach($pages as $k => $data)
                            <li class="list--column__item">
                                <a href="{{route('pages',[$data->slug])}}" class="t-link t-link--base text--white d-inline-block">
                                    {{__($data->name)}}
                                </a>
                            </li>
                        @endforeach

                        <li class="list--column__item">
                            <a href="{{route('blogs')}}" class="t-link t-link--base text--white d-inline-block">
                                @lang('Blog')
                            </a>
                        </li>
                        <li class="list--column__item">
                            <a href="{{route('contact')}}" class="t-link t-link--base text--white d-inline-block">
                                @lang('Contact')
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-md-2">
                    <h6 class="mt-0 text--white">@lang('Company Policy')</h6>
                 
                    <ul class="list list--column">
                        @foreach ($policyElements as $policy)
                            <li class="list--column__item">
                                <a href="{{route('policy.details',[$policy->id,slug(@$policy->data_values->title)])}}" class="t-link t-link--base text--white d-inline-block">
                                    {{shortDescription(__(@$policy->data_values->title),15)}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-2">
                    <h6 class="mt-0 text--white">@lang('Contact Us')</h6>
                 
                    <ul class="list list--column">
                     
                            <li class="list--column__item">
                                <div class="contact-card">
                                    <div class="contact-card__icon">
                                      <img src="{{url('')}}/assets/images/location.png" alt="">
                                    </div>
                                    <div class="contact-card__content">
                                        <p class="text--white mb-0">
                                            NIGERIA
                                        </p>
                                    </div>
                                </div>
                            </li>
                            <li class="list--column__item">
                                <div class="contact-card">
                                    <div class="contact-card__icon">
                                      <img src="{{url('')}}/assets/images/envlope.png" alt="">
                                    </div>
                                    <div class="contact-card__content">
                                        <p class="text--white mb-0">
                                            support@infiniteescrow.com
                                        </p>
                                    </div>
                                </div>
                            </li>
                            <li class="list--column__item">
                                <div class="contact-card">
                                    <div class="contact-card__icon">
                                      <img src="{{url('')}}/assets/images/phone.png" alt="">
                                    </div>
                                    <div class="contact-card__content">
                                        <p class="text--white mb-0">
                                            08122771172 
                                        </p>
                                    </div>
                                </div>
                            </li>
                        {{-- @endforeach --}}
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="footer__copyright py-3">
      <p class="mb-0 sm-text text--white">
        @lang('Copyright') © {{now()->format('Y')}}. @lang('All Rights Reserved By')
        <a href="{{route('home')}}" class="t-link t-link--base text-white" style="text-decoration: underline;">{{__($general->sitename)}}</a>
      </p>

      {{-- <div class="float-end" style="position: relative;
      bottom: 26px;">
        <img src="{{url('')}}/assets/images/f1.png" alt="">
        <img src="{{url('')}}/assets/images/f2.png" alt="">
        <img src="{{url('')}}/assets/images/f3.png" alt=""></div> --}}
        {{-- <ul class="list list--row">
            @foreach ($socialElements as $social)
                <li class="list--row__item">
                    <a href="{{@$social->data_values->url}}"class="social-icon t-link icon icon--sm icon--circle" target="_blank">
                        @php echo @$social->data_values->icon @endphp
                    </a>
                </li>
            @endforeach
        </ul> --}}
      
    </div>

</footer>
