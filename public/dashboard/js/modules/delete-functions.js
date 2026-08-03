import { swalCancel, swalOk, warning } from "./trans.js";
import { responseStatus } from "./requests-response.js";

//Are you sure to delete this data?
let title = warning + " ! ";

export function swalDelete(form = ".delete") {
    let submitButton = $(form + " button[type=submit]");

    $(submitButton).click(function (e) {
        e.preventDefault();

        // Remove All Class This IF Isset
        $(submitButton).removeClass("delete-this-item");
        $(form).removeClass("form-this-item");
        // And Add For This Clicked Target
        $(this).addClass("delete-this-item");
        $(this).parents(form).addClass("form-this-item");

        swal({
            title: title,
            text: $(this).attr("data-delete"),
            icon: "warning",
            buttons: [swalCancel, swalOk],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $(".form-this-item").submit();
            }
        });
    });
}

/**
 *
 * @param {*} form The Form Class Name
 * @param {*} parent A Parent Class Name For Hide & Remove From DOM
 */
export function ajaxDelete(form = ".ajax-delete", parent = ".parents") {
    let submitButton = $(form + " button[type=submit]");
    $(submitButton).click(function (e) {
        e.preventDefault();

        // Parent Form
        let parentForm = $(this).parents(form);
        // After Click Set Delete Class For Ready To Delete
        parentForm.parents(parent).addClass("deleted");

        swal({
            title: title,
            text: $(this).attr("data-delete"),
            icon: "warning",
            buttons: [swalCancel, swalOk],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                let url = parentForm.attr("action"); // Get Form URL
                let id = parentForm.find(".id").val(); // Get Form URL
                // Request To Delete
                $.post(
                    url,
                    { _method: "DELETE", id: id },
                    function (data) {
                        responseStatus(data, parentForm);
                    },
                    "json"
                );

                // Hide The Parent Box
                $(this)
                    .parents(parent)
                    .fadeOut(500, function () {
                        // If isset deleted class remove box
                        $(".deleted").remove();
                    });
            } else {
                // Else REMOVE All deleted class from all parents
                $(parent).removeClass("deleted");
            }
        });

    });
}





/**
 *
 * @param {*} form The Form Class Name
 * @param {*} parent Parent wrapper to hide/remove
 */
export function ajaxInfoAction(form = ".ajax-swal-info", parent = ".parents") {

    let submitButton = $(form + " button[type=submit]");

    submitButton.on("click", function (e) {

        e.preventDefault();

        let parentForm = $(this).closest(form);
        parentForm.closest(parent).addClass("processing");

        swal({
            title: "تنبيه",
            text: $(this).attr("data-info"),
            icon: "info",
            buttons: [swalCancel, "نعم"],
        }).then((confirmed) => {

            if (!confirmed) {
                $(parent).removeClass("processing");
                return;
            }

            let url = parentForm.attr("action");
            let id = parentForm.find(".id").val();

            $.post(
                url,
                { _method: "PATCH", id },
                function (data) {
                    responseStatus(data, parentForm);
                },
                "json"
            );

            // parentForm.closest(parent).fadeOut(400, function () {
            //     $(".processing").remove();
            // });



        });
    });
}
