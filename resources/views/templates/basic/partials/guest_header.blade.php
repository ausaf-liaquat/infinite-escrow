<li class="primary-menu__list">
    <a href="{{route('home')}}" class="primary-menu__link">@lang('Home')</a>
  </li>

  @foreach($pages as $k => $data)
      <li class="primary-menu__list">
          <a href="{{route('pages',[$data->slug])}}" class="primary-menu__link">{{__($data->name)}}</a>
        </li>
  @endforeach

  <li class="primary-menu__list">
    <a href="{{route('blogs')}}" class="primary-menu__link">@lang('Blog')</a>
  </li>
  <li class="primary-menu__list">
    <a href="{{route('contact')}}" class="primary-menu__link">@lang('Contact')</a>
  </li>
