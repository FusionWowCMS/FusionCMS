<?php

use MX\MX_Controller;

class Unstuck extends MX_Controller
{
    private $characters;
    private $total;

    private array $gps = [
        'mapId' => 571,
        'orientation' => 1.64,
        'posX' => 5804.15,
        'posY' => 624.771,
        'posZ' => 647.767
    ];

    public function __construct()
    {
        parent::__construct();

        $this->user->userArea();

        //Load the Config
        $this->load->config('unstuck');

        //Load the models
        $this->load->model('Unstuck_Model');
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

        $this->template->setTitle("Character Unstuck");

        clientLang("cant_afford", "unstuck");
        clientLang("purchase", "unstuck");
        clientLang("want_to_buy", "unstuck");
        clientLang("processing", "unstuck");
        clientLang("no_realm_selected", "unstuck");
        clientLang("no_char_selected", "unstuck");

        //Load the content
        $content_data = array(
            "characters" => $this->characters,
            "url" => $this->template->page_url,
            "total" => $this->total,
            "dp" => $this->user->getDp(),
            "service_cost" => $this->config->item("price"),
            'description' => $this->config->item("description")
        );

        $page_content = $this->template->loadPage("unstuck.tpl", $content_data);

        //Load the page
        $page_data = array(
            "module" => "default",
            "headline" => "Character Unstuck",
            "content" => $page_content
        );

        $page = $this->template->loadPage("page.tpl", $page_data);

        $this->template->view($page, "modules/unstuck/css/unstuck.css", "modules/unstuck/js/unstuck.js");
    }

    public function submit()
    {
        $characterGuid = $this->input->post('guid');
        $realmId = $this->input->post('realm');

        // Make sure the realm actually supports console commands
        if (!$this->realms->getRealm($realmId)->getEmulator()->hasConsole()) {
            die(lang("not_support", "unstuck"));
        }

        if ($characterGuid && $realmId) {

            $realmConnection = $this->realms->getRealm($realmId)->getCharacters();
            $realmConnection->connect();

            //Get the price
            $Price = $this->config->item("price");

            // Make sure the character exists
            if (!$realmConnection->characterExists($characterGuid)) {
                die(lang("character_does_not_exist", "unstuck"));
            }

            // Make sure the character belongs to this account
            if (!$realmConnection->characterBelongsToAccount($characterGuid, $this->user->getId())) {
                die(lang("character_does_not_belong_account", "unstuck"));
            }

            //Get the character name
            $CharacterName = $realmConnection->getNameByGuid($characterGuid);

            //Make sure we've got the name
            if (!$CharacterName) {
                die(lang("unable_resolve_character_name", "unstuck"));
            }

            //Get the character  is online?
            $isOnline = $realmConnection->isOnline($characterGuid);

            if ($isOnline) {
                die(lang("character_is_online", "unstuck"));
            }

            //Check if the user can afford the service
            if ($this->user->getDp() >= $Price) {

                $this->home($realmId, $characterGuid);

                $this->Unstuck_Model->setLocation($this->gps['posX'], $this->gps['posY'], $this->gps['posZ'], $this->gps['orientation'], $this->gps['mapId'], $characterGuid, $realmConnection->getConnection());

                //Update Donation Points
                if ($Price > 0) {
                    $this->user->setDp($this->user->getDp() - $Price);
                }

                //Successful
                die(lang("successfully", "unstuck"));

            } else {
                die(lang("dont_enough_Donation_Points", "unstuck"));
            }

        } else {
            die(lang("no_selected_service", "unstuck"));
        }
    }

    public function home($realmid, $guid)
    {
        $rows = $this->Unstuck_Model->getcharacter_homebind($realmid, $guid);
        $this->gps['mapId'] = $rows[0]['mapId'];
        $this->gps['orientation'] = 1.64;
        $this->gps['posX'] = $rows[0]['posX'];
        $this->gps['posY'] = $rows[0]['posY'];
        $this->gps['posZ'] = $rows[0]['posZ'];
    }

}
