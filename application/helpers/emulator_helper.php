<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Get the name of a table
 *
 * @param string $name
 * @param bool|int $realm
 * @return string
 */
function table(string $name, bool|int $realm = false): string|null
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
 * @param string $table
 * @param string $name
 * @param bool $as
 * @param bool|int $realm
 * @return false|string
 */
function column(string $table, string $name, bool $as = false, bool|int $realm = false): false|string|null
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
 * @param string $name
 * @param bool|int $realm
 * @return string|null
 */
function query(string $name, bool|int $realm = false): string|null
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
 * @param string $table
 * @param array $columns
 * @param bool|int $realm
 * @return string
 */
function columns(string $table, array $columns, bool|int $realm = false): string|null
{
    $out = '';
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
 * @param string $table
 * @param bool|int $realm
 * @return string
 */
function allColumns(string $table, bool|int $realm = false): string|null
{
    global $CI;
    $out = '';

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
