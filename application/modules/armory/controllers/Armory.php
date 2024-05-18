<?php

use MX\MX_Controller;

/**
 * Armory Controller Class
 * @property armory_model $armory_model armory_model Class
 */
class Armory extends MX_Controller
{
    private $weapon_sub;
    private $armor_sub;
    private $slots;

    public function __construct()
    {
        parent::__construct();

        requirePermission("view");

        $this->load->model('armory_model');

        $this->load->library('form_validation');

        $this->weapon_sub = lang('weapon_sub', 'wow_tooltip');
        $this->armor_sub = lang('armor_sub', 'wow_tooltip');
        $this->slots = lang('slots', 'wow_tooltip');
    }

    public function index()
    {
        clientLang("search_too_short", "armory");

        $this->template->setTitle(lang("search_title", "armory"));

        $realms = $this->realms->getRealms();

        $data = array(
            "realms" => $realms,
        );

        $this->template->view($this->template->loadPage("page.tpl", array(
            "module" => "default", 
            "headline" => lang("search_headline", "armory"),
            "content" => $this->template->loadPage("search.tpl", $data)
        )), "modules/armory/css/search.css", "modules/armory/js/search.js");
    }
    
    public function search()
    {
        if (!$this->input->is_ajax_request()) {
            die('No direct script access allowed');
        }

        $this->form_validation->set_rules('realm', 'realm', 'trim|required|min_length[1]|max_length[3]|integer');
        $this->form_validation->set_rules('table', 'table', 'trim|required|min_length[5]|max_length[10]|alpha_numeric');
        $this->form_validation->set_rules('start', 'start', 'trim|max_length[4]|integer');
        $this->form_validation->set_rules('length', 'length', 'trim|max_length[4]|integer');
        $this->form_validation->set_rules('search', 'search', 'trim|required|min_length[3]|max_length[100]');

        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run())
        {
            $realm = $this->input->post('realm');
            $table = $this->input->post('table');
            $start = $this->input->post('start');
            $length = $this->input->post('length');
            $string = $this->input->post("search");

            $result = [];

            switch ($table)
            {
                case 'items':
                    $data = $this->armory_model->get_items($string, $length, $start, $realm);

                    if ($data)
                    {
                        foreach ($data as $row)
                        {
                            $result[] = [
                                'id' => $row['entry'],
                                'name' => $row['name'],
                                'level' => $row['ItemLevel'],
                                'required' => $row['RequiredLevel'],
                                'type' => $this->getItemType($row['InventoryType'], $row['class'], $row['subclass']),
                                'quality' => $row['Quality'],
                                'realm' => $realm,
                                'icon' => $this->getIcon($row['entry'], $realm)
                            ];
                        }
                    }

                    $total = $this->armory_model->get_items_count($string, $realm);
                    $output = [
                        'draw' => $this->input->post('draw'),
                        'recordsTotal' => $total,
                        'recordsFiltered' => $total,
                        'data' => $result
                    ];

                    die(json_encode($output));
                case 'guilds':
                    $data = $this->armory_model->get_guilds($string, $length, $start, $realm);

                    if ($data)
                    {
                        foreach ($data as $row)
                        {
                            $result[] = [
                                'id' => $row['guildid'],
                                'name' => $row['name'],
                                'members' => $row['GuildMemberCount'],
                                'realm' => $realm,
                                'ownerGuid' => $row['leaderguid'],
                                'ownerName' => $row['leaderName']
                            ];
                        }
                    }

                    $total = $this->armory_model->get_guilds_count($string, $realm);
                    $output = [
                        'draw' => $this->input->post('draw'),
                        'recordsTotal' => $total,
                        'recordsFiltered' => $total,
                        'data' => $result
                    ];

                    die(json_encode($output));
                case 'characters':
                    $data = $this->armory_model->get_characters($string, $length, $start, $realm);

                    if ($data)
                    {
                        foreach ($data as $row)
                        {
                            $result[] = [
                                'guid' => $row['guid'],
                                'name' => $row['name'],
                                'race' => $this->realms->getRealm($realm)->getCharacters()->getFaction($row['guid']),
                                'gender' => $row['gender'],
                                'class' => $row['class'],
                                'level' => $row['level'],
                                'avatar' => $this->realms->formatAvatarPath($row),
                                'realm' => $realm
                            ];
                        }
                    }

                    $total = $this->armory_model->get_characters_count($string, $realm);
                    $output = [
                        'draw' => $this->input->post('draw'),
                        'recordsTotal' => $total,
                        'recordsFiltered' => $total,
                        'data' => $result
                    ];

                    die(json_encode($output));
            }
        }
        else
        {
            die(json_encode(['error' => validation_errors()]));
        }
    }

    private function getIcon($id, $realm)
    {
        $cache = $this->cache->get("items/item_" . $realm . "_" . $id);

        if ($cache !== false) {
            if ($cache['icon']) {
                return '<img src="' . $this->config->item('api_item_icons') . '/small/' . $cache['icon'] . '.jpg" align="absmiddle" />';
            } else {
                return '<img src="' . $this->config->item('api_item_icons') . '/small/inv_misc_questionmark.jpg" align="absmiddle" />';
            }
        } else {
            return $this->template->loadPage("icon_ajax.tpl", array('id' => $id, 'realm' => $realm, 'url' => $this->template->page_url));
        }
    }

    private function getItemType($slot, $class, $subclass)
    {
        // Weapons
        if ($class == 2) {
            $type = (array_key_exists($subclass, $this->weapon_sub)) ? $this->weapon_sub[$subclass] : "Unknown";
        }

        // Armor
        elseif ($class == 4) {
            $type = (array_key_exists($subclass, $this->armor_sub)) ? $this->armor_sub[$subclass] : "Unknown";
        }

        // Anything else
        else {
            $type = null;
        }

        $slot = $this->slots[$slot];

        if ($slot && $type) {
            if (strlen($slot) && strlen($type)) {
                return $slot . " (" . $type . ")";
            } else {
                return lang("misc", "armory");
            }
        } else {
            return lang("misc", "armory");
        }
    }
}
