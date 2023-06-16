<?php

class Message extends MX_Controller
{
    public function __construct()
    {
        // Make sure to load the administrator library!
        $this->load->library('administrator');

        require_once('application/libraries/Configeditor.php');

        parent::__construct();

        requirePermission("viewMessage");
    }

    public function index()
    {
        // Change the title
        $this->administrator->setTitle("Global maintenance");

        // Prepare my data
        $data = array(
            'url' => $this->template->page_url,
            'message_enabled' => $this->config->item('message_enabled'),
            'message_headline' => $this->config->item('message_headline'),
            'message_headline_size' => $this->config->item('message_headline_size'),
            'message_text' => $this->config->item('message_text')
        );

        // Load my view
        $output = $this->template->loadPage("message.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->administrator->box('Global maintenance', $output);

        // Output my content. The method accepts the same arguments as template->view
        $this->administrator->view($content, "modules/admin/css/message.css", "modules/admin/js/settings.js");
    }

    public function save()
    {
        requirePermission("toggleMessage");

        $fusionConfig = new ConfigEditor("application/config/message.php");

        $fusionConfig->set('message_enabled', $this->input->post('message_enabled'));
        $fusionConfig->set('message_headline', $this->input->post('message_headline'));
        $fusionConfig->set('message_headline_size', $this->input->post('message_headline_size'));
        $fusionConfig->set('message_text', $this->input->post('message_text'));

        $fusionConfig->save();

        die("The settings has been saved!");
    }
}
