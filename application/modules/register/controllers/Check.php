<?php

class Check extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->user->guestArea();
    }

    public function username($value = false)
    {
        if ($value != false) {
            if (!$this->external_account_model->usernameExists($value)) {
                die("1");
            } else {
                die("0");
            }
        }
    }

    public function email()
    {
        $value = $this->input->post("email");

        if ($value != false) {
            if (!$this->external_account_model->emailExists($value)) {
                die("1");
            } else {
                die("0");
            }
        }
    }
}
