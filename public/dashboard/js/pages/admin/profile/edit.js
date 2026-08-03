import * as response from "../../../modules/requests-response.js";
import { swalDelete } from "../../../modules/delete-functions.js";

$(document).ready(function () {
    /**
     * Run From Modules
     */
    swalDelete();

    /**
     *
     * Button Send Mail For Verify
     *
     */
    $("#btn-verify-email").click(function () {
        let btn = $(this);

        // Disabled The Button
        btn.attr("disabled", "disabled");
        // Add Spainer
        btn.append(
            `<div style="width: 1rem !important;height: 1rem !important;border: 0.18em solid currentColor !important;border-right-color: transparent !important" class="mx-1 spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>`
        );

        // Send Request
        $.post(
            adminUrl + "/profile/verify-email",
            { id: btn.attr("data-id") },
            function (data, textStatus, jqXHR) {
                response.responseStatus(data, "");
                // Disabled The Button
                btn.removeAttr("disabled");
                // Add Spainer
                $(".spinner-border").remove();
            },
            "json"
        );
    });

    /**
     *
     * Update Profile Avatar
     * Show Button Update After Choose The Image
     *
     */
    $("#input-profile-avatar").change(function () {
        $("#btn-update-avatar").show();
    });
    $("#input-cover").change(function () {
        $("#form-change-cover button").show();
    });

    /**
     *
     * Personal Data
     *
     */
    $("#f_name").keyup(function (e) {
        $(".f_name").text($(this).val());
    });

    $("#l_name").keyup(function (e) {
        $(".l_name").text($(this).val());
    });

    /**
     *
     * Password
     *
     */
    $("#btn-forgot-password").click(function (e) {
        e.preventDefault();

        let btn = $(this);

        // Disabled The Button
        btn.attr("disabled", "disabled");
        // Add Spainer
        btn.append(
            `<div style="width: 1rem !important;height: 1rem !important;border: 0.18em solid currentColor !important;border-right-color: transparent !important" class="mx-1 spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>`
        );

        // Send Request
        $.post(
            adminUrl + "/profile/forgot-password",
            { id: btn.attr("data-id") },
            function (data, textStatus, jqXHR) {
                response.responseStatus(data, "");
                // Disabled The Button
                btn.removeAttr("disabled");
                // Add Spainer
                $(".spinner-border").remove();
            },
            "json"
        );
    });

    /**
     *
     * Portfolio
     *
     */
    let inputSocialUrl = document.querySelector(".input-social-media-url");
    $("#select-social-media").change(function (e) {
        e.preventDefault();
        let val = $(this).val();
        let text = $(this).text();

        // Show Input
        $(inputSocialUrl).fadeIn(100);
        // Set Name
        $(inputSocialUrl).attr("name", val);
        $(inputSocialUrl).attr("placeholder", `https://${val}.com`);
    });

    /**
     *
     * Experience
     *
     */
    let expBoxForAddNew = document.querySelector("#experience #form-inputs"), // This Is Box For Add New Inputs
        btnAddNewExp = document.getElementById("btn-exp-add-new"),
        experienceCard = ".experience-card";
    // Classes For Parent Select box ( end year , start year)
    let startYearParentsClassName = "parents-col-for-start-year",
        endYearParentsClassName = "parents-col-for-end-year";
    $(btnAddNewExp).click(function (e) {
        e.preventDefault();

        $(expBoxForAddNew).append(
            `<div class="row experience-card add-new-effect"> <div class="col-md-12"> <div class="form-group"> <label>Job Title<b class="text-danger font-weight-bold"> * </b></label> <input type="text" name="job_title[]" required/> </div></div><div class="col-md-6"> <div class="form-group"> <label>Company Name<b class="text-danger font-weight-bold"> * </b></label> <input type="text" name="company_name[]" required/> </div></div><div class="col-md-3 ${startYearParentsClassName}"> <div class="form-group"> <label>Start Year<b class="text-danger font-weight-bold"> * </b></label> <select name="start_year[]" required class="start-year set-years"> <option selected disabled>Choose</option> </select> </div></div><div class="col-md-3 ${endYearParentsClassName}"> <div class="form-group"> <label>End Year<b class="text-danger font-weight-bold"> * </b></label> <select name="end_year[]" class="end-years" required> <option selected disabled>Choose</option> </select> </div></div><div class="col-md-12"> <div class="form-group"> <label>Job Description<b class="text-danger font-weight-bold"> * </b></label> <textarea name="job_desc[]" required rows="3"></textarea> </div></div><div title="Remove" class="btn-delete-job btn btn-soft-danger font-15" > <i class="fa-solid fa-trash-can"></i> </div></div>`
        );

        if (document.querySelectorAll(experienceCard).length > 0) {
            $(".exp-empty-box").hide(0);
        }

        // Run Functions
        appendYearsInSelectBox();
        setDynamicEndYear();
        removeExp();
    });

    // Set End Year In Selet Input
    function setDynamicEndYear() {
        $(".start-year").change(function () {
            let startYear = $(this).val(),
                selectedClass = "start-year-selected",
                endSelectBoxClass = "set-end-years";

            // Remove Class
            $(".start-year")
                .parents(`.${startYearParentsClassName}`)
                .removeClass(selectedClass);
            $(".end-years").removeClass(endSelectBoxClass);

            // Add Class To Parent
            $(this)
                .parents(`.${startYearParentsClassName}`)
                .addClass(selectedClass);

            // Get start-year select box Elements from DOM
            $(`.${selectedClass}`)
                .next(`.${endYearParentsClassName}`)
                .find(".end-years")
                .addClass(endSelectBoxClass);

            // Empty The Select Options
            $(`.${endSelectBoxClass}`).empty();
            $(`.${endSelectBoxClass}`).append(
                `<option selected disabled>Choose</option>`
            );
            appendYearsInSelectBox(`.${endSelectBoxClass}`, startYear);
        });
    }
    setDynamicEndYear(); // Run

    // Helpers Function Get Years
    function appendYearsInSelectBox(
        appendTo = null,
        startYear = 1995,
        endYear = null
    ) {
        // Check IF End Year Null Set date('Y)
        endYear = endYear == null ? 2023 : endYear;
        appendTo = appendTo == null ? ".set-years" : appendTo;

        // Loop
        for (let i = startYear; i <= endYear; i++) {
            $(appendTo).append(`<option value="${i}">${i}</option>`);
        }
    }

    // Remove Exp Box From DOM
    function removeExp() {
        // Remove
        $(".btn-delete-job").click(function (e) {
            let targetDeleteButton = $(this);
            // Get ID Attr From This Button
            let experienceId = $(this).attr("data-id");
            let adminId = $(this).attr("data-admin-id");

            swal({
                title: "Experience Card",
                text: "Are you sure to delete ?",
                icon: "warning",
                dangerMode: true,
                buttons: ["Cancel", "Delete"],
            }).then((willDelete) => {
                if (willDelete) {
                    // Check IF Isset
                    if (experienceId !== undefined) {
                        // Send Request To Backend For Delete
                        $.post(
                            adminUrl + "/profile/delete-experience",
                            {
                                _method: "DELETE",
                                exp_id: experienceId,
                                id: adminId,
                            },
                            function (data, textStatus, jqXHR) {
                                response.responseStatus(data, "");
                                if (data.status == "success") {
                                    deleteExpBoxFromDom();
                                }
                            },
                            "json"
                        );
                    } else {
                        deleteExpBoxFromDom();
                    }
                }
            });

            // Remove
            function deleteExpBoxFromDom() {
                // Add Class Removed In Target
                targetDeleteButton.parent(".row").addClass("removed");
                // SlideUp
                targetDeleteButton.parent(".row").slideUp(200);
                // Time Out For Run This Action
                setTimeout(function () {
                    // Check IF DOM Elements Have Class Removed And Remove Element From DOM
                    $(".removed").remove();
                }, 210);

                // Display The Image Empty Box In Dom IF Not Have Any Experience Card
                if (document.querySelectorAll(experienceCard).length > 0) {
                    $(".exp-empty-box").slideDown();
                }
            }
        });
    }
    removeExp(); // Run

    //
    // let num = 0;
    // $(top).click(function () {
    //     num += 5;
    //     if (num <= 100) {
    //         $(header).css("background-position", `center ${num}%`);
    //     }
    // });

    // $(bottom).click(function () {
    //     console.log("log");
    // });
});
