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
 

class CI_Smarty extends Smarty
{
    public function __construct()
    {
        parent::__construct();

        $this->setCompileDir(APPPATH . "cache/templates");
        $this->setTemplateDir(APPPATH);
        $this->assign('APPPATH', APPPATH);
        $this->assign('BASEPATH', BASEPATH);

        // Assign CodeIgniter object by reference to CI
        if (method_exists($this, 'assignByRef')) {
            $CI = &get_instance();
            $this->assignByRef("ci", $CI);
        }

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
     * @param  string
     * @param  array
     * @param  bool
     * @return string
     */
    public function view($template, $data = array(), $return = false)
    {
        try {
            if ($data == '') {
                $data = array();
            }

            foreach ($data as $key => $val) {
                $this->assign($key, $val);
            }

            if ($return == false) {
                $CI = &get_instance();
                if (method_exists($CI->output, 'set_output')) {
                    $CI->output->set_output($this->fetch($template));
                } else {
                    $CI->output->final_output = $this->fetch($template);
                }
                return;
            } else {
                return $this->fetch($template);
            }
        } catch (SmartyException $e) {
            return "<span style='color:red;'><div style='font-size:16px;color:black;font-weight:bold;text-align:center;'>An error has occured while trying to load the requested view.</div><br /><br /><b>Template path:</b> " . $template . "<br /><br /><b>Error:</b> " . nl2br(preg_replace("/Stack trace\:/", "<br /><b>Stack trace:</b>", $e)) . "</span>";
        }
    }
}
// END Smarty Class
