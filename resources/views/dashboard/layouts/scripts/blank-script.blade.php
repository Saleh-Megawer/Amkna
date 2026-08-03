<!-- jquery -->
<script src="{{ asset('dashboard/plugins/jquery/jquery-3.6.0.min.js') }}"></script>
<!-- popper-->
<script src="{{ asset('dashboard/plugins/popper/popper.min.js') }}"></script>
<!-- bootstrap-->
<script src="{{ asset('dashboard/plugins/bootstrap/bootstrap.min.js') }}"></script>

<!-- fontawesome -->
<script src="{{ asset('dashboard/plugins/fontawesome/all.min.js') }}"></script>


<!-- toastr-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
{{-- <script src="{{ asset('dashboard/plugins/toastr/toastr.min.js') }}"></script> --}}
<!-- jquery.validate -->
<script src="{{ asset('dashboard/plugins/jquery/jquery.validate.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/nice-select/jquery.nice-select.min.js') }}"></script>
<!-- jquery.form -->
<script src="{{ asset('dashboard/plugins/jquery/jquery.form.min.js') }}"></script>
<!-- sweetalert -->
<script src="{{ asset('dashboard/plugins/sweetalert/sweetalert.min.js') }}"></script>




<!-- Global Var -->
<script type='text/javascript' src="{{ asset('dashboard/js/global/global.js') }}"></script>
<!-- Auto -->
<script type='module' src="{{ asset('dashboard/js/auto/main.js') }}"></script>
<!-- validation -->
<script type='text/javascript' src="{{ asset('dashboard/js/validation.js') }}"></script>
<!-- Plugins Run And Custom -->
<script type='text/javascript' src="{{ asset('dashboard/js/plugins.js') }}"></script>
<!-- Requests -->
<script type='module' src="{{ asset('dashboard/js/global/ajax-post.js') }}"></script>

<!-- Include From Other Pages -->
@yield('js')
