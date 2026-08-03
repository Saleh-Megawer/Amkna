$(document).ready(function () {

    // لو مفيش أي tab عليه active
    if ($('#tabs-bar a.active-tab').length === 0) {

        $('#tabs-bar a:not(.tab-link-page):first')
            .addClass('active-tab')
            .removeClass('btn-soft-third');

    }

    // عند الضغط على أي زر
    $('#tabs-bar a').on('click', function () {

        $('#tabs-bar a')
            .removeClass('active-tab')
            .addClass('btn-soft-third');

        $(this)
            .addClass('active-tab')
            .removeClass('btn-soft-third');

    });

});