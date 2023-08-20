<header class="header-fixed header--primary">
    <div class="container-fluid">
      <div class="row g-0 align-items-center">
        <div class="col-6 col-lg-2">

          <!-- Logo  -->
          <a href="{{route('home')}}" class="logo">
            {{-- <img src="{{ getImage(imagePath()['logoIcon']['path'] .'/logo.png') }}" alt="image" class="img-fluid "> --}}
            <img src="{{ url('')}}/assets/images/logo2.png" alt="image" class="img-fluid ">
          </a>
          <!-- Logo End -->

        </div>
        <div class="col-6 col-lg-10">
          <div class="nav-container">

            <!-- Navigation Toggler  -->
            <div class="d-flex justify-content-end align-items-center d-lg-none">

              <button
                type="button"
                class="btn btn--sqr btn--base nav--toggle text--white"
              >
                <i class="las la-bars"></i>
              </button>
            </div>
            <!-- Navigation Toggler End -->

            <!-- Navigation  -->
            <nav class="navs">
              <!-- Primary Menu  -->
              <ul class="list primary-menu ms-lg-auto">
                @stack('header')
              </ul>
              <!-- Primary Menu End -->

              <!-- User Login  -->
              <div class="mx-3 ms-lg-4 ms-xl-5 me-lg-0">
                <ul class="list primary-menu primary-menu--alt">
                  <li class="primary-menu__list text-center">
                    <div class="form--select-dark d-flex align-items-center">
                      <select class="form-select form--select-sm langSel">
                            @foreach($language as $lang)
                                <option value="{{$lang->code}}" @if(session('lang') == $lang->code) selected  @endif>{{ __($lang->name) }}</option>
                            @endforeach
                      </select>
                    </div>
                  </li>

                    @guest
                        <li class="primary-menu__list text-center">
                            <a href="{{route('user.login')}}" class="btn btn--md w-100 text--accent" style="border: 1px solid;
                            border-radius: 1px;">@lang('Login') <i class="fas fa-arrow-right"></i></a>
                        </li>
                     
                    @else
                        <li class="primary-menu__list text-center">
                            <a href="{{route('user.home')}}" class="btn btn--md w-100">@lang('Dashboard')</a>
                        </li>
                        <li class="primary-menu__list text-center">
                            <a href="{{route('user.logout')}}" class="btn btn--md btn--base w-100">@lang('Logout')</a>
                        </li>
                    @endguest
                </ul>
              </div>
              <!-- User Login End -->

            </nav>
            <!-- Navigation End -->
          </div>
        </div>
      </div>
    </div>
</header>
