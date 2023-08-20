@extends($activeTemplate . 'layouts.frontend')

@section('content')
    @if (!Request::url()==url('')."/about-us")
        @include($activeTemplate . 'partials.breadcrumb')
    @endif
    @if ($sections != null)
        @foreach (json_decode($sections) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection
