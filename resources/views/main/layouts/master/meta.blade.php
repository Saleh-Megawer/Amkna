@php
    $currentPath = request()->path(); /* Get Current Path Url */
    $pathSegments = explode('/', $currentPath); // Get Current Path And Explode

    // Check And Remove Lang From Path Segments
    if (array_key_exists($pathSegments[0], languages())) {
        array_shift($pathSegments);
    }
    $cleanPathWithOutLangPrefix = implode('/', $pathSegments);

    /*** ------------------------ ***/

    /* Prepare Page Title – */
    $pageTitle = trim($title ?? (View::yieldContent('title') ?? 'Empty Page Title'));
    if (!isset($removeAppNameFromTitle) || !$removeAppNameFromTitle) {
        $pageTitle .= ' | ' . __('main.app_name');
    }
@endphp
<!--------------- Standard Meta ------------------>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="url" content="{{ url('') }}">
<meta name="language" content="{{ lang() }}">
<meta name="robots" content="index, follow">
<meta name="application-name" content="{{ __('main.app_name') }}">
<meta name="author" content="{{ __('main.app_name') }}">
<link rel="icon" href="{{ website_icon() }}" sizes="32x32">
<link rel="apple-touch-icon" href="{{ asset('assets/images/meta/icons/apple-touch-icon.png') }}">
<link rel="sitemap" type="application/xml" title="Sitemap" href="{{ url('sitemap.xml') }}">
<meta name="robots" content="index, follow">
<!--------------- SEO / Meta Title & Description ------------------>
<meta name="title" content="{!! $pageTitle !!}">
<meta name="description" content="@yield('description')">
<title>{!! $pageTitle !!}</title>
<!--------------- Open Graph / Facebook & General Social ------------------>
<meta property="og:title" content="{!! $pageTitle !!}">
<meta property="og:site_name" content="Ask Property">
<meta property="og:url" content="@yield('url', urldecode(Request::url()))">
<meta property="og:description" content="@yield('description')">
<meta property="og:type" content="@yield('type', 'website')">
<meta property="og:image" content="@yield('image', asset('assets/images/meta-image-defualt.jpg'))">
<meta property="og:image:alt" content="{!! $pageTitle !!}">
<meta property="og:image:type" content="image/webp">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<!--------------- Twitter Cards ------------------>
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:data1" content="Ask Property">
<meta property="twitter:image" content="@yield('image', asset('assets/images/meta-image-defualt.jpg'))">
<meta name="twitter:image:alt" content="{!! $pageTitle !!}">
<meta name="twitter:title" content="{!! $pageTitle !!}">
<meta name="twitter:description" content="@yield('description')">
{{-- <meta name="twitter:site" content="@SahdProperty">
<meta name="twitter:creator" content="@SahdProperty"> --}}
<!--------------- Canonical & Hreflang Tags ------------------>
<link rel="canonical" href="{{ url()->current() }}" />
<link rel="alternate" hreflang="x-default" href="{{ url($cleanPathWithOutLangPrefix) }}" />
@foreach (languages() as $key => $lang)
<link rel="alternate" hreflang="{{ $key }}" href="{{ url($key . '/' . $cleanPathWithOutLangPrefix) }}" />
@endforeach
<!--------------- Google Analytics ------------------>
