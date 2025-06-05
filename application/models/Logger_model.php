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
    public function getLogsDb($logType = "", int $offset = 0, int $limit = 0, int $accountId = 0, $event = ''): array
    {
        if (($logType != "" && !is_string($logType)) || (!is_string($event) && !is_array($event)) || !is_numeric($limit) || !is_numeric($offset) || !is_numeric($accountId)) {
            return [];
        }

        $builder = $this->db->table('logs')->select('*');

        if ($logType != "") {
            $builder->where('type', $logType);
        }

        if (!empty($event)) {
            if (is_array($event)) {
                $builder->whereIn('event', $event);
            } else {
                $builder->where('event', $event);
            }
        }

        if ($accountId > 0) {
            $builder->where('user_id', $accountId);
        }

        $builder->orderBy('time', 'DESC');

        if ($limit > 0) {
            $builder->limit($limit, $offset);
        }

        $query = $builder->get();

        // Get the results
        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        } else {
            return [];
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
        $this->db->table('logs')
            ->insert([
                'module'  => $module,
                'user_id' => $user,
                'type'    => $type,
                'event'   => $event,
                'message' => $message,
                'status'  => $status,
                'custom'  => $custom,
                'ip'      => $ip,
                'time'    => time(),
            ]);
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
        $this->db->table('gm_log')
            ->insert([
                'action'   => $action,
                'gm_id'    => $gm_id,
                'affected' => $affected,
                'ip'       => $ip,
                'type'     => $type,
                'realm'    => $realmId,
                'time'     => time(),
            ]);
    }
}
