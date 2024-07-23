<?php

use CodeIgniter\Database\BaseResult;
use CodeIgniter\Database\Query;

class Read_model extends CI_Model
{
    public function reply($user_id, $sender_id, $title, $message): bool|BaseResult|Query
    {
        $data = [
            'user_id' => $user_id,
            'sender_id' => $sender_id,
            'message' => $message,
            'time' => time(),
            'title' => $title,
        ];

        return $this->db->table('private_message')->insert($data);
    }

    public function getMessages($id): bool|array
    {
        $query = $this->db->query("SELECT * FROM private_message WHERE id = ? AND (sender_id = ? OR user_id = ?) LIMIT 1", [$id, $this->user->getId(), $this->user->getId()]);

        if($query->getNumRows() > 0)
        {
            $result = $query->getResultArray();
            $result = $result[0];

            $query2 = $this->db->query("SELECT * FROM `private_message` WHERE (sender_id = ? AND user_id = ?) OR (sender_id = ? AND user_id = ?) ORDER BY `time` DESC LIMIT 5", [$result['sender_id'], $result['user_id'], $result['user_id'], $result['sender_id']]);
            $result2 = $query2->getResultArray();

            // We want the newest on the bottom
            return array_reverse($result2);
        }
        else
        {
            return false;
        }
    }

    public function markRead($user, $sender)
    {
        $this->db->query("UPDATE private_message SET `read` = 1 WHERE user_id = ? AND sender_id = ?", [$user, $sender]);
    }

    public function getLastTitle($id)
    {
        $query = $this->db->table('private_message')
            ->select('title')
            ->where(['sender_id' => $id])
            ->orderBy("id", "DESC")
            ->limit(1)
            ->get();

        if($query->getNumRows() > 0)
        {
            $result = $query->getResultArray();
            return $result[0]['title'];
        }
        else
        {
            return "Unknown sender";
        }
    }
}