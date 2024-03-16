<?php

use CodeIgniter\Database\BaseConnection;

class Password_recovery_model extends CI_Model
{
    private BaseConnection $connection;

    public function __construct()
    {
        if (empty($this->connection))
        {
            $this->connection = $this->load->database('account', true);
        }
    }

    public function get_username($email)
    {
        $builder = $this->connection->table(table('account'))->select(column('account', 'username'));
        $builder->where(column('account', 'email'), $email);
        $query = $builder->get();
        $result = $query->getResultArray();
        return $result[0][column('account', 'username')];
    }

    public function get_token($token)
    {
        if ($token)
        {
            $query = $this->db->table('password_recovery_key')->select()->where('recoverykey', $token)->get();

            $result = $query->getResultArray();
            if (isset($result[0]['recoverykey']) == $token)
            {
                return $result[0];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function insert_token($token, $username, $email, $ip)
    {
        if (!$token || !$username || !$email || !$ip)
        {
            return false;
        }

        $data = [
            'recoverykey' => $token,
            'username' => $username,
            'email' => $email,
            'ip' => $ip,
            'time' => time(),
        ];

        $this->db->table('password_recovery_key')->insert($data);
        return true;
    }

    public function delete_token($token)
    {
        if (!$token)
        {
            return false;
        }

        $this->db->table('password_recovery_key')->where('recoverykey', $token)->delete();
        return true;
    }
}
