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

class Items
{
	public function __construct()
	{
		$this->CI = &get_instance();
	}

	/**
	 * Check if item is in Wowhead
	 *
	 * @param  Int $item
	 * @param  String $type
	 * @return String
	 */
	public function getItemWowHead($item, $realm, $type = 'icon', $enableCache = true)
	{
		// Get the item XML data
		$data = @file_get_contents("https://www.wowhead.com/item=" . $item . "&xml");

		if (!isset($data))
			$data = $this->XMLtoArray($data);

		if (is_array($data) && !isset($data['wowhead']['error'])) {
			$cacheData['entry'] = $item;
			$cacheData['name'] = $data['wowhead']['item']['name'];
			$cacheData['icon'] = $data['wowhead']['item']['icon']['_value'];
			$cacheData['Quality'] = $data['wowhead']['item']['quality']['@attributes']['id'];
			$cacheData['displayid'] = $data['wowhead']['item']['icon']['@attributes']['displayId'];
			$cacheData['htmlTooltip'] = $data['wowhead']['item']['htmlTooltip'];
			$cacheData['stackable'] = $this->findStack($data['wowhead']['item']['htmlTooltip'], 'whtt-maxstack');

			if (!is_array($cacheData['icon'])) {
				// make sure its not in DB already
				$result = $this->CI->db->query("SELECT COUNT(*) as count FROM item_template WHERE entry = ?", [$item])->row();
				if ($result->count == 0) {
					$query = $this->CI->db->query("INSERT INTO item_template (entry, name, displayid, icon, quality, stackable, htmlTooltip) VALUES (?, ?, ?, ?, ?, ?, ?)", [$cacheData['entry'], $cacheData['name'], $cacheData['displayid'], $cacheData['icon'], $cacheData['Quality'], $cacheData['stackable'], $cacheData['htmlTooltip']]);
				}

				// save to cache
				if ($enableCache)
					$this->CI->cache->save('items/item_' . $realm . '_' . $item, $cacheData);
			}
			// return false in case of wowhead xml is broken (rare but it happens)
			else {
				return false;
			}

			switch ($type) {

				case 'all':
					return $cacheData;

				case 'displayid':
					return $cacheData['displayid'];

				case 'htmlTooltip':
					return $cacheData['htmlTooltip'];

				case 'name':
					return $cacheData['name'];

				case 'icon':
				default:
					return $cacheData['icon'];
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
	public function getItemCache($item, $realm, $type = 'icon')
	{
		// Get the item XML data
		$cache = $this->CI->cache->get('items/item_' . $realm . '_' . $item);
		// can we use the cache?
		if ($cache !== false) {
			$icon = $cache['icon'];
			$name = $cache['name'];
			$displayId = $cache['displayid'];
			$htmlTooltip = $cache['htmlTooltip'];

			switch ($type) {
				case 'all': {
						return $cache;
					}
				case 'displayid': {
						if (!is_array($displayId) && !empty($displayId)) {
							return $displayId;
						} else {
							return false;
						}
					}
				case 'htmlTooltip': {
						return $htmlTooltip;
					}
				case 'name': {
						if (!is_array($name)) {
							return $name;
						} else {
							return false;
						}
					}
				case 'icon':
				default: {
						if (!is_array($icon)) {
							return $icon;
						} else {
							return false;
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
	public function getItemDB($item, $realm, $type = 'icon')
	{
		// Get the item ID
		$query = $this->CI->db->query("SELECT * FROM item_template WHERE entry = ? LIMIT 1", [$item]);
		$row = null;

		// Check for results
		if ($query->num_rows() > 0) {
			$row = $query->result_array();

			$displayId = $row[0]['displayid'];
			$icon = $row[0]['icon'];
			$name = $row[0]['name'];
			$htmlTooltip = $row[0]['htmlTooltip'];

			// save to cache
			$this->CI->cache->save('items/item_' . $realm . '_' . $item, $row[0]);
		} else {
			return false;
		}

		switch ($type) {

			case 'all':
				return $row[0];

			case 'displayid':
				return $displayId;

			case 'htmlTooltip':
				return $htmlTooltip;

			case 'name':
				return $name;

			case 'icon':
			default:
				return $icon;
		}

		return false;
	}

	/**
	 * Get a specific item row
	 *
	 * @param  Int $item
	 * @param  Int $realm
	 * @param  String $type
	 * @return Array
	 */
	public function getItem($item, $realm, $type = 'all')
	{
		$cache = $this->CI->cache->get("items/item_" . $realm . "_" . $item);

		if ($cache !== false) {
			switch ($type) {
				case 'all':
				default:
					return $cache;

				case 'displayid':
					return $cache['displayid'];

				case 'htmlTooltip':
					return $cache['htmlTooltip'];

				case 'name':
					return $cache['name'];

				case 'icon':
					return $cache['icon'];
			}
		} else {
			// Load the realm
			$realmObj = $this->CI->realms->getRealm($realm);

			// In patch 6.x.x and higher, the item_template table has been removed.
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
						$item_wowhead = $this->getItemWowHead($item, $realm, $type);

						if ($item_wowhead) {
							return $item_wowhead;
						} else {
							return false;
						}
					}
				}
			} else {
				$db = $this->CI->load->database($realmObj->getConfig('world'), true);
				$query = $db->query(query('get_item', $realm), array($item));

				if ($db->error()) {
					$error = $db->error();
					if ($error['code'] != 0) {
						die($error["message"]);
					}
				}

				if ($query->num_rows() > 0) {
					$row = $query->result_array();

					// check if item is on Wowhead
					$item_wowhead = $this->getItemWowHead($item, $realm, 'all', false);

					if ($item_wowhead) {
						$row[0]['icon'] = $item_wowhead['icon'];
						$row[0]['displayId'] = $item_wowhead['displayid'];
						$row[0]['htmlTooltip'] = $item_wowhead['htmlTooltip'];
					}

					// Cache it forever
					$this->CI->cache->save("items/item_" . $realm . "_" . $item, $row[0]);

					switch ($type) {
						case 'all':
						default:
							return $row[0];

						case 'displayId':
							return $row[0]['displayid'];

						case 'htmlTooltip':
							return $row[0]['htmlTooltip'];

						case 'name':
							return $row[0]['name'];

						case 'icon':
							return $row[0]['icon'];
					}
				} else {
					// Cache it for 24 hours
					$this->CI->cache->save("items/item_" . $realm . "_" . $item, 'empty', 60 * 60 * 24);

					return false;
				}
			}
		}
	}

	/**
	 * XMLtoArray
	 * @param  string $xml
	 * @return object $dom
	 */
	private function XMLtoArray($xml)
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
	 * @param  object $dom
	 * @return string $result
	 */
	private function DOMtoArray($dom)
	{
		$result = array();

		if ($dom->hasAttributes()) {
			$attrs = $dom->attributes;

			foreach ($attrs as $attr)
				$result['@attributes'][$attr->name] = $attr->value;
		}

		if ($dom->hasChildNodes()) {
			$groups   = [];
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
	 * @param  string $html
	 * @param  string $class
	 * @return array
	 */
	private function findStack($html, $class)
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

		// Initialize result
		$result = '';

		// Find stackable
		$result = (int)filter_var($nodes->item(0)->textContent, FILTER_SANITIZE_NUMBER_INT);

		return $result;
	}
}
