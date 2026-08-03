$(function () {

    // Handle click on purpose buttons
    $('.btn-label-purpose').on('click', function (e) {
        e.preventDefault();

        // Remove active class and checked from all buttons
        $('.btn-label-purpose')
            .removeClass('is-active-purpose')
            .find('input[name="purpose"]')
            .prop('checked', false);

        // Add active class and checked to the clicked button
        $(this)
            .addClass('is-active-purpose')
            .find('input[name="purpose"]')
            .prop('checked', true);
    });

});
