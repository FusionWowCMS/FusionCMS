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
        return $this->CI->items->getItem($id, $this->realmId);
    }
}
