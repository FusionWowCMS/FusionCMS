<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * @package FusionCMS
 * @author  Jesper Lindström
 * @author  Xavier Geerinck
 * @author  Elliott Robbins
 * @author  Keramat Jokar (Nightprince) <https://github.com/Nightprince>
 * @author  Ehsan Zare (Darksider) <darksider.legend@gmail.com>
 * @link    https://github.com/FusionWowCMS/FusionCMS
 */
class Language
{
    private $CI;
    private $language;
    private $languageAbbreviation;
    private $defaultLanguage;
    private $requestedFiles;
    private $data;
    private $clientData;

    /**
     * Get the CI instance and load the default language
     */
    public function __construct()
    {
        $this->CI = &get_instance();

        $this->requestedFiles = $this->data = array();

        // Load default language
        $this->defaultLanguage = $this->CI->config->item('language');

        if (!is_dir("application/language/" . $this->defaultLanguage)) {
            $this->defaultLanguage = "english";

            if (!is_dir("application/language/" . $this->defaultLanguage)) {
                show_error("The actual default language <b>" . $this->CI->config->item('language') . "</b> does not exist, and neither does English. Please install at least one language.");
            }
        }

        $this->language = $this->defaultLanguage;
        $this->load("main");
        $this->languagePrefix = $this->get("abbreviation");
    }

    /**
     * Change the language on the fly
     *
     * @param String $language
     */
    public function setLanguage($language)
    {
        $realLanguage = $language;
        $this->language = $language;

        if (!is_dir("application/language/" . $language)) {
            $language = $this->defaultLanguage;

            if (!is_dir("application/language/" . $language)) {
                $language = "english";

                if (!is_dir("application/language/" . $language)) {
                    show_error("The requested language <b>" . $realLanguage . "</b> doesn't exist and the actual default language <b>" . $this->CI->config->item('language') . "</b> does not exist either, and nor does English. Please install at least one language.");
                }
            }
        }

        $this->reloadLanguage();
        $this->languagePrefix = $this->get("abbreviation");
    }

    /**
     * Reload all previously loaded language files,
     * meant to be used after "on the fly" change of language
     */
    private function reloadLanguage()
    {
        if (count($this->requestedFiles)) {
            foreach ($this->requestedFiles as $file) {
                $this->load($file);
            }
        }
    }

    /**
     * Get the currently active language name
     * in lowercase, such as "english"
     *
     * @return String
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Get the default language name
     * in lowercase, such as "english"
     *
     * @return String
     */
    public function getDefaultLanguage()
    {
        return $this->defaultLanguage;
    }

    /**
     * Translate the JSON-stored language string to the desired language
     *
     * @param  String $json
     * @return String
     */
    public function translateLanguageColumn($json)
    {
        $data = json_decode($json, true);

        if (is_array($data)) {
            if (array_key_exists($this->language, $data)) {
                return $data[$this->language];
            } elseif (array_key_exists($this->defaultLanguage, $data)) {
                return $data[$this->defaultLanguage];
            } else {
                return reset($data);
            }
        } else {
            return $json;
        }
    }

    /**
      * Get the selected language
     *
     * @param  String $json
     * @return String
     */
    public function getColumnLanguage($json)
    {
        $data = json_decode($json, true);

        if (is_array($data)) {
            if (array_key_exists($this->language, $data)) {
                return $this->language;
            } elseif (array_key_exists($this->defaultLanguage, $data)) {
                return $this->defaultLanguage;
            } else {
                show_error($json . " does not contain an entry for <b>" . $this->defaultLanguage . "</b> which is the default langauge");
            }
        } else {
            return $this->defaultLanguage;
        }
    }

    /**
     * Get the currently active language abbreviation
     *
     * @return String
     */
    public function getLanguageAbbreviation()
    {
        $this->languageAbbreviation = $this->get("abbreviation");
        return $this->languageAbbreviation;
    }

    /**
     * Get a language string
     *
     * @param String $id
     * @param String $file defaults to 'main'
     */
    public function get($id, $file = 'main')
    {
        if (!in_array($file, $this->requestedFiles)) {
            $this->load($file);
        }

        // Try to find the string in the current language
        if (array_key_exists($id, $this->data[$this->language][$file])) {
            return $this->data[$this->language][$file][$id];
        }

        // If the current language isn't the default language
        elseif ($this->language != $this->defaultLanguage) {
            if (!array_key_exists($file, $this->data[$this->defaultLanguage])) {
                $this->load($file, $this->defaultLanguage);
            }

            if (array_key_exists($id, $this->data[$this->defaultLanguage][$file])) {
                return $this->data[$this->defaultLanguage][$file][$id];
            } else {
                show_error("Language string not found (" . $id . " in " . $file . ")");
            }
        } else {
            show_error("Language string not found (" . $id . " in " . $file . ")");
        }
    }

    /**
     * Load a language file
     *
     * @param String $file
     * @param String $language defaults to the current language
     */
    private function load($file, $language = false)
    {
        // Default to the current language
        if (!$language) {
            $language = $this->language;
        }

        // Prevent errors
        if (!array_key_exists($language, $this->data)) {
            $this->data[$language] = array();
        }

        // Add it to the list of requested files if it doesn't exist already
        if (!in_array($file, $this->requestedFiles)) {
            array_push($this->requestedFiles, $file);
        }

        // Look in the shared directory
        if (file_exists("application/language/" . $language . "/" . $file . ".php")) {
            $path = "application/language/" . $language . "/" . $file . ".php";
        }

        // Look in the module directory
        elseif (
            is_dir("application/modules/" . $this->CI->template->module_name . "/language/")
            && is_dir("application/modules/" . $this->CI->template->module_name . "/language/" . $language)
            && file_exists("application/modules/" . $this->CI->template->module_name . "/language/" . $language . "/" . $file . ".php")
        ) {
            $path = "application/modules/" . $this->CI->template->module_name . "/language/" . $language . "/" . $file . ".php";
        }

        // Look in the themes directory
        elseif (
            is_dir("application/themes/" . $this->CI->template->theme . "/language/")
            && is_dir("application/themes/" . $this->CI->template->theme . "/language/" . $language)
            && file_exists("application/themes/" . $this->CI->template->theme . "/language/" . $language . "/" . $file . ".php")
        ) {
            $path = "application/themes/" . $this->CI->template->theme . "/language/" . $language . "/" . $file . ".php";
        }

        // No language file was found, and this is the default language
        elseif ($language == $this->defaultLanguage) {
            $this->data[$language][$file] = array();
            show_error("Language file <b>" . $file . ".php</b> does not exist in application/language/" . $language . "/ or in application/modules/" . $this->CI->template->module_name . "/language/" . $language . "/");
        }

        // No language file was found, but it may exist for the default language
        else {
            $this->data[$language][$file] = array();
            return false;
        }

        // Load the requested language file
        require($path);

        // Save it to the data array
        $this->data[$language][$file] = $lang;
    }

    /**
     * Get all languages as an array
     *
     * @return Array
     */
    public function getAllLanguages()
    {
        $languages = array();

        $results = glob("application/language/*/");

        foreach ($results as $file) {
            if (is_dir($file)) {
                $language = preg_replace("/(application\/language\/)|\//", "", $file);
                $abbreviation = $this->getAbbreviationByLanguage($language);
                $languages[$abbreviation] = $language;
            }
        }

        return $languages;
    }

    public function getAbbreviationByLanguage($language)
    {
        if (is_dir("application/language/" . $language)) {
            require("application/language/" . $language . "/main.php");

            return $lang['abbreviation'];
        } else {
            return false;
        }
    }

    public function setClientData($id, $file = 'main')
    {
        $this->clientData[$file][$id] = $this->get($id, $file);
    }

    /**
     * Get the client side language strings as JSON
     *
     * @return String
     */
    public function getClientData()
    {
        return json_encode($this->clientData);
    }
}
