<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * @package FusionCMS
 *
 * @author  Keramat Jokar (Nightprince) <https://github.com/Nightprince>
 * @link    https://github.com/FusionWowCMS/FusionCMS
 */

class WowheadItems
{
    public function __construct()
    {
        $this->CI = &get_instance();
    }

    /**
     * Convert XML data to an array
     *
     * @param  String $xml
     * @return Array
     */
    private function xmlToArray($xml)
    {
        $xml = simplexml_load_string($xml,'SimpleXMLElement', LIBXML_NOCDATA);
        $json = json_encode($xml);
        $array = json_decode($json, true);

        return $array;
    }

    /**
     * Check if item is in Wowhead
     *
     * @param  Int $item
     * @param  String $type
     * @return String
     */
    public function get_item_wowhead($item, $realm, $type = 'icon')
    {
        // Get the item XML data
        $data = file_get_contents("https://www.wowhead.com/item=" . $item . "&xml");

        $itemData = $this->xmlToArray($data);

        if (!isset($data->error) && !isset($itemData['error']))
        {
            $xml = simplexml_load_string($data);
            $icon = $itemData['item']['icon'];
            $name = $itemData['item']['name'];
            $displayId = $xml->item[0]->icon['displayId'];
            $htmlTooltip = $itemData['item']['htmlTooltip'];

            if (!is_array($icon))
            {
                // make sure its not in DB already
                $result = $this->CI->db->query("SELECT COUNT(*) as count FROM item_template WHERE entry = ?", [$item])->row();
                if ($result->count == 0)
                {
                    if (!is_array($displayId) && !empty($displayId))
                        $query = $this->CI->db->query("INSERT INTO item_template (entry, name, displayid, icon, data) VALUES (?, ?, ?, ?, ?)", [$item, $name, $displayId, $icon, $data]);
                    else
                        $query = $this->CI->db->query("INSERT INTO item_template (entry, name, icon, data) VALUES (?, ?, ?, ?)", [$item, $name, $icon, $data]);
                }

                // save to cache
                $this->CI->cache->save('items/item_' . $realm . '_' . $item, $data);
            }
            // return false in case of wowhead xml is broken (rare but it happens)
            else {
                return false;
            }

            switch($type) {

				case 'displayId':
					return $displayId;

				case 'htmlTooltip':
					return $htmlTooltip;

				case 'name':
					return $name;

				case 'icon':
				default:
					return $icon;
            }
        }

        return false;
    }

    /**
     * Check if item is in cache
     *
     * @param  Int $item
     * @param  String $type
     * @return String
     */
    public function get_item_cache($item, $realm, $type = 'icon')
    {
        // Get the item XML data
        $xml = $this->CI->cache->get('items/item_' . $realm . '_' . $item);
        // can we use the cache?
        if ($xml !== false)
        {
			$itemData = $this->xmlToArray($xml);

			if (!isset($xml->error) && !isset($itemData['error']))
			{
				$xml = simplexml_load_string($xml);
				$icon = $itemData['item']['icon'];
				$name = $itemData['item']['name'];
				$displayId = $xml->item[0]->icon['displayId'];
				$htmlTooltip = $itemData['item']['htmlTooltip'];

				switch($type) {
					case 'displayId': {
						if (!is_array($displayId) && !empty($displayId)) {
							return $displayId;
						}
						else
						{
							return false;
						}
					}
					case 'htmlTooltip': {
						return $htmlTooltip;
					}
					case 'name': {
						if (!is_array($name)) {
							return $name;
						}
						else
						{
							return false;
						}
					}
					case 'icon':
					default: {
						if (!is_array($icon)) {
							return $icon;
						}
						else
						{
							return false;
						}
					}
				}
			}
        }

        return false;
    }

    /**
     * Check if item is in database
     *
     * @param  Int $item
     * @param  String $type
     * @return String
     */
    public function get_item_db($item, $realm, $type = 'icon')
    {
        // Get the item ID
        $query = $this->CI->db->query("SELECT * FROM item_template WHERE entry = ? LIMIT 1", [$item]);

        // Check for results
        if ($query->num_rows() > 0)
        {
            $row = $query->result_array();

            $displayId = $row[0]['displayid'];
            $icon = $row[0]['icon'];
            $name = $row[0]['name'];
            $xml = $row[0]['data'];

            // save to cache
            $this->CI->cache->save('items/item_' . $realm . '_' . $item, $xml);
        }
        else
        {
            return false;
        }

        switch($type) {

			case 'displayId':
				return $displayId;

			case 'htmlTooltip': {
				$itemData = $this->xmlToArray($xml);
				if (!isset($xml->error) && !isset($itemData['error']))
				{
					$xml = simplexml_load_string($xml);
					$htmlTooltip = $itemData['item']['htmlTooltip'];
					return $htmlTooltip;
				}
				return false;
			}

			case 'name':
				return $name;

			case 'icon':
			default:
				return $icon;
        }

        return false;
    }
}
