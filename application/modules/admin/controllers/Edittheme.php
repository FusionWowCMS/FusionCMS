<?php

class EditTheme extends MX_Controller
{
    private $theme;
    private $manifest;
    private $configs;

    public function __construct()
    {
        // Make sure to load the administrator library!
        $this->load->library('administrator');

        parent::__construct();

        requirePermission("editModuleConfigs");

        require_once('application/libraries/Configeditor.php');
    }

    /**
     * Output the configs
     *
     * @param String $theme
     */
    public function index($theme = false)
    {
        // Make sure the theme exists and has configs
        if (
            !$theme
            || !file_exists("application/themes/" . $theme . "/")
            || !$this->hasConfigs($theme)
        ) {
            die();
        }

        $this->theme = $theme;

        $this->loadTheme();
        $this->loadConfigs();

        // Change the title
        $this->administrator->setTitle($this->manifest['name']);

        $data = array(
            "configs" => $this->configs,
            "themeName" => $theme,
            "url" => $this->template->page_url
        );

        // Load my view
        $output = $this->template->loadPage("config_theme.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->administrator->box('<a href="' . $this->template->page_url . 'admin/theme">Theme</a> &rarr; Edit Config ' . $this->manifest['name'], $output);

        // Output my content. The method accepts the same arguments as template->view
        $this->administrator->view($content, false, "modules/admin/js/settings.js");
    }

    /**
     * Load the theme manifest
     */
    private function loadTheme()
    {
        $this->manifest = @file_get_contents("application/themes/" . $this->theme . "/manifest.json");

        if (!$this->manifest) {
            die("The theme <b>" . $this->theme . "</b> is missing manifest.json");
        } else {
            $this->manifest = json_decode($this->manifest, true);

            // Add the theme folder name as name if none was specified
            if (!array_key_exists("name", $this->manifest)) {
                $this->manifest['name'] = ucfirst($this->theme);
            }
        }
    }

    /**
     * Load the theme configs
     */
    private function loadConfigs()
    {
        foreach (glob("application/themes/" . $this->theme . "/config/*") as $file) {
            $this->getConfig($file);
        }
    }

    /**
     * Load the config into the function variable scope and assign it to the configs array
     */
    private function getConfig($file)
    {
        include($file);

        $this->configs[$this->getConfigName($file)] = $config;
        $this->configs[$this->getConfigName($file)]['source'] = $this->getConfigSource($file);
    }

    private function getConfigSource($file)
    {
        $handle = fopen($file, "r");
        $data = fread($handle, filesize($file));
        fclose($handle);

        return $data;
    }

    /**
     * Get the config name out of the path
     *
     * @param  String $path
     * @return String
     */
    private function getConfigName($path = "")
    {
        return preg_replace("/application\/themes\/" . $this->theme . "\/config\/([A-Za-z0-9_-]*)\.php/", "$1", $path);
    }

    public function save($theme = false, $name = false)
    {
        if (!$name || !$theme || !$this->configExists($theme, $name)) {
            die("Invalid theme or config name");
        } else {
            if ($this->input->post()) {
                $fusionConfig = new ConfigEditor("application/themes/" . $theme . "/config/" . $name . ".php");

                foreach ($this->input->post() as $key => $value) {
                    $fusionConfig->set($key, $value);
                }

                $fusionConfig->save();

                die("yes");
            } else {
                die("No data to set");
            }
        }
    }

    public function saveSource($theme = false, $name = false)
    {
        if (!$name || !$theme || !$this->configExists($theme, $name)) {
            die("Invalid theme or config name");
        } else {
            if ($this->input->post("source")) {
                $file = fopen("application/themes/" . $theme . "/config/" . $name . ".php", "w");
                fwrite($file, $this->input->post("source"));
                fclose($file);

                $file = file("application/themes/" . $theme . "/config/" . $name . ".php");
                $file[0] = str_replace("&lt;", "<", $file[0]);
                file_put_contents("application/themes/" . $theme . "/config/" . $name . ".php", $file);

                die("yes");
            } else {
                die("No data to set");
            }
        }
    }

    private function configExists($theme, $file)
    {
        if (file_exists("application/themes/" . $theme . "/config/" . $file . ".php")) {
            return true;
        } else {
            return false;
        }
    }

    public function hasConfigs($theme)
    {
        if (file_exists("application/themes/" . $theme . "/config")) {
            return true;
        } else {
            return false;
        }
    }
}
