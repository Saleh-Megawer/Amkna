
$(document).ready(function () {

    $("#reviews .owl-carousel").owlCarousel({
        loop: false,
        margin: 0,
        nav: false,
        dots: true,
        autoplay: true,
        autoplayTimeout: 8000,
        autoplaySpeed: 500,
        smartSpeed: 500,
        autoplayHoverPause: true,
        rtl: true,
        autoHeight: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 1,
            },
            1000: {
                items: 1,
            },
        },
    });


    
});
