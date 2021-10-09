<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    @include('layouts.frontend.head')

</head>

<body>
    <div class="page-holder {{ request()->routeIs('frontend.detail') ? ' bg-light' : null }}">

        @include('layouts.frontend.navbar')


        @yield('content')


        @include('layouts.frontend.footer')
        @include('layouts.frontend.footer_script')



    </div>
</body>

</html>
