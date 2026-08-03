$(document).ready(function () {
    /**
     * For Services Card
     */
    $(".service-card").on("mousemove", function (e) {
        const width = $(this).outerWidth();
        const height = $(this).outerHeight();
        const x = e.offsetX;
        const y = e.offsetY;

        // حساب نصف العرض والطول للـ div
        const xCenter = width / 2;
        const yCenter = height / 2;

        // حساب الزوايا بناءً على موقع الماوس
        const rotateX = ((y - yCenter) / height) * 20; // زاوية الدوران حول X
        const rotateY = ((xCenter - x) / width) * 20; // زاوية الدوران حول Y

        // تطبيق التحويل
        $(this).css(
            "transform",
            `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1, 1, 1)`
        );
    });
    // إعادة الـ div لوضعه الأصلي عند إزالة الماوس
    $(".service-card").on("mouseleave", function () {
        $(this).css(
            "transform",
            "perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)"
        );
    });






    /****************************************************************************** */










    // This Div For Set Response Result Here
    $("#header").after(`<div class='result'></div>`);

    /*
    |
    | Global Class For Auto Validate Just Set class = validate in your form tag
    |
    */
    $(".validate").validate({
        rules: {},
    });

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

    // Set For All Lable [*] IF Have Class [required]
    let labelRequired = $(".required");
    for (let i = 0; i <= labelRequired.length; i++) {
        $(labelRequired[i]).append(
            "<b class='text-danger font-weight-bold'> * </b>"
        );
    }
});
