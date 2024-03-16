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
        $module = $this->db->escapeString($module);

        if ($search) {
            $query = $this->db->query("SELECT * FROM `logs` WHERE " . (($module) ? "`module` = '" . $module . "' AND " : "") . " (`user_id` = ? OR `ip` = ?)", array($userId, $search));
        } else {
            $query = $this->db->query("SELECT * FROM `logs` " . (($module) ? "WHERE `module` = '" . $module . "'" : ""));
        }


        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        } else {
            return false;
        }
    }

    public function getLogs($id = false, $offset = 0, $limit = 0)
    {
        if (!is_numeric($id) || !is_numeric($limit) || !is_numeric($offset)) {
            return null;
        }

        $builder = $this->db->table('logs')->select();
        $builder->where('user_id', $id);
        $builder->orderBy('time', 'DESC');
        if ($limit > 0 && $offset == 0) {
            $builder->limit($limit);
        }
        if ($limit > 0 && $offset > 0) {
            $builder->limit(($offset + $limit), $offset);
        }
        $query = $builder->get();

        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        } else {
            return null;
        }
    }
}
