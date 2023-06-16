<?php

class Tooltip extends MX_Controller
{
    private $id;
    private $realm;
    private $item;

    public function Index($realm = false, $id = false)
    {
        // Make sure item and realm are set
        if (!$id || !$realm) {
            die("No item or realm specified!");
        }

        $cache = $this->cache->get("items/tooltip_" . $realm . "_" . $id . "_" . getLang());

        if ($cache !== false) {
            die($cache);
        } else {
            // Assign values
            $this->id = $id;
            $this->realm = $realm;

            $this->getItemData();

            $data = array(
                    'module' => 'tooltip',
                    'item' => $this->item
                );

            $out = $this->template->loadPage("tooltip.tpl", $data);

            // Cache it
            $this->cache->save("items/tooltip_" . $realm . "_" . $id . "_" . getLang(), $out);

            die($out);
        }
    }

    /**
     * Gather all data needed
     */
    private function getItemData()
    {
        // Load constants
        $this->load->config("tooltip_constants");

        // Assign them
        $bind = $this->config->item("bind");
        $slots = $this->config->item("slots");
        $damages = $this->config->item("damages");

        // Load the realm
        $realmObj = $this->realms->getRealm($this->realm);

        // Get the item SQL data
        $item = $realmObj->getWorld()->getItem($this->id);

        // No item was found
        if (!$item || $item == "empty") {
            die(lang("unknown_item", "tooltip"));
        }

        $this->flags = $this->getFlags($item['Flags']);

        $this->item['name'] = $item['name'];

        // Support custom colors
        if (preg_match("/\|cff/", $item['name'])) {
            while (preg_match("/\|cff/", $this->item['name'])) {
                $this->item['name'] = preg_replace("/\|cff([A-Za-z0-9]{6})(.*)(\|cff)?/", '<span style="color:#$1;">$2</span>', $this->item['name']);
            }
        }

        $this->item['quality'] = $item['Quality'];
        $this->item['bind'] = $bind[$item['bonding']];
        $this->item['unique'] = ($this->hasFlag(524288)) ? "Unique-Equipped" : null;
        $this->item['slot'] = $slots[$item['InventoryType']];
        $this->item['durability'] = $item['MaxDurability'];
        $this->item['armor'] = (array_key_exists("armor", $item)) ? $item['armor'] : false;
        $this->item['required'] = $item['RequiredLevel'];
        $this->item['level'] = $item['ItemLevel'];
        $this->item['type'] = $this->getType($item['class'], $item['subclass']);
        $this->item['damage_type'] = (array_key_exists("dmg_type1", $item)) ? $damages[$item['dmg_type1']] : false;

        if (array_key_exists("dmg_min1", $item)) {
            $this->item['damage_min'] = $item['dmg_min1'];
            $this->item['damage_max'] = $item['dmg_max1'];
        }

        // For SkyFire: calculate weapon damage manually
        elseif ($item['class'] == 2) {
            $dmg = $this->calculateDamage($item);

            $this->item['damage_min'] = $dmg['min'];
            $this->item['damage_max'] = $dmg['max'];
        } else {
            $this->item['damage_min'] = false;
            $this->item['damage_max'] = false;
        }

        $this->item['spells'] = $this->getSpells($item);
        $this->item['attributes'] = $this->getAttributes($item);
        $this->item['holy_res'] = (array_key_exists("holy_res", $item)) ? $item['holy_res'] : $this->getAttributeById(53, $item);
        $this->item['fire_res'] = (array_key_exists("fire_res", $item)) ? $item['fire_res'] : $this->getAttributeById(51, $item);
        $this->item['nature_res'] = (array_key_exists("nature_res", $item)) ? $item['nature_res'] : $this->getAttributeById(55, $item);
        $this->item['frost_res'] = (array_key_exists("frost_res", $item)) ? $item['frost_res'] : $this->getAttributeById(52, $item);
        $this->item['shadow_res'] = (array_key_exists("shadow_res", $item)) ? $item['shadow_res'] : $this->getAttributeById(54, $item);
        $this->item['arcane_res'] = (array_key_exists("arcane_res", $item)) ? $item['arcane_res'] : $this->getAttributeById(56, $item);
        $this->item['speed'] = ($item['delay'] > 0) ? ($item['delay'] / 1000) . "0" : 0;
        $this->item['dps'] = $this->getDPS($this->item['damage_min'], $this->item['damage_max'], $this->item['speed']);
        $this->item['sockets'] = $this->getSockets($item);
    }

    private function calculateDamage($item)
    {
        /**
         * Algorithm needed!
         */

        $min = 0;
        $max = 0;

        return array(
            'min' => $min,
            'max' => $max
        );
    }

    /**
     * Get the sockets
     *
     * @param  Array $item
     * @return String
     */
    private function getSockets($item)
    {
        if (array_key_exists("socketColor_1", $item)) {
            $output = "";

            $meta = "<span class='socket-meta q0'>" . lang("meta", "tooltip") . "</span><br />";
            $red = "<span class='socket-red q0'>" . lang("red", "tooltip") . "</span><br />";
            $yellow = "<span class='socket-yellow q0'>" . lang("yellow", "tooltip") . "</span><br />";
            $blue = "<span class='socket-blue q0'>" . lang("blue", "tooltip") . "</span><br />";

            for ($i = 1; $i < 3; $i++) {
                switch ($item['socketColor_' . $i]) {
                    case 1:
                        $output .= $meta;
                        break;
                    case 2:
                        $output .= $red;
                        break;
                    case 4:
                        $output .= $yellow;
                        break;
                    case 8:
                        $output .= $blue;
                        break;
                }
            }

            return $output;
        } else {
            return false;
        }
    }

    /**
     * Calculate DPS
     *
     * @param  Float $min
     * @param  Float $max
     * @param  Float $speed
     * @return Float
     */
    private function getDPS($min, $max, $speed)
    {
        if ($speed > 0) {
            return round((($min + $max) / 2) / $speed, 1);
        }
    }

    /**
     * Get the attributes
     *
     * @param  Array $item
     * @return Array
     */
    private function getAttributes($item)
    {
        $types = $this->config->item("stats");

        $statCount = 10;
        $attributes = array(
                "spells" => array(),
                "regular" => array()
            );

        for ($i = 1; $i <= $statCount; $i++) {
            if (!empty($item['stat_value' . $i]) && array_key_exists($item['stat_type' . $i], $types)) {
                $type = "spells";

                // Mana/health
                if (in_array($item['stat_type' . $i], array(42,46))) {
                    $stat = "<span class='q2'>" . lang("restores", "tooltip") . " " . $item['stat_value' . $i] . " " . $types[$item['stat_type' . $i]] . "</span><br />";
                } elseif ($item['stat_type' . $i] > 7 && !in_array($item['stat_type' . $i], array(42,46))) {
                    $stat = "<span class='q2'>" . lang("increases", "tooltip") . " " . $types[$item['stat_type' . $i]] . lang("by", "tooltip") . " " . $item['stat_value' . $i] . ".</span><br />";
                } else {
                    if (array_key_exists($item['stat_type' . $i], $types)) {
                        $type = "regular";
                        $stat = "+" . $item['stat_value' . $i] . " " . $types[$item['stat_type' . $i]] . "<br />";
                    }
                }

                array_push($attributes[$type], array('id' => $item['stat_value' . $i], 'text' => $stat));
            }
        }

        return $attributes;
    }

    /**
     * Get attribute by the ID if any
     *
     * @param  Int $id
     * @return Int
     */
    private function getAttributeById($id, $item)
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
     * @param  Array $item
     * @return Array
     */
    private function getSpells($item)
    {
        $spelltriggers = $this->config->item("spelltriggers");

        $spellCount = 5;
        $spells = array();

        for ($i = 0; $i < $spellCount; $i++) {
            if (!empty($item['spellid_' . $i])) {
                $data = array(
                        "id" => $item['spellid_' . $i],
                        "trigger" => $spelltriggers[$item['spelltrigger_' . $i]],
                        "text" => $this->getSpellText($item['spellid_' . $i])
                    );

                array_push($spells, $data);
            }
        }

        return $spells;
    }

    private function getSpellText($id)
    {
        $cache = $this->cache->get("spells/spell_" . $id);

        if ($cache !== false) {
            return $cache;
        } else {
            $query = $this->db->query("SELECT spellText FROM spelltext_en WHERE spellId=? LIMIT 1", array($id));

            // Check for results
            if ($query->num_rows() > 0) {
                $row = $query->result_array();

                $data = $row[0]['spellText'];
            } else {
                $data = false;
            }

            $this->cache->save("spells/spell_" . $id, $data);

            return $data;
        }
    }

    /**
     * Get the type
     *
     * @param  Int $class
     * @param  Int $subclass
     * @return String
     */
    private function getType($class, $subclass)
    {
        // Weapons
        if ($class == 2) {
            $sub = $this->config->item("weapon_sub");

            return $sub[$subclass];
        }

        // Armor
        elseif ($class == 4) {
            $sub = $this->config->item("armor_sub");

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
     * @param  Int $flags
     * @return Array
     */
    private function getFlags($flags)
    {
        $bits = array();

        for ($i = 1; $i <= $flags; $i *= 2) {
            if (($i & $flags) > 0) {
                array_push($bits, $i);
            }
        }

        return $bits;
    }

    /**
     * Check if our flags array contains the flag
     *
     * @param  Int $flag
     * @return Boolean
     */
    private function hasFlag($flag)
    {
        if (in_array($flag, $this->flags)) {
            return true;
        } else {
            return false;
        }
    }
}
