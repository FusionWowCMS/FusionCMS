/**
 * Upgrade
 *
 * @package    install
 * @subpackage js
 * @since      1.0.0
 * @version    1.0.0
 * @author     Ehsan Zare <darksider.legend@gmail.com>
 * @link       https://code-path.com
 * @copyright  (c) 2024 Code-path web developing team
 */

const upgrade = (() => {
    // THIS object
    const self = {};

    self.install = (el, limit, offset) => {
        // Missing or invalid parameters
        if(!el || typeof(el) !== 'object' || typeof(el.querySelectorAll) !== 'function')
            return false;

        // Input: Find
        const $input = el.querySelectorAll('input:not([disabled]), select:not([disabled])');

        // Request: Initialize
        let req = {
            limit: limit   || 1000,
            offset: offset || 0
        };

        // Input: Loop through
        [...$input].map((item, key) => {
            // Request: Append
            req[item.name] = item.value;
        });

        // Post: Request install...
        $.post(el.dataset.baseurl + 'install/upgrade/migrate' + window.location.search, req, (data) => {
            // Data: Invalid
            if(typeof(data) !== 'object' || (typeof(data.status) !== 'number' || isNaN(data.status)) || typeof(data.response) !== 'string')
                return UI.alert('Something went wrong');

            // Data: Error
            if(data.status !== 0)
                return UI.alert(data.response);

            // Logs: Get
            const $logs = document.querySelector('[migrate_logs]');

            // Logs: Append
            if(data.affected_rows)
                $logs.insertAdjacentHTML('beforeend', '<div>' + data.response + '</div>');

            // Continue migrating...
            if(data.affected_rows == req.limit)
                self.install(document.forms['migrate'], req.limit, (req.offset + req.limit));
        }, 'json')
        .fail(() => {
            return UI.alert('Something went wrong');
        })
        .always(() => {
            // #
        });
    };

    /**
     * Initialize actions
     * Starts the chain
     *
     * @return void
     */
    self.init = () => {
        const $tables = document.querySelectorAll('select[name="table"]');

        document.querySelector('select[name="cms"]').addEventListener('change', (event) => {
            const $target = document.querySelector('select[' + event.target.value + ']');

            [...$tables].map((item, key) => {
                item.style.display = 'none';
                item.setAttribute('disabled', 'true');
            });

            $target.style.display = 'block';
            $target.removeAttribute('disabled');
        });
    };

    return self;
})();

// Call module when content is loaded
(document.readyState !== 'loading') ? upgrade.init() : document.addEventListener('DOMContentLoaded', () => { upgrade.init(); });
