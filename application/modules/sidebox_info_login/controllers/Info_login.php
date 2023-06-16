<?php

class Info_login extends MX_Controller
{
    public function view()
    {
        if ($this->config->item("use_captcha") == true || (int)$this->session->userdata('attempts') >= $this->config->item('captcha_attemps')) {
            $data["use_captcha"] = true;
        }

        if ($this->user->isOnline()) {
            $data = array(
                    "module" => "sidebox_info_login",
                    "url" => $this->template->page_url,
                    "currentIp" => $this->input->ip_address(),
                    "lastIp" => $this->user->getLastIp(),
                    "vp" => $this->user->getVp(),
                    "dp" => $this->user->getDp()
                );

            $page = $this->template->loadPage("info.tpl", $data);
        } else {
            $this->load->helper('form');

            $data = array(
                    "module" => "sidebox_info_login",
                    "url" => $this->template->page_url,
                    "use_captcha" => false,
                    "has_smtp" => $this->config->item('has_smtp')
                );
                
            if ($this->config->item("use_captcha") == true || (int)$this->session->userdata('attempts') >= $this->config->item('captcha_attemps')) {
                $data["use_captcha"] = true;
            }

            $page = $this->template->loadPage("login.tpl", $data);
        }

        return $page;
    }
}
