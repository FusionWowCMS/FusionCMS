<?php

use MX\MX_Controller;

class Errors extends MX_Controller
{
    public function index()
    {
        if (isset($this->template))
            $this->template->show404();
        else
            show_404('', false);
    }
}
