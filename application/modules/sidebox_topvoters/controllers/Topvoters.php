<?php

use MX\MX_Controller;

/**
 * Topvoters Controller Class
 * @property topvoters_model $topvoters_model topvoters_model Class
 */
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
        $cache = $this->cache->get("sidebox_topvoters");

        if ($cache !== false) {
            $page = $cache;
        } else {
            $data = [
                'url'      => $this->template->page_url,
                'module'   => 'sidebox_topvoters',
                'accounts' => $this->topvoters_model->getThisWeekAccounts($this->config->item("limit")),
                'css'      => APPPATH . 'modules/sidebox_topvoters/css/topvoters.css'
            ];

            $page = $this->template->loadPage("topvoters.tpl", $data);

            // Cache
            $this->cache->save("sidebox_topvoters", $page, strtotime($this->config->item("cache_time")));
        }

        return $page;
    }
}
