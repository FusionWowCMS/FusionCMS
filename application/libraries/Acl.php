<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

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
    private $modules;
    private $runtimeCache;

    public function __construct()
    {
        $this->modules = array();
        $this->runtimeCache = array();
        $this->CI = &get_instance();
    }

    /**
     * Require the user to have a specific permission
     *
     * @param String $permissionName
     * @param String $moduleName
     */
    public function requirePermission($permissionName, $moduleName = false)
    {
        if (!$this->hasPermission($permissionName, $moduleName)) {
            $this->CI->template->showError(lang("permission_denied", "error"));
        }
    }

    /**
     * Check if the user has a specific permission to view a certain item
     *
     * @param  String $permissionName
     * @param  String $moduleName
     * @return Boolean
     */
    public function hasViewPermission($permissionName, $moduleName)
    {
        $userId = false;

        if ($this->CI->user->isOnline()) {
            $userId = $this->CI->user->getId();
        }

        // Asked the question before? Grab the last answer
        if (
            array_key_exists($moduleName, $this->runtimeCache)
            && array_key_exists($permissionName, $this->runtimeCache[$moduleName])
            && array_key_exists($userId, $this->runtimeCache[$moduleName][$permissionName])
        ) {
            return $this->runtimeCache[$moduleName][$permissionName][$userId];
        } else {
            // Get permission for a specific user
            if ($userId) {
                $result = $this->CI->acl_model->hasPermission($userId, $permissionName, $moduleName, true);
            }


            // Get permission for the guest group
            else {
                $result = $this->CI->acl_model->hasPermissionGuest($permissionName, $moduleName, true);
            }

            return $result;
        }
    }

    /**
     * Check if the user has a specific permission
     *
     * @param  String $permissionName
     * @param  String $moduleName
     * @param  Int $userId
     * @return Boolean
     */
    public function hasPermission($permissionName, $moduleName = false, $userId = false)
    {
        // Default to the current module
        if (!$moduleName) {
            $moduleName = $this->CI->template->module_name;
        }

        if (!$userId && $this->CI->user->isOnline()) {
            $userId = $this->CI->user->getId();
        }

        // Asked the question before? Grab the last answer
        if (
            array_key_exists($moduleName, $this->runtimeCache)
            && array_key_exists($permissionName, $this->runtimeCache[$moduleName])
            && array_key_exists($userId, $this->runtimeCache[$moduleName][$permissionName])
        ) {
            return $this->runtimeCache[$moduleName][$permissionName][$userId];
        } else {
            // Get the permission information
            $permission = $this->getPermission($permissionName, $moduleName);

            // Assign the default value
            $result = $permission['default'];

            // Get permission for a specific user
            if ($userId) {
                $userPermission = $this->CI->acl_model->hasPermission($userId, $permissionName, $moduleName);
            }

            // Get permission for the guest group
            else {
                $userPermission = $this->CI->acl_model->hasPermissionGuest($permissionName, $moduleName);
            }

            // Only override the default value if the user has the permission assigned
            if ($userPermission !== null) {
                $result = $userPermission;
            }

            return $result;
        }
    }

    /**
     * Get the permission information
     *
     * @param  String $permissionName
     * @param  String $moduleName
     * @return Array
     */
    public function getPermission($permissionName, $moduleName)
    {
        if (!array_key_exists($moduleName, $this->modules)) {
            $this->loadManifest($moduleName);
        }

        // Make sure the permission exists
        if (array_key_exists($permissionName, $this->modules[$moduleName]['permissions'])) {
            return $this->modules[$moduleName]['permissions'][$permissionName];
        } else {
            show_error("The permission <b>" . $permissionName . "</b> does not exist in <b>" . $moduleName . "</b>");
        }
    }

    /**
     * Get the role
     *
     * @param  String $roleName
     * @param  String $moduleName
     * @return Array
     */
    public function getManifestRole($roleName, $moduleName)
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
    private function loadManifest($moduleName)
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
}
