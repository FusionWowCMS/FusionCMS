<?php

class Backups extends MX_Controller
{
    public function __construct()
    {
        // Make sure to load the administrator library!
        $this->load->library('administrator');
        $this->load->library('dbbackup');
        $this->load->helper('download');
        $this->load->model('cms_model');

        parent::__construct();

        $this->load->config('backups');

        require_once('application/libraries/Configeditor.php');

        requirePermission("viewBackups");
    }

    public function index()
    {
        // Change the title
        $this->administrator->setTitle("Backups");

        $backups = $this->cms_model->getBackups();

        $config['auto_backups'] = $this->config->item('auto_backups');
        $config['backups_interval'] = $this->config->item('backups_interval');
        $config['backups_time'] = $this->config->item('backups_time');
        $config['backups_max_keep'] = $this->config->item('backups_max_keep');

        // Prepare my data
        $data = array(
            'backups' => $backups,
            'config' => $config,
            'url' => $this->template->page_url
        );

        // Load my view
        $output = $this->template->loadPage("backups.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->administrator->box('Backups', $output);

        // Output my content. The method accepts the same arguments as template->view
        $this->administrator->view($content, false, "modules/admin/js/backups.js");
    }

    public function do_backup()
    {
        requirePermission("generateBackup");
        $this->dbbackup->backup(true);
    }

    public function saveSettings()
    {
        requirePermission("editBackupSettings");

        if (!is_numeric($this->input->post('backups_interval')) || !is_numeric($this->input->post('backups_max_keep'))) {
            die('Only numbers allowed');
        }

        if ($this->input->post('backups_time') == 'hour' && $this->input->post('backups_interval') > 24) {
            die('A day only has 24 hours');
        }

        $fusionConfig = new ConfigEditor("application/config/backups.php");

        $fusionConfig->set('auto_backups', $this->input->post('auto_backups'));
        $fusionConfig->set('backups_interval', $this->input->post('backups_interval'));
        $fusionConfig->set('backups_time', $this->input->post('backups_time'));
        $fusionConfig->set('backups_max_keep', $this->input->post('backups_max_keep'));

        $fusionConfig->save();

        die('yes');
    }

    public function download($id)
    {
        requirePermission("executeBackupActions");

        $name = $this->cms_model->getBackups($id);
        $file = 'backups/' . $name . '.zip';
        if (file_exists($file)) {
            force_download($file, null);
        } else {
            die("File doesn't exist");
        }
    }

    public function delete($id)
    {
        requirePermission("executeBackupActions");

        $name = $this->cms_model->getBackups($id);
        $file = 'backups/' . $name . '.zip';
        $this->cms_model->deleteBackups($id);
        if (file_exists($file)) {
            unlink($file);
            die('yes');
        } else {
            die("File doesn't exist");
        }
    }

    public function restore($id)
    {
		set_time_limit(0);
        requirePermission("executeBackupActions");

        $name = $this->cms_model->getBackups($id);
        $zip = new ZipArchive();
        $zipfile = $zip->open('backups/' . $name . '.zip');

        if ($zipfile === true) {
            // Unzip path
            $extractpath = "backups/";

            // Extract file
            $zip->extractTo($extractpath);
            $zip->close();
        } else {
            die('Extract failed. Check file permissions');
        }

        $sqlfile = 'backups/' . $name . '.sql';

        if (file_exists($sqlfile)) {
            $lines = file($sqlfile);
            $statement = '';
            foreach ($lines as $line) {
                $statement .= $line;
                if (substr(trim($line), -1) === ';') {
                    $this->db->simple_query($statement);
                    $statement = '';
                }
            }
        } else {
            die("SQL file doesn't exist!");
        }

        unlink('backups/' . $name . '.sql');
        die('yes');
    }
}
