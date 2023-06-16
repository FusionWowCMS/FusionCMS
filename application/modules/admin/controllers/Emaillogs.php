<?php

class Emaillogs extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('dashboard_model');

        $this->load->library('administrator');
    }

    public function index()
    {
        $emaillogs = $this->dashboard_model->getEmailLogs();

        $data = array(
            'emaillogs' => $emaillogs
        );

        $output = $this->template->loadPage("emaillogs.tpl", $data);

        $content = $this->administrator->box('Email logs', $output);

        $this->administrator->view($content, false, false);
    }
}
