
define(['jquery', 'bootstrap'], function ($, bs) {

    $(document).ready(function() {

        $(window).resize(function() {
            if ($(window).width() >= 765) {
                $(".sidebar .sidebar-inner").slideDown(350);
            } else {
                $(".sidebar .sidebar-inner").slideUp(350);
            }
        });

        $(".has_submenu").on('mouseenter mouseleave', function(e) {
            e.preventDefault();
            var menu_li = $(this);
            var menu_ul = menu_li.children("ul");

            menu_ul.stop(true, true);
            if (menu_li.hasClass("open")) {
                menu_ul.slideUp(350);
                menu_li.removeClass("open");
            } else {
                $(".navi > li > ul").slideUp(350);
                $(".navi > li").removeClass("open");
                menu_ul.slideDown(350);
                menu_li.addClass("open");
            }
        });

        $('body').on('click', 'a.no-click', function(e){
            e.preventDefault();
            e.stopPropagation();
            return false;
        });

        $(".sidebar-dropdown a").on('click', function(e) {
            e.preventDefault();

            if (!$(this).hasClass("dropy")) {
                // hide any open menus and remove all other classes
                $(".sidebar .sidebar-inner").slideUp(350);
                $(".sidebar-dropdown a").removeClass("dropy");

                // open our new menu and add the dropy class
                $(".sidebar .sidebar-inner").slideDown(350);
                $(this).addClass("dropy");
            }

            else if ($(this).hasClass("dropy")) {
                $(this).removeClass("dropy");
                $(".sidebar .sidebar-inner").slideUp(350);
            }
        });

        $(".sidebar-inner .navi a").click(function(){
            if ($(window).width() <= 765) {
                $a = $(this);
                if(!$a.parent('li').hasClass('has_submenu')){
                    $(".sidebar .sidebar-inner").slideUp(350);
                }
            }
        });
    });

    /* Scroll to Top */

    $(".totop").hide();

    $(function() {
        $(window).scroll(function() {
            if ($(this).scrollTop() > 300) {
                $('.totop').slideDown();
            } else {
                $('.totop').slideUp();
            }
        });

        $('.totop a').click(function(e) {
            e.preventDefault();
            $('body,html').animate({
                scrollTop : 0
            }, 500);
            return false;
        });

    });

});
