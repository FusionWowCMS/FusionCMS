<?php defined('BASEPATH') OR exit('No direct script access allowed');

use MX\MX_Controller;

/**
 * Countdown Controller Class
 */
class Countdown extends MX_Controller
{
    private static string $moduleUrl;
    private static string $moduleName;

    public function __construct()
    {
        parent::__construct();

        $this->load->config('sidebox_countdown/countdown');

        // Get module name
        self::$moduleName = basename(str_replace('controllers', '', __DIR__));

        // Get module url
        self::$moduleUrl = rtrim(base_url(), '/') . '/' . basename(APPPATH) . '/modules/' . self::$moduleName . '/';
    }

    /**
     * View
     * @return string
     */
    public function view(): string
    {
        $data = [
            'module'       => self::$moduleName,
            'moduleUrl'    => self::$moduleUrl,
            'date'         => $this->config->item('Date_Timestamp'),
            'text'         => $this->config->item('text'),
        ];

        return $this->template->loadPage('countdown.tpl', $data);
    }
}
