<?php

class Realmmanager extends MX_Controller
{
    public function __construct()
    {
        // Make sure to load the administrator library!
        $this->load->library('administrator');
        $this->load->model('realm_model');

        parent::__construct();

        requirePermission("editSystemSettings");
    }

    public function edit($id = false)
    {
        if (!$id || !is_numeric($id)) {
            die();
        }

        $realm = $this->realms->getRealm($id);

        // Change the title
        $this->administrator->setTitle($realm->getName());

        // Prepare my data
        $data = array(
            'url' => $this->template->page_url,
            'realm' => $realm,
            'hostname_char' => ($realm->getConfig('override_hostname_char')) ? $realm->getConfig('override_hostname_char') : $realm->getConfig('hostname'),
            'username_char' => ($realm->getConfig('override_username_char')) ? $realm->getConfig('override_username_char') : $realm->getConfig('username'),
            'password_char' => ($realm->getConfig('override_password_char')) ? $realm->getConfig('override_password_char') : $realm->getConfig('password'),
            'port_char' => ($realm->getConfig('override_port_char')) ? $realm->getConfig('override_port_char') : 3306,
            'hostname_world' => ($realm->getConfig('override_hostname_world')) ? $realm->getConfig('override_hostname_world') : $realm->getConfig('hostname'),
            'username_world' => ($realm->getConfig('override_username_world')) ? $realm->getConfig('override_username_world') : $realm->getConfig('username'),
            'password_world' => ($realm->getConfig('override_password_world')) ? $realm->getConfig('override_password_world') : $realm->getConfig('password'),
            'port_world' => ($realm->getConfig('override_port_world')) ? $realm->getConfig('override_port_world') : 3306,
            'emulators' => $this->getEmulators()
        );

        // Load my view
        $output = $this->template->loadPage("edit_realm.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->administrator->box("<a href='" . $this->template->page_url . "admin/settings'>Settings</a> &rarr; " . $realm->getname(), $output);

        // Output my content. The method accepts the same arguments as template->view
        $this->administrator->view($content, false, "modules/admin/js/settings.js");
    }

    private function getEmulators()
    {
        require("application/config/emulator_names.php");

        return $emulators;
    }

    public function delete($id)
    {
        $this->cache->delete('*.cache');
        $this->cache->delete('items/item_' . $id . '_*.cache');
        $this->realm_model->delete($id);
    }

    public function create()
    {
        $data = array();

        $data['realmName'] = $this->input->post('name');
        $data['hostname'] = $this->input->post('hostname');
        $data['username'] = $this->input->post('username');
        $data['password'] = $this->input->post('password');
        $data['char_database'] = $this->input->post('characters');
        $data['world_database'] = $this->input->post('world');
        $data['cap'] = $this->input->post('cap');
        $data['realm_port'] = $this->input->post('port');
        $data['emulator'] = $this->input->post('emulator');
        $data['console_username'] = $this->input->post('console_username');
        $data['console_password'] = $this->input->post('console_password');
        $data['console_port'] = $this->input->post('console_port');

        $data['override_hostname_char'] = $this->input->post('override_hostname_char');
        $data['override_username_char'] = $this->input->post('override_username_char');
        $data['override_password_char'] = $this->input->post('override_password_char');
        $data['override_port_char'] = $this->input->post('override_port_char');

        $data['override_hostname_world'] = $this->input->post('override_hostname_world');
        $data['override_username_world'] = $this->input->post('override_username_world');
        $data['override_password_world'] = $this->input->post('override_password_world');
        $data['override_port_world'] = $this->input->post('override_port_world');

        if (!is_numeric($data['cap'])) {
            die('Cap must be a number');
        }

        if (!is_numeric($data['realm_port'])) {
            die('Port must be a number');
        }

        if (!file_exists("application/emulators/" . $data['emulator'] . ".php")) {
            die('Invalid emulator');
        }

        $id = $this->realm_model->create($data);

        die((string)$id);
    }

    public function save($id = false)
    {
        if (!$id || !is_numeric($id)) {
            die();
        }

        $data['realmName'] = $this->input->post('realmName');
        $data['hostname'] = $this->input->post('hostname');
        $data['username'] = $this->input->post('username');

        if ($this->input->post('password')) {
            $data['password'] = $this->input->post('password');
        }

        $data['char_database'] = $this->input->post('characters');
        $data['world_database'] = $this->input->post('world');
        $data['cap'] = $this->input->post('cap');
        $data['realm_port'] = $this->input->post('port');
        $data['emulator'] = $this->input->post('emulator');
        $data['console_username'] = $this->input->post('console_username');

        $data['override_hostname_char'] = $this->input->post('override_hostname_char');
        $data['override_username_char'] = $this->input->post('override_username_char');
        $data['override_password_char'] = $this->input->post('override_password_char');
        $data['override_port_char'] = $this->input->post('override_port_char');

        $data['override_hostname_world'] = $this->input->post('override_hostname_world');
        $data['override_username_world'] = $this->input->post('override_username_world');
        $data['override_password_world'] = $this->input->post('override_password_world');
        $data['override_port_world'] = $this->input->post('override_port_world');

        if ($this->input->post('console_password')) {
            $data['console_password'] = $this->input->post('console_password');
        }

        $data['console_port'] = $this->input->post('console_port');

        if (!is_numeric($data['cap'])) {
            die('Cap must be a number');
        }

        if (!is_numeric($data['realm_port'])) {
            die('Port must be a number');
        }

        if (!is_numeric($data['console_port'])) {
            die('Console port must be a number');
        }

        if (!file_exists("application/emulators/" . $data['emulator'] . ".php")) {
            die('Invalid emulator');
        }

        $this->realm_model->save($id, $data);

        die('success');
    }
}
