// Zorg dat alles pas werkt na DOM load
jQuery(document).ready(function ($) {
    // Mobile submenu toggle for topbar-menu (e.g. WPML language switcher)
    $('.topbar-menu > li.menu-item-has-children > a').on('click', function (e) {
        if ($(window).width() <= 991) {
            const $parentLi = $(this).parent();
            if ($parentLi.hasClass('submenu-open')) {
                return true;
            }
            e.preventDefault();
            $('.topbar-menu > li.menu-item-has-children').not($parentLi).removeClass('submenu-open');
            $parentLi.addClass('submenu-open');
        }
    });

    // Close submenu when clicking outside on mobile (topbar-menu)
    $(document).on('click', function (e) {
        if ($(window).width() <= 991) {
            if (!$(e.target).closest('.topbar-menu > li.menu-item-has-children').length) {
                $('.topbar-menu > li.menu-item-has-children').removeClass('submenu-open');
            }
        }
    });
    // JS for header block.
    const $header = $('.header');
    const $topbar = $('.header-topbar');
    const $hamburger = $('.hamburger-menu');
    const $menu = $('.header-content .menu');




    // Hamburger menu toggle
    $hamburger.on('click', function () {
        const isActive = $hamburger.hasClass('active');

        $hamburger.toggleClass('active');
        $menu.toggleClass('active');

        // Update aria-expanded
        $hamburger.attr('aria-expanded', !isActive);

        // Close all submenus when closing main menu
        if (isActive) {
            $('.header-menu > li.menu-item-has-children').removeClass('submenu-open');
        }
    });

    // Mobile submenu toggle - click on parent link
    $('.header-menu > li.menu-item-has-children > a').on('click', function (e) {
        // Only handle on mobile
        if ($(window).width() <= 991) {
            const $parentLi = $(this).parent();

            // If submenu is already open, allow navigation (second click)
            if ($parentLi.hasClass('submenu-open')) {
                return true;
            }

            // First click: open submenu, prevent navigation
            e.preventDefault();

            // Close other open submenus
            $('.header-menu > li.menu-item-has-children').not($parentLi).removeClass('submenu-open');

            // Open current submenu
            $parentLi.addClass('submenu-open');
        }
    });

    // Close submenu when clicking outside on mobile
    $(document).on('click', function (e) {
        if ($(window).width() <= 991) {
            if (!$(e.target).closest('.header-menu > li.menu-item-has-children').length) {
                $('.header-menu > li.menu-item-has-children').removeClass('submenu-open');
            }
        }
    });

    // Close menu on escape key
    $(document).on('keydown', function (e) {
        if (e.key === 'Escape' && $menu.hasClass('active')) {
            $hamburger.removeClass('active');
            $menu.removeClass('active');
            $hamburger.attr('aria-expanded', 'false');
        }
    });

    // Close menu when clicking outside
    $(document).on('click', function (e) {
        if (!$(e.target).closest('.header-content').length && $menu.hasClass('active')) {
            $hamburger.removeClass('active');
            $menu.removeClass('active');
            $hamburger.attr('aria-expanded', 'false');
        }
    });

    // Close menu on window resize if larger than mobile breakpoint
    $(window).on('resize', function () {
        if ($(window).width() > 991) {
            $hamburger.removeClass('active');
            $menu.removeClass('active');
            $hamburger.attr('aria-expanded', 'false');
            $('.header-menu > li.menu-item-has-children').removeClass('submenu-open');
        }
    });

    if ($topbar.length) {
        const topbarHeight = $topbar.outerHeight();

        $(window).on('scroll', function () {
            const scrollTop = $(window).scrollTop();

            // Move header up based on scroll, but cap at topbar height
            const offset = Math.min(scrollTop, topbarHeight + 20);
            $header.css('transform', 'translateY(-' + offset + 'px)');

            // Add scrolled class when fully scrolled past topbar
            if (scrollTop >= topbarHeight + 20) {
                $header.addClass('scrolled');
            } else {
                $header.removeClass('scrolled');
            }
        });

        // Check on page load
        $(window).trigger('scroll');
    }
});


