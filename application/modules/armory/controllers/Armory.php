<?php

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

        $this->load->config('tooltip/tooltip_constants');

        $this->weapon_sub = $this->config->item("weapon_sub");
        $this->armor_sub = $this->config->item("armor_sub");
        $this->slots = $this->config->item("slots");
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
    
    public function get_data()
    {
        $realm = $this->input->post('realm');
        $table = $this->input->post('table');
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $string = $this->input->post("search");

        if(!$string || strlen($string) <= 2 || !$realm || !is_numeric($realm)|| !is_numeric($start)|| !is_numeric($length) || !ctype_alnum($string))
        {
			die();
        }

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

        die(json_encode($result));
    }

    private function getIcon($id, $realm)
    {
        $cache = $this->cache->get("items/item_" . $realm . "_" . $id);

        if ($cache !== false) {
            $cache2 = $this->cache->get("items/display_iconname_" . $id);

            if ($cache2 != false) {
                return '<img src="https://icons.wowdb.com/retail/small/' . $cache2 . '.jpg" align="absmiddle" />';
            } else {
                return '<img src="https://icons.wowdb.com/retail/small/inv_misc_questionmark.jpg" align="absmiddle" />';
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

        if (
            strlen($slot)
            && strlen($type)
        ) {
            return $slot . " (" . $type . ")";
        } else {
            return lang("misc", "armory");
        }
    }
}
