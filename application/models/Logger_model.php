<?php

/**
 * @package FusionCMS
 * @author  Jesper Lindström
 * @author  Xavier Geerinck
 * @author  Elliott Robbins
 * @link    http://fusion-hub.com
 */

class Logger_model extends CI_Model
{
    public function getLogsDb(string $logType = "", int $offset = 0, int $limit = 0): ?array
    {
        if (($logType != "" && !is_string($logType)) || !is_numeric($limit) || !is_numeric($offset)) {
            return null;
        }

        $this->db->select('*');
        if ($logType != "") {
            $this->db->where('type', $logType);
        }
        $this->db->order_by('time', 'DESC');
        if ($limit > 0 && $offset == 0) {
            $this->db->limit($limit);
        }
        if ($limit > 0 && $offset > 0) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get('logs');

        // Get the results
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function getLogCount()
    {
        $this->db->select("COUNT(id) 'count'");
        $query = $this->db->get('logs');

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result[0]['count'];
        }

        return null;
    }

    public function createLogDb($module, $user, $type, $event, $message, $status, $custom, $ip): void
    {
        $this->db->query("INSERT INTO `logs` (`module`, `user_id`, `type`, `event`, `message`, `status`, `custom`, `ip`, `time`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)", array($module, $user, $type, $event, $message, $status, $custom, $ip, time()));
    }

    public function getGMLogsDb(string $logType = "", int $offset = 0, int $limit = 0): ?array
    {
        $this->db->select('*');
        if ($logType != "") {
            $this->db->where('type', $logType);
        }
        $this->db->order_by('time', 'DESC');
        if ($limit > 0 && $offset == 0) {
            $this->db->limit($limit);
        }
        if ($limit > 0 && $offset > 0) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get('gm_log');

        // Get the results
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function createGMLogDb($action, $gm_id, $affected, $ip, $type, $realmId): void
    {
        $this->db->query("INSERT INTO `gm_log` (`action`, `gm_id`, `affected`, `ip`, `type`, `realm`, `time`) VALUES (?, ?, ?, ?, ?, ?, ?)", array($action, $gm_id, $affected, $ip, $type, $realmId, time()));
    }
}
