$(document).ready(function () {
    // حساب ارتفاع Navbar و Page Tabs
    let navbarHeight = $("#navbar").outerHeight();
    let tabsHeight = $(".page-tabs").outerHeight();
    let totalOffset = navbarHeight + tabsHeight;

    // دالة لتفعيل التاب الأول إذا كانت الصفحة في أعلى
    function activateFirstTab() {
        if ($(this).scrollTop() <= 300) {
            $(".page-tabs a").first().addClass("active-tab-link");
        }
    }

    // ضبط موقع Page Tabs تحت Navbar
    $(".page-tabs").css("top", navbarHeight + "px");

    // عند التمرير
    $(window).on("scroll", function () {
        let scrollTop = $(this).scrollTop();
        let offset = totalOffset + 30;

        // تفعيل/تعطيل كلاس active للتاب
        if (scrollTop > 280) {
            $(".page-tabs").addClass("active");
        } else {
            $(".page-tabs").removeClass("active");
        }

        // تفعيل التاب حسب القسم اللي ظاهر
        $("main section").each(function () {
            let sectionTop = $(this).offset().top;
            let sectionHeight = $(this).outerHeight();
            let sectionId = $(this).attr("id");

            if (scrollTop >= sectionTop - offset && scrollTop < sectionTop + sectionHeight - offset) {
                $('.page-tabs a[href="#' + sectionId + '"]').addClass("active-tab-link");
            } else {
                $('.page-tabs a[href="#' + sectionId + '"]').removeClass("active-tab-link");
            }
        });

        // تفعيل التاب الأول إذا في أعلى الصفحة
        activateFirstTab();
    });

    // عند الضغط على أي رابط في Page Tabs
    $('.page-tabs a[href^="#"]').on("click", function (event) {
        let target = $($(this).attr("href"));
        let scrollPosition = 0;

        if (target.length) {
            if (target.data("index") != "0") {
                scrollPosition = target.offset().top - totalOffset;
            }
            $("html, body").animate({ scrollTop: scrollPosition }, 0);
            event.preventDefault();
            activateFirstTab();
        }
    });

    // تفعيل التاب الأول عند تحميل الصفحة
    activateFirstTab();
});
