@extends($activeTemplate.'layouts.app')
@section('content')
    @push('header')
        @include($activeTemplate.'partials.guest_header')
    @endpush

    @yield('content')
@endsection
