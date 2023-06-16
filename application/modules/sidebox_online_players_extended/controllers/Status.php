<?php

class Status extends CI_Controller
{
    private $connection = null;

    public function __construct()
    {
        parent::__construct();
        $this->load->config('server_online_players');
        $this->load->helper('date');
        $this->load->model('external_account_model');
    }

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

        $total = 0;
        foreach ($realms as $realm)
        {
            if ($realm->isOnline(true))
            {
                $count = $realm->getOnline();
                $total += $count;
            }
        }

        $uptimes = $this->flush_uptime($realms);

        // Prepare data
        $data = array(
            "module" => "sidebox_online_players_extended",
            "realms" => $realms,
            "uptimes" => $uptimes,
            "total" => $total,
            "realmlist" => $this->config->item('realmlist'),
            "show_uptime" => $this->config->item('show_uptime'),
            "bar_height" => $this->config->item('horizontal_bar_height'),
        );

        // Load the template file and format
        $out = $this->template->loadPage("status.tpl", $data);

        return $out;
    }

    private function flush_uptime($realms)
    {
        $uptimes = array();
        foreach ($realms as $k => $realm) {
            $uptimes[$realm->getId()] = $this->uptime($realm->getId());
        }
        return $uptimes;
    }

    private function uptime($realm_id)
    {
        $this->connection = $this->load->database("account", true);
        $this->connection->where('realmid', $realm_id);
        $query = $this->connection->get('uptime');
        $last = $query->last_row('array');
        if (isset($last)) {
            $first_date = new DateTime(date('Y-m-d h:i:s', $last['starttime']));
            $second_date = new DateTime(date('Y-m-d h:i:s'));

            $difference = $first_date->diff($second_date);

            return $this->format_interval($difference);
        } else {
            return "Offline";
        }
    }

    private function format_interval(DateInterval $interval)
    {
        $result = "";
        if ($interval->y) {
            $result .= $interval->format("<span>%y</span>y ");
        }
        if ($interval->m) {
            $result .= $interval->format("<span>%m</span>m ");
        }
        if ($interval->d) {
            $result .= $interval->format("<span>%d</span>d ");
        }
        if ($interval->h) {
            $result .= $interval->format("<span>%h</span>h ");
        }
        if ($interval->i) {
            $result .= $interval->format("<span>%i</span>m ");
        }
        if ($interval->s) {
            $result .= $interval->format("<span>%s</span>s ");
        }

        return $result;
    }
}
