<?php

use CodeIgniter\Database\BaseConnection;
use MX\CI;

class Accounts_model extends CI_Model
{
    private BaseConnection $connection;

    public function __construct()
    {
        parent::__construct();
        $this->connection = $this->external_account_model->getConnection();
    }

    public function get_users($limit, $start, $search = null)
    {
        $builder = $this->connection->table('account')->select('id, username, email, joindate, expansion');

        if (!empty($search))
        {
            $builder->groupStart()
                        ->like('username', $search)
                        ->orLike('email', $search)
                    ->groupEnd();
        }

        $builder->limit($limit, $start);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function count_all_users()
    {
        return $this->connection->table('account')->countAll();
    }

    public function count_filtered_users($search = null)
    {
        $builder = $this->connection->table('account')->select();

        if (!empty($search))
        {
            $builder->groupStart()
                        ->like('username', $search)
                        ->orLike('email', $search)
                    ->groupEnd();
        }

        $query = $builder->get();
        return $query->getNumRows();
    }

    public function getById($id)
    {
        $encryption = $this->config->item('account_encryption');

        if (preg_match("/^cmangos/i", get_class($this->realms->getEmulator())))
        {
            $query = $this->connection->query(query('get_account_id'), [$id]);
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

            $query = $this->connection->query("SELECT " . formatColumns($columns) . " FROM " . table("account") . " WHERE " . column("account", "id") . " = ?", [$id]);
        }

        if ($query->getNumRows() > 0)
        {
            $result = $query->getResultArray();
            return $result[0];
        } else {
            return false;
        }
    }

    public function getInternalDetails($userId = 0)
    {
        $query = $this->db->query("SELECT * FROM account_data WHERE id = ?", array($userId));

        if ($query->getNumRows() > 0) {
            $result = $query->getResultArray();
            return $result[0];
        } else {
            return false;
        }
    }

    public function getAccessId($userId = 0)
    {
        if (preg_match("/mangos/i", get_class($this->realms->getEmulator()))) {
            $query = $this->connection->query("SELECT " . column("account", "gmlevel", true) . " FROM " . table("account") . " WHERE " . column("account", "id") . " = ?", array($userId));
        } else {
            $query = $this->connection->query("SELECT " . column("account_access", "gmlevel", true) . " FROM " . table("account_access") . " WHERE " . column("account_access", "id") . " = ?", array($userId));
        }

        if ($query->getNumRows() > 0) {
            $result = $query->getResultArray();
            return $result[0];
        } else {
            return false;
        }
    }

    public function save($id, $external_account_data, $external_account_access_data, $internal_data)
    {
        $old_external_data = $this->accounts_model->getById($id);
        $old_internal_data = $this->accounts_model->getInternalDetails($id);

        $old_values = array_merge($old_external_data, $old_internal_data);
        $new_values = array_merge($external_account_data, $external_account_access_data, $internal_data);

        // Initialize an empty array to store the changed values
        $changed_values = array();

        // Compare the old and new values and store the changed values in the array
        foreach ($new_values as $key => $value) {
            if (isset($old_values[$key]) && $old_values[$key] != $value) {
                $changed_values[$key] = array(
                    'old' => $old_values[$key],
                    'new' => $value
                );
            }
        }

        if ($this->getAccessId($id)) {
            if (preg_match("/mangos/i", get_class($this->realms->getEmulator()))) {
                // Update external access
                $this->connection->table(table('account'))->where(column('account', 'id'), $id)->update($external_account_access_data);
            } else {
                // Update external access
                $this->connection->table(table('account_access'))->where(column('account_access', 'id'), $id)->update($external_account_access_data);
            }
        } else {
            if (preg_match("/mangos/i", get_class($this->realms->getEmulator()))) {
                // Update external access
                $external_account_access_data[column('account', 'id')] = $id;
                $this->connection->table(table('account'))->insert($external_account_access_data);
            } else {
                // Update external access
                $external_account_access_data[column('account_access', 'id')] = $id;
                $this->connection->table(table('account_access'))->insert($external_account_access_data);
            }
        }

        // Update internal
        $this->db->table('account_data')->where('id', $id)->update($internal_data);

        // Update external
        $this->connection->table(table('account'))->where(column('account', 'id'), $id)->update($external_account_data);

        $this->dblogger->createLog("admin", "edit", "Edited account " . $this->user->getUsername($id) . " (" . $id . ")", $changed_values);
    }

    public function getLogs($id, $offset = 0, $limit = 0)
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
