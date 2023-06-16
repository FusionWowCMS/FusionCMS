<?php

class Online_refresh extends MX_Controller
{
    public function index()
    {
        $cache = $this->cache->get("online_module");

        if ($cache !== false) {
            $page = $cache;
        } else {
            $online_data = array(
                "realms" => $this->realms->getRealms(),
                "url" => $this->template->page_url,
                "realmsObj" => $this->realms
            );

            $page = $this->template->loadPage("online.tpl", $online_data);

            // Load the topsite page and format the page contents
            $data = array(
                "module" => "default",
                "headline" => lang("online_players", "online"),
                "content" => $page
            );

            $cache = $this->template->loadPage("page.tpl", $data);

            $this->cache->save("online_module", $cache, 60 * 5);
        }

        //Load the template form
        die($page);
    }
}
