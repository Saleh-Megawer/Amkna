import {
    choose,
    deactivate,
    activate,
    activatedSuccessfully,
    deactivateSuccessfully,
} from "../../modules/trans.js";
import { ajaxDelete } from "../../modules/delete-functions.js";
$(document).ready(function () {
    /*
    |
    | Load Sub Category
    |
    */
    $(".getSubCatgeory").change(function (e) {
        e.preventDefault();
        let id = $(this).val();
        $(".sub-category").empty();
        $.post(
            adminUrl + "/articles/sub-category",
            { id: id },
            function (data, textStatus) {
                if (textStatus == "success") {
                    if (data.length == 0) {
                        toastr.warning($("#There-are-no-subcategories").text());
                    } else {
                        $(".sub-category").append(
                            `<option selected disabled>${choose}</option>`
                        );
                        $.each(data, function (indexInArray, val) {
                            $(".sub-category").append(
                                `<option value="${val.id}">${val.name}</option>`
                            );
                        });
                    }
                }
            },
            "json"
        );
    });

    /**
     *
     */
    $(".first-info").click(function () {
        $(this).next(".openInfo").slideToggle(100);
    });

    /*
    |
    | All Articles Page
    |
    */
    ajaxDelete();

    // Change Status
    let formStatus = ".form-status";
    $(formStatus + " button[type=submit]").click(function (e) {
        e.preventDefault();
        // Varibale
        let status = $(this).attr("data-status"),
            btn = $(this);

        // Empty & Remove
        btn.removeClass(
            "btn-outline-warning btn-outline-success btn-success btn-warning"
        );
        btn.text("");
        $(".tooltip").remove();

        // Check IF Status  Active = 1
        if (status == 1) {
            btn.attr("data-status", 0); // Change Status

            btn.append(`<span class="draft">${activatedSuccessfully}</span>`); // Message
            btn.addClass("btn-warning"); // Change Color Mode

            setTimeout(rebackToActive, 1000);
            function rebackToActive() {
                btn.find(".draft").fadeOut("slow", function () {
                    btn.attr("data-original-title", activate);
                    btn.removeClass("btn-success"); // Change Color Mode
                    btn.addClass("btn-warning"); // Change Color Mode
                    btn.append(`<i class="fa-solid fa-clock-rotate-left"></i>`); // Append Icon
                    btn.find(".draft").remove(0);
                });
            }
        } else {
            btn.attr("data-status", 1); // Change Status

            btn.append(
                `<span class="activated">${deactivateSuccessfully}</span>`
            ); // Append Icon
            btn.addClass("btn-success"); // Change Color Mode

            setTimeout(rebackToDraft, 1000);
            function rebackToDraft() {
                btn.find(".activated").fadeOut("slow", function () {
                    btn.attr("data-original-title", deactivate);
                    btn.removeClass("btn-warning"); // Change Color Mode
                    btn.addClass("btn-success"); // Change Color Mode
                    btn.append(`<i class="fa-solid fa-check"></i>`); // Append Icon
                    btn.find(".activated").remove(0);
                });
            }
        }

        let parentForm = $(this).parents(formStatus);
        let url = parentForm.attr("action"); // Get Form URL
        let id = parentForm.find(".id").val(); // Get Form URL
        // Request To Delete
        $.post(url, { _method: "PATCH", id: id }, function (data) {}, "json");
    });

    // Var
    let btnChangeSelectMode = $("#btn-change-select-mode"),
        articleBox = ".article .box",
        articleBoxOverlay = "overlay",
        selectModeClassName = "select-mode",
        articleSelected = "article-selected",
        inputId = ".input-multi-select-id";

    // Toggle Checked
    function toggleChecked(element) {
        // Toggle Checked
        if (element.attr("checked") == undefined) {
            element.attr("checked", "checked");
        } else {
            element.removeAttr("checked", "");
        }
    }

    // Select Mode On
    function selectModeOn() {
        $(`.${selectModeClassName} .${articleBoxOverlay}`).click(function () {
            let parent = $(this).parent(".box");
            if (parent.hasClass(selectModeClassName)) {
                // Selected Style
                $(this).toggleClass(articleSelected);
                toggleChecked(parent.find(inputId));
            }
        });
    }

    // Reset
    function resetSelectOnceMode() {
        btnChangeSelectMode.val("on"); // Change Mode Ready To On
        // Else Remove Class Name => ( selectModeClassName ) Now Select Mode Off
        $(articleBox).removeClass(selectModeClassName);
        // Remove Overylay On The Articles
        $(articleBox + " ." + articleBoxOverlay).remove();
        // Remove Badge ON
        $(".mode-on").remove();
    }
    /**
     * Select Once
     */
    btnChangeSelectMode.change(function () {
        let mode = $(this).val(); // Value

        // Change Mode On Off & Set Class
        if (mode == "on") {
            resetSelectAllMode();

            $(this).val("off"); // Change Mode Ready To Off

            btnChangeSelectMode
                .next("label")
                .append(`<span class="badge badge-success mode-on">ON</span>`); // ADD Badge ON

            $(articleBox).addClass(selectModeClassName); // Add Class In Article Div class name => ( selectModeClassName )
            // Append Overlay On The Article Div
            $("." + selectModeClassName).append(
                `<div class="${articleBoxOverlay}"></div>`
            );

            // First Article Add Gif For Learn How To Select Article In Select Mode
            $(".first-article .box").append(
                `<div class="how-to-select"> <div class="d-flex justify-content-center align-items-center"> <img style="width:64px" src="${
                    baseUrl + "/dashboard/images/mouse-click.gif"
                }" alt=""> </div></div>`
            );
            // After 2 sec... Remove
            setTimeout(removeClickedImage, 1500);
            function removeClickedImage() {
                $(".how-to-select").fadeOut(500, function () {
                    $(this).remove();
                });
            }

            // Open Select Mode
            selectModeOn();
        } else {
            resetSelectOnceMode();
        }
    });

    /**
     * Select All
     */
    $("#btn-select-all").click(function () {
        $(articleBox).toggleClass(selectModeClassName); // Add Selected Class In Parent
        $("." + articleBoxOverlay).remove(); // REMOVE bEFORE APPEND

        // Check IF ON
        if ($(this).attr("data-select") == "on") {
            resetSelectOnceMode();
            // Checked All
            $(inputId).attr("checked", "checked");

            $(this).append(
                `<span class="badge badge-success mode-select-all-on">ON</span>`
            );

            // Replace Mode To Off
            $(this).attr("data-select", "off");

            // Append Overlay On The Article Div
            $(articleBox).append(
                `<div class="${
                    articleBoxOverlay + " " + articleSelected
                }"></div>`
            );
        } else {
            resetSelectAllMode();
        }
        toggleSelectedInModeSelectAll();
    });

    /**
     * Toggle Select Mode IF Mode On Chnage To Off Else Change to ON
     */
    function toggleSelectedInModeSelectAll() {
        $("." + articleBoxOverlay).click(function () {
            $(this).toggleClass(articleSelected); // Add Class Selected
            toggleChecked($(this).parent(".box").find(inputId));
        });
    }

    /**
     * Select All Mode Reset Cheked And Remove Style
     */
    function resetSelectAllMode() {
        $(inputId).removeAttr("checked", "");
        $(".mode-select-all-on").remove();
        $("." + articleSelected).remove();
        $("#btn-select-all").attr("data-select", "on");
    }
});
