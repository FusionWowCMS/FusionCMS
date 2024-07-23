<?php

use CodeIgniter\Database\BaseResult;
use CodeIgniter\Database\Query;

class Create_model extends CI_Model
{
    public function insertMessage($user_id, $sender_id, $title, $message): bool|BaseResult|Query
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

    public function getUsersLike($username): bool|array
    {
        $query = $this->db->table('account_data')
            ->select('nickname')
            ->like('nickname', $username)
            ->limit(5)
            ->get();

        $result = $query->getResultArray();

        if($query->getNumRows() == 0) {
            return false;
        } else if($query->getNumRows() == 1 && $result[0]['nickname'] == $username) {
            return true;
        } else {
            $usernames = [];

            foreach($result as $value)
            {
                $usernames[] = $value['nickname'];
            }

            usort($usernames, 'sortIt');

            if(in_array($username, $usernames))
            {
                return true;
            }
            else
            {
                return $usernames;
            }
        }
    }
}

function sortIt($a, $b): int
{
    return strlen($a) - strlen($b);
}