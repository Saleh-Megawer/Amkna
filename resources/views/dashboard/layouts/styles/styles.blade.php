<!-- bootstrap -->
<link rel="stylesheet" href="{{ asset('dashboard/plugins/bootstrap/bootstrap.min.css') }}" />
{{-- <!-- fontawesome -->
<link rel="stylesheet" href="{{ asset('dashboard/plugins/fontawesome/all.min.css') }}" />
 --}}

<!-- toastr -->
{{-- <link rel="stylesheet" href="{{ asset('dashboard/plugins/toastr/toastr.min.css') }}" /> --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" />

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js@11.1.0/public/assets/styles/choices.min.css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!--
    | Themes Color
    | Check If Choose Theme Exist In public\dashboard\themes\theme-name.css
    | Default If Not Exist Theme File => light
-->

<link rel="stylesheet" href="{{ asset('dashboard/css/themes/light.css') }}" />


<!-- Webiste DIR  -->
{{-- @if (app()->getLocale() == 'ar')
    <link rel="stylesheet" href="{{ asset('dashboard/css/directions/rtl/rtl.css') }}" />
    <!-- rtl -->
@else
    <link rel="stylesheet" href="{{ asset('dashboard/css/directions/ltr/ltr.css') }}" />
    <!-- ltr -->
@endif --}}
<link rel="stylesheet" href="{{ asset('dashboard/css/directions/rtl/rtl.css') }}?v=<?php echo time(); ?>" />


<!-- components -->
<link rel="stylesheet" href="{{ asset('dashboard/css/helpers.css') }}?v=<?php echo time(); ?>" />
<link rel="stylesheet" href="{{ asset('dashboard/css/components/components.css') }}?v=<?php echo time(); ?>" />


<!-- aside & navbar https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css -->
<link rel="stylesheet" href="{{ asset('dashboard/css/layouts/aside.css') }}?v=<?php echo time(); ?>" />
<link rel="stylesheet" href="{{ asset('dashboard/css/layouts/navbar.css') }}?v=<?php echo time(); ?>" /><!-- navbar -->





<!-- global & plugins -->
<link rel="stylesheet" href="{{ asset('dashboard/css/global/global.css') }}?v=<?php echo time(); ?>" /><!-- main -->
<link rel="stylesheet" href="{{ asset('dashboard/css/override/override.css') }}?v=<?php echo time(); ?>" />
<link rel="stylesheet" href="{{ asset('dashboard/css/app/app.css') }}?v=<?php echo time(); ?>" />
<!-- global -->



<!-- Auto Load Css File -->
@yield('css')
