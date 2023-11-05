/**
 * @package    APP
 * @subpackage Template JS core
 * @since      1.0.0
 * @version    1.0.0
 * @author     Ehsan Zare <darksider.legend@gmail.com>
 * @link       https://code-path.com
 * @copyright  (c) 2021 Code-path web developing team
 */

let App = (function()
{
    // THIS object
    let self = {};

    /**
     * Handle sticky navbar
     * @return void
     */
    self.stickyNav = function()
    {
        const body       = document.body;
        const scrollUp   = 'scroll-up';
        const scrollDown = 'scroll-down';

        let lastScroll = 0;

        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;

            if(currentScroll <= 0)
            {
                body.classList.remove(scrollUp);
                return;
            }

            // Down
            if(currentScroll > lastScroll && !body.classList.contains(scrollDown))
            {
                body.classList.remove(scrollUp);
                body.classList.add(scrollDown);
            }
            // Up
            else if(currentScroll < lastScroll && body.classList.contains(scrollDown))
            {
                body.classList.remove(scrollDown);
                body.classList.add(scrollUp);
            }

            lastScroll = currentScroll;
        });
    }

    /**
     * Initialize owlCarousel
     * @return void
     */
    self.owlCarousel = function()
    {
        $('[owl-carousel="main"]').owlCarousel({
            nav: false,
            loop: true,
            margin: 16,
            responsive: {
                0: { items: 1 }
            }
        });
    }

    /**
     * Toggler
     * @return void
     */
    self.toggler = function()
    {
        $(document.body).on('click', '[data-toggle]', function()
        {
            let $this   = $(this),
                $panel  = $($(this).data('toggle') + ':visible'),
                $target = $($(this).data('target') + ':hidden');

            if(!$panel.length || !$target.length || $this.hasClass('active'))
                return;

            $panel.not($target).stop(true, true).fadeOut('fast', function() {
                $target.stop(true, true).fadeIn('fast');
                $('[data-toggle="' + $this.data('toggle') + '"]').removeClass('active');
                $this.addClass('active');
            });
        });
    }

    /**
     * Copyright
     * @return void
     */
    self.copyright = function()
    {
        // Define css
        const css = {
            1: 'color: #ff6600; font-weight: bold; font-size: 1.5rem;',
            2: 'color: #ff0088; font-weight: bold; font-style: italic;',
            3: 'color: #20882a; font-weight: bold; font-style: italic;'
        };

        console.log('%c%s', css[1], 'Thank you for reaching out!');
        console.log('%c%s', css[2], 'Heaven theme is designed by Veins and coded by Darksider <darksider.legend@gmail.com>.');
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
    self.init = function()
    {
        self.toggler();
        self.copyright();
        self.stickyNav();
        self.owlCarousel();
    }

    /**
     * Fire whole thing
     * @return void
     */
    self.__start__ = function()
    {
        // Call APP
        self.init();
    }

    return self;
}());

// Call APP when content is loaded
(document.readyState !== 'loading') ? App.__start__() : document.addEventListener('DOMContentLoaded', function() { App.__start__(); });
