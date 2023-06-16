<?php

class Accounts_model extends CI_Model
{
    private $connection;

    public function __construct()
    {
        parent::__construct();
        $this->connection = $this->external_account_model->getConnection();
    }

    public function get_users($limit, $start, $search = null)
    {
        $this->connection->select('id, username, email, joindate, expansion');
        $this->connection->from('account');

        if (!empty($search))
        {
            $this->connection->group_start()
                             ->like('username', $search)
                             ->or_like('email', $search)
                             ->group_end();
        }

        $this->connection->limit($limit, $start);
        $query = $this->connection->get();
        return $query->result_array();
    }

    public function count_all_users()
    {
        return $this->connection->count_all('account');
    }

    public function count_filtered_users($search = null)
    {
        $this->connection->select('*');
        $this->connection->from('account');

        if (!empty($search))
        {
            $this->connection->group_start()
                             ->like('username', $search)
                             ->or_like('email', $search)
                             ->group_end();
        }

        $query = $this->connection->get();
        return $query->num_rows();
    }

    public function getById($id)
    {
        if (preg_match("/^cmangos/i", get_class($this->realms->getEmulator())))
        {
            $query = $this->connection->query(query("get_account_id"), array($id));
        } else {
            $query = $this->connection->query("SELECT " . allColumns("account") . " FROM " . table("account") . " WHERE " . column("account", "id") . " = ?", array($id));
        }

        if ($query->num_rows() > 0)
        {
            $result = $query->result_array();
            return $result[0];
        } else {
            return false;
        }
    }

    public function getInternalDetails($userId = 0)
    {
        $query = $this->db->query("SELECT * FROM account_data WHERE id = ?", array($userId));

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
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

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
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
                $this->connection->where(column('account', 'id'), $id);
                $this->connection->update(table('account'), $external_account_access_data);
            } else {
                // Update external access
                $this->connection->where(column('account_access', 'id'), $id);
                $this->connection->update(table('account_access'), $external_account_access_data);
            }
        } else {
            if (preg_match("/mangos/i", get_class($this->realms->getEmulator()))) {
                // Update external access
                $external_account_access_data[column('account', 'id')] = $id;
                $this->connection->insert(table('account'), $external_account_access_data);
            } else {
                // Update external access
                $external_account_access_data[column('account_access', 'id')] = $id;
                $this->connection->insert(table('account_access'), $external_account_access_data);
            }
        }

        // Update internal
        $this->db->where('id', $id);
        $this->db->update('account_data', $internal_data);

        // Update external
        $this->connection->where(column('account', 'id'), $id);
        $this->connection->update(table('account'), $external_account_data);

        $this->logger->createLog("admin", "edit", "Edited account " . $this->user->getUsername($id) . " (" . $id . ")", $changed_values);
    }

    public function getLogs($id, $offset = 0, $limit = 0)
    {
        if (!is_numeric($id) || !is_numeric($limit) || !is_numeric($offset)) {
            return null;
        }

        $this->db->select("*");
        $this->db->where('user_id', $id);
        $this->db->order_by('time', 'DESC');
        if ($limit > 0 && $offset == 0) {
            $this->db->limit($limit);
        }
        if ($limit > 0 && $offset > 0) {
            $this->db->limit(($offset + $limit), $offset);
        }
        $query = $this->db->get('logs');

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }
}
