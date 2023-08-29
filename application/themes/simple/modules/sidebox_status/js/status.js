/**
 * @package    Status
 * @subpackage Status
 * @since      1.0.0
 * @version    1.0.0
 * @author     Ehsan Zare <darksider.legend@gmail.com>
 * @link       https://code-path.com
 * @copyright  (c) 2023 Code-path web developing team
 */

const SIMPLE_status = (() => {
    // THIS object
    const self = {};

    // Define status selector
    self.Selector = {
        // Container (ajax)
        container: '[__realmStatusAjax__]'
    };

    // Define status attributes
    self.Attributes = {};

    /**
     * Initialize actions
     * @return void
     */
    self.init = () => {
        // Load realms
        self.loadRealms();
    };

    /**
     * Load realms
     * @return void
     */
    self.loadRealms = () => {
        // Get elements
        let $container = $(self.Selector.container);

        // No need to go any further
        if(!$container.length)
            return;

        // Perform AJAX to fetch realms data
        $.get(Config.URL + 'sidebox_status/status_refresh' + window.location.search, {}, function(response)
        {
            $container.find('> *').fadeOut(300, function()
            {
                // Swap html and unwrap inner-container
                $container.html(response).fadeIn(300).find('> *').unwrap();

                // Refresh tooltip
                if(typeof Tooltip === 'object')
                    Tooltip.refresh();

                // re-Apply iCheck and selectbox
                if(typeof App === 'object')
                {
                    if(typeof App.initIcheck === 'function')
                        App.initIcheck();

                    if(typeof App.initSelectbox === 'function')
                        App.initSelectbox();
                }
            });
        })
        .fail(function()
        {
            // #
        })
        .always(function()
        {
            // #
        });
    };

    return self;
})();

// Call Status when content is loaded
(document.readyState !== 'loading') ? SIMPLE_status.init() : document.addEventListener('DOMContentLoaded', function() { SIMPLE_status.init(); });
