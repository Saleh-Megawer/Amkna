<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <title>@yield('title')</title>
    @include('dashboard.layouts.meta.meta')
    @include('dashboard.layouts.styles.blank-style')
    <!-- Auto Load Css File -->
    @yield('css')
</head>

<body>

    @include('dashboard.layouts.components.results')


    @yield('content')


    @include('dashboard.layouts.scripts.blank-script')

    @yield('js')

</body>

</html>
