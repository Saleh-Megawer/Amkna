import * as response from "../modules/requests-response.js";
$(document).ready(function () {
    // Function Post Request
    // function post(
    //     form = ".ajax-post",
    //     buttonName = "button[type=submit]",
    //     resultBox = ".result .row"
    // ) {
    //     $(form + " " + buttonName).click(function () {
    //         // Get Target Button
    //         let targetButton = $(this);
    //         // Get Parent Form For This Button
    //         let targetForm = targetButton.parents(form);



    //         $(targetForm).ajaxForm({
    //             url: $(this).attr("action"),
    //             dataType: "json",
    //             type: "POST",

    //             beforeSend: function () {
    //                 response.beforeSendRequest(targetButton);
    //             },

    //             success: function (data) {
    //                 response.responseStatus(data, targetForm, resultBox);
    //             },

    //             error: function (dataErrors, exception) {
    //                 response.errorRequest(dataErrors, exception);
    //             },

    //             complete: function () {
    //                 response.completeRequest(targetButton);
    //             },
    //         }); // End AjaxForm
    //     });
    // }
    // post(".form");

    function post(
        form = ".ajax-post",
        resultBox = ".result .row"
    ) {

        $(document).on('submit', form, function (e) {

            e.preventDefault();

            const targetForm = $(this);
            const targetButton = targetForm.find('button[type=submit]');

            targetForm.ajaxSubmit({
                dataType: "json",
                type: "POST",

                beforeSend: function () {
                    response.beforeSendRequest(targetButton);
                },

                success: function (data) {
                    response.responseStatus(data, targetForm, resultBox);
                },

                error: function (dataErrors, exception) {
                    response.errorRequest(dataErrors, exception);
                },

                complete: function () {
                    response.completeRequest(targetButton);
                },
            });
        });
    }

    // Initialize once only
    post(".form");



    post(); // Add in from class ( ajax-post )


    // Get Errors Type
    // function postV2(
    //     form = ".ajax-post",
    //     buttonName = "button[type=submit]",
    //     resultBox = ".result .row",
    //     callbacks = {}  // ✅ إضافة callbacks اختيارية
    // ) {
    //     $(form + " " + buttonName).click(function () {
    //         // Get Target Button
    //         let targetButton = $(this);
    //         // Get Parent Form For This Button
    //         let targetForm = targetButton.parents(form);

    //         $(targetForm).ajaxForm({
    //             url: $(this).attr("action"),
    //             dataType: "json",
    //             type: "POST",

    //             beforeSend: function () {
    //                 response.beforeSendRequest(targetButton);

    //                 // ✅ Custom beforeSend callback
    //                 if (callbacks.beforeSend && typeof callbacks.beforeSend === 'function') {
    //                     callbacks.beforeSend(targetButton, targetForm);
    //                 }
    //             },

    //             success: function (data) {
    //                 response.responseStatus(data, targetForm, resultBox);

    //                 // ✅ Custom success callback
    //                 if (callbacks.success && typeof callbacks.success === 'function') {
    //                     callbacks.success(data, targetForm, targetButton);
    //                 }
    //             },

    //             error: function (dataErrors, exception) {
    //                 response.errorRequest(dataErrors, exception);

    //                 // ✅ Custom error callback
    //                 if (callbacks.error && typeof callbacks.error === 'function') {
    //                     callbacks.error(dataErrors, exception, targetForm, targetButton);
    //                 }
    //             },

    //             complete: function () {
    //                 response.completeRequest(targetButton);

    //                 // ✅ Custom complete callback
    //                 if (callbacks.complete && typeof callbacks.complete === 'function') {
    //                     callbacks.complete(targetButton, targetForm);
    //                 }
    //             },
    //         }); // End AjaxForm
    //     });
    // }

    // Get Errors Type
    function postV2(
        form = ".ajax-post",
        buttonName = "button[type=submit]",
        resultBox = ".result .row",
        callbacks = {}
    ) {
        // دالة التهيئة
        function initAjaxForm($form) {
            if ($form.data('ajax-initialized')) {
                return;
            }

            $form.ajaxForm({
                url: $form.attr("action"),
                dataType: "json",
                type: "POST",

                beforeSend: function () {
                    let targetButton = $form.find(buttonName);
                    response.beforeSendRequest(targetButton);

                    if (callbacks.beforeSend && typeof callbacks.beforeSend === 'function') {
                        callbacks.beforeSend(targetButton, $form);
                    }
                },

                success: function (data) {
                    let targetButton = $form.find(buttonName);
                    response.responseStatus(data, $form, resultBox);

                    if (callbacks.success && typeof callbacks.success === 'function') {
                        callbacks.success(data, $form, targetButton);
                    }
                },

                error: function (dataErrors, exception) {
                    let targetButton = $form.find(buttonName);
                    response.errorRequest(dataErrors, exception);

                    if (callbacks.error && typeof callbacks.error === 'function') {
                        callbacks.error(dataErrors, exception, $form, targetButton);
                    }
                },

                complete: function () {
                    let targetButton = $form.find(buttonName);
                    response.completeRequest(targetButton);

                    if (callbacks.complete && typeof callbacks.complete === 'function') {
                        callbacks.complete(targetButton, $form);
                    }

                    // ⭐ أعد تهيئة الـ forms بعد الانتهاء
                    setTimeout(() => {
                        $(form).each(function () {
                            let $newForm = $(this);
                            if (!$newForm.data('ajax-initialized')) {
                                initAjaxForm($newForm);
                            }
                        });
                    }, 200);
                },
            });

            $form.data('ajax-initialized', true);
        }

        // هيّئ كل الـ forms الموجودة
        $(form).each(function () {
            initAjaxForm($(this));
        });

        // Event delegation للـ button click
        $(document).on('click', form + " " + buttonName, function (e) {
            e.preventDefault();

            let targetButton = $(this);
            let targetForm = targetButton.parents(form);

            if (targetForm.data('submitting')) {
                return false;
            }

            // ⭐ أعد التهيئة لو الـ form جديد
            if (!targetForm.data('ajax-initialized')) {
                // امسح أي تهيئة قديمة
                targetForm.ajaxFormUnbind();
                targetForm.removeData('ajax-initialized');

                // هيّئ من جديد
                initAjaxForm(targetForm);
            }

            targetForm.data('submitting', true);
            targetForm.submit();

            setTimeout(() => {
                targetForm.data('submitting', false);
            }, 1000);
        });
    }




    /**
     * 
     */
    postV2(".form-interests-status", "button[type=submit]", ".result .row", {
        success: function (data, targetForm, targetButton) {
            if (data.buttonHtml) {
                targetForm.data('newButtonHtml', data.buttonHtml);
            }
            if (data.statusBadgeHtml) {
                targetForm.data('statusBadgeHtml', data.statusBadgeHtml);
            }

            let interestId = targetForm.find('input[name="interest_id"]').val();
            targetForm.data('interestId', interestId);


            if (data.is_closed) {
                targetForm.closest('tr.interest-tr').fadeOut(500);
                setTimeout(() => {
                    targetForm.closest('tr.interest-tr').remove();
                }, 500);
            }
        },
        complete: function (targetButton, targetForm) {


            let buttonHtml = targetForm.data('newButtonHtml');
            let statusBadgeHtml = targetForm.data('statusBadgeHtml');
            let interestId = targetForm.data('interestId');

            if (buttonHtml) {
                // ⭐ استبدل الـ td كلها (مش الـ dropdown بس)
                let $actionsCell = targetForm.closest('td');

                if ($actionsCell.length) {
                    // لو في td، استبدلها كلها
                    setTimeout(() => {
                        $actionsCell.html(buttonHtml);

                        // استبدال Badge الحالة
                        if (statusBadgeHtml && interestId) {
                            $('#status-' + interestId).html(statusBadgeHtml);
                        }
                    }, 100);
                } else {
                    // لو مش في td (fallback للكود القديم)
                    let $container = targetForm.closest('.dropdown').length
                        ? targetForm.closest('.dropdown')
                        : targetForm;

                    setTimeout(() => {
                        $container.replaceWith(buttonHtml);

                        if (statusBadgeHtml && interestId) {
                            $('#status-' + interestId).html(statusBadgeHtml);
                        }
                    }, 100);
                }
            }
        }
    });




    // Form تغيير الحالة
    postV2(".form-status", "button[type=submit]", ".result .row", {
        success: function (data, targetForm, targetButton) {
            // احفظ البيانات
            if (data.buttonHtml) {
                targetForm.data('newButtonHtml', data.buttonHtml);
            }
        },
        complete: function (targetButton, targetForm) {
            // استبدل الزر
            let buttonHtml = targetForm.data('newButtonHtml');
            if (buttonHtml) {
                // استنى شوية بسيطة عشان response.completeRequest تخلص
                setTimeout(() => {
                    targetForm.find('.btn-status').replaceWith(buttonHtml);
                }, 50);
            }
        }
    });





});
