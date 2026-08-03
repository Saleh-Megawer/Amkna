$(document).ready(function () {

    /**
     * - Bootstrap
     * - Summernote Editor
     * - Toastr Alert
     * - Nice Select
     * - Lazy
     */


    // AOS.init();

    /**
     * owl
     */
    $(".owl-next").text("");
    $(".owl-prev").text("");
    $(".owl-prev").append(`<svg xmlns="http://www.w3.org/2000/svg"
    viewBox="0 0 320 512">
    <path
        d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" />
    </svg>
    `);

    $(".owl-next").append(`<svg xmlns="http://www.w3.org/2000/svg"
    viewBox="0 0 320 512">
    <path
        d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z" />
    </svg>`);



    // Bootstrap
    let tip = $(".tip"),
        toolTipDir = "top";
    if (tip.length > 0) {
        // Auto Set Dir
        if (tip.hasClass("left")) {
            toolTipDir = "left";
        } else if (tip.hasClass("right")) {
            toolTipDir = "right";
        } else if (tip.hasClass("bottom")) {
            toolTipDir = "bottom";
        }

        tip.attr("data-toggle", "tooltip");
        tip.attr("data-placement", toolTipDir);
        $(".tip").tooltip();
    }


    // Toastr Alert
    toastr.options = {
        closeButton: false,
        debug: false,
        newestOnTop: true,
        progressBar: true,
        positionClass: "toast-top-right",
        preventDuplicates: false,
        showDuration: "300",
        hideDuration: "1000",
        timeOut: "4000",
        extendedTimeOut: 4000, // نفس الوقت
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
    };

    /*
    |
    | Lazy Load Image
    | Chnage Image src to => data-src
    | And Set Class lazy in img class like
    | Output => <img class="lazy" data-src="" />
    */
    let lazy = $(".lazy");
    if (lazy.length > 0) {
        $(".lazy").lazy();
    }






    /* =====================================================
     * Choices.js (Reusable Initializer)
     * ===================================================== */
    const lang = $('meta[name="language"]').attr('content');


    function initChoices(selector, options = {}) {
        document.querySelectorAll(selector).forEach(select => {

            if (select.getAttribute('data-search') === 'false') return;
            if (select.tagName !== 'SELECT') return;
            if (select.dataset.choicesInit || select.choicesInstance) return;

            // Get placeholder from select or option
            let placeholder =
                select.getAttribute('placeholder') ||
                select.dataset.placeholder ||
                select.querySelector('option[placeholder]')?.textContent ||
                select.querySelector('option[value=""]')?.textContent ||
                'اختر';

            select.choicesInstance = new Choices(select, Object.assign({
                removeItemButton: true,
                shouldSort: false,
                searchPlaceholderValue: lang == 'ar' ? 'ابحث...' : 'Search...',
                itemSelectText: '',
                placeholder: true,
                placeholderValue: placeholder,
                direction: 'rtl',
            }, options));

            select.dataset.choicesInit = true;
        });
    }

    // Single select
    initChoices('.choices', {
        removeItemButton: false,
    });

    // Multiple select
    initChoices('.choices-multiple', {
        removeItemButton: true,
        placeholderValue: '',
    });

});
