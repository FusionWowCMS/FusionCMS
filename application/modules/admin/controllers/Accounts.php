<?php

class Accounts extends MX_Controller
{
    private $logsToLoad = 10;

    public function __construct()
    {
        parent::__construct();

        $this->load->library('administrator');
        $this->load->model('accounts_model');
        $this->load->model('logging_model');

        requirePermission("viewAccounts");
    }

    /**
     * Display the admin panel if we have access
     */
    public function index()
    {
        // Change the title
        $this->administrator->setTitle("Accounts");

        // Prepare my data
        $data = array();

        // Load my view
        $output = $this->template->loadPage("accounts/accounts_search.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->administrator->box('Accounts', $output);

        // Output my content. The method accepts the same arguments as template->view
        $this->administrator->view($content, false, "modules/admin/js/accounts.js");
    }
    
    public function get_accs_ajax()
    {
        $total_users = $this->accounts_model->count_all_users();

        $search_value = $this->input->post('search');

        $filtered_users = $this->accounts_model->count_filtered_users($search_value);

        $start = $this->input->post('start');

        $length = $this->input->post('length');

        $users = $this->accounts_model->get_users($length, $start, $search_value);

        $output = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => $total_users,
            "recordsFiltered" => $filtered_users,
            "data" => $users
        );
        die(json_encode($output));
    }

    public function get($id = false)
    {
        if (!is_numeric($id))
        {
            die('<span>No such account</span>');
        }
        $data = $this->accounts_model->getById($id);

        if ($data) {
            $internal_details = $this->accounts_model->getInternalDetails($data['id']);

            $userGroup = $this->acl_model->getGroupsByUser($data['id']);

            $logs = $this->accounts_model->getLogs($data['id'], 0, 10);

            // Prepare my data
            $page_data = array(
                'internal_details' => $internal_details,
                'external_details' => $data,
                'access_id'  => $this->accounts_model->getAccessId($data['id']),
                'expansions' => $this->realms->getExpansions(),
                'guestId' => $this->config->item('default_guest_group'),
                'groups' => $this->acl_model->getGroups(),
                'userGroup' => $userGroup[0]['id'],
                'banstatus' => $this->external_account_model->getBannedStatus($data['id']),
                "avatar"    => $this->user->getAvatar($data['id']),
                "groups" => $this->acl_model->getGroupsByUser($data['id']),
                'register_date' => preg_replace("/\s.*/", "", $this->external_account_model->getJoinDate()),
                'modules' => $this->getModulePermissions(),
                'logs' => $logs,
                'show_more' => $this->logger->getLogCount() - count(array($logs))
            );

            // Load my view
            $output = $this->template->loadPage("accounts/accounts_found.tpl", $page_data);

            // Put my view in the main box with a headline
            $content = $this->administrator->box('Account #' . $id . '', $output);

            // Output my content. The method accepts the same arguments as template->view
            $this->administrator->view($content, false, "modules/admin/js/accounts.js");
        } else {
            die("<span>Account doesn't exist</span>");
        }
    }

    private function getModulePermissions()
    {
        $modules = array();

        foreach (glob("application/modules/*") as $module) {
            if (is_dir($module)) {
                $data = file_get_contents($module . "/manifest.json");
                $manifest = json_decode($data, true);

                $module = preg_replace("/^application\/modules\//", "", $module);

                if (is_array($manifest)) {
                    $modules[$module]['name'] = (array_key_exists("name", $manifest)) ? $manifest['name'] : $module;
                    $modules[$module]['manifest'] = (array_key_exists("permissions", $manifest)) ? $manifest['permissions'] : false;
                    $modules[$module]['folderName'] = $module;
                }
            }
        }

        return $modules;
    }

    public function save($id = false)
    {
        if (!hasPermission("editAccounts")) {
            die('You do not have permission to edit accounts');
        }

        if (!$id || !is_numeric($id)) {
            die();
        }

        $external_account_data[column("account", "expansion")] = $this->input->post("expansion");
        $external_account_data[column("account", "email")] = $this->input->post("email");

        if (hasPermission("editPermissions")) {
            $this->acl_model->removePermissionsFromUser($id);

            foreach ($_POST as $k => $v) {
                if ($v !== '' && !in_array($k, array("vp", "dp", "nickname", "email", "group", "expansion", "gm_level"))) {
                    $permissionParts = explode("-", $k);

                    // UserID, permissionName, moduleName
                    $this->acl_model->assignPermissionToUser($id, $permissionParts[1], $permissionParts[0], $v);
                }
            }
        }

        if (preg_match("/mangos/i", get_class($this->realms->getEmulator()))) {
            $external_account_access_data[column("account", "gmlevel")] = $this->input->post("gm_level");
        } else {
            $external_account_access_data[column("account_access", "gmlevel")] = $this->input->post("gm_level");
        }

        $internal_account_data["vp"] = $this->input->post("vp");
        $internal_account_data["dp"] = $this->input->post("dp");
        $internal_account_data["nickname"] = $this->input->post("nickname");

        $this->accounts_model->save($id, $external_account_data, $external_account_access_data, $internal_account_data);

        die('yes');
    }

    public function loadMoreLogs($id)
    {
        $offset = $this->input->post('offset');
        $count = $this->input->post('count');
        $extraLogCount = $this->input->post('show_more');

        $extraLogCount -= $this->logsToLoad;

        // Validation, checking is done in the model.
        $logs = $this->logging_model->getLogs($id, $offset, $count);

        if ($logs) {
            // Prepare my data
            $data = array(
                'logs' => $logs,
                'userid' => $id,
                'show_more' => $extraLogCount
            );

            // Load my view
            $output = $this->template->loadPage("accounts/accounts_logging_found.tpl", $data);

            die($output);
        } else {
            die("<span>No results</span>");
        }
    }
}
