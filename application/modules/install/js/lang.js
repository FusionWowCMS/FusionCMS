/**
 * @package    Installer
 * @subpackage Language
 * @since      1.0.0
 * @version    1.0.0
 * @author     Ehsan Zare <darksider.legend@gmail.com>
 * @link       https://code-path.com
 * @copyright  (c) 2023 Code-path web developing team
 */

const Language = (() => {
    // THIS object
    const self = {};

    // Language strings
    self.lang = {};

    // User language
    self.userLang = false;

    // Default language
    self.defaultLang = 'en';

    /**
     * Load JSON file
     * @param  string   file
     * @param  function callback
     * @return void
     */
    self.loadJSON = (file, callback) => {
        // Old browsers compatibility
        file     = file     || false;
        callback = callback || false;

        // Missing a parameter or two..
        if(!file || !callback)
            return false;

        // Validate parameters
        if(typeof(file) !== 'string' || typeof(callback) !== 'function')
            return false;

        // Initialize XHR
        const xObj = new XMLHttpRequest();

        // Set MimeType
        xObj.overrideMimeType('application/json');

        // Request JSON file
        xObj.open('GET', Config.url + 'application/modules/install/languages/' + file + '.json', false);

        // Call `callback` function
        xObj.onreadystatechange = () => {
            if(xObj.readyState === 4 && xObj.status === 200)
                callback(xObj.responseText);
        };

        xObj.send(null);
    };

    /**
     * Load language file
     * @return void
     */
    self.load = (file) => {
        // Old browsers compatibility
        file = file || false;

        // Missing a parameter or two..
        if(!file)
            return false;

        // Validate parameters
        if(typeof(file) !== 'string')
            return false;

        // Language file is loaded already
        if(typeof self.lang[file] !== 'undefined')
            return false;

        // Load language strings
        self.loadJSON(file, (response) => {
            self.lang[file] = JSON.parse(response);
        });
    };

    /**
     * Get language string
     * @param  string key
     * @param  string lang
     * @return string
     */
    self.get = (key, lang) => {
        // Old browsers compatibility
        key  = key  || false;
        lang = lang || self.defaultLang;

        // Missing a parameter or two..
        if(!key || !lang)
            return false;

        // Validate parameters
        if(typeof(key) !== 'string' || typeof(lang) !== 'string')
            return false;

        // Check if requested key exists
        if(typeof self.lang[lang] !== 'undefined' && typeof self.lang[lang][key] !== 'undefined')
            return self.lang[lang][key];

        // Return key from default language
        if(typeof self.lang[self.defaultLang] !== 'undefined' && typeof self.lang[self.defaultLang][key] !== 'undefined')
            return self.lang[self.defaultLang][key];

        return false;
    };

    /**
     * Initialize actions
     * @return void
     */
    self.init = () => {
        // Read localstorage to set user language
        self.userLang = localStorage.getItem('language') == null ? 'en' : localStorage.getItem('language');

        // Load default language
        self.load(self.defaultLang);

        // Load user language
        self.load(self.userLang);

        // Loop through `default` strings and replace document.. if exists
        Object.keys(self.lang[self.defaultLang]).forEach((key, index) => {
            let find    = '{{' + key + '}}';
            let replace = self.get(key, self.userLang);

            // Replace
            document.body.innerHTML = document.body.innerHTML.replaceAll(find, replace);
        });
    };

    return self;
})();
