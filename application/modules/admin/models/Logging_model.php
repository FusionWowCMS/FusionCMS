<?php

/**
 * @package FusionCMS
 * @version 6.X
 * @author  Jesper Lindström
 * @author  Xavier Geerinck
 * @link    http://fusion-hub.com
 */
class Logging_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Find logs by the given parameters
     *
     * @param  $search
     * @param  $module
     * @return bool
     */
    public function findLogs($search = "", $module = "")
    {
        if (!empty($search)) {
            if (!is_numeric($search)) {
                $userId = $this->user->getId($search);
            } else {
                $userId = $search;
            }
        }

        // prevent sql injection
        $module = $this->db->escape_str($module);

        if ($search) {
            $query = $this->db->query("SELECT * FROM `logs` WHERE " . (($module) ? "`module` = '" . $module . "' AND " : "") . " (`user_id` = ? OR `ip` = ?)", array($userId, $search));
        } else {
            $query = $this->db->query("SELECT * FROM `logs` " . (($module) ? "WHERE `module` = '" . $module . "'" : ""));
        }


        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function getLogs($id = false, $offset = 0, $limit = 0)
    {
        $this->db->select("*");
        $this->db->where('user_id', $id);
        $this->db->order_by('time', 'DESC');
        if ($limit > 0 && $offset == 0) {
            $this->db->limit($limit);
        }
        if ($limit > 0 && $offset > 0) {
            $this->db->limit(($offset + $limit), $offset);
        }
        $query = $this->db->get('logs');

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }
}
