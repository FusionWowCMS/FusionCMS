<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Get the name of a table
 *
 * @param  String $name
 * @return String
 */
function table($name, $realm = false)
{
    $CI = &get_instance();

    if ($realm) {
        return $CI->realms->getRealm($realm)->getEmulator()->getTable($name);
    } else {
        return $CI->realms->getEmulator()->getTable($name);
    }
}

/**
 * Get the name of a column
 *
 * @param  String $table
 * @param  String $name
 * @param  Boolean $as
 * @return String
 */
function column($table, $name, $as = false, $realm = false)
{
    $CI = &get_instance();

    if ($realm) {
        $column = $CI->realms->getRealm($realm)->getEmulator()->getColumn($table, $name);
    } else {
        $column = $CI->realms->getEmulator()->getColumn($table, $name);
    }

    if (!$column) {
        return false;
    }

    return $column . (($as) ? " AS " . $name : "");
}

/**
 * Get a pre-defined query
 *
 * @param  String $name
 * @return String
 */
function query($name, $realm = false)
{
    $CI = &get_instance();

    if ($realm) {
        return $CI->realms->getRealm($realm)->getEmulator()->getQuery($name);
    } else {
        return $CI->realms->getEmulator()->getQuery($name);
    }
}

/**
 * Get the columns and format them
 *
 * @param  String $table
 * @param  Array $columns
 * @return String
 */
function columns($table, $columns, $realm = false)
{
    foreach ($columns as $column) {
        if (!isset($out)) {
            $out = column($table, $column, false, $realm) . " AS " . $column;
        } else {
            $out .= "," . column($table, $column, false, $realm) . " AS " . $column;
        }
    }

    return $out;
}

/**
 * Get the columns and format them
 *
 * @param  String $table
 * @param  Array $columns
 * @return String
 */
function allColumns($table, $realm = false)
{
    global $CI;

    if ($realm) {
        $columns = $CI->realms->getRealm($realm)->getEmulator()->getAllColumns($table);
    } else {
        $columns = $CI->realms->getEmulator()->getAllColumns($table);
    }

    foreach ($columns as $name => $column) {
        if (!isset($out)) {
            $out = $column . " AS " . $name;
        } else {
            $out .= "," . $column . " AS " . $name;
        }
    }

    return $out;
}
