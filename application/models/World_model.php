<?php

/**
 * @package FusionCMS
 * @author  Jesper Lindström
 * @author  Xavier Geerinck
 * @author  Elliott Robbins
 * @link    http://fusion-hub.com
 */

class World_model
{
    private $db;
    private $config;
    private $CI;
    private $realmId;

    /**
     * Initialize the realm
     *
     * @param Array $config Database config
     */
    public function __construct($config)
    {
        $this->config = $config;
        $this->CI = &get_instance();
        $this->realmId = $this->config['id'];
    }

    /**
     * Connect to the database if not already connected
     */
    public function connect()
    {
        if (empty($this->db)) {
            $this->db = $this->CI->load->database($this->config['world'], true);
        }
    }

    public function getConnection()
    {
        $this->connect();

        return $this->db;
    }

    /**
     * Get a specific item row
     *
     * @param  Int $realm
     * @param  Int $id
     * @return Array
     */
    public function getItem($id)
    {
        $cache = $this->CI->cache->get("items/item_" . $this->realmId . "_" . $id);

        if ($cache !== false) {
            return $cache;
        } else {
            $this->connect();

            $query = $this->db->query(query('get_item', $this->realmId), array($id));

            if ($this->db->error()) {
                $error = $this->db->error();
                if ($error['code'] != 0) {
                    die($error["message"]);
                }
            }

            if ($query->num_rows() > 0) {
                $row = $query->result_array();

                // Cache it forever
                $this->CI->cache->save("items/item_" . $this->realmId . "_" . $id, $row[0]);

                return $row[0];
            } else {
                // Cache it for 24 hours
                $this->CI->cache->save("items/item_" . $this->realmId . "_" . $id, 'empty', 60 * 60 * 24);

                return false;
            }
        }
    }
}
