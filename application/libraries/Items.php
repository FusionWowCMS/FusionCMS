<?php

use App\Config\Services;

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
        // Get the item XML data
        $response = Services::curlrequest()->get('https://www.wowhead.com/item=' . $item . '&xml');
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
                    'htmlTooltip' => $data['wowhead']['item']['htmlTooltip'],
                    'stackable' => $this->findStack($data['wowhead']['item']['htmlTooltip'], 'whtt-maxstack')
                ];

                if (!is_array($cacheData['icon'])) {
                    // make sure It's not in DB already
                    $result = $this->CI->db->query("SELECT COUNT(*) as count FROM item_template WHERE entry = ?", [$item])->row();
                    if ($result->count == 0) {
                        $this->CI->db->insert('item_template', $cacheData);
                    }

                    // save to cache
                    if ($enableCache)
                        $this->CI->cache->save('items/item_' . $realm . '_' . $item, $cacheData);
                } // return false in case of wowhead xml is broken (rare, but it happens)
                else {
                    return false;
                }

                return match ($type) {
                    'displayid' => $cacheData['displayid'],
                    'htmlTooltip' => $cacheData['htmlTooltip'],
                    'name' => $cacheData['name'],
                    'icon' => $cacheData['icon'],
                    default => $cacheData,
                };
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
            $iconIsArray = is_array($cache['icon']);
            $nameIsArray = is_array($cache['name']);

            return match ($type) {
                'displayid' => (!empty($cache['displayid']) ? $cache['displayid'] : false),
                'htmlTooltip' => $cache['htmlTooltip'],
                'name' => (!$nameIsArray ? $cache['name'] : false),
                'icon' => (!$iconIsArray ? $cache['icon'] : false),
                default => $cache,
            };
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
        if ($query->num_rows() > 0) {
            $row = $query->result_array()[0];

            // save to cache
            $this->CI->cache->save('items/item_' . $realm . '_' . $item, $row);

            return match ($type) {
                'displayid' => $row['displayid'],
                'htmlTooltip' => $row['htmlTooltip'],
                'name' => $row['name'],
                'icon' => $row['icon'],
                default => $row,
            };
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
            return match ($type) {
                'displayid' => $cache['displayid'],
                'htmlTooltip' => $cache['htmlTooltip'],
                'name' => $cache['name'],
                'icon' => $cache['icon'],
                default => $cache,
            };
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
                    $row = $query->result_array()[0];

                    // check if item is on Wowhead
                    $item_wowhead = $this->getItemWowHead($item, $realm, 'all', false);

                    if ($item_wowhead) {
                        $row['icon'] = $item_wowhead['icon'];
                        $row['displayId'] = $item_wowhead['displayid'];
                        $row['htmlTooltip'] = $item_wowhead['htmlTooltip'];
                    } else {
                        $row['icon'] = 'inv_misc_questionmark';
                    }

                    // Cache it forever
                    $this->CI->cache->save("items/item_" . $realm . "_" . $item, $row);

                    return match ($type) {
                        'displayid' => $row['displayid'],
                        'htmlTooltip' => $row['htmlTooltip'],
                        'name' => $row['name'],
                        'icon' => isset($row['icon']) ? $row['icon'] : 'inv_misc_questionmark',
                        default => $row,
                    };
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
        $result = array();

        if ($dom->hasAttributes()) {
            $attrs = $dom->attributes;

            foreach ($attrs as $attr)
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
