<?php

use MX\MX_Controller;

class History extends MX_Controller
{
	public function __construct()
	{
		parent::__construct();

		requirePermission("view");
	}

	public function index(): void
    {
        $gmLogs = $this->dblogger->getGMLogs();

        $data = array(
            'url' => pageURL,
            'link_active' => 'history',
            'gmLogs' => $gmLogs,
        );

        $content = $this->template->loadPage('history.tpl', $data);

        $output = $this->template->box(breadcumb(array(
            "gm" => lang("gm_panel", "gm"),
            "gm/history" => lang("history_list", "gm")
        )), $content);

        $this->template->view($output, "modules/gm/css/gm.css", "modules/gm/js/gm.js");
	}
}