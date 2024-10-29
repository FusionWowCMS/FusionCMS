<?php

use App\Config\Services;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\BaseResult;
use CodeIgniter\Database\Query;
use CodeIgniter\Events\Events;
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
    private BaseConnection $connection;
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
            $this->noUserExists();
        }
    }

    public function getConnection(): BaseConnection
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

    public function initialize($where = false): bool
    {
        $this->connect();

        $encryption = $this->config->item('account_encryption');
        $totp_secret_name = $this->config->item('totp_secret_name');

        $query = $this->fetchAccountData($encryption, $totp_secret_name, $where);

        if (!$query)
            show_error('Database Error occurs: ' . $this->connection->error()['message'] . "<br/>Please check website database `realms.emulator` in 'field list' <b>(make sure you selected right emulator.)</b>");

        return $this->populateAccountData($query);
    }

    private function fetchAccountData($encryption, $totp_secret_name, $where): bool|BaseResult|Query
    {
        if (preg_match("/^cmangos/i", get_class($this->realms->getEmulator()))) {
            return !$where
                ? $this->connection->query(query('get_account_id'), [Services::session()->get('uid')])
                : $this->connection->query(query('get_account'), [$where]);
        }

        $columns = CI::$APP->realms->getEmulator()->getAllColumns(table('account'));
        $columns = $this->removeExtraColumnsForEncryption($columns, $encryption);

        if ($this->config->item('totp_secret')) {
            $columns['totp_secret'] = $totp_secret_name == 'totp_secret' ? 'totp_secret' : 'token_key';
        }

        $columnList = formatColumns($columns);
        $conditionColumn = !$where ? column('account', 'id') : column('account', 'username');
        $conditionValue = !$where ? Services::session()->get('uid') : $where;

        return $this->connection->query("SELECT $columnList FROM " . table('account') . " WHERE $conditionColumn = ?", [$conditionValue]);
    }

    private function removeExtraColumnsForEncryption($columns, $encryption)
    {
        switch ($encryption) {
            case 'SPH':
                if (column('account', 'verifier') && column('account', 'salt')){
                    unset($columns[column('account', 'verifier')]);
                    unset($columns[column('account', 'salt')]);
                }
                break;
            case 'SRP':
                if (column('account', 'sha_pass_hash')){
                    unset($columns[column('account', 'sha_pass_hash')]);
                }
                break;
            case 'SRP6':
                if (column('account', 'sha_pass_hash')){
                    unset($columns[column('account', 'sha_pass_hash')]);
                }
                if (column('account', 'v') && column('account', 's')){
                    unset($columns[column('account', 'v')]);
                    unset($columns[column('account', 's')]);
                }
                break;
        }
        return $columns;
    }

    private function populateAccountData($query): bool
    {
        if ($query->getNumRows() > 0) {
            $result = $query->getRowArray();
            $this->id = $result['id'];
            $this->username = $result['username'];
            $this->password = $result['verifier'] ?? $result['sha_pass_hash'];
            $this->email = $result['email'];
            $this->joindate = $result['joindate'];
            $this->expansion = $result['expansion'];
            $this->last_ip = $result['last_ip'];
            $this->last_login = $result['last_login'];
            $this->totp_secret = $result['totp_secret'] ?? '';
            return true;
        }

        $this->noUserExists();

        return false;
    }

    private function noUserExists(): void
    {
        $this->id = 0;
        $this->username = 'Guest';
        $this->password = '';
        $this->email = '';
        $this->joindate = '';
        $this->expansion = 0;
        $this->last_ip = '';
        $this->last_login = '';
        $this->totp_secret = '';
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

        $userId = $this->connection->table(table("account"))->insert($data);

        if (preg_match("/^cmangos/i", get_class($this->realms->getEmulator())))
        {
            $ip_data = [
                'accountId' => $userId,
                'ip' => $this->input->ip_address(),
                'loginTime' => date("Y-m-d H:i:s"),
                'loginSource' => '0'
            ];

            $this->connection->table(table("account_logons"))->insert($ip_data);
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

            $this->connection->table(table("battlenet_accounts"))->insert($battleData);

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
            $this->connection->table('rbac_account_permissions')->insert($rbac_data);
        }

        $this->updateDailySignUps();
    }

    private function updateDailySignUps()
    {
        $query = $this->db->query("SELECT COUNT(*) AS `total` FROM daily_signups WHERE `date`=?", [date("Y-m-d")]);

        $row = $query->getResultArray();

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

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

            return $row[0];
        } elseif (query('get_ip_banned')) {
            //check if the ip is banned
            $query = $this->connection->query(query("get_ip_banned"), [$this->input->ip_address(), time()]);

            if ($query->getNumRows() > 0) {
                $row = $query->getResultArray();

                return $row[0];
            } else {
                return false;
            }
        }
    }

    /**
     * Get the rank
     *
     * @param bool|String $value
     * @param bool $isUsername
     * @return int
     */
    public function getRank(bool|string $value = false, bool $isUsername = false): int
    {
        $this->connect();

        if (!$value) {
            $value = $this->getId();
        } elseif ($isUsername) {
            $value = $this->getId($value);
        }

        $query = $this->connection->query(query("get_rank"), [$value]);

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

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
    public function usernameExists(string $username): bool
    {
        $this->connect();

        $count = $this->connection->table(table("account"))->where([column("account", "username") => $username])->countAllResults();

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
    public function getAccountCount(): int
    {
        $this->connect();

        $query = $this->connection->query("SELECT COUNT(*) as `total` FROM " . table("account"));
        $row = $query->getResultArray();

        return $row[0]['total'];
    }

    /**
     * Check if an user id exists
     *
     * @param int $id
     * @return bool
     */
    public function userExists(int $id): bool
    {
        $this->connect();

        $count = $this->connection->table(table("account"))->where([column("account", "id") => $id])->countAllResults();

        if ($count) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if an email exists
     *
     * @param string $email
     * @return bool
     */
    public function emailExists(string $email): bool
    {
        $this->connect();

        $count = $this->connection->table(table("account"))->where([column("account", "email") => $email])->countAllResults();

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

        $this->connection->table(table("account"))->where(column("account", "username"), $oldUsername)->update([column("account", "username") => $newUsername]);
    }

    public function setPassword($username, $email, $newPassword)
    {
        $this->connect();

        $builder = $this->connection->table(table("account"));

        $builder->where(column("account", "username"), $username);

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

        $builder->update($data);

        $userId = $this->user->getId($username);

        // Battlenet accounts
        if ($this->config->item('battle_net')) {
            $builder = $this->connection->table(table("battlenet_accounts"))->where(column("battlenet_accounts", "email"), strtoupper($email));

            $battleData = [
                column("battlenet_accounts", "last_ip") => $this->input->ip_address(),
                column("battlenet_accounts", "joindate") => date("Y-m-d H:i:s")
            ];
            list($hash, $battleData) = $this->setBattleNetPassword($email, $newPassword, $battleData);

            $builder->update($battleData);
        }

        Events::trigger('onChangePassword', $userId, $hash);
    }

    public function setEmail($username, $newEmail)
    {
        $this->connect();

        $this->connection->table(table("account"))->where(column("account", "username"), $username)->update([column("account", "email") => $newEmail]);
    }

    public function setExpansion($newExpansion, $username = false)
    {
        $this->connect();

        $builder = $this->connection->table(table("account"));

        if ($username)
        {
            // Update only the expansion column for the given username
            $builder->where(column("account", "username"), $username);
        }

        // Update the 'expansion' column for all users
        $builder->update([column("account", "expansion") => $newExpansion]);
    }

    public function setRank($userId, $newRank)
    {
        $this->connect();

        if (preg_match("/^trinity/i", get_class($this->realms->getEmulator()))) {
            $this->connection->table(table("account_access"))->where(column("account", "id"), $userId)->update([column("account_access", "SecurityLevel") => $newRank]);
        } elseif (preg_match("/^cmangos/i", get_class($this->realms->getEmulator()))) {
            $this->connection->table(table("account"))->where(column("account", "id"), $userId)->update([column("account", "gmlevel") => $newRank]);
        } else {
            $this->connection->table(table("account_access"))->where(column("account", "id"), $userId)->update([column("account_access", "gmlevel") => $newRank]);
        }
    }

    public function setLastIp($userId, $ip)
    {
        $this->connect();

        if (preg_match("/^cmangos/i", get_class($this->realms->getEmulator()))) {
            $data = [
                'accountId' => $userId,
                'ip' => $ip,
                'loginTime' => date("Y-m-d H:i:s"),
                'loginSource' => '0'
            ];

            $this->connection->table(table("account_logons"))->insert($data);
        } else {
            $this->connection->table(table("account"))->where(column("account", "id"), $userId)->update([column("account", "last_ip") => $ip]);
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

            $query = $this->connection->table(table("account"))->select(column("account", "id", true))->where(column("account", "username"), $username)->get();

            if ($query->getNumRows() > 0) {
                $result = $query->getResultArray();

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

            $query = $this->connection->table(table("account"))->select(column("account", "username", true))->where([column("account", "id") => $id])->get();

            if ($query->getNumRows() > 0) {
                $result = $query->getResultArray();

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

        $query = $this->connection->table(table("account"))->select($fields)->where([column("account", "id") => $id])->get();

        if ($query->getNumRows() > 0) {
            $result = $query->getResultArray();

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

                $query = $this->connection->table(table("account"))
                    ->select(column("account", "username", true) . ',' . column("account", "email") . ',' . column("account", "joindate"))
                    ->where([column("account", "id") => $id])
                    ->get();

                if ($query->getNumRows() > 0) {
                    $result = $query->getResultArray();
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

                ;
                $query = $this->connection->table(table("account"))->select(column("account", "id"))->where([column("account", "email") => $email])->get();

                if ($query->getNumRows() > 0) {
                    $result = $query->getResultArray();
                    $this->account_cache[$email] = $result[0];

                    return $result[0]["id"];
                } else {
                    $this->account_cache[$email]["id"] = false;

                    return false;
                }
            }
        }
    }

    public function getJoinDate(): string
    {
        return $this->joindate;
    }

    public function getLastIp(): string
    {
        return $this->last_ip;
    }

    public function getLastLogin(): string
    {
        return $this->last_login;
    }

    public function getExpansion(): int
    {
        return $this->expansion;
    }

    public function getTotpSecret(): string
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
