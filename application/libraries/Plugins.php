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

class Plugins
{
    private $plugins = array();
    private $CI;
    public $module_name;

    /**
     * Get the instance of CI and load all plugins.
     */
    public function __construct()
    {
        $this->CI = &get_instance();
        $this->module_name = $this->CI->router->fetch_module();

        // Do plugins even exist for this module?
        if (is_dir('application/modules/' . $this->module_name . '/plugins')) {
            // Load our plugin class
            require_once('Plugin.php');

            $files = preg_grep('/.+_config.php$/', glob('application/modules/' . $this->module_name . '/plugins/*.php'), PREG_GREP_INVERT);
            foreach ($files as $file) {
                $pinfo = pathinfo($file, PATHINFO_FILENAME);
                include_once($file);
                $this->plugins[$pinfo] = new $pinfo($this->getConfig($pinfo));
            }
        }
    }

    /**
     * Scope hack for setting configs
     *
     * @param  String
     * @return Array
     */
    private function getConfig($filename)
    {
        $filename = 'application/modules/' . $this->module_name . '/plugins/' . $filename . '_config.php';
        if (!file_exists($filename)) {
            return null;
        }

        include($filename);
        return (isset($config) ? $config : null);
    }

    /**
     * Returns all loaded plugins.
     *
     * @return Array
     */
    public function getPlugins()
    {
        return $this->plugins;
    }

    /**
     * Checks to see if the specified plugin is loaded.
     *
     * @param  String
     * @return bool
     */
    public function isLoaded($name)
    {
        $ret = false;
        foreach ($this->plugins as $plugin) {
            if (strtolower($plugin->name) == strtolower($name)) {
                $ret = true;
                break;
            }
        }

        return $ret;
    }

    /**
     * Call a function in each of the loaded plugin classes if the method exists.
     *
     * @param  mixed
     * @return array
     */
    public function __call($func, $args)
    {
        $ret = array();
        foreach ($this->plugins as $plugin) {
            // Does the method exist, and is it public?
            if (method_exists($plugin, $func) && is_callable(array($plugin, $func))) {
                $ret[$plugin->name] = call_user_func_array(array($plugin, $func), $args);
            }
        }

        return $ret;
    }

    /**
     * Sets a variable in all the loaded plugins
     *
     * @param String
     * @param mixed
     */
    public function __set($name, $value)
    {
        foreach ($this->plugins as $plugin) {
            $plugin->$name = $value;
        }
    }

    /**
     * Gets any variables that exist under the passed name for all plugins.
     *
     * @param  String
     * @return mixed
     */
    public function __get($name)
    {
        $ret = array();
        foreach ($this->plugins as $plugin) {
            // Is this an explicit reference to the class?
            if (strtolower($plugin->name) == strtolower($name)) {
                return $plugin;
            }
        }

        foreach ($this->plugins as $plugin) {
            $ret[$plugin->name] = $plugin->$name;
        }

        return $ret;
    }
}
