<script src="{{ asset('assets/plugins/jquery/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('assets/plugins/popper/popper.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/bootstrap.min.js') }}"></script>
<script type='text/javascript' src="{{ asset('assets/js/global/global.js') }}"></script>
<script src="{{ asset('assets/plugins/lazy/lazy.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery/jquery.form.min.js') }}"></script>
<script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery/jquery.sticky.js') }}"></script>
@if (lang() == 'ar')
    <script src="{{ asset('assets/plugins/jquery/jquery-validate-message-ar.js') }}"></script>
@endif
<!--  -->




<!-- Choices -->
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

<!-- noUiSlider -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.8.1/nouislider.min.js"
    integrity="sha512-g/feAizmeiVKSwvfW0Xk3ZHZqv5Zs8PEXEBKzL15pM0SevEvoX8eJ4yFWbqakvRj7vtw1Q97bLzEpG2IVWX0Mg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- EasyAutocomplete -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/easy-autocomplete/1.3.5/jquery.easy-autocomplete.min.js"></script>

<!-- Lozad -->
<script src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>






<!--  -->
<script type='text/javascript' src="{{ asset('assets/js/auto/main.js') }}"></script>
<script type='text/javascript' src="{{ asset('assets/js/plugins.js') }}"></script>
<script type='module' src="{{ asset('assets/js/global/ajax-post.js') }}"></script>
<script type='text/javascript' src="{{ asset('assets/js/layouts/navbar.js') }}"></script>






<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {

        function formatFlag(state) {
            if (!state.id) {
                return state.text;
            }

            var flag = $(state.element).data('flag');

            var $state = $(
                '<span><img class="flag-img" src="' + flag + '" /> ' + state.text + '</span>'
            );

            return $state;
        }

        $('.country-select').select2({
            templateResult: formatFlag,
            templateSelection: formatFlag,
            minimumResultsForSearch: -1, // disable search
            width: '100%'
        });

    });
</script>




<!-- Extra -->
@yield('component-js')
@yield('js')
