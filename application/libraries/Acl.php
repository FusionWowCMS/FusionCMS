<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use MX\CI;

/**
 * @package FusionCMS
 * @author  Jesper Lindström
 * @author  Xavier Geerinck
 * @author  Elliott Robbins
 * @author  Keramat Jokar (Nightprince) <https://github.com/Nightprince>
 * @author  Ehsan Zare (Darksider) <darksider.legend@gmail.com>
 * @link    https://github.com/FusionWowCMS/FusionCMS
 */

class Acl
{
    private $CI;
    private array $modules;
    private array $runtimeCache;

    public function __construct()
    {
        $this->modules = [];
        $this->runtimeCache = [];
        $this->CI = &get_instance();
    }

    /**
     * Require the user to have a specific permission
     *
     * @param String $permissionName
     * @param bool|String $moduleName
     * @return bool
     */
    public function requirePermission(string $permissionName, bool|string $moduleName = false): bool
    {
        if (!$this->hasPermission($permissionName, $moduleName)) {
            $this->CI->template->showError(lang("permission_denied", "error"));
            return false;
        }

        return true;
    }

    /**
     * Check if the user has a specific permission to view a certain item
     *
     * @param String $permissionName
     * @param String $moduleName
     * @return bool|null
     */
    public function hasViewPermission(string $permissionName, string $moduleName): bool|null
    {
        // SKIP! No permission required
        if(!$permissionName)
            return true;

        // Set: User id
        $userId = $this->CI->user->getId();

        // Fill runtime cache
        if(!isset($this->runtimeCache[$userId][$moduleName][$permissionName]))
            $this->fillRuntimeCache($userId);

        // It's been queried already
        if(isset($this->runtimeCache[$userId][$moduleName][$permissionName]))
            return $this->runtimeCache[$userId][$moduleName][$permissionName];

        // DEBUG
        # echo str_replace(['1', '2', '3'], [$moduleName, $permissionName, $userId], '[1][2][3]<br />');

        return false;
    }

    /**
     * Check if the user has a specific permission
     *
     * @param String $permissionName
     * @param bool|String $moduleName
     * @param bool|Int $userId
     * @return Boolean
     */
    public function hasPermission(string $permissionName, bool|string $moduleName = false, bool|int $userId = false): bool
    {
        // SKIP! No permission required
        if(!$permissionName)
            return true;

        // Set: Module name
        if(!$moduleName)
            $moduleName = $this->CI->template->module_name;

        // Set: User id
        if(!$userId)
            $userId = $this->CI->user->getId();

        // Fill runtime cache
        if(!isset($this->runtimeCache[$userId][$moduleName][$permissionName]))
            $this->fillRuntimeCache($userId);

        // It's been queried already
        if(isset($this->runtimeCache[$userId][$moduleName][$permissionName]))
            return $this->runtimeCache[$userId][$moduleName][$permissionName];

        // DEBUG
        # echo str_replace(['1', '2', '3'], [$moduleName, $permissionName, $userId], '[1][2][3]<br />');

        return false;
    }

    /**
     * Get the role
     *
     * @param String $roleName
     * @param String $moduleName
     * @return false|array
     */
    public function getManifestRole(string $roleName, string $moduleName): false|array
    {
        if (!array_key_exists($moduleName, $this->modules)) {
            $this->loadManifest($moduleName);
        }

        // Make sure the role exists
        if (array_key_exists($roleName, $this->modules[$moduleName]['roles'])) {
            return $this->modules[$moduleName]['roles'][$roleName];
        } else {
            return false;
        }
    }

    /**
     * Load the manifest
     *
     * @param String $moduleName
     */
    private function loadManifest(string $moduleName): void
    {
        if (!file_exists("application/modules/" . $moduleName . "/manifest.json")) {
            show_error("The manifest.json file for <b>" . strtolower($moduleName) . "</b> does not exist");
        }

        $manifest = file_get_contents("application/modules/" . $moduleName . "/manifest.json");
        $manifest = json_decode($manifest, true);

        if (!is_array($manifest)) {
            show_error("The manifest.json file for <b>" . strtolower($moduleName) . "</b> is not properly formatted");
        }

        $this->modules[$moduleName]['permissions'] = (array_key_exists("permissions", $manifest)) ? $manifest['permissions'] : array();
        $this->modules[$moduleName]['roles'] = (array_key_exists("roles", $manifest)) ? $manifest['roles'] : array();
    }

    /**
     * Fill runtime cache
     * Track all user permissions
     *
     * @param  int $userId
     * @return void
     */
    private function fillRuntimeCache(int $userId = 0): void
    {
        // STOP! Its filled already
        if(count($this->runtimeCache))
            return;

        // Set: User id
        if(!$userId)
            $userId = CI::$APP->user->getId();

        $this->loadDbPermissions($userId);

        $this->loadManifestPermissions($userId);
    }

    /**
     * Account permissions from DB
     *
     * @param int $userId
     * @return void
     */
    private function loadDbPermissions(int $userId): void
    {
        // Groups: Initialize
        $groups = (array)CI::$APP->acl_model->getGroupsByUser($userId);

        $default_player_group = CI::$APP->config->item('default_player_group');

        $default_group = (CI::$APP->user->isOnline() ? $default_player_group : CI::$APP->config->item('default_guest_group'));

        // Auth: Initialize | Keep track of user authentication status
        $auth = $userId && $default_group === $default_player_group;

        // Player only: Initialize
        $player_only = $auth && count($groups) == 1 && in_array($default_player_group, array_column($groups, 'id'));

        // Get: Account roles permissions
        $cacheKey = 'permissions_group_' . $default_group;
        if(!$auth || $player_only) {
            if ($cached = $this->CI->cache->get($cacheKey)) {
                $accountRolesPermissions = $cached;
            } else {
                $accountRolesPermissions = CI::$APP->acl_model->getAccountRolesPermissions($userId, $default_group, $auth, $player_only);

                $this->CI->cache->save($cacheKey, $accountRolesPermissions, 3600);
            }
        } else {
            $accountRolesPermissions = CI::$APP->acl_model->getAccountRolesPermissions($userId, $default_group, true, false);
        }

        // Get: Account permissions
        $accountPermissions = CI::$APP->acl_model->getAccountPermissions($userId);

        // Merge: account-permissions and account-roles-permissions
        $permissions = array_column((array)$accountPermissions, 'module', 'permission_name') + array_column((array)$accountRolesPermissions, 'module', 'role_name');

        // Loop through permissions
        foreach ($permissions as $module => $permission)
        {
            // Check if its menu permission
            if (in_array(strtoupper(trim($permission)), ['--MENU--', '--PAGE--', '--SIDEBOX--']))
            {
                // Temporary store module and permission
                $tmp = [
                    'module'     => $module,
                    'permission' => $permission
                ];

                // Swap module and permission
                $module     = $tmp['permission'];
                $permission = $tmp['module'];

                // Free up RAM
                unset($tmp);
            }

            // Fill runtime cache
            $this->runtimeCache[$userId][$module][$permission] = true;
        }
    }

    /**
     * Manifest permissions
     *
     * @param int $userId
     * @return void
     */
    private function loadManifestPermissions(int $userId): void
    {
        // Get: Account roles (account-specific-roles and account-group-roles)
        $roles = array_merge(array_column((array)CI::$APP->acl_model->getAccountRoles($userId), 'role_name'), array_column((array)CI::$APP->acl_model->getGroupRolesByUser($userId), 'role_name'));

        // Manifest permissions: Initialize
        $manifestPermissions = [];

        // Get: Modules
        if (!empty($modules = glob(realpath(APPPATH) . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR)))
        {
            // Loop through modules
            foreach ($modules as $module) {
                // Load manifest
                if (!isset($this->modules[basename($module)])) {
                    $this->loadManifest(basename($module));
                }

                // Prevent error
                if (!isset($manifestPermissions[basename($module)]))
                    $manifestPermissions[basename($module)] = [];

                // Priority 1: Store available permissions (db)
                if (is_array($roles))
                {
                    // Loop through account roles
                    foreach ($roles as $role)
                    {
                        // Get: Manifest role
                        $manifest = $this->getManifestRole($role, basename($module));

                        // Set: Manifest permissions (db)
                        if (isset($manifest['permissions']) && is_array($manifest['permissions']))
                            $manifestPermissions[basename($module)] = array_merge($manifestPermissions[basename($module)], $manifest['permissions']);
                    }
                }

                // Priority 2: Store available permissions (json)
                if (is_array($this->modules[basename($module)]['permissions']))
                {
                    // Loop through manifest permissions
                    foreach ($this->modules[basename($module)]['permissions'] as $permission => $permission_info)
                    {
                        // Set: Manifest permissions (manifest.json/default)
                        if (!isset($manifestPermissions[basename($module)][$permission]))
                            $manifestPermissions[basename($module)][$permission] = $permission_info['default'];
                    }
                }
            }
        }

        // Loop through manifest permissions
        foreach ($manifestPermissions as $module => $perms)
        {
            // Loop through permissions
            foreach ($perms as $k => $v)
            {
                // Fill runtime cache (if it's not being filled by database already)
                if (!isset($this->runtimeCache[$userId][basename($module)][$k]))
                    $this->runtimeCache[$userId][basename($module)][$k] = (bool)$v;
            }
        }
    }

    public function clearCache(): void {
        CI::$APP->cache->delete(CI::$APP->config->item('default_player_group'));
        CI::$APP->cache->delete(CI::$APP->config->item('default_guest_group'));
    }
}
