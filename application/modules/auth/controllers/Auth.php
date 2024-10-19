<?php

use App\Config\Services;
use CodeIgniter\Events\Events;
use MX\MX_Controller;

/**
 * Auth Controller Class
 * @property login_model $login_model login_model Class
 */
class Auth extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('security');
        $this->load->library('security');
        $this->load->library('form_validation');
        $this->load->library('captcha');
        $this->load->library('recaptcha');
        $this->load->library('GoogleAuthenticator');
        $this->load->model('login_model');

        requirePermission("view");
    }

    //Redirect to login
    public function index()
    {
        if ($this->user->isOnline())
        {
            redirect($this->template->page_url . "ucp");
        } else {
            redirect($this->template->page_url . "login");
        }
    }

    //Login page
    public function login()
    {
        if ($this->user->isOnline())
        {
            redirect($this->template->page_url . "ucp");
        }

        $use_captcha = $this->config->item('use_captcha');

        $data = [
            "use_captcha" => false,
            "captcha_type" => $this->config->item('captcha_type'),
            "recaptcha_html" => $this->recaptcha->getScriptTag() . $this->recaptcha->getWidget(),
            "has_smtp" => $this->config->item('has_smtp')
        ];

        if ($use_captcha || (int)Services::session()->get('attempts') >= $this->config->item('captcha_attemps')) {
            $data["use_captcha"] = true;
        }

        $this->template->view($this->template->loadPage("page.tpl", array(
                    "module" => "default", 
                    "headline" => lang("log_in", "auth"),
                    "class" => array("class" => "page_form"),
                    "content" => $this->template->loadPage("login.tpl", $data)
                )), "modules/auth/css/auth.css", "modules/auth/js/login.js");

    }

    public function register()
    {
        if ($this->user->isOnline())
        {
            redirect($this->template->page_url . "ucp");
        }

        die("register");
    }

    public function checkLogin()
    {
        if (!$this->input->is_ajax_request()) {
            die('No direct script access allowed');
        }

        $use_captcha = $this->config->item('use_captcha');
        $captcha_type = $this->config->item('captcha_type');
        $show_captcha = $use_captcha == true || (int)Services::session()->get('attempts') >= $this->config->item('captcha_attemps');

        $this->form_validation->set_rules('username', 'username', 'trim|required|min_length[4]|max_length[24]|alpha_numeric');
        $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[6]');

        if ($show_captcha && $captcha_type == 'inbuilt')
        {
            $this->form_validation->set_rules('captcha', 'captcha', 'trim|required|exact_length[7]|alpha_numeric');
        }

        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        $data = [
            "redirect" => false,
            "messages" => []
        ];

        if ($this->form_validation->run())
        {
            //Get the players IP address
            $ip_address = $this->input->ip_address();

            //Check if the IP address has been blocked
            $find = $this->login_model->getIP($ip_address);

            // Check attempts
            $this->increaseAttempts($ip_address);

            if ($find && (time() < $find['block_until']))
            {
                // The IP address is blocked, calculate remaining minutes
                $remaining_minutes = round(($find['block_until'] - time()) / 60);
                $data["messages"]["error"] = lang("ip_blocked", "auth") . "<br>" . lang("try_again", "auth") . " " . $remaining_minutes . " " . lang("minutes", "auth");
                die(json_encode($data));
            }

            //Check captcha
            if ($show_captcha)
            {
                $data['showCaptcha'] = true;
                if ($captcha_type == 'inbuilt' || !empty($this->input->post('captcha'))) {
                    if ($this->input->post('captcha') != $this->captcha->getValue() || empty($this->input->post('captcha'))) {
                        $data['messages']["error"] = lang("captcha_invalid", "auth");
                        die(json_encode($data));
                    }
                } else if ($captcha_type == 'recaptcha') {
                    $recaptcha = $this->input->post('recaptcha');
                    $result = $this->recaptcha->verifyResponse($recaptcha)['success'];
                    if (!$result) {
                        $data['messages']["error"] = lang("captcha_invalid", "auth") . $result;
                        die(json_encode($data));
                    }
                } else if ($captcha_type == 'recaptcha3') {
                    $recaptcha = $this->input->post('recaptcha');
                    $score = $this->recaptcha->verifyScore($recaptcha);
                    if($score < 0.5) {
                        $data['messages']["error"] = lang("captcha_invalid", "auth");
                        die(json_encode($data));
                    }
                }
            }

            $username = $this->input->post('username');
            $password = $this->input->post('password');

            //Login
            $sha_pass_hash = $this->user->getAccountPassword($username, $password);
            $check = $this->user->setUserDetails($username, $sha_pass_hash["verifier"]);

            //if no errors, login
            if ($check == 0)
            {
                $data["redirect"] = true;

                unset($_SESSION['captcha']);
                Services::session()->remove('attempts');

                // Remember me
                if (isset($_POST["remember"]))
                {
                    if($this->input->post("remember") == "true")
                    {
                        $this->input->set_cookie("fcms_username", $username, 60 * 60 * 24 * 365);
                        $this->input->set_cookie("fcms_password", $sha_pass_hash["verifier"], 60 * 60 * 24 * 365);
                    }
                }

                $this->external_account_model->setLastIp($this->user->getId(), $this->input->ip_address());

                Events::trigger('onLogin', $username);

                $this->login_model->deleteIP($ip_address);
                $this->dblogger->createLog("user", "login", "Login");
            }
            else
            {
                $this->dblogger->createLog("user", "login", "Login", [], Dblogger::STATUS_FAILED, $this->user->getId($username));
                $data["messages"]["error"] = lang("error", "auth");
            }
        }
        else
        {
            $data['messages']["error"] = validation_errors();
        }
        die(json_encode($data));
    }

    public function getCaptcha()
    {
        $this->captcha->generate();
        $this->captcha->output();
    }
    
    private function increaseAttempts($ip_address)
    {
        $find = $this->login_model->getIP($ip_address);
        
        Services::session()->set('attempts', Services::session()->get('attempts') + 1);

        if (!empty($find['attempts']))
        {
            //Update failed login attempts and last_attempt
            $ip_data = array(
                'attempts' => $find['attempts'] + 1,
                'last_attempt' => date('Y-m-d H:i:s'),
            );

            $this->login_model->updateIP($ip_address, $ip_data);
        }
        else
        {
            $ip_data = array(
                'ip_address' => $ip_address,
                'attempts' => 1,
                'last_attempt' => date('Y-m-d H:i:s'),
            );
            $this->login_model->insertIP($ip_data);
        }
        
        //Get new ip datas
        $find = $this->login_model->getIP($ip_address);

        if (!empty($find['attempts']) && $find['attempts'] >= $this->config->item('block_attemps'))
        {
            //Block the IP address
            $block_until = time() + ($this->config->item('block_duration') * 60);
            $block_data = array(
                'block_until' => $block_until
            );

            $this->login_model->updateIP($ip_address, $block_data);
        }
    }

    //Two-Factor page
    public function security()
    {
        if ($this->external_account_model->getTotpSecret() == null || ($this->user->getTotpSecret() == $this->external_account_model->getTotpSecret()))
        {
            redirect($this->template->page_url . "ucp");
        }

        clientLang("six_digit_not_empty", "security");

        $data = array(
            "module" => "default",
            "headline" => lang("two_factor", "security"),
            "class" => array("class" => "page_form"),
            "content" => $this->template->loadPage("security.tpl")
        );

        $this->template->view($this->template->loadPage("page.tpl", $data), "modules/auth/css/security.css", "modules/auth/js/security.js");
    }

    //Two-Factor page
    public function checkTotp()
    {
        if (!$this->input->is_ajax_request())
            exit('No direct script access allowed');

        $digit = $this->input->post('digit');

        $secret = $this->external_account_model->getTotpSecret();

        $googleObj = new GoogleAuthenticator();

        $result = $googleObj->verifyCode($secret, $digit);

        if ($result)
            $this->user->setTotpSecret($secret); // save to session

        $data = [
            'status' => $result,
            'icon' => ($result) ? 'success' : 'error',
            'text' => ($result) ? lang("verified", "security") : lang('six_digit_not_true', 'security')
        ];

        die(json_encode($data));
    }
}
