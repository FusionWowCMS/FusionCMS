<?php

class Online extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        requirePermission("view");
    }

    public function index()
    {
        $this->template->setTitle(lang("online_players", "online"));

        // Perform ajax call to refresh if expired
        if ($this->cache->hasExpired("online_module")) {
            // Prepare data
            $data = array(
                "module" => "online",
                "image_path" => $this->template->image_path
            );

            // Load the template file and format
            $ajax = $this->template->loadPage("ajax.tpl", $data);

            // Load the topsite page and format the page contents
            $data2 = array(
                "module" => "default",
                "headline" => lang("online_players", "online"),
                "content" => $ajax
            );

            $page = $this->template->loadPage("page.tpl", $data2);
        } else {
            $cache = $this->cache->get("online_module");
            $page = $cache;
        }

        //Load the template form
        $this->template->view($page, "modules/online/css/online.css", "modules/online/js/sort.js");
    }
}
