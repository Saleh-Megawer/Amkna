$(document).ready(function () {

    // View Request Details
    $('#viewRequestModal').on('show.bs.modal', function (e) {
        const button = $(e.relatedTarget);
        const requestId = button.data('request-id');
        const modal = $(this);
        const oaUuid = $('meta[name="owner-association-uuid"]').attr('content');

        // Show loading
        modal.find('.request-details-loading').show();
        modal.find('.request-details-content').hide();

        // Fetch request details
        $.post(
            adminUrl + '/owner-associations/' + oaUuid + '/requests/' + requestId,
            function (data) {
                if (data.status) {
                    return iziToast.error({ message: data.message });
                }

                // Fill modal content
                modal.find('.request-type-icon').html(data.type_icon);
                modal.find('.request-type-label').text(data.type_label);
                modal.find('.request-priority-badge')
                    .attr('class', 'badge ' + data.priority_color)
                    .text(data.priority_label);

                modal.find('.request-title').text(data.title);
                modal.find('.request-description').text(data.description || '-');

                modal.find('.request-client').text(data.client_name);
                modal.find('.request-unit').text(data.unit_info || '-');

                modal.find('.request-status-badge')
                    .attr('class', 'badge ' + data.status_color)
                    .text(data.status_label);

                modal.find('.request-created-at').text(data.created_at);

                // Admin notes
                if (data.admin_notes) {
                    modal.find('.request-admin-notes').text(data.admin_notes);
                    modal.find('.request-admin-notes-section').show();
                } else {
                    modal.find('.request-admin-notes-section').hide();
                }

                // Hide loading, show content
                modal.find('.request-details-loading').hide();
                modal.find('.request-details-content').show();
            }
        ).fail(function () {
            iziToast.error({ message: 'حدث خطأ أثناء تحميل البيانات' });
            modal.modal('hide');
        });
    });


    // Open Change Status Modal
    $(document).on('click', '.btn-change-status', function () {
        const requestId = $(this).data('request-id');
        const requestTitle = $(this).data('request-title');
        const currentStatus = $(this).data('current-status');
        const currentStatusLabel = $(this).data('current-status-label');
        const currentStatusColor = $(this).data('current-status-color');

        const modal = $('#changeStatusModal');

        // Fill modal data
        modal.find('.change-status-title').text(requestTitle);
        modal.find('.change-status-current-badge')
            .attr('class', 'badge badge-md ' + currentStatusColor)
            .text(currentStatusLabel);

        modal.find('#change-status-request-id').val(requestId);
        modal.find('[name="status"]').val(currentStatus); // ← غيّر من '' لـ currentStatus
        modal.find('[name="admin_notes"]').val('');

        modal.modal('show');
    });


    // Submit Change Status
    $('#submitChangeStatus').click(function () {
        const button = $(this);
        const form = $('#changeStatusForm');
        const requestId = form.find('#change-status-request-id').val();
        const oaUuid = $('meta[name="owner-association-uuid"]').attr('content');

        // Validate
        if (!form.find('[name="status"]').val()) {
            return iziToast.warning({ message: 'يرجى اختيار الحالة الجديدة' });
        }

        // Show loading
        button.prop('disabled', true);
        button.find('.btn-text').hide();
        button.find('.btn-loading').show();

        // Submit
        $.ajax({
            url: adminUrl + '/owner-associations/' + oaUuid + '/requests/' + requestId + '/update-status',
            type: 'PATCH',
            data: form.serialize(),
            success: function (response) {

                iziToast.success({ message: response.message });
                setTimeout(() => window.location.reload(), 1500);

            },
            error: function () {
                iziToast.error({ message: 'حدث خطأ أثناء تحديث الحالة' });
            },
            complete: function () {
                button.prop('disabled', false);
                button.find('.btn-text').show();
                button.find('.btn-loading').hide();
            }
        });

    });


    // Open Change Payment Status Modal
    $(document).on('click', '.btn-change-payment-status', function () {
        const requestId = $(this).data('request-id');
        const requestTitle = $(this).data('request-title');
        const currentStatus = $(this).data('current-status');
        const currentStatusLabel = $(this).data('current-status-label');
        const currentStatusColor = $(this).data('current-status-color');

        // بيانات الـ payment الحالية
        const paymentStatus = $(this).data('payment-status');
        const paymentAmount = $(this).data('payment-amount');
        const paymentFrom = $(this).data('payment-from');
        const paymentTo = $(this).data('payment-to');
        const paymentRejection = $(this).data('payment-rejection');
        const paymentNotes = $(this).data('notes');

        const modal = $('#changePaymentStatusModal');

        modal.find('.change-status-title').text(requestTitle);
        modal.find('.change-status-current-badge')
            .attr('class', 'badge badge-md ' + currentStatusColor)
            .text(currentStatusLabel);

        modal.find('#change-payment-request-id').val(requestId);

        // Reset أولاً
        modal.find('#verifiedFields').hide();
        modal.find('#rejectedFields').hide();

        // ملي البيانات لو موجودة
        modal.find('#paymentStatusSelect').val(paymentStatus || '');
        modal.find('[name="paid_amount"]').val(paymentAmount || '');
        modal.find('[name="subscription_from"]').val(paymentFrom || '');
        modal.find('[name="subscription_to"]').val(paymentTo || '');
        modal.find('[name="rejection_reason"]').val(paymentRejection || '');
        modal.find('[name="admin_notes"]').val(paymentNotes || '');

        // اعرض الـ fields المناسبة لو في حالة موجودة
        if (paymentStatus === 'verified') {
            $('#verifiedFields').show();
        } else if (paymentStatus === 'rejected') {
            $('#rejectedFields').show();
        }

        modal.modal('show');
    });


    // Submit Change Payment Status
    $('#submitChangePaymentStatus').click(function () {
        const button = $(this);
        const form = $('#changePaymentStatusForm');
        const requestId = form.find('#change-payment-request-id').val();
        const oaUuid = $('meta[name="owner-association-uuid"]').attr('content');
        const status = form.find('#paymentStatusSelect').val();

        // Validate
        if (!status) {
            return iziToast.warning({ message: 'يرجى اختيار الحالة الجديدة' });
        }

        if (status === 'verified') {
            if (!form.find('[name="paid_amount"]').val()) {
                return iziToast.warning({ message: 'يرجى إدخال المبلغ المدفوع' });
            }
            if (!form.find('[name="subscription_from"]').val() || !form.find('[name="subscription_to"]').val()) {
                return iziToast.warning({ message: 'يرجى تحديد فترة الاشتراك' });
            }
        }

        if (status === 'rejected' && !form.find('[name="rejection_reason"]').val()) {
            return iziToast.warning({ message: 'يرجى إدخال سبب الرفض' });
        }

        // Show loading
        button.prop('disabled', true);
        button.find('.btn-text').hide();
        button.find('.btn-loading').show();

        $.ajax({
            url: adminUrl + '/owner-associations/' + oaUuid + '/requests/' + requestId + '/verify-payment',
            type: 'POST',
            data: form.serialize(),
            success: function (response) {
                iziToast.success({ message: response.message });
                setTimeout(() => window.location.reload(), 1500);
            },
            error: function () {
                iziToast.error({ message: 'حدث خطأ أثناء تحديث الحالة' });
            },
            complete: function () {
                button.prop('disabled', false);
                button.find('.btn-text').show();
                button.find('.btn-loading').hide();
            }
        });
    });

    $('#paymentStatusSelect').on('change', function () {
        const val = $(this).val();
        $('#verifiedFields').hide();
        $('#rejectedFields').hide();

        if (val === 'verified') {
            $('#verifiedFields').show();
        } else if (val === 'rejected') {
            $('#rejectedFields').show();
        }
    });



    /**
     * 
     * Show Page
     * 
     */

    // إضافة رد
    $(document).on('submit', '#add-reply-form', function (e) {
        e.preventDefault();

        const $form = $(this);
        const $btn = $('#btn-add-reply');
        const $btnText = $btn.find('.btn-text');
        const $spinner = $btn.find('.spinner-border');
        const url = $form.attr('action') || $form.data('url');

        // Disable button
        $btn.prop('disabled', true);
        $btnText.addClass('d-none');
        $spinner.removeClass('d-none');

        $.ajax({
            url: url,
            type: 'POST',
            data: $form.serialize(),
            success: function (response) {
                if (response.success) {
                    // استبدال محتوى الردود بالكامل
                    $('#replies-container').html(response.html);

                    // تحديث العدد
                    $('#replies-count').text(response.replies_count);

                    // مسح الـ form
                    $form[0].reset();

                    // Success message
                    toastr.success(response.message);
                }
            },
            error: function (xhr) {
                toastr.error('حدث خطأ أثناء إضافة الرد');
            },
            complete: function () {
                // Enable button
                $btn.prop('disabled', false);
                $btnText.removeClass('d-none');
                $spinner.addClass('d-none');
            }
        });
    });





});
