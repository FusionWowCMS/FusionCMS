<?php

class Auth extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('security');
        $this->load->library('security');
        $this->load->library('form_validation');
        $this->load->library('captcha');
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

        $data = array(
            "use_captcha" => false,
            "captcha_type" => $this->config->item('captcha_type'),
            "has_smtp" => $this->config->item('has_smtp')
        );

        if ($this->config->item("use_captcha") == true || (int)$this->session->userdata('attempts') >= $this->config->item('captcha_attemps')) {
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
        $this->form_validation->set_rules('username', 'username', 'trim|required|min_length[4]|max_length[24]|xss_clean|alpha_numeric');
        $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[6]|xss_clean');

        if ($this->config->item("use_captcha") == true || (int)$this->session->userdata('attempts') >= $this->config->item('captcha_attemps'))
        {
            $this->form_validation->set_rules('captcha', 'captcha', 'trim|required|exact_length[7]|alpha_numeric');
        }

        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        $data = array(
            "redirect" => false,
            "messages" => false
        );

        if (isset($_POST["submit"]) && $this->form_validation->run())
        {
            //Get the players IP address
            $ip_address = $this->input->ip_address();

            //Check if the IP address has been blocked
            $find = $this->login_model->getIP($ip_address);

            if ($find)
            {
                if (time() < $find['block_until'])
                {
                    // The IP address is blocked, calculate remaining minutes
                    $remaining_minutes = round(($find['block_until'] - time()) / 60);
                    $data["messages"]["error"] = lang("ip_blocked", "auth") . "<br>" . lang("try_again", "auth") . " " . $remaining_minutes . " " . lang("minutes", "auth");
                    die(json_encode($data));
                }
            }

            //Check if show captcha
            if ($this->config->item("use_captcha") == true || (int)$this->session->userdata('attempts') >= $this->config->item('captcha_attemps'))
            {
                $data['showCaptcha'] = true;
            }

            //Check captcha
            if ($this->config->item("use_captcha") == true || (int)$this->session->userdata('attempts') >= $this->config->item('captcha_attemps'))
            {
                if ($this->input->post('captcha') != $this->captcha->getValue() || empty($this->input->post('captcha')))
                {
                    $this->increaseAttempts($ip_address);
                    $data['messages']["error"] = lang("captcha_invalid", "auth");
                    die(json_encode($data));
                }
            }

            //Check password
            $existsUser = $this->external_account_model->usernameExists($this->input->post("username"));
            if ($existsUser)
            {
                if ($this->input->post("password") != "")
                {
                    $userId = $this->user->getId($this->input->post("username"));
                    $sha_pass_hash = $this->user->createHash($this->input->post("username"), $this->input->post("password"));

                    if (strtoupper($this->external_account_model->getInfo($userId, "password")["password"]) != strtoupper($sha_pass_hash["verifier"]))
                    {
                        if (isset($_POST["submit"]) && $this->input->post("submit") == "true")
                        {
                            $this->increaseAttempts($ip_address);
                            if ($this->config->item("use_captcha") == true || (int)$this->session->userdata('attempts') >= $this->config->item('captcha_attemps'))
                            {
                                $data["showCaptcha"] = true;
                            }
                            $this->logger->createLog("user", "login", "Login", [], Logger::STATUS_FAILED, $this->user->getId($this->input->post("username")));
                            $data["messages"]["error"] = lang("error", "auth");
                            die(json_encode($data));
                        }
                    }
                }
            }
            else
            {
                $this->increaseAttempts($ip_address);
                if ($this->config->item("use_captcha") == true || (int)$this->session->userdata('attempts') >= $this->config->item('captcha_attemps'))
                {
                    $data["showCaptcha"] = true;
                }
                $data["messages"]["error"] = lang("error", "auth");
                die(json_encode($data));
            }

            //Check csrf
            if ($this->input->post("token") != $this->security->get_csrf_hash())
            {
                $this->increaseAttempts($ip_address);
                $data["messages"]["error"] = "";
                die(json_encode($data));
            }

            //Login
            if ($this->input->post("submit") == "true")
            {
                $sha_pass_hash = $this->user->createHash($this->input->post('username'), $this->input->post('password'));
                $check = $this->user->setUserDetails($this->input->post('username'), $sha_pass_hash["verifier"]);

                //if no errors, login
                if ($check == 0)
                {
                    $data["redirect"] = true;

                    unset($_SESSION['captcha']);
                    $this->session->unset_userdata('attempts');

                    // Remember me
                    if (isset($_POST["remember"]))
                    {
                        if($this->input->post("remember") == "true")
                        {
                            $this->input->set_cookie("fcms_username", $this->input->post('username'), 60 * 60 * 24 * 365);
                            $this->input->set_cookie("fcms_password", $sha_pass_hash["verifier"], 60 * 60 * 24 * 365);
                        }
                    }

                    $this->external_account_model->setLastIp($this->user->getId(), $this->input->ip_address());
                    $this->plugins->onLogin($this->input->post('username'));
                    $this->login_model->deleteIP($ip_address);
                    $this->logger->createLog("user", "login", "Login");

                    die(json_encode($data));
                }
            }
        }
        else
        {
            $data['messages']["error"] = validation_errors();
            die(json_encode($data));
        }
    }

    public function getCaptcha()
    {
        $this->captcha->generate();
        $this->captcha->output();
    }
    
    private function increaseAttempts($ip_address)
    {
        $find = $this->login_model->getIP($ip_address);
        
        $this->session->set_userdata('attempts', $this->session->userdata('attempts') + 1);

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
}
