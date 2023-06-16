<?php

class Mod extends MX_Controller
{
    private $tickets;
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('text');
        $this->load->model('tickets_model');
        $this->load->library('moderator');
        requirePermission("view");
    }

    public function index()
    {
        $this->moderator->setTitle("Mod Panel");

        $modlogs = $this->logger->getModLogs();

        // Prepare my data
        $data = array(
            'url' => pageURL,
            'modlogs' => $modlogs,
            'tickets' => $this->getTickets(),
        );

        // Load my view
        $output = $this->template->loadPage("dashboard.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->moderator->box('Mod Panel', $output);

        $this->moderator->view($output, false, "modules/mod/js/mod.js");
    }

    private function getTickets()
    {
        $tickets = array();
        foreach ($this->realms->getRealms() as $realm) {
            $tickets[] = array(
                "realmName" => $realm->getName(),
                "emulator" => lcfirst(substr(get_class($realm->getEmulator()), 0, strpos(get_class($realm->getEmulator()), '_'))),
                "tickets" => $this->tickets_model->getTickets($realm)
            );
        }
        $data = $tickets;

        return $data;
    }
}
