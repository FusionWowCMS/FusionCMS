<?php

use CodeIgniter\Database\BaseConnection;
use MX\CI;

/**
 * @package FusionCMS
 * @author  Jesper Lindström
 * @author  Xavier Geerinck
 * @author  Elliott Robbins
 * @link    http://fusion-hub.com
 */

class Acl_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

        if (file_exists("application/config/owner.php")) {
            $this->load->config('owner');
            $group = $this->config->item('default_owner_group');
            $id = $this->user->getId($this->config->item('owner'));

            if (!$id) {
                show_error("The owner account that was specified during the installation does not exist. Please reinstall FusionCMS.");
            }

            $this->assignGroupToUser($group, $id);

            unlink("application/config/owner.php");
        }
    }

    /**
     * Get the roles for a group by the user ID
     *
     * @param  Int $userId
     * @param  String $moduleName
     * @return Array
     */
    public function getGroupRolesByUser($userId, $moduleName = false)
    {
        $query =  $this->db->table("acl_group_roles agr, acl_account_groups aag")->select("agr.role_name, agr.module")
                    ->where("aag.account_id", $userId)
                    ->where("aag.group_id = agr.group_id");

        if ($moduleName) {
            $query->where("agr.module", $moduleName);
        }

        $query = $query->get();

        if ($query->getNumRows()) {
            return $query->getResultArray();
        } else {
            return false;
        }
    }

    /**
     * Get account roles permissions
     *
     * @param  int $userId
     * @param  int $default_group
     * @return array
     */
    public function getAccountRolesPermissions(int $userId = 0, int $default_group = 1)
    {
        // Groups: Initialize
        $groups = (array)$this->getGroupsByUser($userId);

        // Auth: Initialize | Keep track of user authentication status
        $auth = $userId && $default_group === $this->config->item('default_player_group');

        // Player only: Initialize
        $player_only = $auth && count($groups) == 1 && in_array($this->config->item('default_player_group'), array_column($groups, 'id'));

        if(!$auth || $player_only)
        {
            // Query: Prepare
            $query = $this->db->table('acl_group_roles agr');

            // Query: Select
            $query = $query->select(['agr.role_name', 'agr.module']);

            // Query: Filter by group
            $query = $query->where('agr.group_id', $default_group);
        }
        else
        {
            // Query: Prepare
            $query = $this->db->table('acl_group_roles agr, acl_account_groups aag');

            // Query: Select
            $query = $query->select(['agr.role_name', 'agr.module']);

            // Query: Filter by account id
            if($userId)
                $query = $query->where('aag.account_id', $userId);

            // Query: Filter by group
            $query = $query->groupStart()
                           ->where('aag.group_id = agr.group_id')
                           ->orWhere('agr.group_id', $default_group)
                           ->groupEnd();
        }

        // Query: Distinct
        $query = $query->distinct();

        // Query: Get
        $query = $query->get();

        // Query: Make sure we have results
        if($query && $query->getNumRows())
            return $query->getResultArray();

        return [];
    }

    /**
     * Get the account-specific permissions
     *
     * @param  Int $userId
     * @return Array
     */
    public function getAccountPermissions($userId)
    {
        $query = $this->db->table('acl_account_permissions')->select("account_id, permission_name, module, value")->where("account_id", $userId)->get();

        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        } else {
            return false;
        }
    }

    /**
     * Get the account-specific roles
     *
     * @param  Int $userId
     * @param  String $module
     * @return Array
     */
    public function getAccountRoles($userId, $module = false)
    {
        $builder = $this->db->table('acl_account_roles')->select("role_name")->where("account_id", $userId);

        if ($module) {
            $builder->where("module", $module);
        }

        $query = $builder->get();

        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        } else {
            return false;
        }
    }

    /**
     * Get the groups of the given user
     *
     * @param  $accountId
     * @return Array
     */
    public function getGroupsByUser($accountId = false)
    {
        if (!$accountId) {
            $accountId = $this->user->getId();
        }

        $builder = $this->db->table("acl_account_groups aag, acl_groups ag");
        $builder->select("ag.id, ag.priority, ag.name, ag.color, ag.color");
        $builder->where("aag.account_id", $accountId);
        $builder->where("aag.group_id = ag.id");
        $builder->orderBy("ag.priority", "DESC");
        $query = $builder->get();

        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        } else {
            // No group found; default to player
            return array($this->getGroup($this->config->item('default_player_group')));
        }
    }

    /**
     * Get all the groups
     *
     * @return Array
     */
    public function getGroups()
    {
        $query = $this->db->table('acl_groups ag')->select('ag.id, ag.priority, ag.name, ag.color, ag.description')->get();

        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        } else {
            return false;
        }
    }

    /**
     * Get member count of a group
     *
     * @param  Int $groupId
     * @return Int
     */
    public function getGroupMemberCount($id)
    {
        $query = $this->db->query("SELECT COUNT(*) `memberCount` FROM acl_account_groups WHERE group_id=?", array($id));

        if ($query->getNumRows() > 0) {
            $result = $query->getResultArray();

            return $result[0]['memberCount'];
        } else {
            return 0;
        }
    }

    /*
     * Get the members of a group
     * @param Int $groupId
     * @return Array
     */
    public function getGroupMembers($id)
    {
        $query = $this->db->query("SELECT account_id FROM acl_account_groups WHERE group_id=?", array($id));

        if ($query->getNumRows()) {
            $result = $query->getResultArray();

            foreach ($result as $k => $v) {
                $result[$k]['username'] = $this->user->getUsername($v['account_id']);
            }

            return $result;
        } else {
            return false;
        }
    }

    /**
     * Get the group by the given id.
     *
     * @param  $groupId
     * @return Array
     */
    public function getGroup($groupId)
    {
        $query = $this->db->table('acl_groups')->select('id, priority, name, color, description')->where('id', $groupId)->get();

        if ($query->getNumRows() > 0) {
            $result = $query->getResultArray();

            return $result[0];
        } else {
            return false;
        }
    }

    /**
     * Get the group by the given name
     *
     * @param  $groupName
     * @return Boolean
     */
    public function getGroupByName($groupName)
    {
        $query = $this->db->table('acl_groups')->select('id, priority, name, color, description')->where('name', $groupName)->get();

        if ($query->getNumRows() > 0) {
            $result = $query->getResultArray();

            return $result[0];
        } else {
            return false;
        }
    }

    /**
     * Check if a group has a specific role
     *
     * @param  Int $id
     * @param  String $name
     * @param  String $module
     * @return Boolean
     */
    public function groupHasRole($groupId, $name, $module)
    {
        $query = $this->db->query("SELECT COUNT(*) `total` FROM acl_group_roles WHERE role_name=? AND module=? AND group_id=?", array($name, $module, $groupId));

        if ($query->getNumRows()) {
            $result = $query->getResultArray();

            return $result[0]['total'];
        } else {
            return false;
        }
    }

    /**
     * Get the database roles for a module
     *
     * @param  String $moduleName
     * @return Array
     */
    public function getRolesByModule($moduleName, $groupId)
    {
        $query = $this->db->query("SELECT * FROM acl_group_roles WHERE module = ? AND group_id = ?", [$moduleName, $groupId]);

        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        } else {
            return false;
        }
    }

    /**
     * Create a group
     *
     * @param $data
     * @return int
     */
    public function createGroup($data)
    {
        $this->db->table('acl_groups')->insert($data);

        return $this->db->insertId();
    }

    /**
     * Delete the group with the given id
     *
     * @param Int $groupId
     */
    public function deleteGroup($groupId)
    {
        $this->db->table('acl_groups')->delete(['id' => $groupId]);
    }

    /**
     * Assign a group to a user
     *
     * @param Int $groupId
     * @param Int $accountId
     */
    public function assignGroupToUser($groupId, $accountId)
    {
        $data = array(
            "account_id" => $accountId,
            "group_id" => $groupId
        );

        $this->db->table('acl_account_groups')->insert($data);
    }

    /**
     * Remove a group assignment
     *
     * @param Int $groupId
     * @param Int $accountId
     */
    public function removeGroupFromUser($groupId, $accountId)
    {
        $data = [
            "account_id" => $accountId,
            "group_id" => $groupId
        ];

        $this->db->table('acl_account_groups')->delete($data);
    }

    /**
     * Remove all group assignments
     *
     * @param Int $accountId
     */
    public function removeGroupsFromUser($accountId)
    {
        $data = [
            "account_id" => $accountId
        ];

        $this->db->table('acl_account_groups')->delete($data);
    }

    /**
     * Remove all permission assignments
     *
     * @param Int $accountId
     */
    public function removePermissionsFromUser($accountId)
    {
        $data = [
            "account_id" => $accountId
        ];

        $this->db->table('acl_account_permissions')->delete($data);
    }

    /**
     * Assign a permission to a user
     *
     * @param Int $accountId
     * @param String $permissionName
     * @param string $moduleName
     */
    public function assignPermissionToUser($accontId, $permissionName, $moduleName, $value)
    {
        $data = [
            "account_id" => $accontId,
            "permission_name" => $permissionName,
            "module" => $moduleName,
            "value" => $value
        ];

        $this->db->table('acl_account_permissions')->insert($data);
    }

    /**
     * Add a role to the given group
     *
     * @param Int $groupId
     * @param String $name
     * @param String $module
     */
    public function addRoleToGroup($groupId, $name, $module)
    {
        $data = [
            'group_id' => $groupId,
            'role_name' => $name,
            'module' => $module
        ];

        $this->db->table('acl_group_roles')->insert($data);
    }

    /**
     * Delete a role from the given group
     *
     * @param Int $groupId
     * @param String $name
     * @param String $module
     */
    public function deleteRoleFromGroup($groupId, $name, $module)
    {
        $this->db->table('acl_group_roles')->delete(['group_id' => $groupId, 'role_name' => $name, 'module' => $module]);
    }

    /**
     * Save the group
     *
     * @param Int $id
     * @param Array $data
     */
    public function saveGroup($id, $data)
    {
        $this->db->table('acl_groups')->where('id', $id)->update($data);
    }

    /**
     * Delete all roles from a given group
     *
     * @param Int $groupId
     */
    public function deleteAllRoleFromGroup($groupId)
    {
        $this->db->table('acl_group_roles')->delete(['group_id' => $groupId]);
    }
}
