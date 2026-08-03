<!-- bootstrap -->
<link rel="stylesheet" href="{{ asset('dashboard/plugins/bootstrap/bootstrap.min.css') }}" />
<!-- fontawesome -->
<link rel="stylesheet" href="{{ asset('dashboard/plugins/fontawesome/all.min.css') }}" />

<!-- toastr -->
{{-- <link rel="stylesheet" href="{{ asset('dashboard/plugins/toastr/toastr.min.css') }}" /> --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" />
<!--
    | Themes Color
-->
<link rel="stylesheet" href="{{ asset('dashboard/css/themes/light.css') }}?v=<?php echo time(); ?>" />


<!-- components -->
<link rel="stylesheet" href="{{ asset('dashboard/css/helpers.css') }}?v=<?php echo time(); ?>" />
<link rel="stylesheet" href="{{ asset('dashboard/css/components/components.css') }}?v=<?php echo time(); ?>" />


<!-- global & plugins -->
<link rel="stylesheet" href="{{ asset('dashboard/css/global/global.css') }}?v=<?php echo time(); ?>" /><!-- main -->
<!-- global & plugins -->
<link rel="stylesheet" href="{{ asset('dashboard/css/override/override.css') }}?v=<?php echo time(); ?>" />



<!-- Auto Load Css File -->
@yield('css')
