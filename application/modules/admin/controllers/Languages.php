<?php

class Languages extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library("administrator");

        requirePermission("viewLanguages");
    }

    /**
     * Loads the page
     */
    public function index($default = false)
    {
        $this->administrator->setTitle("Available languages");

        $data = array(
            'languages' => $this->language->getAllLanguages(),
            'default' => ($default) ? $default : $this->config->item('language')
        );

        $output = $this->template->loadPage("languages/languages.tpl", $data);

        $content = $this->administrator->box('Available languages', $output);

        $this->administrator->view($content, false, "modules/admin/js/languages.js");
    }

    public function set()
    {
        $language = $this->input->post('language');

        requirePermission("changeDefaultLanguage");

        require_once('application/libraries/Configeditor.php');

        if (!$language || !is_dir("application/language/" . $language)) {
            die("Invalid language");
        }

        $fusionConfig = new ConfigEditor("application/config/language.php");
        $fusionConfig->set("language", $language);
        $fusionConfig->save();

        die('success');
    }
}
