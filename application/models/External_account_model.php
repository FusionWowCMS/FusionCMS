<?php

use App\Config\Services;
use MX\CI;

/**
 * @package FusionCMS
 * @author  Jesper Lindström
 * @author  Xavier Geerinck
 * @author  Elliott Robbins
 * @link    http://fusion-hub.com
 */

class External_account_model extends CI_Model
{
    private $connection;
    private $id;
    private $username;
    private $password;
    private $email;
    private $joindate;
    private $last_ip;
    private $last_login;
    private $expansion;
    private $account_cache;
    private $totp_secret;

    public function __construct()
    {
        parent::__construct();

        $this->account_cache = [];

        if ($this->user->getOnline()) {
            $this->initialize();
        } else {
            $this->id = 0;
            $this->username = "Guest";
            $this->password = "";
            $this->email = "";
            $this->joindate =  "";
            $this->expansion = 0;
            $this->last_ip =  "";
            $this->last_login = "";
            $this->totp_secret = "";
        }
    }

    public function getConnection()
    {
        $this->connect();

        return $this->connection;
    }

    public function connect()
    {
        if (empty($this->connection)) {
            $this->connection = $this->load->database("account", true);
        }
    }

    public function initialize($where = false)
    {
        $this->connect();

        $encryption = $this->config->item('account_encryption');
        $totp_secret_name = $this->config->item('totp_secret_name');

        if (preg_match("/^cmangos/i", get_class($this->realms->getEmulator()))) {
            if (!$where) {
                $query = $this->connection->query(query('get_account_id'), [Services::session()->get('uid')]);
            } else {
                $query = $this->connection->query(query('get_account'), [$where]);
            }
        } else {
            $columns = CI::$APP->realms->getEmulator()->getAllColumns(table('account'));

            if ($encryption == 'SPH') {
                if (column('account', 'verifier') && column('account', 'salt')){
                    unset($columns[column('account', 'verifier')]);
                    unset($columns[column('account', 'salt')]);
                }
            } elseif ($encryption == 'SRP6' || $encryption == 'SRP') {
                if (column('account', 'sha_pass_hash')){
                    unset($columns[column('account', 'sha_pass_hash')]);
                }
            }

            if ($this->config->item('totp_secret')) {
                $columns['totp_secret'] = $totp_secret_name == 'totp_secret' ? 'totp_secret' : 'token_key';
            }

            if (!$where) {
                $query = $this->connection->query('SELECT ' . formatColumns($columns) . ' FROM ' . table('account') . ' WHERE ' . column('account', 'id') . ' = ?', [Services::session()->get('uid')]);
            } else {
                $query = $this->connection->query('SELECT ' . formatColumns($columns) . ' FROM ' . table('account') . ' WHERE ' . column('account', 'username') . ' = ?', [$where]);
            }
        }

        if (!$query)
            show_error('Database Error occurs: ' . $this->connection->error()['message'] . "<br/>Please check website database `realms.emulator` in 'field list' <b>(make sure you selected right emulator.)</b>");

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $result = $result[0];

            $this->id = $result['id'];
            $this->username = $result['username'];
            $this->password = $encryption == 'SPH' ? $result['sha_pass_hash'] : $result['verifier'];
            $this->email = $result['email'];
            $this->joindate = $result['joindate'];
            $this->expansion = $result['expansion'];
            $this->last_ip = $result['last_ip'];
            $this->last_login = $result['last_login'];
            $this->totp_secret = $result['totp_secret'] ?? '';

            return true;
        } else {
            $this->id = 0;
            $this->username = 'Guest';
            $this->password = '';
            $this->email = '';
            $this->joindate =  '';
            $this->expansion = 0;
            $this->last_ip =  '';
            $this->last_login = '';
            $this->totp_secret = '';

            return false;
        }
    }

    /**
     * Create a new account
     *
     * @param String $username
     * @param String $password
     * @param String $email
     */
    public function createAccount(string $username, string $password, string $email)
    {
        $this->connect();

        $expansion = $this->config->item('max_expansion');

        $encryption = $this->config->item('account_encryption');

        $data = [
            column("account", "username") => strtoupper($username),
            column("account", "email") => $email,
            column("account", "expansion") => $expansion,
            column("account", "joindate") => date("Y-m-d H:i:s")
        ];

        list($hash, $data) = $this->setAccountPassword($encryption, $username, $password, $data);

        if (!preg_match("/^cmangos/i", get_class($this->realms->getEmulator())))
        {
            $data[column("account", "last_ip")] = $this->input->ip_address();
        }

        $userId = $this->connection->insert(table("account"), $data);

        if (preg_match("/^cmangos/i", get_class($this->realms->getEmulator())))
        {
            $ip_data = [
                'accountId' => $userId,
                'ip' => $this->input->ip_address(),
                'loginTime' => date("Y-m-d H:i:s"),
                'loginSource' => '0'
            ];

            $this->connection->insert(table("account_logons"), $ip_data);
        }

        $userId = $this->user->getId($username);

        // Battlenet accounts
        if ($this->config->item('battle_net')) {
            $battleData = [
                column("battlenet_accounts", "id") => $userId,
                column("battlenet_accounts", "email") => strtoupper($email),
                column("battlenet_accounts", "last_ip") => $this->input->ip_address(),
                column("battlenet_accounts", "joindate") => date("Y-m-d H:i:s")
            ];
            list($hash, $battleData) = $this->setBattleNetPassword($email, $password, $battleData);

            $this->connection->insert(table("battlenet_accounts"), $battleData);

            $this->connection->query("UPDATE account SET battlenet_account = $userId, battlenet_index = 1 WHERE id = $userId", [$userId]);
        }

        // Fix for TrinityCore RBAC (or any emulator with 'rbac')
        if ($this->config->item('rbac')) {
            $rbac_data = [
                'accountId'    => $userId,
                'permissionId' => 195,
                'granted'      => 1,
                'realmId'      => -1
            ];
            $this->connection->insert('rbac_account_permissions', $rbac_data);
        }

        $this->updateDailySignUps();
    }

    private function updateDailySignUps()
    {
        $query = $this->db->query("SELECT COUNT(*) AS `total` FROM daily_signups WHERE `date`=?", [date("Y-m-d")]);

        $row = $query->result_array();

        if ($row[0]['total']) {
            $this->db->query("UPDATE daily_signups SET amount = amount + 1 WHERE `date`=?", [date("Y-m-d")]);
        } else {
            $this->db->query("INSERT INTO daily_signups(`date`, amount) VALUES(?, ?)", [date("Y-m-d"), 1]);
        }
    }

    /**
     * Get the banned status
     *
     * @param Int $id
     * @return Boolean
     */
    public function getBannedStatus(int $id)
    {
        $this->connect();

        $query = $this->connection->query(query("get_banned"), [$id]);

        if ($query->num_rows() > 0) {
            $row = $query->result_array();

            return $row[0];
        } elseif (query('get_ip_banned')) {
            //check if the ip is banned
            $query = $this->connection->query(query("get_ip_banned"), [$this->input->ip_address(), time()]);

            if ($query->num_rows() > 0) {
                $row = $query->result_array();

                return $row[0];
            } else {
                return false;
            }
        }
    }

    /**
     * Get the rank
     *
     * @param false|String $value
     * @param Boolean $isUsername
     * @return int
     */
    public function getRank(false|string $value = false, bool $isUsername = false)
    {
        $this->connect();

        if (!$value) {
            $value = $this->getId();
        } elseif ($isUsername) {
            $value = $this->getId($value);
        }

        $query = $this->connection->query(query("get_rank"), [$value]);

        if ($query->num_rows() > 0) {
            $row = $query->result_array();

            if ($row[0]["gmlevel"] == "") {
                $row[0]["gmlevel"] = 0;
            }

            return $row[0]["gmlevel"];
        } else {
            return 0;
        }
    }

    /**
     * Check if a username exists
     *
     * @param String $username
     * @return Boolean
     */
    public function usernameExists(string $username)
    {
        $this->connect();

        $count = $this->connection->from(table("account"))->where([column("account", "username") => $username])->count_all_results();

        if ($count) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get total amount of accounts
     *
     * @return Int
     */
    public function getAccountCount()
    {
        $this->connect();

        $query = $this->connection->query("SELECT COUNT(*) as `total` FROM " . table("account"));
        $row = $query->result_array();

        return $row[0]['total'];
    }

    /**
     * Check if an user id exists
     *
     * @param  Int $id
     * @return Boolean
     */
    public function userExists($id)
    {
        $this->connect();

        $count = $this->connection->from(table("account"))->where([column("account", "id") => $id])->count_all_results();

        if ($count) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if an email exists
     *
     * @param String $email
     * @return Boolean
     */
    public function emailExists(string $email)
    {
        $this->connect();

        $count = $this->connection->from(table("account"))->where([column("account", "email") => $email])->count_all_results();

        if ($count) {
            return true;
        } else {
            return false;
        }
    }

    /*
    | -------------------------------------------------------------------
    |  Setters
    | -------------------------------------------------------------------
    */
    public function setUsername($oldUsername, $newUsername)
    {
        $this->connect();

        $this->connection->where(column("account", "username"), $oldUsername);
        $this->connection->update(table("account"), [column("account", "username") => $newUsername]);
    }

    public function setPassword($username, $email, $newPassword)
    {
        $this->connect();

        $this->connection->where(column("account", "username"), $username);

        $data = [];

        if (column("account", "v") && column("account", "s") && column("account", "sessionkey")) {
            $data = [
                column("account", "v") => "",
                column("account", "s")  => "",
                column("account", "sessionkey") => "",
            ];
        }

        $encryption = $this->config->item('account_encryption');

        list($hash, $data) = $this->setAccountPassword($encryption, $username, $newPassword, $data);

        $this->connection->update(table("account"), $data);

        $userId = $this->user->getId($username);

        // Battlenet accounts
        if ($this->config->item('battle_net')) {
            $this->connection->flush_cache();
            $this->connection->where(column("battlenet_accounts", "email"), strtoupper($email));

            $battleData = [
                column("battlenet_accounts", "last_ip") => $this->input->ip_address(),
                column("battlenet_accounts", "joindate") => date("Y-m-d H:i:s")
            ];
            list($hash, $battleData) = $this->setBattleNetPassword($email, $newPassword, $battleData);

            $this->connection->update(table("battlenet_accounts"), $battleData);
        }

        CI::$APP->plugins->onChangePassword($userId, $hash);
    }

    public function setEmail($username, $newEmail)
    {
        $this->connect();

        $this->connection->where(column("account", "username"), $username);
        $this->connection->update(table("account"), [column("account", "email") => $newEmail]);
    }

    public function setExpansion($newExpansion, $username = false)
    {
        $this->connect();

        if ($username)
        {
            // Update only the expansion column for the given username
            $this->connection->where(column("account", "username"), $username);
        }

        // Update the 'expansion' column for all users
        $this->connection->update(table("account"), [column("account", "expansion") => $newExpansion]);
    }

    public function setRank($userId, $newRank)
    {
        $this->connect();

        $this->connection->where(column("account", "id"), $userId);

        if (preg_match("/^trinity/i", get_class($this->realms->getEmulator()))) {
            $this->connection->update(table("account_access"), [column("account_access", "SecurityLevel") => $newRank]);
        } elseif (preg_match("/^cmangos/i", get_class($this->realms->getEmulator()))) {
            $this->connection->update(table("account"), [column("account", "gmlevel") => $newRank]);
        } else {
            $this->connection->update(table("account_access"), [column("account_access", "gmlevel") => $newRank]);
        }
    }

    public function setLastIp($userId, $ip)
    {
        $this->connect();

        $this->connection->where(column("account", "id"), $userId);

        if (preg_match("/^cmangos/i", get_class($this->realms->getEmulator()))) {
            $data = [
                'accountId' => $userId,
                'ip' => $ip,
                'loginTime' => date("Y-m-d H:i:s"),
                'loginSource' => '0'
            ];

            $this->connection->insert(table("account_logons"), $data);
        } else {
            $this->connection->update(table("account"), [column("account", "last_ip") => $ip]);
        }
    }

    /*
    | -------------------------------------------------------------------
    |  Getters
    | -------------------------------------------------------------------
    */
    public function getId($username = false)
    {
        if (!$username) {
            return $this->id;
        } else {
            $this->connect();

            $this->connection->select(column("account", "id", true))->from(table("account"))->where(column("account", "username"), $username);
            $query = $this->connection->get();

            if ($query->num_rows() > 0) {
                $result = $query->result_array();

                return $result[0]["id"];
            } else {
                //Return id 0
                return false;
            }
        }
    }

    /**
     * Get the username
     *
     * @param  Int $id
     * @return String
     */
    public function getUsername($id = false)
    {
        if (!$id) {
            return $this->username;
        } else {
            $this->connect();

            $this->connection->select(column("account", "username", true))->from(table("account"))->where([column("account", "id") => $id]);
            $query = $this->connection->get();

            if ($query->num_rows() > 0) {
                $result = $query->result_array();

                return $result[0]["username"];
            } else {
                return "Unknown";
            }
        }
    }

    /**
     * Get the username
     *
     * @param  Int $id
     * @return String
     */
    public function getInfo($id = false, $fields = "*")
    {
        if (!$id) {
            $id = $this->id;
        }

        if ($fields != "*" && !is_array($fields)) {
            $fields = preg_replace("/ /", "", $fields);
            $fields = explode(",", $fields);
            $fields = columns("account", $fields);
        }

        $this->connect();

        $this->connection->select($fields)->from(table("account"))->where([column("account", "id") => $id]);
        $query = $this->connection->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();

            return $result[0];
        } else {
            return false;
        }
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getEmail($id = false)
    {
        if (!$id) {
            return $this->email;
        } else {
            // Check if it has been loaded already
            if (array_key_exists($id, $this->account_cache)) {
                return $this->account_cache[$id]['email'];
            } else {
                $this->connect();

                $this->connection->select(column("account", "username", true) . ',' . column("account", "email") . ',' . column("account", "joindate"))->from(table("account"))->where([column("account", "id") => $id]);
                $query = $this->connection->get();

                if ($query->num_rows() > 0) {
                    $result = $query->result_array();
                    $this->account_cache[$id] = $result[0];

                    return $result[0]["email"];
                } else {
                    $this->account_cache[$id]["email"] = false;

                    return false;
                }
            }
        }
    }

    public function getIdByEmail($email = false)
    {
        if (!$email) {
            return $this->id;
        } else {
            // Check if it has been loaded already
            if (array_key_exists($email, $this->account_cache)) {
                return $this->account_cache[$email]['id'];
            } else {
                $this->connect();

                $this->connection->select(column("account", "id"))->from(table("account"))->where([column("account", "email") => $email]);
                $query = $this->connection->get();

                if ($query->num_rows() > 0) {
                    $result = $query->result_array();
                    $this->account_cache[$email] = $result[0];

                    return $result[0]["id"];
                } else {
                    $this->account_cache[$email]["id"] = false;

                    return false;
                }
            }
        }
    }

    public function getJoinDate()
    {
        return $this->joindate;
    }

    public function getLastIp()
    {
        return $this->last_ip;
    }

    public function getExpansion()
    {
        return $this->expansion;
    }

    public function getTotpSecret()
    {
        return $this->totp_secret;
    }

    /**
     * @param string|null $encryption
     * @param $username
     * @param $newPassword
     * @param array $data
     * @return array
     */
    private function setAccountPassword(?string $encryption, $username, $newPassword, array $data): array
    {
        if ($encryption == 'SRP6') {
            $hash = $this->crypto->SRP6($username, $newPassword);
            $data[column("account", "salt")] = $hash["salt"];
            $data[column("account", "verifier")] = $hash["verifier"];
        } else if ($encryption == 'SRP') {
            $hash = $this->crypto->SRP($username, $newPassword);
            $data[column("account", "salt")] = $hash["salt"];
            $data[column("account", "verifier")] = $hash["verifier"];
        } else {
            $hash = $this->crypto->SHA_PASS_HASH($username, $newPassword);
            $data[column("account", "sha_pass_hash")] = $hash["verifier"];
        }
        return array($hash, $data);
    }

    /**
     * @param $email
     * @param $newPassword
     * @param array $battleData
     * @return array
     */
    private function setBattleNetPassword($email, $newPassword, array $battleData): array
    {
        if ($this->config->item('battle_net_encryption') == 'SRP6_V2') {
            $hash = $this->crypto->BnetSRP6_V2($email, $newPassword);
            $battleData['srp_version'] = 2;
            $battleData[column("battlenet_accounts", "salt")] = $hash["salt"];
            $battleData[column("battlenet_accounts", "verifier")] = $hash["verifier"];
        } else if ($this->config->item('battle_net_encryption') == 'SRP6_V1') {
            $hash = $this->crypto->BnetSRP6_V1($email, $newPassword);
            $battleData['srp_version'] = 1;
            $battleData[column("battlenet_accounts", "salt")] = $hash["salt"];
            $battleData[column("battlenet_accounts", "verifier")] = $hash["verifier"];
        } else {
            $hash = $this->crypto->SHA_PASS_HASH_V2($email, $newPassword);
            $battleData[column("battlenet_accounts", "sha_pass_hash")] = $hash["verifier"];
        }
        return array($hash, $battleData);
    }
}
