/**************************************************
 * ASIDE BAR SCRIPT
 * Handle open/close sidebar and menus
 **************************************************/
$(document).ready(function () {
    // Get Aside
    let aside = $("#aside"),
        asideWidth = aside.innerWidth() + 1,
        btnAsideToggle = $("#btn-aside-toggle"),
        classToggleName = "toggle",
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

    /*
     * Auto set body padding based on language
     */
    let bodyAutoSetPadding = $("body").css(
        lang == "ar" ? "paddingRight" : "paddingLeft",
        asideWidth
    );

    /*
     * Set body padding function
     */
    function bodySetPadding(value = "0px") {
        if (lang == "ar") {
            $(bodyAutoSetPadding).animate(
                { paddingRight: value },
                0
            );
        } else {
            $(bodyAutoSetPadding).animate(
                { paddingLeft: value },
                0
            );
        }
    }

    /*
     * Toggle aside open / close
     */
    btnAsideToggle.click(function () {
        $(aside).toggleClass(classToggleName);
        asideOverlayBg.fadeToggle(250);

        if (aside.hasClass(classToggleName)) {
            bodySetPadding();
            navbar.addClass("navbar-full-width");
        } else {
            bodySetPadding(asideWidth);
            navbar.removeClass("navbar-full-width");
        }
    });

    /*
     * Close aside on overlay click (mobile)
     */
    asideOverlayBg.click(function () {
        bodySetPadding(asideWidth);
        aside.removeClass("toggle");
        $(this).hide();
        navbar.removeClass("navbar-full-width");
    });

    /*
     * Handle submenu toggle
     */
    menuItemLink.click(function () {
        $(this).next(subMenu).slideToggle(100);
        $(this).next(subMenu).addClass("open");

        if ($(this).next(subMenu).hasClass("open")) {
            $(this).children(".arrow-icon").toggleClass("rotate-icon");
        }
    });



    /**************************************************
     * TABS BAR FIXED SCRIPT
     * Make tabs bar sticky on scroll
     * Sync with aside open/close state
     **************************************************/

    if (document.getElementById('tabs-bar')) {

        // Get elements
        var $tabs = $('#tabs-bar');
        var $aside = $('#aside');

        // Create placeholder to avoid layout jump
        var $placeholder = $('<div></div>');
        $tabs.before($placeholder);



        // Save original position
        var tabsTop = $tabs.offset().top;

        /*
         * Update tabs position based on aside status
         */
        function updateTabsPosition() {
            var asideWidth = $aside.hasClass('toggle') ? 0 : $aside.innerWidth();

            asideWidth += 1;

            if ($tabs.hasClass('tabs-fixed')) {
                if (lang === 'ar') {
                    $tabs.css({
                        right: asideWidth + 'px',
                        left: '0',
                        width: 'calc(100% - ' + asideWidth + 'px)'
                    });
                } else {
                    $tabs.css({
                        left: asideWidth + 'px',
                        right: '0',
                        width: 'calc(100% - ' + asideWidth + 'px)'
                    });
                }
            }
        }


        /*
         * Handle scroll to make tabs fixed
         */
        $(window).on('scroll', function () {
            if ($(window).scrollTop() > tabsTop) {
                
                if (!$tabs.hasClass('tabs-fixed')) {
                    $tabs.addClass('tabs-fixed');
                    $placeholder.height($tabs.outerHeight());
                }

                updateTabsPosition();

            } else {
                $tabs.removeClass('tabs-fixed').removeAttr('style');
                $placeholder.height(0);
            }
        });

        /*
         * Sync with aside toggle button
         */
        $('#btn-aside-toggle').on('click', function () {
            setTimeout(updateTabsPosition, 50);
        });

        /*
         * Sync with overlay click (mobile close)
         */
        $('.aside-overlay').on('click', function () {
            setTimeout(updateTabsPosition, 50);
        });

    }


});
