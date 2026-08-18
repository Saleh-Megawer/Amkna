<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    @include('main.layouts.master.meta')
    @include('main.layouts.master.styles')
    @yield('head')
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-KHL3GX8X');</script>
    <!-- End Google Tag Manager -->
</head>

<body @class([
    // من الـ yield
    trim($__env->yieldContent('body-class', '')),
    // ديناميكي
    'body-client' => clientHasAuth(),
])>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KHL3GX8X"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

    <x-navbar :options="$navbarOptions ?? []" />


    @yield('content')


    @include('main.layouts.master.footer')
    @include('main.layouts.master.scripts')

</body>

</html>
