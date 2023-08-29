/**
 * @package    App
 * @subpackage Template JS core
 * @since      1.0.0
 * @version    1.0.0
 * @author     Ehsan Zare <darksider.legend@gmail.com>
 * @link       https://code-path.com
 * @copyright  (c) 2023 Code-path web developing team
 */

const App = (() => {
    // THIS object
    const self = {};

    // Define App selector
    self.Selector = {
        // Input
        input: 'input',

        // Slider
        slider: '#slider',

        // Selectbox
        sbHolder: '.sbHolder',
        selectbox: 'select:not([sb])',
        selectboxLazy: 'select[sb=\'lazy\']'
    };

    // Define App attribute
    self.Attribute = {};

    /**
     * Initialize slider
     * @return void
     */
    self.initSlider = () => {
        // Failed to load flux plugin
        if(typeof flux === 'undefined')
            return;

        // Get elements
        const $slider = $(self.Selector.slider);

        // No need to go any further
        if(!$slider.length)
            return;

        // Prepare slider config
        const sliderCFG = {
            delay: Config.Slider.interval,
            autoplay: true,
            captions: true,
            pagination: true,
            transitions: new Array('dissolve')
        };

        // Call flux
        window.myFlux = new flux.slider(self.Selector.slider, sliderCFG)
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
        $(self.Selector.input).iCheck({radioClass: 'iradio_futurico', checkboxClass: 'icheckbox_futurico'}).on('ifChecked ifUnchecked', () => {$(this).change();});
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
        ((refresh) ? $(self.Selector.selectboxLazy) : $(self.Selector.selectbox)).each(function()
        {
            const visibility = $(this).css('display') !== 'none';

            // Call selectbox
            $(this).selectbox({onChange: (value) => {$(this).val(value).change();}}).next(self.Selector.sbHolder).attr('style', $(this).attr('style'))[visibility ? 'show' : 'hide']();
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
        console.log('%c%s', css[2], 'Simple theme is designed by EvilSystem and coded by Darksider <darksider.legend@gmail.com>.');
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
        self.copyright();
        self.initSlider();
        self.initIcheck();
        self.initSelectbox();

        // [DataTables init] Call iCheck and selectbox
        $('body').on('init.dt', (e, ctx) => {
            self.initIcheck();
            self.initSelectbox();
        });
    };

    return self;
})();

// Call APP when content is loaded
(document.readyState !== 'loading') ? App.init() : document.addEventListener('DOMContentLoaded', () => { App.init(); });
