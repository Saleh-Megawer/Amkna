import * as response from "../../modules/requests-response.js";
import { swalDelete } from "../../modules/delete-functions.js";
import { swalYes, swalNo, update, add } from "../../modules/trans.js";

$(document).ready(function () {
    // Global Variables
    const mainUrlPath = adminUrl + "/categories/";
    let btnResetFormForAddNew = $("#btn-reset-form-for-add-new");

    // Reset
    function resetForm() {
        // Hide Button
        $(btnResetFormForAddNew).hide();
        // Change Submit Button Text
        $(submitButtonParentCategory).text(add);
        // Reset Form For Empty All Inputs
        $("form").trigger("reset");
        // Change Form Action Url Request
        $(formParentCategory).attr(
            "action",
            mainUrlPath + "parent-category-store"
        );

        // Sub Category Form
        $(formSubCategory).attr("action", mainUrlPath + "sub-category-store");
        // Change Submit Button Text
        $(submitButtonSubCategory).text(add);

        // Remove Errors Message IF Isset
        $(".error").remove();
    }

    $(btnResetFormForAddNew).click(function (e) {
        e.preventDefault();
        // Check IF Edit Done Or No
        swal({
            text: $(this).attr("data-message"),
            buttons: [swalNo, swalYes],
        }).then((willDelete) => {
            if (willDelete) {
                resetForm();
            }
        });
    });

    // Delete Parent & Sub
    swalDelete(".catgory-delete");

    /**
     *
     */

    // Insert
    let formParentCategory = "#form-parent-category",
        submitButtonParentCategory =
            formParentCategory + " button[type=submit]",
        categoriesTbody = $("#categories-tbody");

    $(submitButtonParentCategory).click(function (e) {
        // Scope Varible
        let submitButton = $(this),
            form = formParentCategory;

        $(form).ajaxForm({
            url: $(this).attr("action"),
            dataType: "json",
            type: "POST",

            beforeSend: function () {
                response.beforeSendRequest(submitButton);
            },

            success: function (data) {
                response.responseStatus(data, form);

                // Check IF Status Success
                if (data.status == "success") {
                    // IF Description Null Set Default Value
                    let desc = data.row.desc;
                    if (desc == null) {
                        desc = "";
                    }

                    if (data.request == "update") {
                        let editTd = $(".edit td");
                        // Get Length From Td Columns And Set a new Data
                        for (let i = 0; i < editTd.length; i++) {
                            $(editTd[0]).text(data.row.name);
                            $(editTd[1]).text(desc);
                        }
                        $("#search-category-name").text(data.row.name); // Replace Text Name IF Have Update
                        resetForm();
                    } else {
                        // Append
                        categoriesTbody.prepend(`<tr>
                            <td>${data.row.name}</td>
                            <td>${desc}</td>
                            <td class="text-center">0</td>
                            <td class="text-center">
                            <a href=""
                            class="btn-edit text-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                |
                                <a href="" class=" text-danger"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>`);
                    }
                }
            },

            error: function (dataErrors, exception) {
                response.errorRequest(dataErrors, exception);
            },
            complete: function () {
                response.completeRequest(submitButton);
            },
        }); // End AjaxForm

        $(window).scrollTop(0);
    });

    // Update
    $(".btn-edit").click(function (e) {
        e.preventDefault();
        $(window).scrollTop(0);
        let id = $(this).attr("data-id");

        // Replace Button Submit Text To Update
        $(submitButtonParentCategory).text(update);
        $(submitButtonParentCategory).addClass("btn-update");

        // Add Button Reset Form For Add New
        btnResetFormForAddNew.show();

        // Add And Remove Class For The Choose Column For Edit
        $("tr").removeClass("edit");
        $(this).parents("tr").addClass("edit");

        // Load Row Data From DB
        $.post(
            adminUrl + "/categories/get-category",
            { id: id },
            function (data, textStatus, jqXHR) {
                if (textStatus == "success") {
                    // Replace Url For Update
                    $(formParentCategory).attr(
                        "action",
                        mainUrlPath + "parent-category-update"
                    );
                    // Set Data In Form Inputs
                    $(".parnet-name").val(data.name);
                    $(".parnet-desc").val(data.desc);
                    $(".parent-id").val(data.id);
                }
            },
            "json"
        );
    });

    /**
     *
     * Sub
     *
     */

    // Insert
    let formSubCategory = "#form-sub-category",
        submitButtonSubCategory = formSubCategory + " button[type=submit]",
        subCategoriesTbody = $("#sub-categories-tbody");
    $(submitButtonSubCategory).click(function (e) {
        // Scope Varible
        let submitButton = $(this),
            form = formSubCategory;

        $(form).ajaxForm({
            url: $(this).attr("action"),
            dataType: "json",
            type: "POST",

            beforeSend: function () {
                response.beforeSendRequest(submitButton);
            },

            success: function (data) {
                response.responseStatus(data, form);

                // Check IF Status Success
                if (data.status == "success") {
                    // IF Description Null Set Default Value
                    let desc = data.row.desc;
                    if (desc == null) {
                        desc = "";
                    }

                    if (data.request == "update") {
                        let editTd = $(".edit td");
                        // Get Length From Td Columns And Set a new Data
                        for (let i = 0; i < editTd.length; i++) {
                            $(editTd[0]).text(data.row.name);
                            $(editTd[1]).text(desc);

                            $(editTd[2]).empty(); // Empty Column Positon 2 For Set New Link If Have Update

                            $(editTd[2]).append(
                                `<a href="${
                                    mainUrlPath + "?id=" + data.row.cat.id
                                }">${data.row.cat.name}</a>`
                            );
                            // Replace Text Name And Link IF Have Update
                            $("#main-category-link").text(data.row.cat.name);
                            $("#main-category-link").attr(
                                "href",
                                mainUrlPath + "?id=" + data.row.cat.id
                            );
                        }
                        resetForm();
                    } else {
                        // Append
                        subCategoriesTbody.prepend(`<tr>
                         <td>${data.row.name}</td>
                         <td>${desc}</td>
                         <td><a href="${
                             mainUrlPath + "?id=" + data.row.cat.id
                         }">${data.row.cat.name}</a></td>
                         <td class="text-center">
                         <a href=""
                         class="btn-edit text-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                             |
                             <a href="" class=" text-danger"><i class="fa-solid fa-trash"></i></a>
                         </td>
                     </tr>`);
                    }
                }
            },

            error: function (dataErrors, exception) {
                response.errorRequest(dataErrors, exception);
            },
            complete: function () {
                response.completeRequest(submitButton);
            },
        }); // End AjaxForm

        $(window).scrollTop(0);
    });

    // Update
    let parentCategorySelect = document.getElementById("category"); // Select Options Box
    $(".btn-sub-edit").click(function (e) {
        e.preventDefault();
        $(window).scrollTop(0);
        let id = $(this).attr("data-id");

        // Replace Button Submit Text To Update
        $(submitButtonSubCategory).text(update);
        $(submitButtonSubCategory).addClass("btn-update");

        // Add Button Reset Form For Add New
        btnResetFormForAddNew.show();

        // Add And Remove Class For The Choose Column For Edit
        $("tr").removeClass("edit");
        $(this).parents("tr").addClass("edit");

        // Load Row Data From DB
        $.post(
            mainUrlPath + "get-sub-category",
            { id: id },
            function (data, textStatus, jqXHR) {
                if (textStatus == "success") {
                    // Replace Url For Update
                    $(formSubCategory).attr(
                        "action",
                        mainUrlPath + "sub-category-update"
                    );
                    // Set Data In Form Inputs
                    $(".sub-name").val(data.name);
                    $(".sub-slug").val(data.slug);
                    $(".sub-color").val(data.color);
                    $(".sub-desc").val(data.desc);
                    $(".sub-id").val(data.id);
                    // Loop For Set Selected Attr IF Option Value Equle Category Parent ID
                    for (
                        let i = 0;
                        i < parentCategorySelect.options.length;
                        i++
                    ) {
                        // Auto Set Selected For This Option
                        if (
                            parentCategorySelect.options[i].value == data.cat.id
                        ) {
                            $(parentCategorySelect.options[i]).attr(
                                "selected",
                                "selected"
                            );
                        }
                    }
                }
            },
            "json"
        );
    });
});
