import { responseStatus } from "../../modules/requests-response.js";

$(document).ready(function () {
    /**
     * Get Neighborhood IF City Change
     */
    $("#city").change(function (e) {
        let target = $(this);
        $.post(
            target.attr("data-url-get-neighborhoods"),
            { city_id: target.val() },
            function (data, textStatus, jqXHR) {
                if (data.status == "empty") {
                    return toastr.warning(data.message);
                } else {
                    $("#neighborhood").empty();
                    $.each(data, function (name, id) {
                        $("#neighborhood").append(
                            `<option value="${id}">${name}</option>`
                        );
                    });
                }
            },
            "json"
        ); // end post
    }); // End city change

    /**
     * Edit Row From Model
     */
    $(".btn-edit-item").click(function (e) {
        let btn = $(this),
            model = $("#update-form");
        $.post(
            adminUrl + "/products/ads/items/get-row",
            { id: btn.attr("data-id") },
            function (row, textStatus, jqXHR) {
                model.find('input[name="item_id"]').val(row.id);
                model.find('input[name="name"]').val(row.name);
                model
                    .find('input[name="area_in_metres"]')
                    .val(row.area_in_metres);
                model.find('input[name="price"]').val(row.price);
                model.find('input[name="room_numbers"]').val(row.room_numbers);
                model
                    .find('input[name="bathrooms_numbers"]')
                    .val(row.bathrooms_numbers);
                // Set Image Src
                $(".item-edit-image").attr(
                    "src",
                    baseUrl + "/storage/medium/ads-products/items/" + row.image
                );
                // Update Action
                model.attr("action", adminUrl + "/products/ads/items/item-update");
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

    const uploadUrl = adminUrl + "/products/ads/gallery-upload-store",
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
                        $(btnBrowse).text("( " + countFiles + " ) Upload...");

                        if (percent == 100) {
                            $("#uploader .box .progress .percent-box").text(
                                "Processing..."
                            );
                        }
                    },
                    success: function (data, two, three) {
                        responseStatus(data, "#update-form");
                        // Button
                        $(btnBrowse).text("Browse File");
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
});
