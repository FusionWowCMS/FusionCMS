/**
 * @package    Updater
 * @subpackage admin/updater
 * @since      1.0.0
 * @version    1.0.0
 * @author     Ehsan Zare <darksider.legend@gmail.com>
 * @link       https://code-path.com
 * @copyright  (c) 2023 Code-path web developing team
 */

const Updater = (() => {
    // THIS object
    const self = {};

    // Installing flag
    self.installing = false;

    // Log inverval
    self.logInterval = false;

    // Define Updater selector
    self.Selector = {
        // Log
        log: '[__update_trace___]',
        logArea: '[__update_trace_textarea__]',

        // Button
        button: '[__update_install_button__]',
        buttonSpinner: '[__update_install_button_spinner__]'
    };

    // Define Updater attribute
    self.Attribute = {};

    /**
     * Install
     * @return void
     */
    self.install = () => {
        // Prevent multiple requests
        if(self.installing)
            return false;

        // Set installing flag
        self.installing = true;

        // Get elements
        const $log           = $(self.Selector.log);
        const $logArea       = $(self.Selector.logArea);
        const $button        = $(self.Selector.button);
        const $buttonSpinner = $(self.Selector.buttonSpinner);

        // Show log trace
        $log.fadeIn('300');

        // Show spinner
        $buttonSpinner.fadeIn('300');

        // Get logs (live)
        self.logInterval = setInterval(() => {self.getLog($logArea)}, 1000);

        // Perform AJAX to install updates
        $.get(Config.URL + 'admin/updater/update' + window.location.search, {}, function(response)
        {
            // Display message
            Swal.fire({
              text: response.message,
              icon: (response.updated === '1') ? 'success' : 'error',
              title: 'Updater'
            });

            // Updates installed!
            if(response.updated === '1')
            {
                // Remove install button
                $button.fadeOut('300', () => {$(this).remove()});
            }
        }, 'json')
        .fail(function()
        {
            // #
        })
        .always(function()
        {
            // Set installing flag
            self.installing = false;

            // Hide spinner
            $buttonSpinner.fadeOut('300');

            // Clear log interval
            setTimeout(() => {clearInterval(self.logInterval)}, 1999);
        });
    };

    /**
     * Get log
     * @return object el
     * @return void
     */
    self.getLog = (el) => {
        // Perform AJAX to get logs
        $.get(Config.URL + 'admin/updater/logs' + window.location.search, {'today': 'true'}, function(response)
        {
            el.val(response);
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

    /**
     * Initialize actions
     * @return void
     */
    self.init = () => {
        $(document.body).on('click', self.Selector.button, function()
        {
            self.install();
        });
    };

    return self;
})();

// Call UPDATER when content is loaded
(document.readyState !== 'loading') ? Updater.init() : document.addEventListener('DOMContentLoaded', () => { Updater.init(); });
