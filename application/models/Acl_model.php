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
     * @param Int $userId
     * @param false|String $moduleName
     * @return Array
     */
    public function getGroupRolesByUser(int $userId, false|string $moduleName = false): array
    {
        if ($userId == 0)
            return [];

        $query = $this->db->table('acl_group_roles agr')
            ->select('agr.role_name, agr.module')
            ->join('acl_account_groups aag', 'aag.group_id = agr.group_id', 'inner')
            ->where('aag.account_id', $userId);

        if ($moduleName) {
            $query->where("agr.module", $moduleName);
        }


        return $query->get()->getResultArray() ?? [];
    }

    /**
     * Get account roles permissions
     *
     * @param  int $userId
     * @param  int $default_group
     * @param  bool $auth
     * @param  bool $player_only
     * @return array
     */
    public function getAccountRolesPermissions(int $userId = 0, int $default_group = 1, bool $auth = false, bool $player_only = true): array
    {
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
     * @param Int $userId
     * @return Array
     */
    public function getAccountPermissions(int $userId): array
    {
        if ($userId == 0)
            return [];

        $query = $this->db->table('acl_account_permissions')->select("account_id, permission_name, module, value")->where("account_id", $userId)->get();

        return $query->getResultArray() ?? [];
    }

    /**
     * Get the account-specific roles
     *
     * @param Int $userId
     * @param false|String $module
     * @return Array
     */
    public function getAccountRoles(int $userId, false|string $module = false): array
    {
        if ($userId == 0)
            return [];

        $builder = $this->db->table('acl_account_roles')->select("role_name")->where("account_id", $userId);

        if ($module) {
            $builder->where("module", $module);
        }

        return $builder->get()->getResultArray() ?? [];
    }

    /**
     * Get the groups of the given user
     *
     * @param false|int $accountId
     * @return Array
     */
    public function getGroupsByUser(false|int $accountId = false): array
    {
        if (!$accountId) {
            $accountId = $this->user->getId();
        }

        if ($accountId == 0)
            return [];

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
            return [$this->getGroup($this->config->item('default_player_group'))];
        }
    }

    /**
     * Get all the groups
     *
     * @return Array
     */
    public function getGroups(): array
    {
        $query = $this->db->table('acl_groups ag')->select('ag.id, ag.priority, ag.name, ag.color, ag.description')->get();

        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        } else {
            return [];
        }
    }

    /**
     * Get member count of a group
     *
     * @param Int $groupId
     * @return Int
     */
    public function getGroupMemberCount(int $groupId): int
    {
        return (int) $this->db->table('acl_account_groups')->where('group_id', $groupId)->countAllResults();
    }

    /**
     * Get the members of a group
     * @param Int $groupId
     * @return Array
     */
    public function getGroupMembers(int $groupId): array
    {
        $result = $this->db->table('acl_account_groups')
            ->select('account_id')
            ->where('group_id', $groupId)
            ->get()
            ->getResultArray();

        foreach ($result as &$row) {
            $row['username'] = $this->user->getUsername($row['account_id']);
        }

        return $result ?: [];
    }

    /**
     * Get the group by the given id.
     *
     * @param int $groupId
     * @return false|array
     */
    public function getGroup(int $groupId): false|array
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
     * @param string $groupName
     * @return Boolean
     */
    public function getGroupByName(string $groupName)
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
     * @param Int $groupId
     * @param String $name
     * @param String $module
     * @return int
     */
    public function groupHasRole(int $groupId, string $name, string $module): int
    {
        return (int) $this->db->table('acl_group_roles')
            ->where('role_name', $name)
            ->where('module', $module)
            ->where('group_id', $groupId)
            ->countAllResults();
    }

    /**
     * Get the database roles for a module
     *
     * @param String $moduleName
     * @param int $groupId
     * @return Array
     */
    public function getRolesByModule(string $moduleName, int $groupId): array
    {
        return $this->db->table('acl_group_roles')
            ->where('module', $moduleName)
            ->where('group_id', $groupId)
            ->get()
            ->getResultArray() ?? [];
    }

    /**
     * Create a group
     *
     * @param $data
     * @return int
     */
    public function createGroup($data): int
    {
        $this->db->table('acl_groups')->insert($data);

        return $this->db->insertId();
    }

    /**
     * Delete the group with the given id
     *
     * @param Int $groupId
     */
    public function deleteGroup(int $groupId): void
    {
        $this->db->table('acl_groups')->delete(['id' => $groupId]);
    }

    /**
     * Assign a group to a user
     *
     * @param Int $groupId
     * @param Int $accountId
     */
    public function assignGroupToUser(int $groupId, int $accountId): void
    {
        $data = [
            "account_id" => $accountId,
            "group_id" => $groupId
        ];

        $this->db->table('acl_account_groups')->insert($data);
    }

    /**
     * Remove a group assignment
     *
     * @param Int $groupId
     * @param Int $accountId
     */
    public function removeGroupFromUser(int $groupId, int $accountId): void
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
    public function removeGroupsFromUser(int $accountId): void
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
    public function removePermissionsFromUser(int $accountId): void
    {
        $data = [
            "account_id" => $accountId
        ];

        $this->db->table('acl_account_permissions')->delete($data);
    }

    /**
     * Assign a permission to a user
     *
     * @param int $accountId
     * @param String $permissionName
     * @param string $moduleName
     * @param $value
     */
    public function assignPermissionToUser(int $accountId, string $permissionName, string $moduleName, $value): void
    {
        $data = [
            "account_id" => $accountId,
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
    public function addRoleToGroup(int $groupId, string $name, string $module): void
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
    public function deleteRoleFromGroup(int $groupId, string $name, string $module): void
    {
        $this->db->table('acl_group_roles')->delete(['group_id' => $groupId, 'role_name' => $name, 'module' => $module]);
    }

    /**
     * Save the group
     *
     * @param Int $id
     * @param Array $data
     */
    public function saveGroup(int $id, array $data): void
    {
        $this->db->table('acl_groups')->where('id', $id)->update($data);
    }

    /**
     * Delete all roles from a given group
     *
     * @param Int $groupId
     */
    public function deleteAllRoleFromGroup(int $groupId): void
    {
        $this->db->table('acl_group_roles')->delete(['group_id' => $groupId]);
    }
}
