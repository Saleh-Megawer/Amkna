$(document).ready(function () {

    $('.assign-admin').each(function () {
        // Prevent duplicate initialization
        if (this.classList.contains('select2-hidden-accessible')) return;
        $(this).select2({
            width: '100%',
            minimumResultsForSearch: 0,
            dropdownParent: document.body,
        });
    });

    // بعد ما تخلّص تهيئة كل الـ selects
  

    // $('.assign-admin').each(function () {
    //     if (this.classList.contains('select2-hidden-accessible')) return;

    //     $(this).select2({
    //         width: '100%',
    //         minimumResultsForSearch: 0,
    //         dropdownParent: $(this).closest('.table') // ← جرب أقرب حاجة منطقية
    //         // أو لو الجدول كله داخل div معين مثلاً → $('#table-container')
    //     });
    // });

});


$(document).on('change', '.assign-admin', function () {
    const adminId = $(this).val();
    if (!adminId) return;

    $.ajax({
        url: $(this).data('action'),
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            assigned_to: adminId
        },
        success: function (response) {
            iziToast.success({
                message: response.message || 'تم تكليف الموظف بنجاح'
            });
        },
        error: function (xhr) {
            iziToast.error({
                message: xhr.responseJSON?.message ||
                    'حدث خطأ أثناء التكليف'
            });
        }
    });
});