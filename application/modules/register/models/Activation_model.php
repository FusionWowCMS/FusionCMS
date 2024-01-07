<?php

class Activation_model extends CI_Model
{
    public function add($username, $password, $email): string
    {
        $random_string = bin2hex(random_bytes(32));
        // Generate unique key
        $key = sha1($username . $email . $password . time() . $random_string);

        $data = [
            'username' => $username,
            'password' =>  $this->encrypt($username, $password),
            'email' => $email,
            'timestamp' => time(),
            'ip' => $this->input->ip_address(),
            'key' => $key
        ];

        $this->db->insert("pending_accounts", $data);

        return $key;
    }

    public function getAccount($key)
    {
        $query = $this->db->query("SELECT * FROM pending_accounts WHERE `key` = ?", [$key]);

        if($query->num_rows())
        {
            $row = $query->result_array();

            if(isset($row[0]['password']))
                $row[0]['password'] = $this->decrypt($row[0]['username'], $row[0]['password']);

            return $row[0];
        }
        else
        {
            return false;
        }
    }

    public function remove($id, $username, $email)
    {
        $this->db->query("DELETE FROM pending_accounts WHERE id = ? OR username = ? OR email = ?", [$id, $username, $email]);
    }

    /**
     * Basic two-way encryption
     * @param string $string
     * @param string $action
     * @param string $username
     * @return bool|string $output
     */
    private function crypt(string $string, string $action, string $username): bool|string
    {
        // Get keys cache
        $keys = $this->cache->get('register_activation_keys_' . $username);

        // Cache isn't available, generate keys
        if($keys === FALSE)
        {
            $keys = [
                'secret_key' => bin2hex(random_bytes(50)),
                'secret_iv'  => bin2hex(random_bytes(50))
            ];

            // Save the keys for later
            $this->cache->save('register_activation_keys_' . $username, $keys);
        }

        $encrypt_method = 'AES-256-CBC';
        $_key           = hash('sha256', $keys['secret_key']);
        $_iv            = substr(hash('sha256', $keys['secret_iv']), 0, 16);

        // Initialize output
        $output = false;

        switch($action)
        {
            case 'e':
                $output = base64_encode(openssl_encrypt($string, $encrypt_method, $_key, 0, $_iv)); # encrypt string
                break;

            case 'd':
                $output = openssl_decrypt(base64_decode($string), $encrypt_method, $_key, 0, $_iv); # decrypt string
                $this->cache->delete('register_activation_keys_' . $username . '.cache');                # delete related cache keys
                break;
        }

        return $output;
    }

    /**
     * Creates a hash of the password we enter
     * @param string $username
     * @param string $password
     * @return bool|string
     */
    private function encrypt(string $username, string $password): bool|string
    {
        return $this->crypt($password, 'e', $username);
    }

    /**
     * Decrypt hashed password we enter
     * @param string $username
     * @param string $password
     * @return bool|string
     */
    private function decrypt(string $username, string $password): bool|string
    {
        return $this->crypt($password, 'd', $username);
    }
}