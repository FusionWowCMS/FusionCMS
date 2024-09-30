<?php

use MX\MX_Controller;

/**
 * Pvp_statistics Controller Class
 * @property data_model $data_model data_model Class
 */
class Pvp_statistics extends MX_Controller
{
    public function __construct()
    {
        //Call the constructor of MX_Controller
        parent::__construct();

        $this->load->model("data_model");
        $this->load->config('pvp_statistics/pvps_config');
    }

    public function index(int|bool $RealmId = false)
    {
        $cache = $this->cache->get('pvp_statistics_' . $RealmId);

        if ($cache !== false) {
            $page = $cache;
        } else {
            $this->template->setTitle("PVP Statistics");

            $user_id = $this->user->getId();

            $data = [
                'user_id'           => $user_id,
                'realms_count'      => !isset($this->realms),
                'selected_realm'    => $RealmId,
                'url'               => $this->template->page_url,
            ];

            // Get the realms
            if (!isset($this->realms) > 0) {
                foreach ($this->realms->getRealms() as $realm) {
                    //Set the first realm as realmid
                    if (!$RealmId) {
                        $RealmId = $realm->getId();
                        $data['selected_realm'] = $RealmId;
                    }

                    $data['realms'][$realm->getId()] = ['name' => $realm->getName()];
                }
            }

            //Set the realmid for the data model
            $this->data_model->setRealm($RealmId);

            //Get the top teams
            $data['Teams2'] = $this->data_model->getTeams($this->config->item("arena_teams_limit"), 2);
            $data['Teams3'] = $this->data_model->getTeams($this->config->item("arena_teams_limit"), 3);
            $data['Teams5'] = $this->data_model->getTeams($this->config->item("arena_teams_limit"), 5);

            //Get Top Honorable Kills Players
            $data['TopHK'] = $this->data_model->getTopHKPlayers($this->config->item("hk_players_limit"));

            // Get Factions
            $data['allianceRaces'] = get_instance()->realms->getAllianceRaces();
            $data['hordeRaces'] = get_instance()->realms->getHordeRaces();

            $page = $this->template->loadPage("pvp_statistics.tpl", $data);

            // Cache
            $this->cache->save('pvp_statistics_' . $RealmId, $page, strtotime($this->config->item("cache_time")));
        }

        $this->template->box("PVP Statistics", $page, true, "modules/pvp_statistics/css/style.css", "modules/pvp_statistics/js/scripts.js");
    }
}
