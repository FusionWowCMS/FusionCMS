/**
 * @package    CustomJS
 * @subpackage Template JS core
 * @since      1.0.0
 * @version    1.0.0
 * @author     Ehsan Zare <darksider.legend@gmail.com>
 * @link       https://code-path.com
 * @copyright  (c) 2023 Code-path web developing team
 */

const CustomJS = (() => {
    // THIS object
    const self = {};

    /**
     * Initialize slider
     * @return void
     */
    self.initSlider = () => {
        // Failed to load flux plugin
        if(typeof flux === 'undefined')
            return;

        // Get elements
        const $slider = $('#slider');

        // No need to go any further
        if(!$slider.length)
            return;

        // Prepare slider config
        const sliderCFG = {
            delay: Config.Slider.interval,
            autoplay: true,
            captions: true,
            controls: false,
            pagination: true,
            transitions: new Array('dissolve')
        };

        // Call flux
        window.myFlux = new flux.slider('#slider', sliderCFG);
    };

    /**
     * Initialize iCheck
     * @param  boolean refresh
     * @return void
     */
    self.initIcheck = (refresh) => {
        // Failed to load iCheck plugin
        if(typeof $.fn.iCheck === 'undefined')
            return;

        // Old browsers compatibility
        refresh = refresh || false;

        // Call iCheck
        $('input').iCheck().on('ifChecked ifUnchecked', () => {$(this).change();});
    };

    /**
     * Initialize selectbox
     * @param  boolean refresh
     * @return void
     */
    self.initSelectbox = (refresh) => {
        // Failed to load selectbox plugin
        if(typeof $.fn.selectbox === 'undefined')
            return;

        // Old browsers compatibility
        refresh = refresh || false;

        // Loop through selects
        ((refresh) ? $('select[sb=\'lazy\']') : $('select:not([sb])')).each(function()
        {
            const visibility = $(this).css('display') !== 'none';

            // Call selectbox
            $(this).selectbox({onChange: (value) => {$(this).val(value).change();}}).next('.sbHolder').attr('style', $(this).attr('style'))[visibility ? 'show' : 'hide']();
        });
    };

    /**
     * Initialize back to top
     * @return void
     */
    self.initB2T = () => {
        $('.back-to-top').click(function(e) {
            e.preventDefault();

            $('html, body').animate({
                scrollTop: 0
            }, 'slow');
        });
    };

    /**
     * Initialize RSS
     * @return void
     */
    self.initRSS = () => {
        $.get(Config.URL + 'news/rss', function(data) {
            var $RSS        = $(data).find('item').first(),
                $latestnews = $('.latestnews'),
                item        = {
                    id:          $RSS.find('guid').text(),
                    link:        $RSS.find('link').text(),
                    title:       $RSS.find('title').text(),
                    author:      $RSS.find('author').text(),
                    description: $RSS.find('description').text(),
                    pubDate:     new Date($RSS.find('pubDate').text())
                };

            item.pubDate = item.pubDate.getDate() + '/' + item.pubDate.getMonth() + '/' + item.pubDate.getFullYear();

            $latestnews.find('.loading_ajax').fadeOut(300, function() {
                $latestnews.find('.rss_item')
                    .append(''
                        + '<a href="' + Config.URL + 'news/view/' + item.id + '" class="item_title vertical_center" title="' + item.title + '"><i>“</i><span class="overflow_ellipsis">' + item.title + '</span><i>”</i></a>'
                        + '<div class="item_date vertical_center">' + item.pubDate + '</div>'
                        + '<a href="' + Config.URL + 'news/view/' + item.id + '" class="item_readmore vertical_center">' + auzwowConfig.lang.readmore + '</a>'
                    )
                    .fadeIn(300);

                $(this).remove();
            });
        });
    };

    /**
     * Initialize mmenu
     * @return void
     */
    self.initMmenu = () => {
        // Failed to load mmenu plugin
        if(typeof $.fn.mmenu === 'undefined')
            return;

        // Get elements
        const $mmenu = $('#my-menu');

        // No need to go any further
        if(!$mmenu.length)
            return;

        // Call mmenu
        $mmenu.mmenu({ 'navbars': [{ height: 3, content: '<img class="mmenu-logo vertical_center" src="' + Config.image_path + 'misc/logo.png" />' }], 'extensions': ['position-right', 'theme-dark'] });

        // Call mCustomScrollbar
        if(typeof $.fn.mCustomScrollbar !== 'undefined')
            $('.mm-panels').mCustomScrollbar();
    };

    /**
     * Initialize countdown
     * @return void
     */
    self.initCountdown = () => {
        // Countdown is disabled
        if(!auzwowConfig.countdownEnabled)
            return;

        // Failed to load countdown plugin
        if(typeof $.fn.countdown === 'undefined')
            return;

        // Call countdown
        $('#countdown_timer').countdown(auzwowConfig.countdownDate, function(event) {
            $(this).html(event.strftime(''
                + '<span>%D <i>' + auzwowConfig.lang.d + '</i></span>'
                + '<span>%H <i>' + auzwowConfig.lang.h + '</i></span>'
                + '<span>%M <i>' + auzwowConfig.lang.m + '</i></span>'));
        }).on('finish.countdown', function(event) { $('.countdown').addClass('finished'); });
    };

    /**
     * Initialize scrollbar
     * @return void
     */
    self.initScrollbar = () => {
        // Failed to load mCustomScrollbar plugin
        if(typeof $.fn.mCustomScrollbar === 'undefined')
            return;

        // Call mCustomScrollbar
        $('.welcome_box .welcome_content').mCustomScrollbar();
    };

    /**
     * Switch realm
     * @return void
     */
    self.switchRealm = (el, realm) => {
        if($(el).hasClass('active'))
            return;

        $('.realm_holder').not($(realm)).stop(true, true).fadeOut('fast', function() {
            $(realm).stop(true, true).fadeIn('fast');
            $('.realm_pagination .active').removeClass('active');
            $(el).addClass('active');
        });
    };

    /**
     * News accordion
     * @return void
     */
    self.newsAccordion = () => {
        $('.expandable .post_header').on('click', function(event) {
            if($(event.target).is('a') && !$(event.target).hasClass('icon-expand') || $(event.target).parents().is('a') && !$(event.target).hasClass('icon-expand'))
                return;

            var article   = $(this).parents().closest('.expandable'),
                collapsed = false;

            if(article.hasClass('collapsed'))
                collapsed = true;

            if(collapsed)
            {
                article.find('.post-left').stop(true, true).css('height', 'auto').animate({opacity: 1}, 300)
                       .next('.post-right').find('.post_body').stop(true, true).fadeIn(300).next('.border_fix').hide();
            }
            else
            {
                article.find('.post-left').stop(true, true).animate({opacity: 0}, 300, function() { $(this).css('height', 1) })
                       .next('.post-right').find('.post_body').stop(true, true).fadeOut(300, function() { $(this).next('.border_fix').show() });
            }

            article.toggleClass('collapsed');
        });
    };

    /**
     * Copyright
     * @return void
     */
    self.copyright = () => {
        // Define css
        const css = {
            1: 'color: #ff6600; font-weight: bold; font-size: 1.5rem;',
            2: 'color: #ff0088; font-weight: bold; font-style: italic;',
            3: 'color: #20882a; font-weight: bold; font-style: italic;'
        };

        console.log('%c%s', css[1], 'Thank you for reaching out!');
        console.log('%c%s', css[2], 'AUZWOW theme is designed by Zafire and coded by Darksider <darksider.legend@gmail.com>.');
        console.log('%c%s', css[2], 'This premium product is completely free of charge, I hope that you will have a nice time using it.');
        console.log('%c%s', css[3], 'Are you a fan or wish to support me?');
        console.log('%c%s', css[3], 'BTC: 12BuzF7JEHHuVLdjYMwD2mC1MDBpfBvqRN');
        console.log('%c%s', css[3], 'USDT (TRC20): TYpJAN55ZfTtbQTDGAwu6CEJ4GDc5mQ7fT');
        console.log('%c%s', css[3], 'USDT (ERC20): 0x6ef363504b3be115ab0ffb8cd2f2259e340ff6c1');
    };

    /**
     * Initialize actions
     * @return void
     */
    self.init = () => {
        self.initB2T();
        self.initRSS();
        self.initMmenu();
        self.initSlider();
        self.initIcheck();
        self.initCountdown();
        self.initSelectbox();
        self.initScrollbar();

        self.copyright();
        self.newsAccordion();

        // [DataTables init] Call iCheck and selectbox
        $('body').on('init.dt', (e, ctx) => {
            self.initIcheck();
            self.initSelectbox();
        });
    };

    return self;
})();

// Call CustomJS when content is loaded
(document.readyState !== 'loading') ? CustomJS.init() : document.addEventListener('DOMContentLoaded', () => { CustomJS.init(); });
