<?php

use MX\MX_Controller;

class Topvoters extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->config('sidebox_topvoters/topvoters_config');
        $this->load->model('sidebox_topvoters/topvoters_model');
    }

    public function view()
    {
        $data = [
            'url'      => $this->template->page_url,
            'module'   => 'sidebox_topvoters',
            'accounts' => $this->topvoters_model->getThisWeekAccounts($this->config->item("limit")),
			'css'	   => APPPATH . 'modules/sidebox_topvoters/css/topvoters.css'
		];

		$page = $this->template->loadPage("topvoters.tpl", $data);

		return $page;
	}
}
