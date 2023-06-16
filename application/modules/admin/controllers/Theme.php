<?php

class Theme extends MX_Controller
{
    public function __construct()
    {
        // Make sure to load the administrator library!
        $this->load->library('administrator');

        parent::__construct();

        require_once('application/libraries/Configeditor.php');

        requirePermission("changeTheme");
    }

    public function index()
    {
        // Change the title
        $this->administrator->setTitle("Select theme");

        // Prepare my data
        $data = array(
            'url' => $this->template->page_url,
            'themes' => $this->getThemes(),
            'current_theme' => $this->config->item('theme')
        );

        // Load my view
        $output = $this->template->loadPage("theme.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->administrator->box('Select theme', $output);

        // Output my content. The method accepts the same arguments as template->view
        $this->administrator->view($content, "modules/admin/css/theme.css", "modules/admin/js/theme.js");
    }

    private function getThemes()
    {
        $themes = glob("application/themes/*");
        $themesArr = array();

        foreach ($themes as $key => $value) {
            $value = preg_replace("/application\/themes\/([A-Za-z_-]*)/", "$1", $value);

            //Check if folder
            if (!is_dir("application/themes/" . $value)) {
                continue;
            }

            if (file_exists("application/themes/" . $value . "/manifest.json")) {
                $manifest = json_decode(file_get_contents("application/themes/" . $value . "/manifest.json"), true);
                $manifest['folderName'] = $value;

                array_push($themesArr, $manifest);
            }
        }

        return $themesArr;
    }

    public function set($theme = false)
    {
        if (!$theme || !file_exists("application/themes/" . $theme)) {
            die('Invalid theme');
        }

        $fusionConfig = new ConfigEditor("application/config/fusion.php");
        $fusionConfig->set('theme', $theme);
        $fusionConfig->save();

        $this->cache->delete('*.cache');
        $this->cache->delete('search/*.cache');

        die('yes');
    }
}
