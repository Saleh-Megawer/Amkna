$(document).ready(function () {


    // ================================
    // Follow Up
    // ================================
    $(document).on('click', '.btn-edit-follow-up', function () {
        let followUpId = $(this).data('follow-up-id'),
            dealUuid = typeof dealUuidMeta === 'function' ? dealUuidMeta() : $(this).data('deal-uuid');

        $.ajax({
            url: adminUrl + `/crm/deals/${dealUuid}/follow-ups/${followUpId}/show`,
            type: 'GET',
            success: function (response) {
                if (response.status === 'success') {
                    $('#editFollowupModal').remove();
                    $('body').append(response.html);
                    $('#editFollowupModal').modal('show');
                }
                if (response.status === 'error') {
                    iziToast.error({ message: response.message });
                }
            },
            error: function () {
                iziToast.error({ message: 'حدث خطأ أثناء تحميل البيانات' });
            }
        });

    });


});