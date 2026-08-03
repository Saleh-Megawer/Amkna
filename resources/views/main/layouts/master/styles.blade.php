<link rel=stylesheet href="{{ asset('assets/plugins/bootstrap/bootstrap.min.css') }}">
<link rel=stylesheet href="{{ asset('assets/css/themes/main.css') }}">
<link rel=stylesheet href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
<!--  -->

<!-- Choices.js -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


<!-- noUiSlider -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.8.1/nouislider.min.css"
    integrity="sha512-qveKnGrvOChbSzAdtSs8p69eoLegyh+1hwOMbmpCViIwj7rn4oJjdmMvWOuyQlTOZgTlZA0N2PXA7iA8/2TUYA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- EasyAutocomplete CSS (optional) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/easy-autocomplete/1.3.5/easy-autocomplete.min.css">



<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
@if (lang() == 'ar')
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100..900&display=swap" rel="stylesheet">
@else
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
@endif

@if (request()->segment(2) == 'about-us')
    <link rel="stylesheet" href="{{ asset('https://unpkg.com/aos@2.3.1/dist/aos.css') }}">
@endif

@if (lang() == 'ar')
    <link rel=stylesheet href="{{ asset('assets/css/directions/rtl/rtl.css') }}?v={{ env('V') }}">
@else
    <link rel=stylesheet href="{{ asset('assets/css/directions/ltr/ltr.css') }}?v={{ env('V') }}">
@endif
<link rel="stylesheet" href="{{ asset('assets/css/all.css') }}?v={{ env('V') }}">


<!-- Load Client Profile Files -->
@if (request()->segment(2) == clientPrefix() && clientHasAuth())
    <link rel="stylesheet" href="{{ asset('assets/css/pages/clients/client.css') }}?v={{ env('V') }}">
@endif


<!--  -->
@yield('component-css')
@yield('css')
