<?php

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
     * Get the permission value for the guest group
     *
     * @param  String $permissionName
     * @param  String $moduleName
     * @param  Boolean $onlyDatabase
     * @return Boolean
     */
    public function hasPermissionGuest($permissionName, $moduleName, $onlyDatabase = false)
    {
        $result = null;

        $groupId = $this->config->item('default_guest_group');

        $this->db->select("arp.value");
        $this->db->where("agr.group_id", $groupId);
        $this->db->where("agr.module", $moduleName);
        $this->db->where("arp.role_name = agr.role_name");
        $this->db->where("arp.module", $moduleName);
        $this->db->where("arp.permission_name", $permissionName);

        $query = $this->db->get("acl_roles_permissions arp, acl_group_roles agr");

        if ($query->num_rows()) {
            $row = $query->result_array();

            $result = $row[0]['value'];
        } elseif (!$onlyDatabase) {
            // Give it another try with manifest defined roles
            $roles = $this->getRolesByGroupId($groupId, $moduleName);

            if ($roles) {
                foreach ($roles as $role) {
                    $manifest = $this->acl->getManifestRole($role['role_name'], $moduleName);

                    if ($manifest && array_key_exists($permissionName, $manifest['permissions'])) {
                        $result = $manifest['permissions'][$permissionName];
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Get the permission value for the player group
     *
     * @param  String $permissionName
     * @param  String $moduleName
     * @return Boolean
     */
    private function hasPermissionPlayer($permissionName, $moduleName)
    {
        $result = null;

        $groupId = $this->config->item('default_player_group');

        $this->db->select("arp.value");
        $this->db->where("agr.group_id", $groupId);
        $this->db->where("agr.module", $moduleName);
        $this->db->where("arp.role_name = agr.role_name");
        $this->db->where("arp.module", $moduleName);
        $this->db->where("arp.permission_name", $permissionName);

        $query = $this->db->get("acl_roles_permissions arp, acl_group_roles agr");

        if ($query->num_rows()) {
            $row = $query->result_array();

            $result = $row[0]['value'];
        }

        return $result;
    }

    /**
     * Get the permission value for a specific user
     *
     * @param  Int $userId
     * @param  String $permissionName
     * @param  String $moduleName
     * @param  Boolean $onlyDatabase
     * @return Boolean
     */
    public function hasPermission($userId, $permissionName, $moduleName, $onlyDatabase = false)
    {
        // Try to find via default player group
        $result = $this->hasPermissionPlayer($permissionName, $moduleName);

        // Try to find via the account's groups' roles
        $this->db->select("arp.value");
        $this->db->where("aag.account_id", $userId);
        $this->db->where("aag.group_id = agr.group_id");
        $this->db->where("agr.module", $moduleName);
        $this->db->where("arp.role_name = agr.role_name");
        $this->db->where("arp.module", $moduleName);
        $this->db->where("arp.permission_name", $permissionName);

        $query = $this->db->get("acl_roles_permissions arp, acl_group_roles agr, acl_account_groups aag");

        if ($query->num_rows()) {
            $permissions = $query->result_array();

            foreach ($permissions as $permission) {
                if ($permission['value'] || $result === null) {
                    $result = $permission['value'];
                }
            }
        } elseif (!$onlyDatabase) {
            // Give it another try with manifest defined roles
            $roles = $this->getGroupRolesByUser($userId, $moduleName);

            if ($roles) {
                foreach ($roles as $role) {
                    $manifest = $this->acl->getManifestRole($role['role_name'], $moduleName);

                    if ($manifest && array_key_exists($permissionName, $manifest['permissions'])) {
                        $result = $manifest['permissions'][$permissionName];
                    }
                }
            }
        }

        // Try to find via the account's roles
        $this->db->select("arp.value");
        $this->db->where("aar.account_id", $userId);
        $this->db->where("aar.module", $moduleName);
        $this->db->where("aar.role_name = arp.role_name");
        $this->db->where("arp.module", $moduleName);
        $this->db->where("arp.permission_name", $permissionName);

        $userRoleQuery = $this->db->get("acl_account_roles aar, acl_roles_permissions arp");

        if ($userRoleQuery->num_rows()) {
            $userRolePermissions = $query->result_array();

            foreach ($userRolePermissions as $userRolePermission) {
                // Override group permissions
                $result = $userRolePermission['value'];
            }
        } elseif (!$onlyDatabase) {
            // Give it another try with manifest defined roles
            $userRoles = $this->getAccountRoles($userId, $moduleName);

            if ($userRoles) {
                foreach ($userRoles as $userRole) {
                    $manifest = $this->acl->getManifestRole($userRole['role_name'], $moduleName);

                    if ($manifest && array_key_exists($permissionName, $manifest['permissions'])) {
                        $result = $manifest['permissions'][$permissionName];
                    }
                }
            }
        }

        // Try to find via account permissions directly
        $this->db->select("value");
        $this->db->where("account_id", $userId);
        $this->db->where("module", $moduleName);
        $this->db->where("permission_name", $permissionName);

        $userQuery = $this->db->get("acl_account_permissions");

        if ($userQuery->num_rows()) {
            $userPermission = $userQuery->result_array();

            // Override group and account role permissions
            $result = $userPermission[0]['value'];
        }

        return $result;
    }

    /**
     * Get the roles for a group by the user ID
     *
     * @param  Int $userId
     * @param  String $moduleName
     * @return Array
     */
    private function getGroupRolesByUser($userId, $moduleName = false)
    {
        $this->db->select("agr.role_name, agr.module");
        $this->db->where("aag.account_id", $userId);
        $this->db->where("aag.group_id = agr.group_id");

        if ($moduleName) {
            $this->db->where("agr.module", $moduleName);
        }

        $query = $this->db->get("acl_group_roles agr, acl_account_groups aag");

        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /**
     * Get the account-specific permissions
     *
     * @param  Int $userId
     * @return Array
     */
    public function getAccountPermissions($userId)
    {
        $this->db->select("account_id, permission_name, module, value");
        $this->db->where("account_id", $userId);
        $query = $this->db->get("acl_account_permissions");

        if ($query->num_rows() > 0) {
            return $query->result_array();
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
        $this->db->select("role_name");
        $this->db->where("account_id", $userId);

        if ($module) {
            $this->db->where("module", $module);
        }

        $query = $this->db->get("acl_account_roles");

        if ($query->num_rows() > 0) {
            return $query->result_array();
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

        $this->db->select("ag.id, ag.name, ag.color, ag.color");
        $this->db->where("aag.account_id", $accountId);
        $this->db->where("aag.group_id = ag.id");
        $this->db->order_by("ag.id", "DESC");
        $query = $this->db->get("acl_account_groups aag, acl_groups ag");

        if ($query->num_rows() > 0) {
            return $query->result_array();
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
        $this->db->select('ag.id, ag.name, ag.color, ag.description');
        $query = $this->db->get('acl_groups ag');

        if ($query->num_rows() > 0) {
            return $query->result_array();
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

        if ($query->num_rows() > 0) {
            $result = $query->result_array();

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

        if ($query->num_rows()) {
            $result = $query->result_array();

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
        $this->db->select('id, name, color, description');
        $this->db->where('id', $groupId);
        $query = $this->db->get('acl_groups');

        if ($query->num_rows() > 0) {
            $result = $query->result_array();

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
        $this->db->select('id, name, color, description');
        $this->db->where('name', $groupName);
        $query = $this->db->get('acl_groups');

        if ($query->num_rows() > 0) {
            $result = $query->result_array();

            return $result[0];
        } else {
            return false;
        }
    }

    /**
     * Get all the roles
     *
     * @return Array
     */
    public function getRoles()
    {
        $this->db->select('name, module, description');
        $query = $this->db->get('acl_roles');

        if ($query->num_rows() > 0) {
            return $query->result_array();
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

        if ($query->num_rows()) {
            $result = $query->result_array();

            return $result[0]['total'];
        } else {
            return false;
        }
    }

    /**
     * Get the role by the given id.
     *
     * @param  String $name
     * @param  String $module
     * @return Array
     */
    public function getRole($name, $module)
    {
        $this->db->select('name, module, description');
        $this->db->where('name', $name);
        $this->db->where('module', $module);
        $query = $this->db->get('acl_roles');

        if ($query->num_rows() > 0) {
            $result = $query->result_array();

            return $result[0];
        } else {
            return false;
        }
    }

    /**
     * Get the roles that match the given groupId
     *
     * @param  Int $groupId
     * @param  String $moduleName
     * @return Array
     */
    public function getRolesByGroupId($groupId, $moduleName)
    {
        $this->db->select("ar.name, ar.module, ar.description");
        $this->db->where("agr.group_id", $groupId);

        if ($moduleName) {
            $this->db->where("agr.module", $moduleName);
        }

        $this->db->where("agr.module = ar.module");
        $this->db->where("agr.role_name = ar.name");
        $query = $this->db->get('acl_group_roles agr, acl_roles ar');

        if ($query->num_rows() > 0) {
            $result = $query->result_array();

            return $result;
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
    public function getRolesByModule($moduleName)
    {
        $query = $this->db->query("SELECT * FROM acl_roles WHERE module=?", array($moduleName));

        if ($query->num_rows() > 0) {
            $result = $query->result_array();

            return $result;
        } else {
            return false;
        }
    }

    /**
     * Get the permissions
     *
     * @param  String $name
     * @param  String $module
     * @return Array
     */
    public function getPermissionsByRole($name, $module)
    {
        $this->db->select("role_name, permission_name, module, value");
        $this->db->where('name', $name);
        $this->db->where('module', $module);
        $query = $this->db->get("acl_roles_permissions");

        if ($query->num_rows() > 0) {
            $result = $query->result_array();

            return $result;
        } else {
            return false;
        }
    }

    /**
     * Create a group
     *
     * @param String $name
     * @param String $color
     * @param String $description
     */
    public function createGroup($name, $color = '', $description = '')
    {
        $data = array(
            'name' => $name,
            'color' => $color,
            'description' => $description
        );

        $this->db->insert('acl_groups', $data);

        return $this->db->insert_id();
    }

    /**
     * Create a role
     *
     * @param String $name
     * @param String $description
     */
    public function createRole($name, $description = '')
    {
        $data = array(
            'name' => $name,
            'description' => $description
        );

        $this->db->insert('acl_roles', $data);
    }

    /**
     * Delete the group with the given id
     *
     * @param Int $groupId
     */
    public function deleteGroup($groupId)
    {
        $this->db->delete('acl_groups', array('id' => $groupId));
    }

    /**
     * Delete the role with the given id
     *
     * @param String $name
     * @param String $module
     */
    public function deleteRole($name, $module)
    {
        $this->db->delete('acl_roles', array('name' => $name, 'module' => $module));
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

        $this->db->insert('acl_account_groups', $data);
    }

    /**
     * Remove a group assignment
     *
     * @param Int $groupId
     * @param Int $accountId
     */
    public function removeGroupFromUser($groupId, $accountId)
    {
        $data = array(
            "account_id" => $accountId,
            "group_id" => $groupId
        );

        $this->db->delete('acl_account_groups', $data);
    }

    /**
     * Remove all group assignments
     *
     * @param Int $accountId
     */
    public function removeGroupsFromUser($accountId)
    {
        $data = array(
            "account_id" => $accountId
        );

        $this->db->delete('acl_account_groups', $data);
    }

    /**
     * Remove all permission assignments
     *
     * @param Int $accountId
     */
    public function removePermissionsFromUser($accountId)
    {
        $data = array(
            "account_id" => $accountId
        );

        $this->db->delete('acl_account_permissions', $data);
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
        $data = array(
            "account_id" => $accontId,
            "permission_name" => $permissionName,
            "module" => $moduleName,
            "value" => $value
        );

        $this->db->insert("acl_account_permissions", $data);
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
        $data = array(
            'group_id' => $groupId,
            'role_name' => $name,
            'module' => $module
        );

        $this->db->insert('acl_group_roles', $data);
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
        $this->db->delete('acl_group_roles', array('group_id' => $groupId, 'role_name' => $name, 'module' => $module));
    }

    /**
     * Save the group
     *
     * @param Int $id
     * @param Array $data
     */
    public function saveGroup($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('acl_groups', $data);
    }

    /**
     * Save the role
     *
     * @param Int $id
     * @param Array $data
     */
    public function saveRole($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('acl_roles', $data);
    }

    /**
     * Delete all roles from a given group
     *
     * @param Int $groupId
     */
    public function deleteAllRoleFromGroup($groupId)
    {
        $this->db->delete('acl_group_roles', array('group_id' => $groupId));
    }

    /**
     * Add a permission to the give role
     *
     * @param String $name
     * @param String $permission
     * @param String $module
     */
    public function addPermissionToRole($name, $permission, $module, $value = 1)
    {
        $data = array(
            'role_name' => $name,
            'permission_name' => $permission,
            'module' => $module,
            'value' => $value
        );

        $this->db->insert('acl_roles_permissions', $data);
    }

    /**
     * Remove a permission from the given role
     *
     * @param String $name
     * @param String $permission
     * @param String $module
     */
    public function deletePermissionFromRole($name, $permission, $module)
    {
        $where = array(
            'role_name' => $name,
            'permission_name' => $permission,
            'module' => $module
        );

        $this->db->delete('acl_roles_permissions', $where);
    }

    /**
     * Update a permission for the given role
     *
     * @param String $name
     * @param String $permission
     * @param String $module
     * @param Int $value
     */
    public function updatePermissionOfRole($name, $permission, $module, $value)
    {
        $this->db->where('role_name', $name);
        $this->db->where('permission_name', $permission);
        $this->db->where('module', $module);
        $this->db->update('acl_roles_permissions', array('value' => $value));
    }
}
