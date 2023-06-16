<?php

class Password_recovery_model extends CI_Model
{
    private $connection;

    public function __construct()
    {
        if (empty($this->connection))
        {
            $this->connection = $this->load->database("account", true);
        }
    }

    public function get_username($email)
    {
        $this->connection->select(column("account", "username"));
        $this->connection->from(table("account"));
        $this->connection->where(column("account", "email"), $email);
        $query = $this->connection->get();
        $result = $query->result_array();
        return $result[0][column("account", "username")];
    }

    public function get_token($token)
    {
        if ($token)
        {
            $this->db->select("*");
            $this->db->from("password_recovery_key");
            $this->db->where("recoverykey", $token);
            $query = $this->db->get();

            $result = $query->result_array();
            if (isset($result[0]["recoverykey"]) == $token)
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
            "recoverykey" => $token,
            "username" => $username,
            "email" => $email,
            "ip" => $ip,
            "time" => time(),
        ];

        $this->db->insert("password_recovery_key", $data);
        return true;
    }

    public function delete_token($token)
    {
        if (!$token)
        {
            return false;
        }

        $this->db->where("recoverykey", $token);
        $this->db->delete("password_recovery_key");
        return true;
    }
}
