$(document).ready(function () {
    // Get Aside
    let aside = $("#aside"),
        asideWidth = aside.innerWidth(), // Aside Bar Full Width
        btnAsideToggle = $("#btn-aside-toggle"), // Button Close & Open
        classToggleName = "toggle", // This Class Use For Action Open And Close
        asideOverlayBg = $(".aside-overlay");

    // Get Aside Menus
    let subMenu = $(".sub-menu"),
        menuItemLink = $(".side-item a");

    // Get Navbar
    let navbar = $("#navbar");

    aside.hover(
        function () {
            $(this).addClass("show-scroll");
        },
        function () {
            $(this).removeClass("show-scroll");
        }
    );

    /**
     * Get lang from file global.js
     * And Check Language Of The Dashboard
     * And Set Padding
     */
    let bodyAutoSetPadding = $("body").css(
        lang == "ar" ? "paddingRight" : "paddingLeft",
        asideWidth
    );

    /**
     *
     * Aside Toggle Open & Close
     *
     */

    // Check Language And Set Padding For Body
    function bodySetPadding(value = "0px") {
        if (lang == "ar") {
            $(bodyAutoSetPadding).animate(
                {
                    paddingRight: value,
                },
                0
            );
        } else {
            $(bodyAutoSetPadding).animate(
                {
                    paddingLeft: value,
                },
                0
            );
        }
    }

    // If Click In Toggle Button In Banner Toggle Open And Close Aside bar
    btnAsideToggle.click(function () {
        $(aside).toggleClass(classToggleName);
        asideOverlayBg.fadeToggle(250);

        if (aside.hasClass(classToggleName)) {
            bodySetPadding();
            // Navbar Full Width
            navbar.addClass("navbar-full-width");
        } else {
            bodySetPadding(asideWidth);
            // Navbar Full Width
            navbar.removeClass("navbar-full-width");
        }
    });

    // This Overlay Will Open In Small Screen If Touch This OverLay Close The Sidebar
    asideOverlayBg.click(function () {
        bodySetPadding(asideWidth);
        aside.removeClass("toggle");
        $(this).hide();
        navbar.removeClass("navbar-full-width");
    });

    /**
     *
     * Aside Menus Options
     *
     */
    // Open SubMenu Items Links
    menuItemLink.click(function (e) {
        $(this).next(subMenu).slideToggle(100); // Slide Top And Down Menu
        $(this).next(subMenu).addClass("open"); // Set Class Open
        if ($(this).next(subMenu).hasClass("open")) {
            $(this).children(".arrow-icon").toggleClass("rotate-icon");
        }
    });
});
