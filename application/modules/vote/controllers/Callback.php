<?php

use MX\MX_Controller;

class Callback extends MX_Controller
{
    public function index($plugin): void
    {
        $plugin = strtolower($plugin);

        // Load the desired plugin dynamically
        $this->load->library($plugin);

        // Call the handleCallback method of the plugin
        $this->$plugin->handleCallback();
    }
}
