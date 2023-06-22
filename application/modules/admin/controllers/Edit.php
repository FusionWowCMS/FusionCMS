<?php

class Edit extends MX_Controller
{
    private $module;
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
     * @param String $module
     */
    public function index($module = false)
    {
        // Make sure the module exists and has configs
        if (
            !$module
            || !file_exists("application/modules/" . $module . "/")
            || !$this->administrator->hasConfigs($module)
        ) {
            die();
        }

        $this->module = $module;

        $this->loadModule();
        $this->loadConfigs();

        // Change the title
        $this->administrator->setTitle($this->manifest['name']);

        $data = array(
            "configs" => $this->configs,
            "moduleName" => $module,
            "url" => $this->template->page_url
        );

        // Load my view
        $output = $this->template->loadPage("config.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->administrator->box('<a href="' . $this->template->page_url . 'admin/modules">Modules</a> &rarr; Edit &rarr; ' . $this->manifest['name'], $output);

        // Output my content. The method accepts the same arguments as template->view
        $this->administrator->view($content, false, "modules/admin/js/settings.js");
    }

    /**
     * Load the module manifest
     */
    private function loadModule()
    {
        $this->manifest = @file_get_contents("application/modules/" . $this->module . "/manifest.json");

        if (!$this->manifest) {
            die("The module <b>" . $this->module . "</b> is missing manifest.json");
        } else {
            $this->manifest = json_decode($this->manifest, true);

            // Add the module folder name as name if none was specified
            if (!array_key_exists("name", $this->manifest)) {
                $this->manifest['name'] = ucfirst($this->module);
            }
        }
    }

    /**
     * Load the module configs
     */
    private function loadConfigs()
    {
        foreach (glob("application/modules/" . $this->module . "/config/*") as $file) {
            if ($file == 'application/modules/' . $this->module . '/config/' . 'routes.php')
                continue;

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
        return preg_replace("/application\/modules\/" . $this->module . "\/config\/([A-Za-z0-9_-]*)\.php/", "$1", $path);
    }

    public function save($module = false, $name = false)
    {
        if (!$name || !$module || !$this->configExists($module, $name)) {
            die("Invalid module or config name");
        } else {
            if ($this->input->post()) {
                $fusionConfig = new ConfigEditor("application/modules/" . $module . "/config/" . $name . ".php");

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

    public function saveSource($module = false, $name = false)
    {
        if (!$name || !$module || !$this->configExists($module, $name)) {
            die("Invalid module or config name");
        } else {
            if ($this->input->post("source")) {
                $file = fopen("application/modules/" . $module . "/config/" . $name . ".php", "w");
                fwrite($file, $this->input->post("source"));
                fclose($file);

                $file = file("application/modules/" . $module . "/config/" . $name . ".php");
                $file[0] = str_replace("&lt;", "<", $file[0]);
                file_put_contents("application/modules/" . $module . "/config/" . $name . ".php", $file);

                die("yes");
            } else {
                die("No data to set");
            }
        }
    }

    private function configExists($module, $file)
    {
        if (file_exists("application/modules/" . $module . "/config/" . $file . ".php")) {
            return true;
        } else {
            return false;
        }
    }
}
