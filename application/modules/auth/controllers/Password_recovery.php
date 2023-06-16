<?php

class Password_recovery extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('password_recovery_model');

        $this->load->helper('email_helper');

        $this->load->library('security');
        $this->load->library('form_validation');

        $this->user->guestArea();

        requirePermission("view");

        if (!$this->config->item('has_smtp'))
        {
            redirect('errors');
        }
    }

    public function index()
    {
        clientLang("email_sent", "recovery");

        $this->template->setTitle(lang("password_recovery", "recovery"));

        $data = [];

        $content = $this->template->loadPage("password_recovery.tpl", $data);
        $box = $this->template->box(lang("password_recovery", "recovery"), $content);
        $this->template->view($box, "modules/auth/css/recovery.css", "modules/auth/js/recovery.js");
    }

    public function create_request()
    {        
        $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');

        $this->form_validation->set_error_delimiters('', '');
        
        $data = [
            "messages" => false,
            "success" => false
        ];

        if ($this->form_validation->run())
        {
            //Check csrf
            if ($this->input->post("token") != $this->security->get_csrf_hash())
            {
                $data['messages']["error"] = 'Something went wrong. Please reload the page.';
                die(json_encode($data));
            }
            
            $email = $this->input->post("email");
            
            if ($this->external_account_model->emailExists($email))
            {
                $username = $this->password_recovery_model->get_username($email);
                $token = $this->generate_token($username, $email);

                $link = base_url() . 'password_recovery/reset_password?token=' . $token;
                sendMail($email, $this->config->item('server_name') . ': ' . lang("reset_password", "recovery"), $username, lang("email", "recovery") . ' <a href="' . $link . '">' . $link . '</a>', 1);

                $this->password_recovery_model->insert_token($token, $username, $email, $this->input->ip_address());
                $this->logger->createLog("user", "recovery", "Password recovery requested", [], Logger::STATUS_SUCCEED, $this->user->getId($this->input->post("username")));
            }
            
            $data['messages']["success"] = lang("email_sent", "recovery");
            die(json_encode($data));
        }
        else
        {
            $data['messages']["error"] = validation_errors();
            die(json_encode($data));
        }
    }

    public function reset_password()
    {
        clientLang("password_changed", "recovery");

        $this->form_validation->set_rules('token', 'token', 'trim|required');
        $this->form_validation->set_rules('new_password', 'new_password', 'trim|required|min_length[6]');

        $this->form_validation->set_error_delimiters('', '');

        if ($this->input->method() === 'post')
        {
            if ($this->form_validation->run())
            {
                $new_password = $this->input->post('new_password');
                $token = $this->input->post('token');
                $token_data = $this->password_recovery_model->get_token($token);

                if ($this->input->post("csrf_token") != $this->security->get_csrf_hash())
                {
                    $data['messages']["error"] = 'Something went wrong. Please reload the page.';
                    die(json_encode($data));
                }

                if (!$token_data)
                {
                    $data['messages']["error"] = lang('invalid', 'recovery');
                    die(json_encode($data));
                }

                $hash = $this->user->createHash($token_data['username'], $new_password);
                $this->external_account_model->setPassword($token_data['username'], $hash["verifier"]);
                
                $this->logger->createLog("user", "recovery", "Password changed via reset", [], Logger::STATUS_SUCCEED, $this->user->getId($token_data['username']));

                $this->password_recovery_model->delete_token($token);

                $data['messages']["success"] = lang("password_reset_success", "recovery");
                die(json_encode($data));
            }
            else
            {
                $data['messages']["error"] = validation_errors();
                die(json_encode($data));
            }
        }

        $this->template->setTitle(lang("password_reset", "recovery"));

        $data = [];
        $data['token'] = $this->input->get('token');

        $content = $this->template->loadPage("password_reset.tpl", $data);
        $box = $this->template->box(lang("password_reset", "recovery"), $content);
        $this->template->view($box, "modules/auth/css/recovery.css", "modules/auth/js/recovery.js");
    }

    private function generate_token($username, $email)
    {
        $timestamp = time();
        $random_string = bin2hex(random_bytes(32));
        $token = hash('sha512', $username . $email . $timestamp . $random_string);
        return $token;
    }
}
