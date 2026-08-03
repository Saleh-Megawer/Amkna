$(document).ready(function () {


    $(document).on('click', '.notes-toggle', function () {

        const btn = $(this);
        const more = btn.siblings('.notes-more');

        if (btn.data('state') === 'collapsed') {
            more.removeClass('d-none');
            btn.text('إخفاء');
            btn.data('state', 'expanded');
        } else {
            more.addClass('d-none');
            btn.text('قراءة المزيد');
            btn.data('state', 'collapsed');
        }
    });


    $('.btn-edit-unit-owner-association').click(function (e) {
        e.preventDefault();

        const unitId = $(this).data('unit-id'),
            oaUuid = $('meta[name="owner-association-uuid"]').attr('content'),
            select = document.querySelector('.edit-unit-select-property-type');

        $.post(
            adminUrl + '/owner-associations/' + oaUuid + '/units/' + unitId,
            function (data) {

                if (data.status) {
                    return iziToast.error({ message: data.message });
                }

                const form = $('#edit-unit-owner-association-form');

                form.attr(
                    'action',
                    adminUrl + '/owner-associations/' + oaUuid + '/units/' + unitId + '/update'
                );

                const choicesInstance = select.choicesInstance;
                if (choicesInstance) {
                    choicesInstance.removeActiveItems();
                    choicesInstance.setChoiceByValue(String(data.property_type_id));
                }

                form.find('[name="unit_number"]').val(data.unit_number);
                form.find('[name="floor"]').val(data.floor);
                form.find('[name="client_id"]').val(data.client_id);
                form.find('.client-search-input').val(data.client_name);

                $('#model-edit-unit-owner-association').modal('show');

            }
        );
    });



    $(document).on('click', '.btn-edit-poll', function (e) {
        e.preventDefault();

        const pollId = $(this).data('poll-id'),
            oaUuid = $('meta[name="owner-association-uuid"]').attr('content');

        $.post(
            adminUrl + '/owner-associations/' + oaUuid + '/polls/' + pollId,
            function (data) {
                if (data.status) {
                    return iziToast.error({ message: data.message });
                }

                const form = $('#model-edit-poll form');

                // تغيير الـ action للـ update
                form.attr(
                    'action',
                    adminUrl + '/owner-associations/' + oaUuid + '/polls/' + pollId + '/update'
                );

                // ملء البيانات
                form.find('[name="title"]').val(data.title);
                form.find('[name="description"]').val(data.description);

                // التعامل مع الـ checkbox
                const isActiveCheckbox = form.find('[name="is_active"]');
                if (data.is_active) {
                    isActiveCheckbox.prop('checked', true);
                } else {
                    isActiveCheckbox.prop('checked', false);
                }

                $('#model-edit-poll').modal('show');
            }
            
        ).fail(function () {
            iziToast.error({ message: 'حدث خطأ أثناء تحميل بيانات الاستطلاع' });
        });
    });






});