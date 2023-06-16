<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * @package FusionGen
 * @author  Jesper Lindström
 * @author  Xavier Geerinck
 * @author  Elliott Robbins
 * @author  Err0r
 * @link    http://fusiongen.net
 */

class Dbbackup
{
    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->helper('file', 'text', 'form', 'string');
        $this->CI->load->model('cms_model');
        $this->CI->load->dbutil();

        $this->FCPATH = FCPATH;
    }

    public function backup($trigger = false)
    {
        $db_backup_path = 'backups/';
        $max_files = $this->CI->config->item('backups_max_keep');
        $backups_interval = $this->CI->config->item('backups_interval');
        $backups_time = $this->CI->config->item('backups_time');

        $date_ref = date("Y-m-d H:i:s", strtotime('-' . $backups_interval . $backups_time . ''));
        $this->CI->db->where('created_date >', $date_ref);
        $this->CI->db->order_by('created_date', 'DESC');
        $this->CI->db->limit(1);
        $row = $this->CI->db->get('backup')->row();

        if (!$row || $trigger) {
            if (!is_dir($db_backup_path) && $trigger) {
                mkdir($db_backup_path, 0777);
                log_message('info', '' . $db_backup_path . ' did not exist. Created!');
            }

            if (!is_writeable($db_backup_path) && $trigger) {
                log_message('error', '' . $db_backup_path . ' not writeable!');
                die("Backup folder not writeable");
            }

            $date = date("Y-m-d H:i:s");
            $file_name = date("Y_m_d_H_i_s");
            $prefs = array(
                'format' => 'zip',
                'filename' => $file_name,
                'add_drop' => true,
                'add_insert' => true,
                'foreign_key_checks' => false,
                'newline' => "\n"
            );
            //Backup your entire database
            $backup = $this->CI->dbutil->backup($prefs);
            $file = $db_backup_path . $file_name . '.zip';

            if (write_file($file, $backup)) {
                $data = array(
                    'backup_name' => $file_name,
                    'created_date' => $date
                );

                $this->CI->db->insert('backup', $data);

                $n_row = $this->CI->db->count_all('backup');

                if ($n_row > $max_files) {
                    $this->CI->db->limit($n_row - $max_files);
                    $this->CI->db->order_by('created_date', 'ASC');
                    $todelete = $this->CI->db->get('backup')->result();

                    foreach ($todelete as $to_delete) {
                        //delete row from db table
                        $this->CI->db->where('id', $to_delete->id);
                        $this->CI->db->delete('backup');

                        // delete file from backup directory
                        $file_del = $db_backup_path . $to_delete->backup_name . '.zip';
                        if (file_exists($file_del)) {
                            unlink($file_del);
                            log_message('error', 'Backup ' . $file_del . ' deleted');
                        }
                    }
                }
                if ($trigger) {
                    die('yes');
                }
            } else {
                log_message('error', 'Backup creation failed. Unknown error');
                if ($trigger) {
                    die('Backup failed');
                }
            }
        } else {
            if ($trigger) {
                log_message('error', 'Backup creation failed. Function not executed.');
                die('Backup creation failed. Function not executed.');
            }
        }
    }
}
