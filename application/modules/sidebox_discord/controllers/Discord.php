<?php

class Discord extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->config('sidebox_discord/discord');
    }

    public function view()
    {
        $data = array(
            "module" => "sidebox_discord",
            "url" => $this->template->page_url,
            "style" => $this->config->item('style'),
            "server_id" => $this->config->item('server_id'),
            "invite_link" => $this->config->item('invite_link'),
        );

        return $this->template->loadPage("sidebox_discord.tpl", $data);
    }
}
