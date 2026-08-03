<!DOCTYPE html>
{{-- <html lang="{{ app()->getLocale() }}" @if (app()->getLocale() === 'ar') dir="rtl" @endif> --}}
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">


<head>
    @include('main.layouts.master.meta')
    @include('main.layouts.master.styles')
    @yield('head')
</head>

<body @class([
    // من الـ yield
    trim($__env->yieldContent('body-class', '')),
    // ديناميكي
    'body-client' => clientHasAuth(),
])>


    <x-navbar :options="$navbarOptions ?? []" />


    @yield('content')


    @include('main.layouts.master.footer')
    @include('main.layouts.master.scripts')

</body>

</html>
