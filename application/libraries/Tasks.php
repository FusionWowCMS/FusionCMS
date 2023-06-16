<?php

/**
 * @package FusionGen
 * @author  Jesper Lindström
 * @author  Xavier Geerinck
 * @author  Elliott Robbins
 * @author  Err0r
 * @link    http://fusiongen.net
 */

class Tasks
{
    private $CI;
    private $db;

    public function __construct()
    {
        $this->CI = &get_instance();

        $this->CI->load->library('dbbackup');
        $this->CI->load->library('user');
        $this->CI->load->model('internal_user_model');
        $this->CI->load->config('backups');

        if ($this->CI->config->item('auto_backups'))
        {
            $this->CI->dbbackup->backup();
        }
    }
}
