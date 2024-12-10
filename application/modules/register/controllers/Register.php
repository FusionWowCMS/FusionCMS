<?php

use CodeIgniter\Events\Events;
use MX\MX_Controller;

/**
 * Register Controller Class
 * @property activation_model $activation_model activation_model Class
 */
class Register extends MX_Controller
{
    private $usernameError;
    private $emailError;

    public function __construct()
    {
        parent::__construct();

        // Make sure that we are not logged in yet
        $this->user->guestArea();

        requirePermission("view");

        $this->load->helper(array('form', 'url', 'security'));
        $this->load->library('form_validation');
        $this->load->library('recaptcha');

        $this->load->helper('email_helper');

        $this->load->config('captcha');

        $this->load->config('activation');
        $this->load->model('activation_model');
    }

    public function index()
    {
        clientLang("username_limit_length", "register");
        clientLang("username_limit", "register");
        clientLang("username_not_available", "register");
        clientLang("email_not_available", "register");
        clientLang("email_invalid", "register");
        clientLang("password_short", "register");
        clientLang("password_match", "register");

        $this->template->setTitle(lang("register", "register"));

        //Load the form validations for if they tried to sneaky bypass our js system
        $this->form_validation->set_rules('register_username', 'username', 'trim|required|min_length[4]|max_length[24]|alpha_numeric');
        $this->form_validation->set_rules('register_email', 'email', 'trim|required|valid_email');
        $this->form_validation->set_rules('register_password', 'password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('register_password_confirm', 'password confirmation', 'trim|required|matches[register_password]');

        $this->form_validation->set_error_delimiters('<img src="' . $this->template->page_url . 'application/images/icons/exclamation.png" data-tip="', '" />');

        require_once('application/libraries/Captcha.php');

        $use_captcha = $this->config->item('use_captcha');
        $captcha_type = $this->config->item('captcha_type');

        $captchaObj = new Captcha($use_captcha);
        $captcha = false;
        $recaptcha = '';

        Events::trigger('onRegisterPageOpened');

        if (count($_POST)) {
            $emailAvailable = $this->email_check($this->input->post('register_email'));
            $usernameAvailable = $this->username_check($this->input->post('register_username'));

            if ($use_captcha) {
                if ($captcha_type == 'recaptcha' || $captcha_type == 'recaptcha3') {
                    if($this->recaptcha->getEnabledRecaptcha()) {
                        $recaptcha = $this->input->post('g-recaptcha-response');
                        if ($captcha_type == 'recaptcha') {
                            $captcha = $this->recaptcha->verifyResponse($recaptcha)['success'];
                        } else if ($captcha_type == 'recaptcha3') {
                            $score = $this->recaptcha->verifyScore($recaptcha);
                            $captcha = $score > 0.5;
                        }
                    }
                    else
                        $recaptcha = 'disabled';
                } else if ($captcha_type == 'inbuilt') {
                    $captcha = strtoupper($this->input->post('register_captcha')) == strtoupper($captchaObj->getValue());
                }
            } else {
                $captcha = true;
            }

        } else {
            $emailAvailable = false;
            $usernameAvailable = false;
            $captcha = false;
        }

        //Check if everything went correct
        if (!$this->form_validation->run() || !$captcha || !count($_POST) || !$usernameAvailable || !$emailAvailable) {
            $fields = array('username', 'email', 'password', 'password_confirm');

            $data = [
                "username_error" => $this->usernameError,
                "email_error" => $this->emailError,
                "password_error" => "",
                "password_confirm_error" => "",
                "use_captcha" => $this->config->item('use_captcha'),
                "captcha_type" => $this->config->item('captcha_type'),
                "recaptcha_html" => $this->recaptcha->getScriptTag() . $this->recaptcha->getWidget(),
                "captcha_error" => "",
                "url" => $this->template->page_url
            ];

            if (count($_POST) > 0) {
                // Loop through fields and assign error or success image
                foreach ($fields as $field) {
                    if (strlen(form_error('register_' . $field)) == 0 && empty($data[$field . "_error"])) {
                        $data[$field . "_error"] = '<img src="' . $this->template->page_url . 'application/images/icons/accept.png" />';
                    } elseif (empty($data[$field . "_error"])) {
                        $data[$field . "_error"] = form_error('register_' . $field);
                    }
                }

                if ($captcha_type == 'recaptcha' || $captcha_type == 'recaptcha3') {
                    if(!$captcha && !$recaptcha == 'disabled') {
                        $data['captcha_error'] = true;
                    }
                } else if ($captcha_type == 'inbuilt') {
                    if ($this->input->post('register_captcha') != $captchaObj->getValue()) {
                        $data['captcha_error'] = '<img src="' . $this->template->page_url . 'application/images/icons/exclamation.png" />';
                    }
                }
            }

            // If not then display our page again
            $this->template->view($this->template->loadPage("page.tpl", [
                "module" => "default",
                "headline" => lang("account_creation", "register"),
                "content" => $this->template->loadPage("register.tpl", $data),
            ]), false, "modules/register/js/validate.js");
        } else {
            $username = $this->input->post('register_username');
            $password = $this->input->post('register_password');
            $email = $this->input->post('register_email');

            if (!$this->username_check($username)) {
                die();
            }

            // Show a success message
            $data = [
                "url" => $this->template->page_url,
                "account" => $username,
                "username" => $username,
                "email" => $email,
                "password" => $password,
                "email_activation" => $this->config->item('enable_email_activation')
            ];

            if($this->config->item('enable_email_activation'))
            {
                $key = $this->activation_model->add($username, $password, $email);

                $link = base_url().'register/activate/'.$key;

                sendMail($email, $this->config->item('server_name').': ' . lang('activate_account', 'register'), $username, lang('created_account_activate', 'register') . ' <a href="' . $link . '">' . $link . '</a>', 1);
            }
            else
            {
                //Register our user.
                $this->external_account_model->createAccount($username, $password, $email);

                Events::trigger('onCreateAccount', $username);

                // Log in
                $sha_pass_hash = $this->user->getAccountPassword($username, $password);
                $this->user->setUserDetails($username, $sha_pass_hash["verifier"]);
            }

            $title = ($data['email_activation']) ? lang("confirm_account", "register") : lang("created", "register");

            $this->template->view($this->template->box($title, $this->template->loadPage("register_success.tpl", $data)));
        }
    }

    public function email_check($email)
    {
        if (!$this->external_account_model->emailExists($email)) {
            $this->emailError = '';

            // The email does not exists so they can register
            return true;
        } else {
            // Email exists
            $this->emailError = '<img src="' . $this->template->page_url . 'application/images/icons/exclamation.png" data-tip="This email is not available" />';

            return false;
        }
    }

    public function username_check($username)
    {
        if (!$this->external_account_model->usernameExists($username)) {
            $this->usernameError = '';

            // The user does not exists so they can register
            return true;
        } else {
            // User exists
            $this->usernameError = '<img src="' . $this->template->page_url . 'application/images/icons/exclamation.png" data-tip="This username is not available" />';

            return false;
        }
    }

    public function activate($key = false)
    {
        if(!$key)
        {
            $this->template->box(lang("invalid_key", "register"), lang("invalid_key_long", "register"), true);
            return;
        }

        $account = $this->activation_model->getAccount($key);

        if(!$account)
        {
            $this->template->box(lang("invalid_key", "register"), lang("invalid_key_long", "register"), true);
            return;
        }

        $this->activation_model->remove($account['id'], $account['username'], $account['email']);

        $this->external_account_model->createAccount($account['username'], $account['password'], $account['email']);

        Events::trigger('onCreateAccount', $account['username']);

        // Log in
        $password = $this->user->getAccountPassword($account['username'], $account['password']);
        $this->user->setUserDetails($account['username'], $password["verifier"]);

        // Show success message
        $data = [
            "url" => $this->template->page_url,
            "account" => $account['username'],
            "username" => $account['username'],
            "email" => $account['email'],
            "password" => $account['password'],
            "email_activation" => false
        ];

        $title = lang("created", "register");

        $this->template->view($this->template->box($title, $this->template->loadPage("register_success.tpl", $data)));
    }
}
