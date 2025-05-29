<?php

use MX\MX_Controller;

class levelup extends MX_Controller
{
    private $characters;
    private $total;

    public function __construct()
    {
        parent::__construct();

        $this->user->userArea();

        //Load the Config
        $this->load->config('levelup');

    }

    private function init()
    {
        $this->characters = $this->user->getCharacters($this->user->getId());

        foreach ($this->characters as $realm_key => $realm) {
            if (is_array($realm['characters'])) {
                foreach ($realm['characters'] as $character_key => $character) {
                    $this->characters[$realm_key]['characters'][$character_key]['avatar'] = $this->realms->formatAvatarPath($character);
                }
            }
        }

        $this->total = 0;

        foreach ($this->characters as $realm) {
            if ($realm['characters']) {
                $this->total += count($realm['characters']);
            }
        }
    }

    public function index()
    {
        $this->init();

        $this->template->setTitle(lang("char_levelup", "levelup"));

        clientLang('cant_afford', 'levelup');
        clientLang('purchase', 'levelup');
        clientLang('want_to_buy', 'levelup');
        clientLang('processing', 'levelup');
        clientLang('no_realm_selected', 'levelup');
        clientLang('no_char_selected', 'levelup');

        //Load the content
        $content_data = [
            "characters" => $this->characters,
            "url" => $this->template->page_url,
            "total" => $this->total,
            "dp" => $this->user->getDp(),
            "service_cost" => $this->config->item("price"),
            'maxlevel' => $this->config->item("max_level"),
            'description' => $this->config->item("description"),
            'prices' => $this->config->item("price_lvl"),
        ];

        $page_content = $this->template->loadPage("levelup.tpl", $content_data);

        //Load the page
        $page_data = array(
            "module" => "default",
            "headline" => breadcrumb([
                "ucp" => lang("ucp"),
                "levelup" => lang("char_levelup", "levelup")
            ]),
            "content" => $page_content
        );

        $page = $this->template->loadPage("page.tpl", $page_data);

        $this->template->view($page, "modules/levelup/css/levelup.css", "modules/levelup/js/levelup.js");
    }

    /**
     * Submit method
     */
    public function submit()
    {
        $characterGuid = $this->input->post('guid');
        $realmId = $this->input->post('realm');
        $price = $this->input->post('price');
        $prices = $this->config->item("price_lvl");

        $levelup = array_search($price, (array)$prices);

        // Make sure the realm actually supports console commands
        if (!$this->realms->getRealm($realmId)->getEmulator()->hasConsole()) {
            die(lang("not_support", "levelup"));
        }

        if ($characterGuid && $realmId) {
            $realmConnection = $this->realms->getRealm($realmId)->getCharacters();
            $realmConnection->connect();

            // Make sure the character exists
            if (!$realmConnection->characterExists($characterGuid)) {
                die(lang("character_does_not_exist", "levelup"));
            }

            // Make sure the character belongs to this account
            if (!$realmConnection->characterBelongsToAccount($characterGuid, $this->user->getId())) {
                die(lang("character_does_not_belong_account", "levelup"));
            }

            //Get the character name
            $CharacterName = $realmConnection->getNameByGuid($characterGuid);

            //Make sure we've got the name
            if (!$CharacterName) {
                die(lang("unable_resolve_character_name", "levelup"));
            }

            //Check if the user can afford the service
            if ($this->user->getDp() >= $price) {
                //Execute the command
                $this->realms->getRealm($realmId)->getEmulator()->sendCommand('.char level ' . $CharacterName . ' ' . $levelup);

                //Update Donation Points
                if ($price > 0) {
                    $this->user->setDp($this->user->getDp() - $price);
                }

                $this->dblogger->createLog("user", "service", "Level Up", $CharacterName, Dblogger::STATUS_SUCCEED, $this->user->getId());

                //Successful
                die(lang("successfully", "levelup"));

            } else {
                die(lang("dont_enough_Donation_Points", "levelup"));
            }

        } else {
            die(lang("no_selected_service", "levelup"));
        }
    }
}
