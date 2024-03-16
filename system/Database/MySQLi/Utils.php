<?php

declare(strict_types=1);

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CodeIgniter\Database\MySQLi;

use CodeIgniter\Database\BaseUtils;
use CodeIgniter\Database\Exceptions\DatabaseException;

/**
 * Utils for MySQLi
 */
class Utils extends BaseUtils
{
    /**
     * List databases statement
     *
     * @var string
     */
    protected $listDatabases = 'SHOW DATABASES';

    /**
     * OPTIMIZE TABLE statement
     *
     * @var string
     */
    protected $optimizeTable = 'OPTIMIZE TABLE %s';

    /**
     * Platform dependent version of the backup function.
     *
     * @return false|string
     */
    public function _backup(?array $prefs = null)
    {
        if (count($prefs) === 0)
            return false;

        // Extract the prefs for simplicity
        extract($prefs);

        // Build the output
        $output = '';

        // Do we need to include a statement to disable foreign key checks?
        if ($foreign_key_checks === false) {
            $output .= 'SET foreign_key_checks = 0;' . $newline;
        }

        foreach ((array)$tables as $table) {
            // Is the table in the "ignore" list?
            if (in_array($table, (array)$ignore, true))
                continue;

            // Get the table schema
            $query = $this->db->query('SHOW CREATE TABLE ' . $this->db->escapeIdentifiers($this->db->database . '.' . $table));

            // No result means the table name was invalid
            if ($query === false)
                continue;

            // Write out the table schema
            $output .= '#' . $newline . '# TABLE STRUCTURE FOR: ' . $table . $newline . '#' . $newline . $newline;

            if ($add_drop === true) {
                $output .= 'DROP TABLE IF EXISTS ' . $this->db->protectIdentifiers($table) . ';' . $newline . $newline;
            }

            $i = 0;
            $result = $query->getResultArray();
            foreach ($result[0] as $val) {
                if ($i++ % 2) {
                    $output .= $val . ';' . $newline . $newline;
                }
            }

            // If inserts are not needed, we're done...
            if ($add_insert === false)
                continue;

            // Grab all the data from the current table
            $query = $this->db->query('SELECT * FROM ' . $this->db->protectIdentifiers($table));

            if ($query->getNumRows() === 0)
                continue;

            // Fetch the field names and determine if the field is an
            // integer type. We use this info to decide whether to
            // surround the data with quotes or not

            $i = 0;
            $field_str = '';
            $is_int = [];
            while ($field = $query->resultID->fetch_field()) {
                // Most versions of MySQL store timestamp as a string
                $is_int[$i] = in_array($field->type, [MYSQLI_TYPE_TINY, MYSQLI_TYPE_SHORT, MYSQLI_TYPE_INT24, MYSQLI_TYPE_LONG], true);

                // Create a string of field names
                $field_str .= $this->db->escapeIdentifiers($field->name) . ', ';
                $i++;
            }

            // Trim off the end comma
            $field_str = preg_replace('/, $/', '', $field_str);

            // Build the insert string
            foreach ($query->getResultArray() as $row) {
                $val_str = '';

                $i = 0;
                foreach ($row as $v) {
                    // Is the value NULL?
                    if ($v === null) {
                        $val_str .= 'NULL';
                    } else {
                        // Escape the data if it's not an integer
                        $val_str .= ($is_int[$i] === false) ? $this->db->escape($v) : $v;
                    }

                    // Append a comma
                    $val_str .= ', ';
                    $i++;
                }

                // Remove the comma at the end of the string
                $val_str = preg_replace('/, $/', '', $val_str);

                // Build the INSERT string
                $output .= 'INSERT INTO ' . $this->db->protectIdentifiers($table) . ' (' . $field_str . ') VALUES (' . $val_str . ');' . $newline;
            }

            $output .= $newline . $newline;
        }

        // Do we need to include a statement to re-enable foreign key checks?
        if ($foreign_key_checks === false) {
            $output .= 'SET foreign_key_checks = 1;' . $newline;
        }

        return $output;
    }
}
