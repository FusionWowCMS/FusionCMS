<?php

use MX\MX_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

class Captcha extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('FusionCaptcha');
    }

    public function challenge()
    {
        $this->output->set_content_type('application/json');

        $this->fusioncaptcha->set_cors_headers();
        $result = $this->fusioncaptcha->generate_challenge();

        $this->output->set_output(json_encode($result));
    }

    public function redeem()
    {
        $this->output->set_content_type('application/json');

        $data = json_decode(file_get_contents('php://input'), true);

        $this->fusioncaptcha->set_cors_headers();
        $result = $this->fusioncaptcha->verify_solutions((string) ($data['token'] ?? ''), (array) ($data['solutions'] ?? []));

        $this->output->set_output(json_encode($result));
    }
}