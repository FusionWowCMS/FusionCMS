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

        $builder = $this->db->table('logs')->select('*');
        if ($logType != "") {
            $builder->where('type', $logType);
        }
        $builder->orderBy('time', 'DESC');
        if ($limit > 0 && $offset == 0) {
            $builder->limit($limit);
        }
        if ($limit > 0 && $offset > 0) {
            $builder->limit($limit, $offset);
        }
        $query = $builder->get();

        // Get the results
        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        } else {
            return null;
        }
    }

    public function getLogCount()
    {
        $query = $this->db->table('logs')->select("COUNT(id) 'count'")->get();

        if ($query->getNumRows() > 0) {
            $result = $query->getResultArray();
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
        $builder = $this->db->table('gm_log')->select();
        if ($logType != "") {
            $builder->where('type', $logType);
        }
        $builder->orderBy('time', 'DESC');
        if ($limit > 0 && $offset == 0) {
            $builder->limit($limit);
        }
        if ($limit > 0 && $offset > 0) {
            $builder->limit($limit, $offset);
        }
        $query = $builder->get();

        // Get the results
        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        } else {
            return null;
        }
    }

    public function createGMLogDb($action, $gm_id, $affected, $ip, $type, $realmId): void
    {
        $this->db->query("INSERT INTO `gm_log` (`action`, `gm_id`, `affected`, `ip`, `type`, `realm`, `time`) VALUES (?, ?, ?, ?, ?, ?, ?)", array($action, $gm_id, $affected, $ip, $type, $realmId, time()));
    }
}
