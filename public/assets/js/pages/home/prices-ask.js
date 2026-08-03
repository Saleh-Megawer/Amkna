$(document).ready(function () {
    // Prepare Sections Names
    let sectionPrograms = "#select-the-programs";

    // Change Services Choose
    let btnChangeTypeChoose = $(".btn-choose-activity");

    $(btnChangeTypeChoose).click(function (e) {
        e.preventDefault();

        let btn = $(this);
        // Set Active Class
        $(btnChangeTypeChoose).removeClass("active");
        btn.addClass("active");

        // Set Checked
        $(btnChangeTypeChoose).find("input").removeAttr("checked");
        btn.find("input").attr("checked", "checked");

        // Get The Related
        $.post(
            baseUrl +
                "/prices-accounting-programs-afaq/get-related-programs-for-the-chosen-activity",
            { activityId: btn.find("input").val() },
            function (data) {
                // Set Cheked In Inputs
                $("#select-the-programs input").removeAttr("checked");
                $.each(data, function (index, row) {
                    // Set Cheked In Inputs
                    $("#select-the-programs #program-" + row).attr(
                        "checked",
                        "checked"
                    );
                });
            }
        );
    });

    /**
     *
     * Change Steps
     *
     */

    // Get Elements From Dom
    let btnNext = "#btn-next-step",
        btnPrev = "#btn-prev-step";
    btnSubmit = "#btn-submit";

    // Setup Data
    let activeSection = ".active-section",
        nextSection = "",
        prevSection = "",
        stepNumber = 0,
        validateSection = false;

    // Inputs
    // let company_name = $('input[name="company_name"]'),
    //     company_activity = $('input[name="company_activity"]'),
    //     company_employees_number = $('input[name="company_employees_number"]'),
    //     country = $('input[name="country"]'),
    //     city = $('input[name="city"]');

    $(btnNext).click(function (e) {
        e.preventDefault();


        // 1- Get The Active Section
        nextSection = $(activeSection).attr("data-next");
        inSection = $(activeSection).attr("id");

        if (inSection == "company-procedures") {
            if (
                $('.btn-choose-activity input[type="radio"]:checked').length ==
                0
            ) {
                return toastr.error(
                    "يجب تحديد نشاط الشركة قبل الإنتقال إلي الخطوة التالية"
                );
            }
            if (
                $(sectionPrograms + ' input[type="checkbox"]:checked').length ==
                0
            ) {
                return toastr.error(
                    "  اختر البرامج التي تريد الإستعلام عنها قبل الإنتقال إلي الخطوة التالية"
                );
            }

            // Validate Section = true
            validateSection = true;
        } else if (
            inSection == "info-about-the-company" ||
            inSection == "info-about-user"
        ) {
            let inputs = document.querySelectorAll("#" + inSection + " input");
            for (let index = 0; index < inputs.length; index++) {
                if (inputs[index].value == "") {
                    return toastr.error("يجب إستكمال الحقول الفارغة");
                }
            }

            if ($("#country").val() == null) {
                // Select Box
                return toastr.error("قم بإختيار البلد");
            }
        }

        // 2- Assign New Step Active Number
        stepNumber = $(nextSection).attr("data-step") - 1;

        if (isNaN(stepNumber)) {
            stepNumber = 3;
        }

        // 3- Show Button Prev
        $(btnPrev).show();

        if (nextSection != undefined && nextSection != "empty") {
            // Global Actions
            $(".sections").slideUp(250);
            $(".sections").removeClass("active-section");

            // Assign (active-section) class in next section
            $(nextSection).addClass("active-section");
            $(nextSection).slideDown(250);
        }

        if (stepNumber == 1) {
            // Update Progress
            updateProg(50);

            // Set Done In Number
            setTimeout(function () {
                $(".one").addClass("done-step");
            }, 490);
        } else if (stepNumber == 2) {
            // Update Progress
            updateProg(100);

            // Set Done In Number
            setTimeout(function () {
                $(".two").addClass("done-step");
            }, 490);

            // Show Save Button Submit
            $(btnSubmit).show();

            // Hide Next Button
            $(btnNext).hide();
        }
        // validate


        $('html, body').animate({ scrollTop: 0 }, 'slow');


    });

    $(btnPrev).click(function (e) {
        e.preventDefault();

        // 1- Get The Active Section
        prevSection = $(activeSection).attr("data-prev");

        // 2- Assign New Step Active Number
        stepNumber = $(prevSection).attr("data-step");

        // if (isNaN(stepNumber)) {
        //     stepNumber = 3;
        // }

        $(btnSubmit).hide();
        $(btnNext).show();
        if (stepNumber == 1 || stepNumber == undefined) {
            $(btnPrev).hide();
        }

        // 3- Show Button Prev
        //  $(btnPrev).show();

        if (prevSection != undefined && prevSection != "empty") {
            // Global Actions
            $(".sections").slideUp(250);
            $(".sections").removeClass("active-section");

            // Assign (active-section) class in next section
            $(prevSection).addClass("active-section");
            $(prevSection).slideDown(250);
        }

        if (stepNumber == 1) {
            // Update Progress
            updateProg(0);

            // Set Done In Number
            setTimeout(function () {
                $(".one").removeClass("done-step");
            }, 490);
        } else if (stepNumber == 2) {
            // Update Progress
            updateProg(50);

            // Set Done In Number
            setTimeout(function () {
                $(".two").removeClass("done-step");
            }, 490);


        }

        $('html, body').animate({ scrollTop: 0 }, 'slow');

    });

    // Update Prograss
    function updateProg(number) {
        $(".progress-bar").css("width", number + "%");
    }
});
