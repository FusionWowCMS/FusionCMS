/**
 * @package    FusionCMS
 * @subpackage Spotlight/JS
 * @since      1.0.0
 * @version    1.0.0
 * @author     Nightprince
 * @link       https://www.yekta-core.ir
 * @copyright  (c) 2023 FusionWowCMS/FusionCMS web developing team
 */

const Spotlight = (() => {
    // THIS object
    const self = {};

    // Define spotlight selector
    self.selector = {
        toggle: '[data-spotlight-toggle]',
        toggleEq: '[data-spotlight-toggle="?"]'
    };

    // Define spotlight attributes
    self.attributes = {
        toggle: 'spotlight-toggle',
        target: 'spotlight-target'
    };

    // Define spotlight classes
    self.classes = {
        active: 'is-active'
    };

    /**
     * Initialize actions
     * @return void
     */
    self.init = () => {
        self.toggler();
    };

    /**
     * Toggler
     * @return void
     */
    self.toggler = () => {
        $(document.body).on('click', self.selector.toggle, function()
        {
            // Get elements
            const $this   = $(this),
                  $toggle = $($(this).data(self.attributes.toggle) + ':visible'),
                  $target = $($(this).data(self.attributes.target) + ':hidden');

            // Missing elements..
            if(!$toggle.length || !$target.length || $this.hasClass(self.classes.active))
                return;

            // Hide toggles
            $toggle.not($target).stop(true, true).fadeOut('fast', () => {
                // Show targets
                $target.stop(true, true).fadeIn('fast');

                // Remove active class from current toggle
                $(self.selector.toggleEq.replace('?', $this.data(self.attributes.toggle))).removeClass(self.classes.active);

                // Add active class to clicked toggle
                $this.addClass(self.classes.active);
            });
        });
    };

    return self;
})();

// Call spotlight when content is loaded
(document.readyState !== 'loading') ? Spotlight.init() : document.addEventListener('DOMContentLoaded', () => { Spotlight.init(); });
