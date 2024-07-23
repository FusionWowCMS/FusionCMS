<?php

class inbox_model extends CI_Model
{
    private bool|int $inbox = false;
    private bool|int $sent = false;

    public function getMessages($userId, $start = 0, $limit = 1): bool|array
    {
        $query = $this->db->table('private_message')
            ->where(['user_id' => $userId, 'deleted_user' => 0])
            ->orderBy('time', 'DESC')
            ->limit($limit, $start)
            ->get();

        if($query->getNumRows() > 0)
        {
            return $query->getResultArray();
        }
        else
        {
            return false;
        }
    }

    public function countMessages($userId)
    {
        if($this->inbox === false)
        {
            $query = $this->db->table('private_message')
                ->select('COUNT(*)')
                ->where(['user_id' => $userId, 'deleted_user' => 0])
                ->get();

            if($query->getNumRows() > 0)
            {
                $result = $query->getResultArray();
                $this->inbox = $result[0]['COUNT(*)'];

                return $result[0]['COUNT(*)'];
            }
            else
            {
                $this->inbox = 0;
                return false;
            }
        }
        else
        {
            return $this->inbox;
        }
    }

    public function getSent($userId, $start = 0, $limit = 1): bool|array
    {
        $query = $this->db->table('private_message')
            ->where(['sender_id' => $userId, 'deleted_sender' => 0])
            ->orderBy('time', 'DESC')
            ->limit($limit, $start)
            ->get();

        if($query->getNumRows() > 0)
        {
            return $query->getResultArray();
        }
        else
        {
            return false;
        }
    }

    public function countSent($userId)
    {
        if($this->sent === false)
        {
            $query = $this->db->table('private_message')
                ->select('COUNT(*)')
                ->where(['sender_id' => $userId, 'deleted_sender' => 0])
                ->get();

            if($query->getNumRows() > 0)
            {
                $result = $query->getResultArray();
                $this->sent = $result[0]['COUNT(*)'];
                return $result[0]['COUNT(*)'];
            }
            else
            {
                $this->sent = 0;
                return false;
            }
        }
        else
        {
            return $this->sent;
        }
    }

    public function clear($id, $sent = false): void
    {
        if($sent)
        {
            $this->db->query("UPDATE private_message SET deleted_sender = 1 WHERE sender_id = ?", [$id]);
        }
        else
        {
            $this->db->query("UPDATE private_message SET deleted_user = 1, `read`=1 WHERE user_id = ?", [$id]);
        }

        $this->cache->delete("messages/".$this->user->getId()."_*");
    }

    public function clearDeleted($id)
    {
        $this->db->query("DELETE FROM private_message WHERE deleted_user = 1 AND deleted_sender = 1 AND (user_id = ? OR sender_id = ?)", [$id, $id]);
    }
}