@extends($activeTemplate.'layouts.app')
@section('content')

    @push('header')
        @include($activeTemplate.'partials.auth_header')
    @endpush
    
    @yield('content')

@endsection
