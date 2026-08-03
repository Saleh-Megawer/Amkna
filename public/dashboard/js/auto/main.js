import { swalDelete, ajaxDelete, ajaxInfoAction } from "../modules/delete-functions.js";

$(document).ready(function () {
    ajaxDelete();
    swalDelete();
    ajaxInfoAction();



    // =====================================
    // Handle input direction (LTR / RTL)
    // =====================================
    $('.input-multi-search').on('input', function () {
        const value = $(this).val();
        const isEnglish = /^[a-zA-Z0-9\s\+\-\(\)]*$/.test(value);

        // Toggle LTR class if input is English
        $(this).toggleClass('ltr text-right', isEnglish && value.length > 0);
    });


    // Set For All Lable [*] IF Have Class [required]
    let labelRequired = $(".required");
    let star = '<svg xmlns="http://www.w3.org/2000/svg" style="position: relative;top: -4px;right: -2px;" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-asterisk"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12l8 -4.5" /><path d="M12 12v9" /><path d="M12 12l-8 -4.5" /><path d="M12 12l8 4.5" /><path d="M12 3v9" /><path d="M12 12l-8 4.5" /></svg>';
    for (let i = 0; i <= labelRequired.length; i++) {
        $(labelRequired[i]).append(
            `<b style='display: inline-block;color:red;' class=' pr-1 font-weight-bold'>${star}</b>`
        );
    }

    // For Set / In All Page Links
    let linksItems = $("#links-bar a");
    for (let i = 1; i <= linksItems.length; i++) {
        $(linksItems[i]).before("<span class='links-bar-item-slash'>›</span>");


    }

    // This Div For Set Response Result Here
    $("#header").after(`<div class='result'></div>`);


});
