<?php

class Online_players_extended extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->config('sidebox_online_players_extended/server_online_players');
    }

    public function view()
    {
        // $this->template->add_css('modules/sidebox_online_players_extended/assets/css/online-players.css');

        $out = $this->template->loadPage("status_wrapper.tpl", array(
            "module" => "sidebox_online_players_extended",
            "auto_refresh" => $this->config->item('auto_refresh_online_players'),
            "auto_refresh_interval" => $this->config->item('auto_refresh_interval_in_seconds')
        ));

        return $out;
    }
}
