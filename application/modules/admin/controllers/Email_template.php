<?php

defined('BASEPATH') or exit('This page does not exist');

use MX\MX_Controller;

/**
 * Email_template Controller Class
 * @property email_template_model $email_template_model email_template_model Class
 */
class Email_template extends MX_Controller
{
    public function __construct()
    {
        // Make sure to load the administrator library!
        $this->load->library('administrator');
        $this->load->model('email_template_model');
        $this->load->helper('file');

        parent::__construct();

        requirePermission("viewBackups");
    }

    public function index()
    {
        // Change the title
        $this->administrator->setTitle(lang('admin_email_templates', 'admin'));

        $templates = $this->email_template_model->getTemplates();

        // Prepare my data
        $data = array(
            'url' => $this->template->page_url,
            'templates' => $templates,
        );

        // Load my view
        $output = $this->template->loadPage("email_template/index.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->administrator->box(lang('admin_email_templates', 'admin'), $output);

        // Output my content. The method accepts the same arguments as template->view
        $this->administrator->view($content, false, "modules/admin/js/email_template.js");
    }

    public function edit($id)
    {
        // Change the title
        $this->administrator->setTitle(lang('admin_edit_template', 'admin'));

        if (!$id || !is_numeric($id)) {
            header('Location: ' . pageURL . 'admin/email_templates');
            die();
        }

        $template = $this->email_template_model->getTemplate($id);

        $content = read_file(APPPATH . '/views/email_templates/' . $template['template_name'] . '');

        // Prepare my data
        $data = array(
            'url' => $this->template->page_url,
            'content' => $content,
            'template' => $template
        );

        // Load my view
        $output = $this->template->loadPage("email_template/edit.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->administrator->box(lang('admin_edit_template', 'admin'), $output);

        // Output my content. The method accepts the same arguments as template->view
        $this->administrator->view($content, false, "modules/admin/js/email_template.js");
    }

    public function save($id)
    {
        $content = $this->input->post('code', false);
        $template = $this->email_template_model->getTemplate($id);

        if (empty($content)) {
            die("Content can't be empty!");
        }

        if (!write_file(APPPATH . '/views/email_templates/' . $template['template_name'] . '', $content)) {
            die('Unable to write the file');
        } else {
            die('yes');
        }
    }
}
