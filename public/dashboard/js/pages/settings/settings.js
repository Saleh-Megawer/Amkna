$(document).ready(function () {

    const trash_icon = `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>`;


    let sliderLangIndex = 10000; // يبدأ من رقم بعيد عن Blade loop

    $("#btn-add-new-slider-title-desc").click(function (e) {
        e.preventDefault();
        sliderLangIndex++;

        $("#form-store-title-desc .itmes").append(
            `<div class="row parent-slider-title-desc-row"><div class="col-md-10"><div class="form-group"><textarea name="header_title[]" rows="2" data-name="header_title" data-laravel-translatable="header_title--lara-trans-error" class="font-16" required="" placeholder="العنوان"></textarea></textarea></div><div class="form-group"><textarea name="header_desc[]" id="header_desc[]" data-name="header_desc" data-laravel-translatable="header_desc--lara-trans-error" class="font-16" rows="4" placeholder="الوصف كل وصف سوف يظهر مع العنوان الخاص به"></textarea></div></div><div class="col-md-2"><button type="submit" class="btn-remove-slider-title-desc btn btn-soft-danger btn-block">${trash_icon}</button></div><div class="col-12"><div class="input-normal-style"><div class="d-flex"><div class="custom-control custom-radio"><input type="radio" class="custom-control-input" id="type-lang-ar-${sliderLangIndex}" name="lang[${sliderLangIndex}]" value="ar" required><label class="custom-control-label cursor-pointer" for="type-lang-ar-${sliderLangIndex}">لغة عربية</label></div><div class="custom-control custom-radio"><input type="radio" class="custom-control-input" id="type-lang-en-${sliderLangIndex}" name="lang[${sliderLangIndex}]" value="en" required><label class="custom-control-label cursor-pointer" for="type-lang-en-${sliderLangIndex}">لغة إنجليزية</label></div></div></div></div><div class="col-12 pb-3"><hr style="border-color:#ddd"></div></div>`
        );
        removeTitleDescSection();
    });

    function removeTitleDescSection() {
        $(".btn-remove-slider-title-desc").click(function (e) {
            e.preventDefault();
            let target = $(this);
            target.parents(".parent-slider-title-desc-row").slideUp(250);
            setTimeout(function () {
                target.parents(".parent-slider-title-desc-row").remove();
            }, 250);
        });
    }
    removeTitleDescSection();

    $("#btn-add-new-email").click(function (e) {
        e.preventDefault();
        $("#emails-box").append(
            `<div class="parent-email"><div class="form-row"><div class="col-2"><div style="margin-top: 3px;" class="btn-remove-email btn btn-soft-danger btn-block">${trash_icon}</div></div><div class="col-10"><div class="form-group mb-2 dir-ltr"><input type="email" name="email[]" value="" data-name="email" data-laravel-translatable="email--lara-trans-error" required="" placeholder="هذا البريد سوف يعرض في صفحات الموقع الرئيسة مثل ( اتصل بنا )"></div></div></div></div>`
        );
        removeEmail();
    });
    function removeEmail() {
        $(".btn-remove-email").click(function (e) {
            e.preventDefault();
            $(this).parents(".parent-email").remove();
        });
    }
    removeEmail();

    $("#btn-add-new-phone").click(function (e) {
        e.preventDefault();
        $("#phones-box").append(
            `<div class="parent-phone"><div class="form-row"><div class="col-2"><div style="margin-top: 3px;" class="btn-remove-phone btn btn-soft-danger btn-block">${trash_icon}</div></div><div class="col-10"><div class="form-group mb-2 dir-ltr"><input type="number" name="phone[]" data-name="phone" data-laravel-translatable="email--lara-trans-error" required="" placeholder="كود البلد يتبعه رقم الهاتف"></div></div></div></div>`
        );
        removePhone();
    });

    function removePhone() {
        $(".btn-remove-phone").click(function (e) {
            e.preventDefault();
            $(this).parents(".parent-phone").remove();
        });
    }
    removePhone();

    // //
    // $("#btn-add-new-receiving-email").click(function (e) {
    //     e.preventDefault();
    //     $("#receiving-emails-box").append(
    //         `<div class="parent-receiving-email"><div class="row"><div class="col-2"><div class="btn-remove-receiving-email btn btn-soft-danger btn-block"><i class="fa fa-trash"></i></div></div><div class="col-10"><div class="form-group dir-ltr"><input type="email" name="email[]" value="" data-name="email" data-laravel-translatable="email--lara-trans-error" required=""></div></div></div></div>`
    //     );
    //     removeReceivingEmail();
    // });
    // function removeReceivingEmail() {
    //     $(".btn-remove-receiving-email").click(function (e) {
    //         e.preventDefault();
    //         $(this).parents(".parent-receiving-email").remove();
    //     });
    // }
    // removeReceivingEmail();
});
