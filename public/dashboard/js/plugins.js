$(document).ready(function () {
});

/**
 * =====================================================
 * Global UI Initializers
 * - Bootstrap Tooltip & Popover
 * - Summernote Editor
 * - iziToast Notifications
 * - Lazy Load Images
 * - Choices.js
 * - Select2
 * =====================================================
 */


/* =====================================================
 * Bootstrap Tooltip
 * ===================================================== */
const tip = $('.tip');
let toolTipDir = 'top';

if (tip.length) {
    // Auto detect tooltip direction
    if (tip.hasClass('left')) toolTipDir = 'left';
    else if (tip.hasClass('right')) toolTipDir = 'right';
    else if (tip.hasClass('bottom')) toolTipDir = 'bottom';

    tip.attr({
        'data-toggle': 'tooltip',
        'data-placement': toolTipDir,
    });

    $('.tip').tooltip({
        trigger: 'hover',
        boundary: 'window'
    });

}

/* =====================================================
 * Bootstrap Popover
 * ===================================================== */
$('[data-toggle="popover"]').popover();


/* =====================================================
 * Summernote Editor
 * ===================================================== */
const editor = $('.editor');

if (editor.length) {

    editor.summernote();

    // Remove upload image button if requested
    if (editor.hasClass('remove-upload-image')) {
        $('.note-group-select-from-files').remove();
    }

    
        $('.note-codeview-keep').remove();
   

}


/* =====================================================
 * iziToast Global Settings
 * ===================================================== */
iziToast.settings({
    timeout: 4000,
    resetOnHover: true,
    progressBar: true,
    progressBarEasing: 'linear',
    close: true,
    closeOnEscape: true,
    closeOnClick: false,
    position: 'topLeft',
    transitionIn: 'fadeInRight',
    transitionOut: 'fadeOutLeft',
    displayMode: 0,
    layout: 2,
    balloon: false,
    animateInside: true,
});


/* =====================================================
 * Lazy Load Images
 * Usage:
 * <img class="lazy" data-src="image.jpg">
 * ===================================================== */
const lazy = $('.lazy');

if (lazy.length) {
    lazy.lazy();
}


/* =====================================================
 * Choices.js (Reusable Initializer)
 * ===================================================== */
function initChoices(selector, options = {}) {
    document.querySelectorAll(selector).forEach(select => {

        // Skip if search disabled explicitly
        if (select.getAttribute('data-search') === 'false') return;

        // Skip if element is not a SELECT (already transformed)
        if (select.tagName !== 'SELECT') return;

        // Skip if already initialized
        if (select.dataset.choicesInit || select.choicesInstance) return;

        // Initialize Choices
        select.choicesInstance = new Choices(select, Object.assign({
            removeItemButton: true,
            shouldSort: false,
            searchPlaceholderValue: 'ابحث...',
            itemSelectText: '',
            placeholder: true,
            placeholderValue: 'اختر',
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


/* =====================================================
 * Select2 (Global & Scalable Setup)
 * ===================================================== */
(function () {

    /**
     * Initialize Select2 safely
     * - Prevents duplicate initialization
     * - Works with tables, AJAX, DataTables
     */
    window.initSelect2 = function (selector = '.select2', options = {}) {
        $(selector).each(function () {

            // Prevent duplicate initialization
            if (this.classList.contains('select2-hidden-accessible')) return;
            $(this).select2({
                width: '100%',
                minimumResultsForSearch: 0,
                dropdownParent: document.body, //
                ...options
            });
        });
    };

    /**
     * Global focus handler
     * Ensures search input is focused on open
     */
    $(document).on('select2:open', function () {
        requestAnimationFrame(() => {
            const field = document.querySelector('.select2-search__field');
            if (field) field.focus();
        });
    });



})();


