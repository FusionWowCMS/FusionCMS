<?php

class Toppvp extends MX_Controller
{
    private $realm;
    private $min_realm;
    private $max_realm;

    public function __construct()
    {
        parent::__construct();

        // Load our assets
        $this->load->config('sidebox_toppvp/toppvp_config');
        $this->load->model('sidebox_toppvp/toppvp_model');

        // Load the realms
        $this->loadRealms();
    }

    private function loadRealms()
    {
        $this->min_realm = false;
        $this->max_realm = false;

        $realms = $this->config->item("pvp_realms");

        if (is_numeric($realms)) {
            $realms = array($realms);
        }

        if (
            isset($realms)
            && is_array($realms)
        ) {
            $this->realm = array();

            foreach ($realms as $id) {
                if ($this->realms->realmExists($id)) {
                    if ($this->min_realm == false || $id < $this->min_realm) {
                        $this->min_realm = $id;
                    }

                    if ($this->max_realm == false || $id > $this->max_realm) {
                        $this->max_realm = $id;
                    }

                    $this->realm[$id] = $this->realms->getRealm($id);
                }
            }
        } else {
            $this->realms = array();
        }
    }

    public function view()
    {
        if (count($this->realm) == 0) {
            return "This module has not been configured";
        } else {
            $cache = $this->cache->get("sidebox_toppvp_" . getLang());

            if ($cache !== false) {
                $out = $cache;
            } else {
                //Get the max chars to show
                $maxCount = $this->config->item('pvp_players');
                $realm_html = array();

                //For each realm
                foreach ($this->realm as $id => $realm) {
                    //Get the topkill characters
                    $topKillChars = $this->toppvp_model->getTopKillChars($maxCount, $realm);

                    $data = array(
                                "module" => "sidebox_toppvp",
                                "name" => $realm->getName(),
                                "id" => $realm->getId(),
                                "characters" => $topKillChars,
                                "url" => $this->template->page_url,
                                "realm" => $realm->getId()
                            );

                    $realm_html[$id] = $this->template->loadPage("realm.tpl", $data);
                }

                $out = $this->template->loadPage("pvp.tpl", array("module" => "sidebox_toppvp", "min_realm" => $this->min_realm, "max_realm" => $this->max_realm, "realm_html" => $realm_html, "realms" => $this->realm));

                // Cache for 12 hours
                $this->cache->save("sidebox_toppvp_" . getLang(), $out, 60 * 60 * 12);
            }

            return $out;
        }
    }
}
