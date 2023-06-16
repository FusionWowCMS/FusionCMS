<?php

class Status extends MX_Controller
{
    public function view()
    {
        // Perform ajax call to refresh if expired
        if (
            $this->cache->hasExpired("online_*", "/online_([0-9]*)\.cache$/")
            && $this->cache->hasExpired("isOnline_*", "/isOnline_([0-9]*)\.cache$/")
        ) {
            // Prepare data
            $data = array(
                        "module" => "sidebox_status",
                        "image_path" => $this->template->image_path
                    );

            // Load the template file and format
            $out = $this->template->loadPage("ajax.tpl", $data);
        } else {
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
        }

        return $out;
    }
}
