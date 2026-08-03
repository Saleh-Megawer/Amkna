import * as response from "../../modules/requests-response.js";

$(document).ready(function () {
    // Prepare Varibles
    let q = "",
        url = $("#form-search").attr("action"),
        responseBox = "#response-data";

    let notResults = `<div class=" py-4 bg-main rounded"><h5 class=" text-center mb-0">No Results</h5></div>`;

    // On Keyup Start Request Search
    $(".btn-search").click(function (e) {
        e.preventDefault();

        q = $(".input-search").val();
        let data = { name: q };

        $(responseBox).empty();

        if (q != "") {
            $.post(
                url,
                data,
                function (data, textStatus, jqXHR) {
                    if (data.length == 0) {
                        $(responseBox).append(notResults);
                    } else {
                        $.each(data, function (key, row) {
                            // Data Varibles
                            let phone = row.phone;

                            $(responseBox).append(
                                `<div class="res-box">
                            <hr>
                            <a href="${adminUrl + "/profile/show/" + row.id
                                }"><h6 class="admin-name text-main mb-0">${row.full_name
                                }</h6>
                                <small class="d-block">${row.email}</small>
                            </a>
                        </div>`
                            );

                            if (phone != null) {
                                $(responseBox).append(
                                    `<small>${phone}</small>`
                                );
                            }
                        });
                    }
                },
                "json"
            );
        } else {
            $(responseBox).append(notResults);
        }
    });

    /**
     *
     * Change Admin Status
     *
     */

    // Active Account

    $(".btn-change-status").click(function () {
        let btn = $(this),
            // Get Parent Form For This Button
            targetForm = btn.parents(".form-status"),
            // Status Element
            statusElem = btn.parents(".admin-card").find(".status-badge"),
            // Admin Name Element
            adminNameElem = btn.parents(".admin-card").find(".admin-name");

        // Send Request
        $(targetForm).ajaxForm({
            url: $(this).attr("action"),
            dataType: "json",
            type: "POST",

            success: function (data) {
                if (data.account_status == 1) {
                    // Remove Closed Badge
                    $(statusElem).remove();

                    // Change From Action
                    $(targetForm).attr(
                        "action",
                        adminUrl + "/admins/close-account"
                    );

                    // Change Button Text
                    btn.text(data.deactivate);
                } else {
                    // Append Closed Badge
                    $(adminNameElem).append(
                        `<small class="mx-1 badge badge-soft-danger font-11 status-badge">تم حظر الحساب</small>`
                    );

                    // Change From Action
                    $(targetForm).attr(
                        "action",
                        adminUrl + "/admins/active-account"
                    );
                    // Change Button Text
                    btn.text(data.activate);
                }
            },
        }); // End AjaxForm
    });






    /////////////////////////////
    // عند تغيير نوع المشرف
    $('input[name="type"]').change(function () {
        if ($(this).val() === 'admin') {
            // إظهار قسم الأدوار
            $('#rolesSection').slideDown();
        } else {
            // إخفاء قسم الأدوار وإلغاء تحديد كل الأدوار
            $('#rolesSection').slideUp();
            $('.role-checkbox').prop('checked', false);
        }
    });

    // تحديد الحالة الأولية
    if ($('#adminTypeGeneral').is(':checked')) {
        $('#rolesSection').show();
    }
});
