<?php

class Status_refresh extends MX_Controller
{
    /**
     * Called via AJAX
     */
    public function index()
    {
        // Force refresh
        die($this->view());
    }

    public function view()
    {
        // Load realm objects
        $realms = $this->realms->getRealms();

        // Prepare data
        $data = array(
                    "module" => "sidebox_status",
                    "realms" => $realms,
                    "realmlist" => $this->config->item('realmlist')
                );

        // Load the template file and format
        $out = $this->template->loadPage("status.tpl", $data);

        return $out;
    }
}
