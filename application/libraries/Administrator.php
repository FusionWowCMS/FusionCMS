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
class Administrator
{
    protected $CI;
    private $theme_path;
    private $menu;
    private $title;
    private $currentPage;
    private $version;

    /**
     * Define our paths and objects
     */
    public function __construct()
    {
        $this->CI = &get_instance();
        $this->theme_path = "application/themes/admin/";
        $this->menu = array();

        if (!$this->CI->user->isStaff()) {
            show_404();
        }

        $this->showLogIn();

        if (!$this->CI->input->is_ajax_request() && !isset($_GET['is_json_ajax'])) {
            $this->loadModules();
            $this->getMenuLinks();
        }
    }

    /**
     * Handle admin log ins
     */
    private function logIn()
    {
        $security_code = $this->CI->input->post('security_code');

        // Make sure the user has permission to view the admin panel
        if (!hasPermission("view", "admin")) {
            die("permission");
        }

        if ($security_code == $this->CI->config->item('security_code')) {
            $this->CI->session->set_userdata(array('admin_access' => true));

            die("welcome");
        } else {
            die("key");
        }
    }

    /**
     * Add an extra page title
     *
     * @param String $title
     */
    public function setTitle($title)
    {
        $this->title = $title . " - ";
    }

    /**
     * Get the modules and their manifests as an array
     *
     * @return Array
     */
    public function getModules()
    {
        $this->loadModules();

        return $this->modules;
    }


    /**
     * Load and read all module manifests
     */
    public function loadModules()
    {
        if (empty($this->modules)) {
            foreach (glob("application/modules/*") as $file) {
                if (is_dir($file)) {
                    $name = $this->getModuleName($file);

                    $this->modules[$name] = @file_get_contents($file . "/manifest.json");

                    if (!$this->modules[$name]) {
                        die("The module <b>" . $name . "</b> is missing manifest.json");
                    } else {
                        $this->modules[$name] = json_decode($this->modules[$name], true);

                        // Add the module folder name as name if none was specified
                        if (!array_key_exists("name", $this->modules[$name])) {
                            $this->modules[$name]['name'] = $name;
                        }

                        // Add the enabled disabled setting, DEFAULT: disabled
                        if (!array_key_exists("enabled", $this->modules[$name])) {
                            $this->modules[$name]["enabled"] = false;
                        }

                        // Add default description if none was specified
                        if (!array_key_exists("description", $this->modules[$name])) {
                            $this->modules[$name]['description'] = "This module has no description";
                        }

                        // Check if the module has any configs
                        if ($this->hasConfigs($name)) {
                            $this->modules[$name]['has_configs'] = true;
                        } else {
                            $this->modules[$name]['has_configs'] = false;
                        }
                    }
                }
            }
        }
    }

    /**
     * Get the module name out of the path
     *
     * @param  String $path
     * @return String
     */
    private function getModuleName($path = "")
    {
        return preg_replace("/application\/modules\//", "", $path);
    }

    /**
     * Check if the module has any configs
     *
     * @param  String $moduleName
     * @return Boolean
     */
    public function hasConfigs($moduleName)
    {
        if (file_exists("application/modules/" . $moduleName . "/config")) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the menu of tools
     *
     * @return Array
     */
    private function getMenuLinks()
    {
        // Loop through all modules that have manifests
        foreach ($this->modules as $module => $manifest) {
            // Check if the admin and group keys exist
            if (
                array_key_exists("enabled", $manifest)
                && $manifest['enabled'] == true
                && array_key_exists("admin", $manifest)
            ) {
                if (array_key_exists("group", $manifest['admin'])) {
                    $manifest['admin'] = array($manifest['admin']['group']);
                }

                foreach ($manifest['admin'] as $menuGroup) {
                    // Check if the group name doesn't exist
                    if (!array_key_exists($menuGroup['text'], $this->menu)) {
                        // Create a new entry and populate it with the icon and an empty array for the links
                        $this->menu[$menuGroup['text']] = array(
                            'links' => array(),
                            'icon' => $menuGroup['icon']
                        );
                    }

                    // Loop through all links
                    foreach ($menuGroup['links'] as $key => $link) {
                        if (
                            !array_key_exists("requirePermission", $link)
                            || hasPermission($link['requirePermission'], $module)
                        ) {
                            $menuGroup['links'][$key]['module'] = $module;

                            // Find out if this is the current link
                            if ($module == $this->CI->router->fetch_module()) {
                                $url = $this->CI->router->fetch_class();


                                if ($this->CI->router->fetch_method() != "index") {
                                    $url .= "/" . $this->CI->router->fetch_method();
                                }

                                if ($url == $menuGroup['links'][$key]['controller']) {
                                    $menuGroup['links'][$key]['active'] = true;
                                    $this->currentPage = $module . "/" . $menuGroup['links'][$key]['controller'];
                                }
                            }

                            // Add them to the array
                            array_push($this->menu[$menuGroup['text']]['links'], $menuGroup['links'][$key]);
                        }
                    }

                    // Work-around to highlight dashboard - since it is not in the manifest
                    if (empty($this->currentPage) && $this->CI->router->fetch_module() == "admin") {
                        switch ($this->CI->router->fetch_class()) {
                            case "admin":
                                $this->currentPage = "admin/";
                                break;
                            case "settings":
                                $this->currentPage = "admin/settings";
                                break;
                            case "backups":
                                $this->currentPage = "admin/backups";
                                break;
                            case "modules":
                                $this->currentPage = "admin/modules";
                                break;
                        }
                    }
                }
            }
        }
    }

    /**
     * Loads the template
     *
     * @param String $content The page content
     * @param String $css Full path to your css file
     * @param String $js Full path to your js file
     */
    public function view($content, $css = false, $js = false)
    {
        if ($this->CI->input->is_ajax_request() && isset($_GET['is_json_ajax']) && $_GET['is_json_ajax'] == 1) {
            $array = array(
                "title" => ($this->title) ? $this->title : "",
                "content" => $content,
                "js" => $js,
                "css" => $css
            );

            die(json_encode($array));
        }

        $menu = $this->menu;
        if ($menu) {
            $menui = 1;
            foreach ($menu as $key => $value) {
                $menu[$key]['nr'] = $menui;
                $menui++;
                foreach ($menu[$key]['links'] as $lkey => $lvalue) {
                    if (isset($menu[$key]['links'][$lkey]['active'])) {
                        $menu[$key]['active'] = true;
                        break;
                    }
                }
            }
        }

        $notifications = $this->CI->cms_model->getNotifications($this->CI->user->getId(), true);
        //var_dump($notifications);

        // Gather the theme data
        $data = array(
            "page" => '<div id="content_ajax">' . $content . '</div>',
            "url" => $this->CI->template->page_url,
            "menu" => $menu,
            "title" => $this->title,
            "extra_js" => $js,
            "extra_css" => $css,
            "nickname" => $this->CI->user->getNickname(),
            "current_page" => $this->currentPage,
            "defaultLanguage" => $this->CI->config->item('language'),
            "languages" => $this->CI->language->getAllLanguages(),
            "serverName" => $this->CI->config->item('server_name'),
            "avatar"    => $this->CI->user->getAvatar($this->CI->user->getId()),
            "groups" => $this->CI->acl_model->getGroupsByUser(),
            "notifications" => $notifications,
            "cdn_link" => $this->CI->config->item('cdn') === true ? $this->CI->config->item('cdn_link') : null
        );

        // Load the main template
        $output = $this->CI->smarty->view($this->theme_path . "template.tpl", $data, true);

        die($output);
    }

    /**
     * Shorthand for loading a content box
     *
     * @param  String $title
     * @param  String $body
     * @param  Boolean $full
     * @return String
     */
    public function box($title, $body, $full = false, $css = false, $js = false)
    {
        $data = array(
            "headline" => $title,
            "content" => $body
        );

        $page = $this->CI->smarty->view($this->theme_path . "box.tpl", $data, true);

        if ($full) {
            $this->view($page, $css, $js);
        } else {
            return $page;
        }
    }

    /**
     * Get the FusionCMS version
     *
     * @return Float
     */
    public function getVersion()
    {
        return $this->CI->config->item('FusionCMSVersion');
    }

    /**
     * Get if the module is enabled or not
     *
     * @return Boolean
     */
    public function isEnabled($moduleName)
    {
        return $this->modules[$moduleName]["enabled"];
    }

    public function getEnabledModules()
    {
        $enabled = array();

        foreach ($this->getModules() as $name => $manifest) {
            if ($manifest['enabled']) {
                $enabled[$name] = $manifest;
            }
        }

        return $enabled;
    }

    public function getDisabledModules()
    {
        $disabled = array();

        foreach ($this->getModules() as $name => $manifest) {
            if (!array_key_exists("enabled", $manifest) || !$manifest['enabled']) {
                $disabled[$name] = $manifest;
            }
        }

        return $disabled;
    }

    /**
     * Make sure only admins and owners can access
     */
    private function showLogIn()
    {
        if (!$this->CI->session->userdata('admin_access') || !hasPermission("view", "admin")) {
            if ($this->CI->input->post('send')) {
                $this->logIn();
            } else {
                if (!$this->CI->input->is_ajax_request() && !isset($_GET['is_json_ajax'])) {
                    $data = array(
                        "url" => $this->CI->template->page_url,
                        "isOnline" => $this->CI->user->isOnline(),
                        "username" => $this->CI->user->getUsername(),
                        "avatar"    => $this->CI->user->getAvatar($this->CI->user->getId()),
                        "cdn_link" => $this->CI->config->item('cdn') === true ? $this->CI->config->item('cdn_link') : null
                    );

                    $output = $this->CI->smarty->view($this->theme_path . "login.tpl", $data, true);

                    die($output);
                } else {
                    die('<script>window.location.reload(true);</script>');
                }
            }
        }
    }
}
