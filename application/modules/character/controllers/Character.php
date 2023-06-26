<?php

class Character extends MX_Controller
{
    private $canCache;

    private $js;
    private $css;
    private $id;
    private $realm;
    private $realmName;

    private $class;
    private $className;
    private $race;
    private $raceName;
    private $level;
    private $accountId;
    private $account;
    private $gender;

    private $stats;
    private $items;
    private $equippedItems;
    private $equippedItemsDisplayId;

    public function __construct()
    {
        parent::__construct();

        requirePermission("view");

        // Set JS and CSS paths
        $this->js = "modules/character/js/character.js";
        $this->css = "modules/character/css/character.css";

        $this->load->model("armory_model");

        $this->canCache = true;
        $this->items = array();
        $this->equippedItems = array();
        $this->equippedItemsDisplayId = array();
    }

    /**
     * Initialize
     */
    public function index($realm = false, $id = false)
    {
        if (!is_numeric($id)) {
            $id = ucfirst($id);
            $id = $this->realms->getRealm($realm)->getCharacters()->getGuidByName($id);
        }

        $this->setId($realm, $id);

        if ($this->realms->getRealm($realm)->getCharacters()->characterExists($id)) { //characterExists
            $this->getProfile();
        } else {
            $this->getError();
        }
    }

    public function getItem($id = false)
    {
        if ($id != false) {
            $cache = $this->cache->get("items/item_" . $this->realm . "_" . $id);

            if ($cache !== false) {
                $cache2 = $this->cache->get("items/display_" . $cache['displayid']);

                if ($cache2 != false) {
                    return "<a href='" . $this->template->page_url . "item/" . $this->realm . "/" . $id . "' rel='item=" . $id . "' data-realm='" . $this->realm . "'></a><img src='https://icons.wowdb.com/retail/large/" . $cache2 . ".jpg' />";
                } else {
                    return "<a href='" . $this->template->page_url . "item/" . $this->realm . "/" . $id . "' rel='item=" . $id . "' data-realm='" . $this->realm . "'></a><img src='https://icons.wowdb.com/retail/large/inv_misc_questionmark.jpg' />";
                }
            } else {
                $this->canCache = false;
                return $this->template->loadPage("icon_ajax.tpl", array('id' => $id, 'realm' => $this->realm, 'url' => $this->template->page_url));
            }
        }
    }

    /**
     * Determinate which Id to assign
     */
    public function setId($realm, $id)
    {
        // Check if valid X-Y format
        if (
            is_numeric($realm)
            && is_numeric($id)
        ) {
            $this->realm = $realm;
            $this->id = $id;

            $this->armory_model->setRealm($this->realm);
            $this->armory_model->setId($this->id);
        } else {
            $this->realm = false;
            $this->id = false;
        }
    }

    /**
     * Get character info
     */
    private function getInfo()
    {
        $character_data = $this->armory_model->getCharacter();

        if ($this->realms->getRealm($this->realm)->getEmulator()->hasStats()) {
            $character_stats = $this->armory_model->getStats();
        } else {
            $character_stats = array('maxhealth' => lang("unknown", "character"));
        }

        $this->pvp = array(
            'kills' => (array_key_exists("totalKills", $character_data)) ? $character_data['totalKills'] : false,
            'honor' => (array_key_exists("totalHonorPoints", $character_data)) ? $character_data['totalHonorPoints'] : false,
            'arena' => (array_key_exists("arenaPoints", $character_data)) ? $character_data['arenaPoints'] : false
        );

        // Assign the character data as real variables
        foreach ($character_data as $key => $value) {
            $this->$key = $value;
        }

        // Assign the character stats
        $this->stats = $character_stats;

        // Get the account username
        $this->accountName = $this->internal_user_model->getNickname($this->account);

        $this->guild = $this->armory_model->getGuild();
        $this->guildName = $this->armory_model->getGuildName($this->guild);

        if (in_array($this->race, array(4,10))) {
            if ($this->race == 4) {
                $this->raceName = "Night elf";
            } else {
                $this->raceName = "Blood elf";
            }
        } else {
            $this->raceName = $this->armory_model->realms->getRaceEN($this->race);
        }

        $this->className = $this->armory_model->realms->getClassEN($this->class);
        $this->realmName = $this->armory_model->realm->getName();

        if ($this->realms->getRealm($this->realm)->getEmulator()->hasStats()) {
            // Find out which power field to use
            switch ($this->className) {
                default:
                    if (isset($this->stats['maxpower4'])) {
                        $this->secondBar = "mana";
                        $this->secondBarValue = $this->stats['maxpower1'];
                    } else {
                        $this->secondBar = "mana";
                        $this->secondBarValue = "Unknown";
                    }
                    break;

                case "Warrior":
                    if (isset($this->stats['maxpower4'])) {
                        $this->secondBar = "rage";
                        $this->secondBarValue = $this->stats['maxpower2'] / 10;
                    } else {
                        $this->secondBar = "rage";
                        $this->secondBarValue = "Unknown";
                    }
                    break;

                case "Rogue":
                    if (isset($this->stats['maxpower4'])) {
                        $this->secondBar = "energy";
                        $this->secondBarValue = $this->stats['maxpower4'];
                    } else {
                        $this->secondBar = "energy";
                        $this->secondBarValue = "Unknown";
                    }
                    break;

                case "Hunter":
                    if ($this->stats['maxpower3']) {
                        $this->secondBar = "focus";
                        $this->secondBarValue = $this->stats['maxpower3'];
                    } else {
                        $this->secondBar = "mana";
                        $this->secondBarValue = $this->stats['maxpower1'];
                    }
                    break;

                case "Death knight":
                    if (isset($this->stats['maxpower7'])) {
                        $this->secondBar = "runic";
                        $this->secondBarValue = $this->stats['maxpower7'] / 10;
                    } else {
                        $this->secondBar = "runic";
                        $this->secondBarValue = "Unknown";
                    }
                    break;
            }
        } else {
            $this->secondBar = "mana";
            $this->secondBarValue = lang("unknown", "character");
        }

        // Load the items
        $items = $this->armory_model->getItems();

        // Item slots
        $slots = array(
                    0 => "head",
                    1 => "neck",
                    2 => "shoulders",
                    3 => "body",
                    4 => "chest",
                    5 => "waist",
                    6 => "legs",
                    7 => "feet",
                    8 => "wrists",
                    9 => "hands",
                    10 => "finger1",
                    11 => "finger2",
                    12 => "trinket1",
                    13 => "trinket2",
                    14 => "back",
                    15 => "mainhand",
                    16 => "offhand",
                    17 => "ranged",
                    18 => "tabard"
                );

        if (is_array($items)) {
            // Loop through to assign the items
            foreach ($items as $item) {
                $this->equippedItems[$item['slot']] = $item['itemEntry'];
                $this->getDisplayId($item['slot'], $item['itemEntry']);
                $this->items[$slots[$item['slot']]] = $this->getItem($item['itemEntry']);
            }
        }

        // Loop through to make sure none are empty
        foreach ($slots as $key => $value) {
            if (!array_key_exists($value, $this->items)) {
                switch ($value) {
                    default:
                        $image = $value;
                        break;
                    case "trinket1":
                        $image = "trinket";
                        break;
                    case "trinket2":
                        $image = "trinket";
                        break;
                    case "finger1":
                        $image = "finger";
                        break;
                    case "finger2":
                        $image = "finger";
                        break;
                    case "back":
                        $image = "chest";
                        break;
                }

                $this->items[$value] = "<div class='item'><img src='" . $this->template->page_url . "application/images/armory/default/" . $image . ".gif' /></div>";
            }
        }
    }

    private function getBackground()
    {
        switch ($this->className) {
            case "Demon Hunter":
                return "mardum";
            break;
        }
        switch ($this->raceName) {
            default:
                return "shattrath";
            break;
            case "Human":
                return "stormwind";
            break;
            case "Blood elf":
                return "silvermoon";
            break;
            case "Night elf":
                return "darnassus";
            break;
            case "Dwarf":
                return "ironforge";
            break;
            case "Gnome":
                return "ironforge";
            break;
            case "Orc":
                return "orgrimmar";
            break;
            case "Draenei":
                return "theexodar";
            break;
            case "Tauren":
                return "thunderbluff";
            break;
            case "Undead":
                return "undercity";
            break;
            case "Troll":
                return "orgrimmar";
            break;
            case "Goblin":
                return "kezan";
            break;
            case "Worgen":
                return "gilneas";
            break;
            case "Pandaren":
                return "wanderingisle";
            break;
            case "Nightborne":
                return "nightwell";
            break;
            case "Highmountain Tauren":
                return "highmountain";
            break;
            case "Void elf":
                return "telogrusrift";
            break;
            case "Lightforged Dranei":
                return "vindicaar";
            break;
            case "Zandalari Troll":
                return "zandalari";
            break;
            case "Kul Tiran":
                return "boralus";
            break;
            case "Dark Iron Dwarf":
                return "shadowforge";
            break;
            case "Vulpera":
                return "voldun";
            break;
            case "Mag'har Orc":
                return "orgrimmar2";
            break;
            case "Mechagnome":
                return "mechagon";
            break;
            case "Dracthyr":
                return "wakingshores";
            break;
        }
    }

    /**
     * Load the profile
     *
     * @return String
     */
    private function getProfile()
    {
        $cache = $this->cache->get("character_" . $this->realm . "_" . $this->id . "_" . getLang());

        if ($cache !== false) {
            $this->template->setTitle($cache['name']);
            $this->template->setDescription($cache['description']);
            $this->template->setKeywords($cache['keywords']);

            $page = $cache['page'];
        } else {
            if ($this->armory_model->characterExists()) {
                // Load all items and info
                $this->getInfo();

                $this->template->setTitle($this->name);

                $avatarArray = array(
                    'class' => $this->class,
                    'race' => $this->race,
                    'level' => $this->level,
                    'gender' => $this->gender
                );

                $charData = array(
                    "name" => $this->name,
                    "race" => $this->race,
                    "class" => $this->class,
                    "level" => $this->level,
                    "gender" => $this->gender,
                    "items" => $this->items,
                    "equippedItems" => (!empty($this->equippedItems) ? $this->equippedItems : false),
                    "equippedItemsDisplayId" => (!empty($this->equippedItemsDisplayId) ? $this->equippedItemsDisplayId : false),
                    "guild" => $this->guild,
                    "guildName" => $this->guildName,
                    "pvp" => $this->pvp,
                    "url" => $this->template->page_url,
                    "raceName" => $this->raceName,
                    "className" => $this->className,
                    "realmName" => $this->realmName,
                    "avatar" => $this->armory_model->realms->formatAvatarPath($avatarArray),
                    "stats" => $this->stats,
                    "secondBar" => $this->secondBar,
                    "secondBarValue" => $this->secondBarValue,
                    "bg" => $this->getBackground(),
                    "realmId" => $this->realm,
                    "fcms_tooltip" => $this->config->item("use_fcms_tooltip"),
                    "has_stats" => $this->realms->getRealm($this->realm)->getEmulator()->hasStats(),
                    "faction" => $this->realms->getRealm($this->realm)->getCharacters()->getFaction($this->id)
                );

                $character = $this->template->loadPage("character.tpl", $charData);

                $data = array(
                    "module" => "default",
                    "headline" => "<span style='cursor:pointer;' data-tip='" . lang("view_profile", "character") . "' onClick='window.location=\"" . $this->template->page_url . "profile/" . $this->account . "\"'>" . $this->name,
                    "content" => $character
                );

                $keywords = "armory," . $charData['name'] . ",lv" . $charData['level'] . "," . $charData['raceName'] . "," . $charData['className'] . "," . $charData['realmName'];
                $description = $charData['name'] . " - level " . $charData['level'] . " " . $charData['raceName'] . " " . $charData['className'] . " on " . $charData['realmName'];

                $this->template->setDescription($description);
                $this->template->setKeywords($keywords);

                $page = $this->template->loadPage("page.tpl", $data);
            } else {
                $keywords = "";
                $description = "";

                $page = $this->getError(true);
            }

            if ($this->canCache) {
                // Cache for 30 min
                $this->cache->save("character_" . $this->realm . "_" . $this->id . "_" . getLang(), array('page' => $page, 'name' => $this->name, 'keywords' => $keywords, 'description' => $description), 60 * 30);
            }
        }

        $this->template->view($page, $this->css, $this->js);
    }

    /**
     * Show "character doesn't exist" error
     */
    private function getError($get = false)
    {
        $this->template->setTitle(lang("doesnt_exist", "character"));

        $data = array(
            "module" => "default",
            "headline" => lang("doesnt_exist", "character"),
            "content" => "<center style='margin:10px;font-weight:bold;'>" . lang("doesnt_exist_long", "character") . "</center>"
        );

        $page = $this->template->loadPage("page.tpl", $data);

        if ($get) {
            return $page;
        } else {
            $this->template->view($page);
        }
    }

    public function getDisplayId($slot, $id)
    {
        // Check if item ID
        if ($id != false)
        {
            // check if item is in cache
            $item_in_cache = $this->get_icon_cache($id);

            if ($item_in_cache)
            {
                $displayId = $item_in_cache;
            } else {
                // check if item is in database
                $item_in_db = $this->get_icon_db($id);

                if ($item_in_db)
                {
                    $displayId = $item_in_db;
                } else {
                    // check if item is on Wowhead
                    $item_wowhead = $this->get_icon_wowhead($id);

                    if ($item_wowhead)
                    {
                        $displayId = $item_wowhead;
                    } else {
                        $displayId = null;
                    }
                }
            }
        }

		if ($displayId == null || $displayId == '')
			return;

		switch ($slot)
		{
			case 0:
				$this->equippedItemsDisplayId[1] = $displayId;
			break;
			case 2:
				$this->equippedItemsDisplayId[3] = $displayId;
			break;
			case 3:
				$this->equippedItemsDisplayId[4] = $displayId;
			break;
			case 4:
				$this->equippedItemsDisplayId[5] = $displayId;
			break;
			case 5:
				$this->equippedItemsDisplayId[6] = $displayId;
			break;
			case 6:
				$this->equippedItemsDisplayId[7] = $displayId;
			break;
			case 7:
				$this->equippedItemsDisplayId[8] = $displayId;
			break;
			case 8:
				$this->equippedItemsDisplayId[9] = $displayId;
			break;
			case 9:
				$this->equippedItemsDisplayId[10] = $displayId;
			break;
			case 14:
				$this->equippedItemsDisplayId[16] = $displayId;
			break;
			case 15:
				$this->equippedItemsDisplayId[21] = $displayId;
			break;
			case 16:
				$this->equippedItemsDisplayId[14] = $displayId;
			break;
			case 18:
				$this->equippedItemsDisplayId[19] = $displayId;
			break;
		}
	}

    /**
     * Check if item icon name is in cache
     *
     * @param  Int $item
     * @return String
     */
    private function get_icon_cache($item)
    {
        $cache = $this->cache->get("items/display_id_" . $item);

        // can we use the cache?
        if ($cache !== false)
        {
            $name = $cache;
        }
        else
        {
            return false;
        }

        return $name;
    }

    /**
     * Check if item icon displayId is in database
     *
     * @param  Int $item
     * @return String
     */
    private function get_icon_db($item)
    {
        // Get the item ID
        $query = $this->db->query("SELECT displayid FROM item_display WHERE entry = ? LIMIT 1", [$item]);

        // Check for results
        if ($query->num_rows() > 0)
        {
            $row = $query->result_array();

            $displayId = $row[0]['displayid'];

            // save to cache
            $this->cache->save("items/display_id_" . $item, $displayId);
        }
        else
        {
            return false;
        }

        return $displayId;
    }

    private function get_icon_wowhead($item)
    {
        // Get the item XML data
        $xml = file_get_contents("https://www.wowhead.com/item=" . $item . "&xml");

        $itemData = $this->xmlToArray($xml);

        if (!isset($xml->error) && !isset($itemData['error']))
        {
            $xml = simplexml_load_string($xml);
            $displayId = $xml->item[0]->icon['displayId'];

            if (!is_array($displayId) && !empty($displayId))
            {
                // make sure its not in DB already
                $result = $this->db->query("SELECT COUNT(*) as count FROM item_display WHERE entry = ?", [$item])->row();
                if ($result->count == 0)
                {
                    // let the users fill the table themselves, optionally they can import item_template themselves
                    $query = $this->db->query("INSERT INTO item_display (entry, displayid) VALUES (?, ?)", [$item, $displayId]);
                }

                // save to cache
                $this->cache->save("items/display_id_" . $item, $displayId);
            }
            // return false in case of wowhead xml is broken (rare but it happens)
            else {
                return false;
            }

            return $displayId;
        }

        return false;
    }

    /**
     * Convert XML data to an array
     *
     * @param  String $xml
     * @return Array
     */
    private function xmlToArray($xml)
    {
        $xml = simplexml_load_string($xml);
        $json = json_encode($xml);
        $array = json_decode($json, true);

        return $array;
    }
}
