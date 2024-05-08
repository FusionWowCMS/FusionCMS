<?php

class Activation_model extends CI_Model
{
    public function add($username, $password, $email): string
    {
        $random_string = bin2hex(random_bytes(32));
        // Generate unique key
        $key  = sha1($username . $email . $password . time() . $random_string);

        $_key = hash('sha256', bin2hex(random_bytes(50)));
        $_iv  = substr(hash('sha256', bin2hex(random_bytes(50))), 0, 16);

        $data = [
            'username' => $username,
            'password' =>  $this->encrypt($password, $_key, $_iv),
            'secret_key' =>  $_key,
            'secret_iv' =>  $_iv,
            'email' => $email,
            'timestamp' => time(),
            'ip' => $this->input->ip_address(),
            'key' => $key
        ];

        $this->db->table('pending_accounts')->insert($data);

        return $key;
    }

    public function getAccount($key)
    {
        $query = $this->db->query("SELECT * FROM pending_accounts WHERE `key` = ?", [$key]);

        if($query->getNumRows())
        {
            $row = $query->getResultArray();

            if(isset($row[0]['password']))
                $row[0]['password'] = $this->decrypt($row[0]['password'], $row[0]['secret_key'], $row[0]['secret_iv']);

            return $row[0];
        }
        else
        {
            return false;
        }
    }

    public function remove($id, $username, $email)
    {
        $this->db->table('pending_accounts')
                 ->where('id', $id)
                 ->where('username', $username)
                 ->where('email', $email)
                 ->delete();
    }

    /**
     * Basic two-way encryption
     * @param string $string
     * @param string $action
     * @param string $secret_key
     * @param string $secret_iv
     * @return bool|string $output
     */
    private function crypt(string $string, string $action, string $secret_key, string $secret_iv): bool|string
    {
        $encrypt_method = 'AES-256-CBC';

        // Initialize output
        $output = false;

        switch($action)
        {
            case 'e':
                $output = base64_encode(openssl_encrypt($string, $encrypt_method, $secret_key, 0, $secret_iv)); # encrypt string
                break;

            case 'd':
                $output = openssl_decrypt(base64_decode($string), $encrypt_method, $secret_key, 0, $secret_iv); # decrypt string
                break;
        }

        return $output;
    }

    /**
     * Creates a hash of the password we enter
     * @param string $password
     * @param string $secret_key
     * @param string $secret_iv
     * @return bool|string
     */
    private function encrypt(string $password, string $secret_key, string $secret_iv): bool|string
    {
        return $this->crypt($password, 'e', $secret_key, $secret_iv);
    }

    /**
     * Decrypt hashed password we enter
     * @param string $password
     * @param string $secret_key
     * @param string $secret_iv
     * @return bool|string
     */
    private function decrypt(string $password, string $secret_key, string $secret_iv): bool|string
    {
        return $this->crypt($password, 'd', $secret_key, $secret_iv);
    }
}