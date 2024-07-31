<?php

use MX\MX_Controller;

class Security extends MX_Controller
{
    public function __construct()
    {
        //Call the constructor of MX_Controller
        parent::__construct();

        if (!$this->config->item('totp_secret'))
            redirect('ucp');

        requirePermission("canUpdateAccountSettings");

        //Make sure that we are logged in
        $this->user->userArea();
        $this->load->library('GoogleAuthenticator');
    }

    public function index()
    {
        clientLang("six_digit_not_empty", "ucp");
        clientLang("changes_saved", "ucp");
        clientLang("six_digit_not_true", "ucp");

        $this->template->setTitle(lang("account_security", "ucp"));

        $google_obj = new GoogleAuthenticator();

        $secret = $google_obj->createSecret();

        $settings_data = array(
            'security_enabled' => !empty($this->user->getTotpSecret()) ? true : false,
            'secret_key' => $secret,
            'qr_code' => $google_obj->getQRCode($this->config->item('title') . ' - ' . $this->user->getUsername(), $secret),
        );

        $data = array(
            "module" => "default",
            "headline" => breadcrumb([
                            "ucp" => lang("ucp"),
                            "ucp/security" => lang("account_security", "ucp")
            ]),
            "content" => $this->template->loadPage("security.tpl", $settings_data)
        );

        $page = $this->template->loadPage("page.tpl", $data);

        //Load the template form
        $this->template->view($page, "modules/ucp/css/ucp.css", "modules/ucp/js/security.js");
    }

    public function submit()
    {
        $security_enabled = $this->input->post('security_enabled') == 'true';

        if ($security_enabled) {
            $auth_code = $this->input->post('auth_code');
            $secret = $this->input->post('secret');

            $google_obj = new GoogleAuthenticator();

            if ($this->config->item('totp_secret_name') == 'totp_secret' && $secret != null) {
                $encrypted = $google_obj->createTotpAes($secret);
                if (!$google_obj->verifyCode($encrypted, $auth_code))
                    die('no');
            } else {
                if (!$google_obj->verifyCode($secret, $auth_code))
                    die('no');
            }

            $this->user->setTotpSecret($secret, $this->user->getId());
        } else {
            $this->user->setTotpSecret(null, $this->user->getId());
        }

        die('yes');
    }
}
