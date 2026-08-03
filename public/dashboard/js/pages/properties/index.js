import { responseStatus } from "../../modules/requests-response.js";

$(document).ready(function () {


    /**
     * Update & Create Page
     */

    $('.box-title').click(function (e) {
        e.preventDefault();
        let btn = $(this);



        btn.parent('.box').find('.box-body').slideToggle(150);
        btn.parent('.box').removeClass('hide-body');



    });

    $('.select2').select2({
        placeholder: 'اختر',
        dir: 'rtl',
        width: '100%'
    });

    $('.select2-multiple').select2({
        placeholder: "",
        dir: 'rtl',
        width: '100%'
    });



    $("#city_id").change(function (e) {
        let target = $(this);
        let neighborhoodSelect = $("#neighborhood_id");

        $.post(
            target.attr("data-url-get-neighborhoods"),
            { city_id: target.val() },
            function (data, textStatus, jqXHR) {
                if (data.status === "empty") {
                    return toastr.warning(data.message);
                } else {
                    // تفريغ خيارات الـ select2 بشكل صحيح
                    neighborhoodSelect.empty();

                    // إضافة خيار فارغ (اختياري)
                    neighborhoodSelect.append('<option></option>');

                    // إضافة الخيارات الجديدة
                    $.each(data, function (name, id) {
                        let newOption = new Option(name, id, false, false);
                        neighborhoodSelect.append(newOption);
                    });

                    // إعادة تهيئة وإعلام select2 بالتغييرات
                    neighborhoodSelect.trigger('change');
                }
            },
            "json"
        );
    });



    const uploadUrl = $('.form-upload-attachments').attr('action'),
        fileInput = document.querySelector(".input-upload"),
        maxUploadSize = 52428800, // 50MB
        maxUploadFile = 20;
    let btnBrowse = "#btn-browse";
    $(btnBrowse).click(function (e) {
        e.preventDefault();
        $(fileInput).click();
    });
    // Remove Progress
    function removeProgress() {
        $("#upload-progress").remove();
    }
    // In Script
    $(fileInput).change(function (e) {


        let files = e.target.files,
            totalFilesSize = 0,
            countFiles = files.length;

        removeProgress();

        if (countFiles <= maxUploadFile) {
            // Get Totla Files Size
            for (let i = 0; i < files.length; i++) {
                totalFilesSize += files[i].size;
            }

            // Check Files Size
            if (totalFilesSize <= maxUploadSize) {
                $("#update-form").ajaxSubmit({
                    url: uploadUrl,
                    type: "POST",

                    beforeSend: function (data, two, three) {
                        removeProgress();
                        $("#uploader .box")
                            .prepend(`<div id="upload-progress" class="progress">
                <div class="progress-bar progress-bar-striped bg-prmariy  progress-bar-animated" role="progressbar"
                    style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                    <div class="percent-box text-right mr-1">
                        <span class="perc">0</span>%
                    </div>
                </div>
            </div>`);

                        $(".upload-icon").addClass("icon-anim");
                    },
                    uploadProgress: function (event, pos, total, percent) {
                        $("#uploader .box .progress .perc").text(percent);
                        $("#uploader .box .progress .progress-bar").css(
                            "width",
                            percent + "%"
                        );
                        $(btnBrowse).attr("disabled", "disabled");
                        $(btnBrowse).text("( " + countFiles + " ) رفع...");

                        if (percent == 100) {
                            $("#uploader .box .progress .percent-box").text(
                                "جاري المعالجة..."
                            );
                        }
                    },
                    success: function (data, two, three) {
                        responseStatus(data, "#update-form");
                        // Button
                        $(btnBrowse).text("تصفح المرفقات");
                        $(btnBrowse).removeAttr("disabled");
                        $(".upload-icon").removeClass("icon-anim");

                        if (data.status == "error") {
                            removeProgress();
                        } else {
                            $("#uploader .box .progress .percent-box").text(
                                "Successfully Uploading"
                            );
                            // Progress
                            $(".progress-bar").addClass("bg-success");
                            // Progress Remove Classes
                            $(".progress-bar").removeClass(
                                "progress-bar-striped"
                            );
                            $(".progress-bar").removeClass(
                                "progress-bar-animated"
                            );
                        }
                    },
                }); // End AjaxForm
            } else {
                toastr.warning(
                    "The Maximum Allowed Is " +
                    maxUploadSize / 1024 / 1024 +
                    "MP"
                );
            }
        } else {
            toastr.warning(
                "The Maximum Allowed Is " + maxUploadFile + " Files"
            );
        }

        $(fileInput).val("");
    });






    



    //////////////////////////////////
    /**
 * Edit Row From Model
 */
    $(".btn-edit-item").click(function (e) {
        let btn = $(this),
            model = $("#update-form");
        $.post(
            adminUrl + "/properties/get-unit-row",
            { id: btn.attr("data-id") },
            function (row, textStatus, jqXHR) {
                model.find('input[name="item_id"]').val(row.id);
                model.find('input[name="name"]').val(row.name);
                model
                    .find('input[name="area"]')
                    .val(row.area);
                model.find('input[name="price"]').val(row.price);
                model.find('input[name="bedrooms"]').val(row.bedrooms);
                model
                    .find('input[name="bathrooms"]')
                    .val(row.bathrooms);
                // Set Image Src
                $(".item-edit-image").attr(
                    "src",
                    baseUrl + "/storage/large/properties/units/" + row.image
                );
                // Update Action
                model.attr("action", adminUrl + "/properties/update-unit");
                // Update Model Name
                model.find("button").text("تحديث النموذج");
                // Update Panel Name
                $(".box-title").text("تحديث النموذج");
                // Rempve Label Star
                $(".item-image-input .form-group")
                    .find('input[name="image"]')
                    .removeAttr("required");
                $(".item-image-input .form-group").find("label b").remove();
            },
            "json"
        );
    });


});
