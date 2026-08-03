// Validation Config
const MAX_FILES = 5;
const MAX_FILE_SIZE = 10 * 1024 * 1024; // 10MB in bytes
const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'zip', 'rar', 'txt'];
const ALLOWED_MIMES = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip', 'application/x-rar-compressed', 'text/plain'];

// File Input Change Event
$('input[name="files[]"]').on('change', function (e) {
    let files = e.target.files;
    let errors = [];

    // 1. Check files count
    if (files.length > MAX_FILES) {
        errors.push(`لا يمكن رفع أكثر من ${MAX_FILES} ملفات في المرة الواحدة`);
    }

    // 2. Validate each file
    Array.from(files).forEach((file, index) => {
        // Check file size
        if (file.size > MAX_FILE_SIZE) {
            errors.push(`الملف "${file.name}" حجمه كبير جدًا (الحد الأقصى: 10 ميجابايت)`);
        }

        // Check file extension
        let extension = file.name.split('.').pop().toLowerCase();
        if (!ALLOWED_EXTENSIONS.includes(extension)) {
            errors.push(`الملف "${file.name}" نوعه غير مسموح`);
        }

        // Check MIME type
        if (!ALLOWED_MIMES.includes(file.type)) {
            errors.push(`الملف "${file.name}" صيغته غير صحيحة`);
        }
    });

    // 3. Show errors or clear input
    if (errors.length > 0) {
        errors.forEach(error => iziToast.error({ message: error }));
        $(this).val(''); // Clear input
        return false;
    }

    // 4. Show selected files info
    if (files.length > 0) {
        let totalSize = Array.from(files).reduce((sum, file) => sum + file.size, 0);
        let totalSizeMB = (totalSize / (1024 * 1024)).toFixed(2);
        iziToast.info({ message: `تم اختيار ${files.length} ملف - الحجم الإجمالي: ${totalSizeMB} ميجابايت` });
    }
});

// Upload Attachment with Progress Bar
$('#addAttachmentForm').on('submit', function (e) {
    e.preventDefault();

    // Double check before upload
    let files = $(this).find('input[name="files[]"]')[0].files;
    if (files.length === 0) {
        iziToast.error({ message: 'يجب اختيار ملف واحد على الأقل' });
        return false;
    }

    if (files.length > MAX_FILES) {
        iziToast.error({ message: `لا يمكن رفع أكثر من ${MAX_FILES} ملفات في المرة الواحدة` });
        return false;
    }

    let formData = new FormData(this);
    let submitBtn = $(this).find('button[type="submit"]');
    let originalText = submitBtn.html();
    let progressBar = $('#uploadProgress');
    let progressBarInner = progressBar.find('.progress-bar');

    submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm mr-2"></span>جاري الرفع...');
    progressBar.removeClass('d-none');
    progressBarInner.css('width', '0%').text('0%');

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        xhr: function () {
            let xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener('progress', function (evt) {
                if (evt.lengthComputable) {
                    let percentComplete = Math.round((evt.loaded / evt.total) * 100);
                    progressBarInner.css('width', percentComplete + '%');
                    progressBarInner.text(percentComplete + '%');
                }
            }, false);
            return xhr;
        },
        success: function (response) {
            if (response.status === 'success') {
                iziToast.success({ message: response.message });
                $('#addAttachmentModal').modal('hide');
                if (response.reload) {
                    setTimeout(() => location.reload(), 1500);
                }
            }
        },
        error: function (xhr) {
            let errors = xhr.responseJSON?.errors;
            if (errors) {
                Object.values(errors).forEach(error => {
                    iziToast.error({ message: error[0] });
                });
            } else {
                iziToast.error({ message: 'حدث خطأ أثناء الرفع' });
            }
        },
        complete: function () {
            submitBtn.prop('disabled', false).html(originalText);
            setTimeout(() => progressBar.addClass('d-none'), 1000);
        }
    });
});

// Delete Attachment
$(document).on('click', '.btn-delete-attachment', function () {
    let attachmentId = $(this).data('attachment-id');

    if (!confirm('هل أنت متأكد من حذف هذا المرفق؟')) return;

    $.ajax({
        url: `/crm/deals/attachments/${attachmentId}/delete`,
        type: 'DELETE',
        data: { _token: $('meta[name="csrf-token"]').attr('content') },
        success: function (response) {
            if (response.status === 'success') {
                iziToast.success({ message: response.message });
                setTimeout(() => location.reload(), 1000);
            }
        },
        error: function () {
            iziToast.error({ message: 'حدث خطأ أثناء الحذف' });
        }
    });
});

// Reset form when modal is closed
$('#addAttachmentModal').on('hidden.bs.modal', function () {
    $('#addAttachmentForm')[0].reset();
    $('#uploadProgress').addClass('d-none');
});
