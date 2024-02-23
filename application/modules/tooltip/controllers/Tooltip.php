<?php

use MX\MX_Controller;

class Tooltip extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model("tooltip_model");
    }

    public function Index($realm = false, $id = false)
    {
        if (!$this->input->is_ajax_request()) {
            die('No direct script access allowed');
        }

        // Make sure item and realm are set
        if (!$id || !$realm) {
            die("No item or realm specified!");
        }

        $item = $this->items->getItem($id, $realm, 'htmlTooltip');

        if (!$item) {
            $item = lang("unknown_item", "tooltip");
        }

        $data = [
            'module' => 'tooltip',
            'item' => $item
        ];

        $out = $this->template->loadPage("tooltip.tpl", $data);

        die($out);
    }

    public function character($realm = false, $id = false)
    {
        if (!$this->input->is_ajax_request()) {
            die('No direct script access allowed');
        }

        // Make sure item and realm are set
        if (!$id || !$realm) {
            die("No item or realm specified!");
        }

        $tooltip = $this->getProfile($realm, $id);

        if (!$tooltip) {
            $tooltip = lang("unknown_item", "tooltip");
        }

        $data = [
            'module' => 'tooltip',
            'data' => $tooltip
        ];

        $out = $this->template->loadPage("character_tooltip.tpl", $data);

        die($out);
    }

    private function getProfile($realm, $id): bool|array
    {
        if (!$this->tooltip_model->characterExists($realm, $id))
            return false;

        $avatarArray = [
            'class'  => '',
            'race'   => '',
            'level'  => '',
            'gender' => ''
        ];

        // Load all items and info
        $character_data = $this->tooltip_model->getCharacter($realm, $id);

        // Assign the character data
        foreach ($character_data as $key => $value) {
            $avatarArray[$key] = $value;
        }

        return [
            'name'      => $avatarArray['name'],
            'race'      => $avatarArray['race'],
            'class'     => $avatarArray['class'],
            'level'     => $avatarArray['level'],
            'gender'    => $avatarArray['gender'],
            'avatar'    => $this->realms->formatAvatarPath($avatarArray),
            'guildName' => $this->tooltip_model->getGuildName($realm, $id),
            'faction'   => $this->realms->getRealm($realm)->getCharacters()->getFaction($id),
            'raceName'  => $this->realms->getRaceEN($avatarArray['race']),
            'className' => $this->realms->getClassEN($avatarArray['class']),
            'realmName' => $this->realms->getRealm($realm)->getName(),
        ];
    }
}
