<?php defined('BASEPATH') OR exit('No direct script access allowed');

use MX\MX_Controller;

class Spotlight extends MX_Controller
{
    # Directory separator shortcut
    const DS = DIRECTORY_SEPARATOR;

    # Metadata properties
    private static $moduleUrl;
    private static $modulePath;
    private static $moduleName;

    # Data properties
    private static $spotlight;

    public function __construct()
    {
        // Call `MX_Controller` construct
        parent::__construct();

        // Get module name
        self::$moduleName = basename(str_replace('controllers', '', __DIR__));

        // Get module url
        self::$moduleUrl = rtrim(base_url(), '/') . '/' . basename(APPPATH) . '/modules/' . self::$moduleName . '/';

        // Get module path
        self::$modulePath = rtrim(str_replace(['\\', '/'], self::DS, realpath(APPPATH)), self::DS) . self::DS . 'modules' . self::DS . self::$moduleName . self::DS;

        // Load models
        $this->load->model(self::$moduleName . '/spotlight_model');

        // Get spotlight
        self::$spotlight = $this->spotlight_model->getData();
    }

    /**
     * View
     * @return void
     */
    public function view()
    {
        // Prepare data
        $data = [
            # Metadata
            'module'     => self::$moduleName,
            'moduleUrl'  => self::$moduleUrl,
            'modulePath' => self::$modulePath,

            # Data
            'spotlight'  => self::$spotlight
        ];

        // Render output
        return $this->template->loadPage('spotlight.tpl', $data);
    }
}
