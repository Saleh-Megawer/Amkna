Dropzone.autoDiscover = false;

$(function () {

    /* =========================
     * Global & Shared Constants
     * ========================= */

    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    const propertyUUID = $('meta[name="property-uuid"]').attr('content');

    const mainImageElement = document.getElementById('mainImageDropzone');
    const galleryElement = document.getElementById('propertyDropzone');

    const mainImageUploadUrl = $(mainImageElement).attr('data-url-store');

    const galleryUploadUrl = $(galleryElement).attr('data-url-store');
    const galleryDestroyUrl = $(galleryElement).attr('data-url-destroy');
    const getAttachmentsUrl = $(galleryElement).attr('data-url-get-attachments');

    let mainImageDropzoneInstance;
    let galleryDropzoneInstance;


    /* =========================
     * Main Image Dropzone
     * ========================= */

    function initMainImageDropzone() {

        if (!mainImageElement || mainImageElement.dropzone) return;

        mainImageDropzoneInstance = new Dropzone(mainImageElement, {
            url: mainImageUploadUrl,
            paramName: "main_image",
            maxFilesize: 5,
            maxFiles: 1,
            acceptedFiles: "image/*",
            dictDefaultMessage: "اختر الصورة الرئيسية للوحدة",
            dictMaxFilesExceeded: "لا يمكن رفع أكثر من صورة واحدة",
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-HTTP-Method-Override': 'PATCH'
            },

            sending: function (file, xhr, formData) {
                formData.append('property_uuid', propertyUUID);
            },

            init: function () {
                const dz = this;

                dz.on("addedfile", function (file) {

                    // حذف كل الملفات القديمة من Dropzone نفسها (مش بس من الـ UI)
                    dz.files = dz.files.filter(function (f) {
                        return f === file;
                    });

                    // حذف أي previews قديمة من الواجهة
                    $(mainImageElement)
                        .find(".dz-preview")
                        .not(file.previewElement)
                        .remove();

                });


            }
        });

    }


    /* =========================
     * Gallery Dropzone
     * ========================= */

    function initGalleryDropzone() {

        if (!galleryElement || galleryElement.dropzone) return;

        galleryDropzoneInstance = new Dropzone(galleryElement, {
            url: galleryUploadUrl,
            paramName: "image",
            maxFilesize: 5,
            maxFiles: 10,
            acceptedFiles: "image/*",
            clickable: true,
            addRemoveLinks: true,
            dictDefaultMessage: "اختر صور اكثر حول الوحدة",
            dictRemoveFile: 'حذف',
            dictMaxFilesExceeded: "لا يمكن رفع أكثر من 10 صور",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },

            sending: function (file, xhr, formData) {
                // Attach property UUID with request
                formData.append('property_uuid', propertyUUID);
            },

            success: function (file, response) {
                // Save attachment id from server
                if (response.attachment_id) {
                    file.serverId = response.attachment_id;
                }
            },

            init: function () {

                this.on("removedfile", function (file) {

                    // Skip delete if file has no server id
                    if (!file.serverId) return;

                    $.ajax({
                        type: "DELETE",
                        url: galleryDestroyUrl,
                        data: {
                            id: file.serverId,
                            _token: csrfToken
                        },
                        success: function () {
                            iziToast.info({ message: 'تم حذف الصورة بنجاح...' });
                        },
                        error: function () {
                            iziToast.error({ message: 'حدث خطأ اثناء حذف الصورة!' });
                        }
                    });

                });

            }
        });

    }


    /* =========================
     * Load Existing Attachments
     * ========================= */

    function loadExistingImages() {

        $.ajax({
            type: "POST",
            url: getAttachmentsUrl,
            data: { property_uuid: propertyUUID },
            dataType: "json",
            success: function (response) {

                // Load main image
                const mainImage = response.main_image;

                const mainImageMockFile = {
                    name: mainImage.name.substring(0, 20) + '...',
                    size: mainImage.size,
                    serverId: mainImage.id
                };

                mainImageDropzoneInstance.displayExistingFile(mainImageMockFile, mainImage.url);
                mainImageDropzoneInstance.emit("complete", mainImageMockFile);


                // Load gallery images
                response.attachments.forEach(function (img) {

                    const shortFileName = img.name.length > 20
                        ? img.name.substring(0, 20) + '...'
                        : img.name;

                    const galleryMockFile = {
                        name: shortFileName,
                        size: img.size,
                        serverId: img.id
                    };

                    galleryDropzoneInstance.displayExistingFile(galleryMockFile, img.url);
                    galleryDropzoneInstance.emit("complete", galleryMockFile);

                });

            }
        });

    }


    /* =========================
     * Initialize Everything
     * ========================= */

    initMainImageDropzone();
    initGalleryDropzone();
    loadExistingImages();

});
