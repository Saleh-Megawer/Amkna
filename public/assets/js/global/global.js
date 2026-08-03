// CSRF TOKEN
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});
let lang = $("html").attr("lang");
let baseUrl = $('meta[name="url"]').attr("content");



setTimeout(function () {
    if (document.querySelectorAll('.owl-dot').length > 0) {
        $(".owl-dot").each(function (index) {
            $(this).attr("aria-label", "Go to slide " + (index + 1));
        });
    }
}, 100);


$(document).ready(function () {
    $('.main-navbar .search-input').focus(function (e) {
        e.preventDefault();
        $(this).blur();
        
        var form = $(this).closest('form');
        window.location.href = form.attr('action');
    });
});
