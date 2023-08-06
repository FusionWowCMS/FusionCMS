<?php

class Donate extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->user->userArea();

        $this->load->config('paypal');
        $this->load->model('donate_model');
        $this->load->model('paypal_model');
    }

    public function index()
    {
        requirePermission("view");

        $this->template->setTitle(lang("donate_title", "donate"));

        $donate_paypal = $this->config->item('donate_paypal');

        $user_id = $this->user->getId();

        $paypal = array(
            "values" => $this->paypal_model->getDonations()
        );

        if ($this->input->post())
        {
            if ($this->input->post("donation_type") == "paypal")
            {
                $this->paypal_model->getDonate($this->input->post("data_id"));
            }
        }

        $data = array(
            "paypal" => $paypal,
            "user_id" => $user_id,
            "server_name" => $this->config->item('server_name'),
            "currency" => $this->config->item('donation_currency'),
            "currency_sign" => $this->config->item('donation_currency_sign'),
        );

        $data['use_paypal'] = (!empty($this->config->item("paypal_userid")) && !empty($this->config->item("paypal_secretpass")) && $this->config->item("use_paypal")) ? true : false;

        $output = $this->template->loadPage("donate.tpl", $data);

        // Load the topsite page and format the page contents
        $pageData = array(
            "module" => "default",
            "headline" => breadcumb(array(
                            "ucp" => lang("ucp"),
                            "donate" => lang("donate_panel", "donate")
                        )),
            "content" => $output
        );

        $page = $this->template->loadPage("page.tpl", $pageData);

        //Load the template form
        $this->template->view($page, "modules/donate/css/donate.css", "modules/donate/js/donate.js");
    }

    public function canceled()
    {
        $this->paypal_model->setCanceled($this->input->get("token"), '2');
        redirect(base_url('/donate'));
    }

    public function checkPaypal($id)
    {
        $this->paypal_model->check($id);
    }

    public function success()
    {
        $this->user->getUserData();

        $page = $this->template->loadPage("success.tpl", array('url' => $this->template->page_url));

        $this->template->box(lang("donate_thanks", "donate"), $page, true);
    }

    public function error()
    {
        $data = array('msg' => $this->session->userdata('paypal_error'));

        $page = $this->template->loadPage("error.tpl", $data);

        $this->template->box(lang("donate_error", "donate"), $page, true);
    }
}
