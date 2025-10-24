<?php

use MX\MX_Controller;

/**
 * Unstuck Controller Class
 * @property unstuck_model $unstuck_model unstuck_model Class
 */
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
        $this->load->model('unstuck_model');
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

        $this->template->setTitle(lang('unstuck', 'unstuck'));

        clientLang("cant_afford", "unstuck");
        clientLang("no_realm_selected", "unstuck");
        clientLang("no_char_selected", "unstuck");
        clientLang("sure_want_unstack", "unstuck");

        //Load the content
        $content_data = array(
            "characters" => $this->characters,
            "url" => $this->template->page_url,
            "total" => $this->total,
            "vp" => $this->user->getVp(),
            "service_cost" => $this->config->item("price_vote_point")
        );

        $page_content = $this->template->loadPage("unstuck.tpl", $content_data);

        //Load the page
        $page_data = array(
            "module" => "default",
            "headline" => breadcrumb([
                "ucp" => lang("ucp"),
                "unstuck" => lang("unstuck", "unstuck")
            ]),
            "content" => $page_content
        );

        $page = $this->template->loadPage("page.tpl", $page_data);

        $this->template->view($page, "modules/unstuck/css/unstuck.css", "modules/unstuck/js/unstuck.js");
    }

    public function submit()
    {
        $characterGuid = $this->input->post('guid');
        $realmId = $this->input->post('realm');
        $realm = $this->realms->getRealm($realmId);

        // Make sure the realm actually supports console commands
        if (!$realm->getEmulator()->hasConsole()) {
            die(lang("not_support", "unstuck"));
        }

        if ($characterGuid && $realmId) {
            $realmConnection = $realm->getCharacters();
            $realmConnection->connect();

            $character = $realmConnection->getCharacterByGuid($characterGuid);
            if ($characterGuid <= 0 || !$character) {
                $data = [
                    'status' => false,
                    'icon' => 'error',
                    'text' => lang("character_does_not_exist", "unstuck")
                ];
                die(json_encode($data));
            }

            // Make sure the character belongs to this account
            if (!$realmConnection->characterBelongsToAccount($characterGuid, $this->user->getId())) {
                $data = [
                    'status' => false,
                    'icon' => 'error',
                    'text' => lang("character_does_not_belong_account", "unstuck")
                ];
                die(json_encode($data));
            }

            $characterName = $character[column("characters", "name", false, $realmId)];

            if (!$characterName) {
                $data = [
                    'status' => false,
                    'icon' => 'error',
                    'text' => lang("unable_resolve_character_name", "unstuck")
                ];
                die(json_encode($data));
            }

            //Get the character is online?
            $isOnline = $realmConnection->isOnline($characterGuid);

            if ($isOnline) {
                $data = [
                    'status' => false,
                    'icon' => 'error',
                    'text' => lang("character_is_online", "unstuck")
                ];
                die(json_encode($data));
            }

            //Get the price
            $price = $this->config->item("price_vote_point");

            //Check if the user can afford the service
            if ($this->user->getVp() >= $price) {
                //Execute the command
                $realm->getEmulator()->sendCommand('.revive ' . $characterName);

                $this->home($realm, $characterGuid);
                $this->unstuck_model->setLocation($this->gps['posX'], $this->gps['posY'], $this->gps['posZ'], $this->gps['orientation'], $this->gps['mapId'], $characterGuid, $realmConnection->getConnection());

                // Update Donation Points
                if ($price > 0) {
                    $this->user->setVp($this->user->getVp() - $price);
                }

                $this->dblogger->createLog("user", "service", "Unstuck", $characterName, Dblogger::STATUS_SUCCEED, $this->user->getId());

                //Successful
                $data = [
                    'status' => true,
                    'icon' => 'success',
                    'text' => lang("successfully", "unstuck")
                ];

            } else {
                $data = [
                    'status' => false,
                    'icon' => 'error',
                    'text' => lang("dont_enough_vote_points", "unstuck")
                ];
            }
            die(json_encode($data));
        } else {
            $data = [
                'status' => false,
                'icon' => 'error',
                'text' => lang("no_selected_service", "unstuck")
            ];
            die(json_encode($data));
        }
    }

    public function home(Realm $realm, int $guid): void
    {
        $rows = $this->unstuck_model->getcharacter_homebind($realm->getId(), $guid);

        switch ($realm->getConfig('emulator')) {
            case 'cmangos':
            case 'mangos_zero':
            case 'mangos_one_two':
            case 'mangos_three':
            case 'vmangos':
            case 'oregoncore':
                $this->gps['mapId'] = $rows[0]['map'];
                $this->gps['orientation'] = 1.64;
                $this->gps['posX'] = $rows[0]['position_x'];
                $this->gps['posY'] = $rows[0]['position_y'];
                $this->gps['posZ'] = $rows[0]['position_z'];
                break;
            default:
                $this->gps['mapId'] = $rows[0]['mapId'];
                $this->gps['orientation'] = 1.64;
                $this->gps['posX'] = $rows[0]['posX'];
                $this->gps['posY'] = $rows[0]['posY'];
                $this->gps['posZ'] = $rows[0]['posZ'];
                break;
        }
    }

}
