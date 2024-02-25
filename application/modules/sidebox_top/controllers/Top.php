<?php

use MX\MX_Controller;

/**
 * Top Controller Class
 * @property top_model $top_model top_model Class
 */
class Top extends MX_Controller
{
    function __construct()
    {
        // Call the constructor of MX_Controller
        parent::__construct();

        $this->load->config('sidebox_top/top_config');
        $this->load->model('sidebox_top/top_model');
    }

    public function view()
    {
        $cache = $this->cache->get("sidebox_top_" . getLang());

        if ($cache !== false)
            $output = $cache;
        else {
            $data = array(
                'module' => 'sidebox_top',
                'selected_realm' => 1,
                'url' => $this->template->page_url,
                'realms' => $this->getData(),
                'load_css' => 'application/modules/sidebox_top/css/sidebox_top.css'
            );

            $output = $this->template->loadPage("sidebox_top.tpl", $data);

            // Cache for 12 hours
            $this->cache->save("sidebox_top_" . getLang(), $output, 60 * 60 * 12);
        }

        return $output;
    }

    private function getData()
    {
        if (count($this->realms->getRealms()) == 0) {
            return "This module has not been configured";
        } else {
            $data = array();
            $limit = $this->config->item('top_players_limit');

            foreach ($this->realms->getRealms() as $realm) {
                $data[$realm->getId()]['name'] = $realm->getName();
                $data[$realm->getId()]['id'] = $realm->getId();

                $this->top_model->setRealm($realm->getId());

                $data[$realm->getId()]['todayKills'] = $this->top_model->getKillTodayPlayers($limit);

                $data[$realm->getId()]['yesterdayKills'] = $this->top_model->getYesterdayPlayers($limit);

                $data[$realm->getId()]['totalKills'] = $this->top_model->getTotalPlayers($limit);

                $data[$realm->getId()]['achivements'] = $this->top_model->getTopAchievementPlayers($limit);

                $data[$realm->getId()]['guilds'] = $this->top_model->getTopGuild($limit);
            }

            return $data;
        }
    }


}
