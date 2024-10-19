<?php

use App\Config\Services;
use CodeIgniter\Events\Events;
use MX\MX_Controller;

class Logout extends MX_Controller
{
    public function __construct()
    {
        //Call the constructor of MX_Controller
        parent::__construct();

        $this->user->userArea();

        $this->load->helper('cookie');
    }

    public function index()
    {
        $this->input->set_cookie("fcms_username", false);
        $this->input->set_cookie("fcms_password", false);
		
        $this->dblogger->createLog("user", "logout", "Logout");

        delete_cookie("fcms_username");
        delete_cookie("fcms_password");

        Services::session()->destroy();

        Events::trigger('onLogout');

        redirect($this->template->page_url);
    }
}
