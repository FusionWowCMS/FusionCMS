<?php

use CodeIgniter\Events\Events;
use MX\MX_Controller;

/**
 * Teleport Controller Class
 * @property teleport_model $teleport_model teleport_model Class
 */
class Teleport extends MX_Controller
{
    private array $teleportLocations;
    private array $teleportMaps;
    private array $characters;
    private int $total;

    public function __construct()
    {
        parent::__construct();

        $this->user->userArea();

        //Load the models
        $this->load->model('teleport_model');

        //Init the variables
        $this->init();
    }

    /**
     * Init every variable
     */
    private function init()
    {
        $this->teleportLocations = $this->teleport_model->getTeleportLocations();
        $this->teleportMaps = $this->teleport_model->getTeleportMaps();

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

    /**
     * Load the page
     */
    public function index()
    {
        requirePermission("view");

        clientLang("cant_afford", "teleport");
        clientLang("select", "teleport");
        clientLang("selected", "teleport");
        clientLang("teleported", "teleport");
        clientLang("vp", "teleport");
        clientLang("dp", "teleport");
        clientLang("gold", "teleport");
        clientLang("free", "teleport");

        //Set the title to teleport locations
        $this->template->setTitle(lang("teleport_hub", "teleport"));

        //Load the content
        $content_data = [
            "locations" => $this->teleportLocations,
            "maps" => $this->teleportMaps,
            "characters" => $this->characters,
            "url" => $this->template->page_url,
            "total" => $this->total,
            "vp" => $this->user->getVp(),
            "dp" => $this->user->getDp(),
            "avatar" => $this->user->getAvatar($this->user->getId()),
        ];

        $page_content = $this->template->loadPage("teleport.tpl", $content_data);

        //Load the page
        $page_data = [
            "module" => "default",
            "headline" => breadcrumb([
                "ucp" => lang("ucp"),
                "teleport" => lang("teleport_hub", "teleport")
            ]),
            "content" => $page_content
        ];

        $page = $this->template->loadPage("page.tpl", $page_data);

        $this->template->view($page, "modules/teleport/css/teleport.css", "modules/teleport/js/teleport.js");
    }

    /**
     * Submit method
     */
    public function submit()
    {
        // Get the post variables
        $characterGuid = $this->input->post('guid');
        $teleportLocationId = $this->input->post('id');

        if (!$teleportLocationId || !$characterGuid) {
            die(lang("no_location", "teleport"));
        }

        $teleport_exists = $this->teleport_model->teleportLocationExists($teleportLocationId);

        if (!$teleport_exists) {
            die(lang("no_location", "teleport"));
        }

        $realmId = $teleport_exists['realm'];
        $faction = $this->realms->getRealm($realmId)->getCharacters()->getFaction($characterGuid);

        if ($teleport_exists['required_faction'] > 0 && $teleport_exists['required_faction'] != $faction) {
            die(lang("wrong_faction", "teleport"));
        }

        $realmConnection = $this->realms->getRealm($realmId)->getCharacters();
        $realmConnection->connect();

        // MAKE SURE THAT THE CHARACTER EXISTS AND THAT HE IS OFFLINE, ALSO MAKE SURE WE CAN AFFORD IT
        $character_exists = $this->teleport_model->characterExists($characterGuid, $realmConnection->getConnection());
        if (!$character_exists) {
            die(lang("must_be_offline", "teleport"));
        }

        // Check the character level with the required level
        if ($character_exists['level'] < $teleport_exists['required_level']) {
            die(lang("level_too_low", "teleport"));
        }

        if ($this->canPay($this->user->getVp(), $this->user->getDp(), $realmConnection->getGold($this->user->getId(), $characterGuid), $teleport_exists['vpCost'], $teleport_exists['dpCost'], $teleport_exists['goldCost'])) {
            // Update the vp, dp and gold.
            $this->user->setVp($this->user->getVp() - $teleport_exists['vpCost']);
            $this->user->setDp($this->user->getDp() - $teleport_exists['dpCost']);
            $realmConnection->setGold($this->user->getId(), $characterGuid, ($realmConnection->getGold($this->user->getId(), $characterGuid) - ($teleport_exists['goldCost'] * 100 * 100)));

            // Change the location of character
            $this->teleport_model->setLocation($teleport_exists['x'], $teleport_exists['y'], $teleport_exists['z'], $teleport_exists['orientation'], $teleport_exists['mapId'], $characterGuid, $realmConnection->getConnection());

            Events::trigger('onTeleport', $this->user->getId(), $characterGuid, $teleport_exists['vpCost'], $teleport_exists['dpCost'], $teleport_exists['goldCost'], $teleport_exists['x'], $teleport_exists['y'], $teleport_exists['z'], $teleport_exists['orientation'], $teleport_exists['mapId']);

            $this->dblogger->createLog("user", "service", "Teleport Character " . $character_exists[column("characters", "name", false, $realmId)], $teleport_exists['name'], Dblogger::STATUS_SUCCEED, $this->user->getId());

            die("1");
        } else {
            die(lang("cant_afford", "teleport"));
        }
    }

    /**
     * Can they pay for this teleport?
     *
     * @param  $currentVp
     * @param  $currentDp
     * @param  $currentGold
     * @param  $requiredVp
     * @param  $requiredDp
     * @param  $requiredGold
     * @return bool
     */
    public function canPay($currentVp, $currentDp, $currentGold, $requiredVp, $requiredDp, $requiredGold): bool
    {
        //check if we can pay
        if (($currentVp >= $requiredVp) && ($currentDp >= $requiredDp) && ($currentGold >= $requiredGold)) {
            return true;
        } else {
            return false;
        }
    }
}
