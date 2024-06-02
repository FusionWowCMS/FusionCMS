<?php

use App\Config\Services;
use MX\CI;

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * @package FusionCMS
 *
 * @author  Keramat Jokar (Nightprince) <https://github.com/Nightprince>
 * @link    https://github.com/FusionWowCMS/FusionCMS
 */
class Items
{
    private Controller $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    /**
     * Check if item is in Wowhead
     *
     * @param Int $item
     * @param $realm
     * @param String $type
     * @param bool $enableCache
     * @return bool|string|array
     */
    public function getItemWowHead(int $item, $realm, string $type, bool $enableCache = true): mixed
    {
        $options = [
            'timeout'         => 300,
            'allow_redirects' => [
                'max' => 10,
            ],
            'user_agent'      => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1',
            'version'         => CURL_HTTP_VERSION_2_0,
            'verify'          => false,
        ];

        // Get the item XML data
        $response = Services::curlrequest()->get($this->CI->config->item('api_item_data') . 'item=' . $item . '&xml', $options);
        $data = $response->getBody();

        if (!empty($data)) {
            $data = $this->XMLtoArray($data);

            if (is_array($data) && !isset($data['wowhead']['error'])) {
                $cacheData = [
                    'entry' => $item,
                    'name' => $data['wowhead']['item']['name'],
                    'icon' => $data['wowhead']['item']['icon']['_value'],
                    'Quality' => $data['wowhead']['item']['quality']['@attributes']['id'],
                    'displayid' => $data['wowhead']['item']['icon']['@attributes']['displayId'],
                    'class' => $data['wowhead']['item']['class']['@attributes']['id'],
                    'subclass' => $data['wowhead']['item']['subclass']['@attributes']['id'],
                    'ItemLevel' => $data['wowhead']['item']['level'],
                    'InventoryType' => $data['wowhead']['item']['inventorySlot']['@attributes']['id'],
                    'htmlTooltip' => $data['wowhead']['item']['htmlTooltip'],
                    'stackable' => $this->findStack($data['wowhead']['item']['htmlTooltip'], 'whtt-maxstack')
                ];

                if (!is_array($cacheData['icon'])) {
                    // make sure It's not in DB already
                    $result = $this->CI->db->query("SELECT COUNT(*) as count FROM item_template WHERE entry = ?", [$item])->getRow();
                    if ($result->count == 0) {
                        $this->CI->db->table('item_template')->insert($cacheData);
                    }

                    // save to cache
                    if ($enableCache)
                        $this->CI->cache->save('items/item_' . $realm . '_' . $item, $cacheData);
                } // return false in case of wowhead xml is broken (rare, but it happens)
                else {
                    return false;
                }

                return $this->getItemType($type, $cacheData);
            }
        }

        return false;
    }

    /**
     * Check if item is in cache
     *
     * @param Int $item
     * @param $realm
     * @param String $type
     * @return bool|string|array
     */
    public function getItemCache(int $item, $realm, string $type): mixed
    {
        // Get the item XML data
        $cache = $this->CI->cache->get('items/item_' . $realm . '_' . $item);

        // can we use the cache?
        if ($cache !== false) {
            return $this->getItemType($type, $cache);
        }

        return false;
    }

    /**
     * Check if item is in database
     *
     * @param Int $item
     * @param $realm
     * @param String $type
     * @return bool|string|array
     */
    public function getItemDB(int $item, $realm, string $type): mixed
    {
        // Get the item ID
        $query = $this->CI->db->query("SELECT * FROM item_template WHERE entry = ? LIMIT 1", [$item]);

        // Check for results
        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray()[0];

            // save to cache
            $this->CI->cache->save('items/item_' . $realm . '_' . $item, $row);

            return $this->getItemType($type, $row);
        }

        return false;
    }

    /**
     * Get a specific item row
     *
     * @param Int $item
     * @param Int $realm
     * @param String $type
     * @return bool|string|array|null
     */
    public function getItem(int $item, int $realm, string $type = 'all'): mixed
    {
        $cache = $this->CI->cache->get("items/item_" . $realm . "_" . $item);

        if ($cache !== false) {
            return $this->getItemType($type, $cache);
        } else {
            // Load the realm
            $realmObj = $this->CI->realms->getRealm($realm);

            // In patch 6.x.x and higher, item_template table has been removed from world DB.
            if ($realmObj->getExpansionId() > 4) {
                // check if item is in cache
                $item_in_cache = $this->getItemCache($item, $realm, $type);

                if ($item_in_cache) {
                    return $item_in_cache;
                } else {
                    // check if item is in database
                    $item_in_db = $this->getItemDB($item, $realm, $type);

                    if ($item_in_db) {
                        return $item_in_db;
                    } else {
                        // check if item is on Wowhead
                        return $this->getItemWowHead($item, $realm, $type);
                    }
                }
            }

            $db = $this->CI->load->database($realmObj->getConfig('world'), true);
            $query = $db->query(query('get_item', $realm), [$item]);

            if ($db->error()) {
                $error = $db->error();
                if ($error['code'] != 0) {
                    die($error["message"]);
                }
            }

            if ($query->getNumRows() > 0) {
                $row = $query->getResultArray()[0];

                // check if item is on Wowhead
                $item_wowhead = $this->getItemWowHead($item, $realm, 'all', false);

                if ($item_wowhead) {
                    $row['icon'] = $item_wowhead['icon'];
                    $row['displayid'] = $item_wowhead['displayid'];

                    if (!array_key_exists('htmlTooltip', $row)) {
                        $row['htmlTooltip'] = $item_wowhead['htmlTooltip'];
                    }
                } else {
                    $row['icon'] = 'inv_misc_questionmark';
                }

                $data = [
                    'item' => $this->getItemDataFromWorldDB($row),
                    'icon' => $row['icon'],
                    'api_item_icons' => $this->CI->config->item('api_item_icons')
                ];

                $row['htmlTooltip'] = CI::$APP->smarty->view(CI::$APP->template->view_path . "tooltip.tpl", $data, true);

                // Cache it forever
                $this->CI->cache->save("items/item_" . $realm . "_" . $item, $row);

                return $this->getItemType($type, $row);
            } else {
                // Cache it for 24 hours
                $this->CI->cache->save("items/item_" . $realm . "_" . $item, 'empty', 60 * 60 * 24);

                return false;
            }
        }
    }

    /**
     * Gather all data item needed
     */
    private function getItemDataFromWorldDB($itemDB)
    {
        // Assign them
        $bind = lang("bind", "wow_tooltip");
        $slots = lang("slots", "wow_tooltip");
        $damages = lang("damages", "wow_tooltip");

        // No item was found
        if (!$itemDB || $itemDB == "empty") {
            return lang("unknown_item", "tooltip");
        }

        $flags = $this->getFlags($itemDB['Flags']);

        $item['name'] = $itemDB['name'];

        // Support custom colors
        if (preg_match("/\|cff/", $itemDB['name'])) {
            while (preg_match("/\|cff/", $item['name'])) {
                $item['name'] = preg_replace("/\|cff([A-Za-z0-9]{6})(.*)(\|cff)?/", '<span style="color:#$1;">$2</span>', $item['name']);
            }
        }

        $item['quality'] = $itemDB['Quality'];
        $item['bind'] = $bind[$itemDB['bonding']];
        $item['unique'] = ($this->hasFlag(524288, $flags)) ? "Unique-Equipped" : null;
        $item['slot'] = $slots[$itemDB['InventoryType']];
        $item['durability'] = $itemDB['MaxDurability'];
        $item['armor'] = (array_key_exists("armor", $itemDB)) ? $itemDB['armor'] : false;
        $item['required'] = $itemDB['RequiredLevel'];
        $item['level'] = $itemDB['ItemLevel'];
        $item['type'] = $this->getType($itemDB['class'], $itemDB['subclass']);
        $item['damage_type'] = (array_key_exists("dmg_type1", $itemDB)) ? $damages[$itemDB['dmg_type1']] : false;

        if (array_key_exists("dmg_min1", $itemDB)) {
            $item['damage_min'] = $itemDB['dmg_min1'];
            $item['damage_max'] = $itemDB['dmg_max1'];
        } else {
            $item['damage_min'] = false;
            $item['damage_max'] = false;
        }

        $item['spells'] = $this->getSpells($itemDB);
        $item['attributes'] = $this->getAttributes($itemDB);
        $item['holy_res'] = (array_key_exists("holy_res", $itemDB)) ? $itemDB['holy_res'] : $this->getAttributeById(53, $itemDB);
        $item['fire_res'] = (array_key_exists("fire_res", $itemDB)) ? $itemDB['fire_res'] : $this->getAttributeById(51, $itemDB);
        $item['nature_res'] = (array_key_exists("nature_res", $itemDB)) ? $itemDB['nature_res'] : $this->getAttributeById(55, $itemDB);
        $item['frost_res'] = (array_key_exists("frost_res", $itemDB)) ? $itemDB['frost_res'] : $this->getAttributeById(52, $itemDB);
        $item['shadow_res'] = (array_key_exists("shadow_res", $itemDB)) ? $itemDB['shadow_res'] : $this->getAttributeById(54, $itemDB);
        $item['arcane_res'] = (array_key_exists("arcane_res", $itemDB)) ? $itemDB['arcane_res'] : $this->getAttributeById(56, $itemDB);
        $item['speed'] = ($itemDB['delay'] > 0) ? ($itemDB['delay'] / 1000) . "0" : 0;
        $item['dps'] = $this->getDPS($item['damage_min'], $item['damage_max'], $item['speed']);
        $item['sockets'] = $this->getSockets($itemDB);

        return $item;
    }

    /**
     * Get the sockets
     *
     * @param array $item
     * @return bool|string
     */
    private function getSockets(array $item): bool|string
    {
        if (!array_key_exists("socketColor_1", $item)) {
            return false;
        }

        $sockets = [
            1 => "meta",
            2 => "red",
            4 => "yellow",
            8 => "blue",
            14 => "prismatic",
            16 => "hydraulic",
            32 => "cogwheel",
            64 => "relic-iron",
            128 => "relic-blood",
            256 => "relic-shadow",
            512 => "relic-fel",
            1024 => "relic-arcane",
            2048 => "relic-frost",
            4096 => "relic-fire",
            8192 => "relic-water",
            16384 => "relic-life",
            32768 => "relic-storm",
            65536 => "relic-holy",
            131072 => "red-punchcard",
            262144 => "yellow-punchcard",
            524288 => "blue-punchcard",
            1048576 => "domination",
            4194304 => "tinker",
            8388608 => "primordial",
        ];

        $output = "";

        for ($i = 1; $i < 3; $i++) {
            $color = $item['socketColor_' . $i];
            if (isset($sockets[$color])) {
                $output .= "<span class='socket-{$sockets[$color]} q0'>" . lang($sockets[$color], "tooltip") . "</span><br />";
            }
        }

        return $output;
    }

    /**
     * Calculate DPS
     *
     * @param float $min
     * @param float $max
     * @param float $speed
     * @return float|int
     */
    private function getDPS(float $min, float $max, float $speed): float|int
    {
        if ($speed > 0) {
            return round((($min + $max) / 2) / $speed, 1);
        }

        return 0;
    }

    /**
     * Get the attributes
     *
     * @param array $item
     * @return array
     */
    private function getAttributes(array $item): array
    {
        $types = lang("stats", "wow_tooltip");

        $statCount = 10;
        $attributes = [
            "spells"  => [],
            "regular" => []
        ];

        for ($i = 1; $i <= $statCount; $i++) {
            if (!empty($item['stat_value' . $i]) && array_key_exists($item['stat_type' . $i], (array)$types)) {
                $type = "spells";

                $stat = '';
                // Mana/health
                if (in_array($item['stat_type' . $i], [42, 46])) {
                    $stat = "<span class='q2'>" . lang("restores", "tooltip") . " " . $item['stat_value' . $i] . " " . $types[$item['stat_type' . $i]] . "</span><br />";
                } elseif ($item['stat_type' . $i] > 7 && !in_array($item['stat_type' . $i], [42, 46])) {
                    $stat = "<span class='q2'>" . lang("increases", "tooltip") . " " . $types[$item['stat_type' . $i]] . lang("by", "tooltip") . " " . $item['stat_value' . $i] . ".</span><br />";
                } else {
                    if (array_key_exists($item['stat_type' . $i], (array)$types)) {
                        $type = "regular";
                        $stat = "+" . $item['stat_value' . $i] . " " . $types[$item['stat_type' . $i]] . "<br />";
                    }
                }

                $attributes[$type][] = ['id' => $item['stat_value' . $i], 'text' => $stat];
            }
        }

        return $attributes;
    }

    /**
     * Get attribute by the ID if any
     *
     * @param int $id
     * @param $item
     * @return bool|int
     */
    private function getAttributeById(int $id, $item): bool|int
    {
        $statCount = 10;

        for ($i = 1; $i <= $statCount; $i++) {
            if ($item['stat_type' . $i] == $id) {
                return $item['stat_value' . $i];
            }
        }

        return false;
    }

    /**
     * Get the spells
     *
     * @param array $item
     * @return array
     */
    private function getSpells(array $item): array
    {
        $spellTriggers = lang("spelltriggers", "wow_tooltip");

        $spellCount = 5;
        $spells = [];

        for ($i = 0; $i < $spellCount; $i++) {
            if (!empty($item['spellid_' . $i])) {
                $data = array(
                    "id" => $item['spellid_' . $i],
                    "trigger" => $spellTriggers[$item['spelltrigger_' . $i]],
                    "text" => $this->getSpellText($item['spellid_' . $i])
                );

                $spells[] = $data;
            }
        }

        return $spells;
    }

    private function getSpellText($id)
    {
        $cache = CI::$APP->cache->get("spells/spell_" . $id);

        if ($cache !== false) {
            return $cache;
        } else {
            $query = CI::$APP->db->query("SELECT spellText FROM spelltext_en WHERE spellId = ? LIMIT 1", [$id]);

            // Check for results
            if ($query->getNumRows() > 0) {
                $row = $query->getResultArray();

                $data = $row[0]['spellText'];
            } else {
                $data = false;
            }

            CI::$APP->cache->save("spells/spell_" . $id, $data);

            return $data;
        }
    }

    /**
     * Get the type
     *
     * @param int $class
     * @param int $subclass
     * @return string|null
     */
    private function getType(int $class, int $subclass): ?string
    {
        // Weapons
        if ($class == 2) {
            $sub = lang("weapon_sub", "wow_tooltip");

            return $sub[$subclass];
        }

        // Armor
        elseif ($class == 4) {
            $sub = lang("armor_sub", "wow_tooltip");

            return $sub[$subclass];
        }

        // Anything else
        else {
            return null;
        }
    }

    /**
     * Get flags as an array
     *
     * @param int $flags
     * @return array
     */
    private function getFlags(int $flags): array
    {
        $bits = [];

        for ($i = 1; $i <= $flags; $i *= 2) {
            if (($i & $flags) > 0) {
                $bits[] = $i;
            }
        }

        return $bits;
    }

    /**
     * Check if our flag array contains the flag
     *
     * @param int $flag
     * @param array $flags
     * @return bool
     */
    private function hasFlag(int $flag, array $flags): bool
    {
        if (in_array($flag, $flags)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Helper function to get an item type
     */
    private function getItemType(string $type, array $data): mixed
    {
        return match ($type) {
            'displayid' => $data['displayid'],
            'htmlTooltip' => $data['htmlTooltip'],
            'name' => $data['name'],
            'icon' => $data['icon'],
            default => $data,
        };
    }

    /**
     * XMLtoArray
     * @param string $xml
     * @return object|array|string $dom
     */
    private function XMLtoArray(string $xml): object|array|string
    {
        $previous_value = libxml_use_internal_errors(true);

        $dom = new DOMDocument('1.0', 'UTF-8');

        $dom->preserveWhiteSpace = false;

        $dom->loadXml($xml);

        libxml_use_internal_errors($previous_value);

        if (libxml_get_errors())
            return [];

        return $this->DOMtoArray($dom);
    }

    /**
     * DOMtoArray
     * @param object $dom
     * @return array|string $result
     */
    private function DOMtoArray(object $dom): array|string
    {
        $result = [];

        if ($dom->hasAttributes()) {
            foreach ($dom->attributes as $attr)
                $result['@attributes'][$attr->name] = $attr->value;
        }

        if ($dom->hasChildNodes()) {
            $groups = [];
            $children = $dom->childNodes;

            if ($children->length == 1) {
                $child = $children->item(0);

                if (in_array($child->nodeType, [XML_TEXT_NODE, XML_CDATA_SECTION_NODE])) {
                    $result['_value'] = $child->nodeValue;
                    return count($result) == 1 ? $result['_value'] : $result;
                }
            }

            foreach ($children as $child) {
                if (!isset($result[$child->nodeName])) {
                    $result[$child->nodeName] = $this->DOMtoArray($child);
                } else {
                    if (!isset($groups[$child->nodeName])) {
                        $groups[$child->nodeName] = 1;
                        $result[$child->nodeName] = array($result[$child->nodeName]);
                    }

                    $result[$child->nodeName][] = $this->DOMtoArray($child);
                }
            }
        }

        return $result;
    }

    /**
     * Find stack
     * @param string $html
     * @param string $class
     * @return array|int
     */
    private function findStack(string $html, string $class): array|int
    {
        // Create new object of DOMDocument
        $dom = new DOMDocument;

        //  Disable libxml errors
        libxml_use_internal_errors(true);

        // Load html
        $dom->loadHTML($html);

        // Create new object of DomXPath
        $finder = new DomXPath($dom);

        // Find nodes
        $nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $class ')]");

        // Node doesn't exists (return 1)
        if (!$nodes || $nodes->length == 0)
            return 1;

        // Find stackable
        return (int)filter_var($nodes->item(0)->textContent, FILTER_SANITIZE_NUMBER_INT);
    }
}
