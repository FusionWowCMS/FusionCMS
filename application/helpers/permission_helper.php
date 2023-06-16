<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Check if a user has permission to do a certain task
 *
 * @param  String $permissionName
 * @param  String $moduleName
 * @param  Int $userId
 * @return Boolean
 */
function hasPermission($permissionName, $moduleName = false, $userId = false)
{
    static $CI;

    if (!$CI) {
        $CI = &get_instance();
    }

    return $CI->acl->hasPermission($permissionName, $moduleName, $userId);
}

/**
 * Check if a user has permission to see a menu link
 *
 * @param  String $permissionName
 * @param  String $moduleName
 * @return Boolean
 */
function hasViewPermission($permissionName, $moduleName)
{
    static $CI;

    if (!$CI) {
        $CI = &get_instance();
    }

    return $CI->acl->hasViewPermission($permissionName, $moduleName);
}

/**
 * Check if a user has permission to do a certain task
 *
 * @param  String $permissionName
 * @param  String $moduleName
 * @return Boolean
 */
function requirePermission($permissionName, $moduleName = false)
{
    static $CI;

    if (!$CI) {
        $CI = &get_instance();
    }

    return $CI->acl->requirePermission($permissionName, $moduleName);
}
