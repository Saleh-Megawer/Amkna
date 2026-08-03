<!-- jquery -->
<script src="{{ asset('dashboard/plugins/jquery/jquery-3.6.0.min.js') }}"></script>
<!-- popper-->
<script src="{{ asset('dashboard/plugins/popper/popper.min.js') }}"></script>
<!-- bootstrap-->
<script src="{{ asset('dashboard/plugins/bootstrap/bootstrap.min.js') }}"></script>

<!-- lazy -->
{{-- <script src="{{ asset('dashboard/plugins/lazy/lazy.js') }}"></script> --}}



<!-- bootstrap select -->
<script src="https://cdn.jsdelivr.net/npm/choices.js@11.1.0/public/assets/scripts/choices.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>




<!-- toastr-->
<script src="{{ asset('dashboard/plugins/toastr/toastr.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>

<!-- jquery.validate -->
{{-- <script src="{{ asset('dashboard/plugins/jquery/jquery.validate.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/jquery/jquery-validate-message-ar.js') }}"></script>
<script src="{{ asset('dashboard/plugins/nice-select/jquery.nice-select.min.js') }}"></script> --}}
<!-- jquery.form -->
<script src="{{ asset('dashboard/plugins/jquery/jquery.form.min.js') }}"></script>
<!-- sweetalert -->
<script src="{{ asset('dashboard/plugins/sweetalert/sweetalert.min.js') }}"></script>
{{-- <!-- fontawesome -->
<script src="{{ asset('dashboard/plugins/fontawesome/all.min.js') }}"></script> --}}




<!-- Global Var -->
<script type='text/javascript' src="{{ asset('dashboard/js/global/global.js') }}"></script>
<script src="{{ asset('dashboard/js/global/notifications.js') }}"></script>

<!-- Layouts -->
<script type='text/javascript' src="{{ asset('dashboard/js/layouts/aside.js') }}"></script>
<script type='text/javascript' src="{{ asset('dashboard/js/layouts/navbar.js') }}"></script>
<!-- Auto -->
<script type='module' src="{{ asset('dashboard/js/auto/main.js') }}"></script>
<!-- app.js -->
<script type='text/javascript' src="{{ asset('dashboard/js/app.js') }}"></script>
{{-- <script type='module' src="{{ asset('dashboard/js/auto/auto-load.js') }}"></script> --}}
<!-- validation -->
<script type='text/javascript' src="{{ asset('dashboard/js/validation.js') }}"></script>

<!-- Requests -->
<script type='module' src="{{ asset('dashboard/js/global/ajax-post.js') }}"></script>




<script>
    /***
     * 
     * This Function For Component ( InputPhone.php )
     * Data From : ViewShareServiceProvider
     * 
     */
    // استيراد البيانات من Laravel
    const phoneNumberLengths = @json($globalPhoneData['lengths']);
    const phoneNumberFormats = @json($globalPhoneData['formats']);
    $(document).ready(function() {

        const $select = $('select[name="country_code"]');
        const $input = $('input[name="phone"]');

        function updatePhoneInput() {
            const code = $select.val();
            const format = phoneNumberFormats[code] || 'xxxxxxxxxx';



            // تحديث placeholder
            $input.attr('placeholder', format);

            // حساب عدد الـ x لتحديد الطول
            const length = (format.match(/x/g) || []).length;


            // تحديث طول الحقل
            $input.attr({
                minlength: format.length,
                maxlength: format.length
            });
        }

        // أول تحميل للصفحة
        updatePhoneInput();

        // عند تغيير الدولة
        $select.on('change', updatePhoneInput);

    });

    document.querySelectorAll('.choices-country').forEach(function(el) {

        const instance = new Choices(el, {
            searchEnabled: false,
            itemSelectText: '',
            shouldSort: false
        });

        function addFlags() {

            document.querySelectorAll('.choices__item[data-value]').forEach(function(item) {

                if (item.querySelector('img')) return;

                const value = item.dataset.value;
                const option = el.querySelector(`option[value="${value}"]`);

                if (option) {
                    const flag = option.dataset.flag;

                    item.insertAdjacentHTML(
                        'afterbegin',
                        `<img src="${flag}" width="18" height="12" style="margin-right:6px;">`
                    );
                }

            });

        }

        addFlags();

        el.addEventListener('change', function() {
            setTimeout(addFlags, 10);
        });

    });
    
</script>


@stack('js')
<!-- Include From Other Pages -->
@yield('js')


<!-- Plugins Run And Custom -->
<script type='text/javascript' src="{{ asset('dashboard/js/plugins.js') }}"></script>
