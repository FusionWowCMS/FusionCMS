<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use Smarty\Smarty;

class Smartyengine extends Smarty
{
    /**
     * @throws \Smarty\Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->setCompileDir(WRITEPATH . 'cache/templates');
        //$this->setCacheDir(WRITEPATH . 'cache/templates/cache');
        //$this->setConfigDir('/some/config/dir');
        $this->setTemplateDir(APPPATH);
        $this->assign('APPPATH', APPPATH);
        $this->assign('BASEPATH', BASEPATH);

        // Assign CodeIgniter object by reference to CI
        $CI = &get_instance();
        $this->assign('ci', $CI);

        if(!empty($plugins = glob(APPPATH . 'ThirdParty/Smarty/Tags/function.*.php'))){
            foreach ($plugins as $plugin) {
                require_once $plugin;
                $name = str_replace(['function.', '.php'], '', basename($plugin));

                $this->registerPlugin(Smarty::PLUGIN_FUNCTION, $name, 'smarty_tag_' . $name);
            }
        }

        $this->php_functions_extend();

        log_message('debug', "Smarty Class Initialized");
    }


    /**
     *  Parse a template using the Smarty engine
     *
     * This is a convenience method that combines assign() and
     * display() into one step.
     *
     * Values to assign are passed in an associative array of
     * name => value pairs.
     *
     * If the output is to be returned as a string to the caller
     * instead of being output, pass true as the third parameter.
     *
     * @access public
     * @param string $template
     * @param array $data
     * @param bool $return
     * @return string
     */
    public function view(string $template, array $data = [], bool $return = false): string
    {
        try {
            if ($data == '') {
                $data = [];
            }

            foreach ($data as $key => $val) {
                $this->assign($key, $val);
            }

            if (!$return) {
                $CI = &get_instance();
                if (method_exists($CI->output, 'set_output')) {
                    $CI->output->set_output($this->fetch($template));
                } else {
                    $CI->output->final_output = $this->fetch($template);
                }
                exit();
            } else {
                return $this->fetch($template);
            }
        } catch (\Smarty\Exception | Exception $e) {
            return "<span style='color:red;'><div style='font-size:16px;color:black;font-weight:bold;text-align:center;'>An error has occured while trying to load the requested view.</div><br /><br /><b>Template path:</b> " . $template . "<br /><br /><b>Error:</b> " . nl2br(preg_replace("/Stack trace\:/", "<br /><b>Stack trace:</b>", $e)) . "</span>";
        }
    }

    /**
     * @throws \Smarty\Exception
     */
    private function php_functions_extend(): void
    {
        $functions = array_merge(array_diff(get_defined_functions()['internal'], ['reset', 'key', 'end']) , [
            # Codeigniter
            'get_instance', 'base_url', 'config', 'config_item', 'form_open', 'form_open_multipart',
            'form_hidden', 'form_input', 'form_password', 'form_upload', 'form_submit', 'form_error',
            'form_multiselect', 'character_limiter', 'word_limiter', 'word_censor', 'highlight_code',
            'highlight_phrase', 'word_wrap', 'ellipsize', 'form_close', 'set_value',

            # FusionCMS
            'lang',
            'query',
            'table',
            'column',
            'langColumn',
            'hasPermission',
            'TinyMCE',
        ]);

        foreach ($functions as $php_function) {
            $this->registerPlugin(Smarty::PLUGIN_MODIFIER, $php_function, $php_function);
        }

        function smarty_modifier_reset(object|array $array): mixed {
            return reset($array);
        }
        function smarty_modifier_key(object|array $array): string|int|null {
            return key($array);
        }
        function smarty_modifier_end(object|array $array): mixed {
            return end($array);
        }

        $this->registerPlugin(Smarty::PLUGIN_MODIFIER, 'reset', 'smarty_modifier_reset');
        $this->registerPlugin(Smarty::PLUGIN_MODIFIER, 'key', 'smarty_modifier_key');
        $this->registerPlugin(Smarty::PLUGIN_MODIFIER, 'end', 'smarty_modifier_end');
    }
}
// END Smarty Class
