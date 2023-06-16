<?php

class Aclmanager extends MX_Controller
{
    /**
     * Perform permission check and initialize the administrator library
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->library('administrator');

        requirePermission("viewPermissions");
    }

    /**
     * Display the ACL manager frontpage
     */
    public function index()
    {
        // Get the template
        $output = $this->template->loadPage("aclmanager/index.tpl");

        // Output the content
        $output = $this->administrator->box("User groups &amp; permissions", $output);
        $this->administrator->view($output, "modules/admin/css/aclmanager.css");
    }

    // --- Group related methods ---

    /**
     * Manage the groups
     */
    public function groups()
    {
        $data = array(
            "groups" => $this->acl_model->getGroups(),
            "modules" => $this->getAllRoles(),
            "guestId" => $this->config->item('default_guest_group'),
            "playerId" => $this->config->item('default_player_group'),
            "links" => $this->cms_model->getLinks("all"),
            "sideboxes" => $this->cms_model->getSideboxes(),
            "pages" => $this->cms_model->getPages()
        );

        if ($data['groups']) {
            foreach ($data['groups'] as $k => $v) {
                $data['groups'][$k]['memberCount'] = $this->acl_model->getGroupMemberCount($v['id']);
            }
        }

        $output = $this->template->loadPage("aclmanager/groups.tpl", $data);

        $output = $this->administrator->box("<a href='" . pageURL . "admin/aclmanager'>User groups &amp; permissions</a> &rarr; Groups", $output);

        $this->administrator->view($output, "modules/admin/css/aclmanager.css", "modules/admin/js/groups.js");
    }

    public function editGroup($id = false)
    {
        requirePermission("editPermissions");

        if (!is_numeric($id) || !$id) {
            die();
        }

        $group = $this->acl_model->getGroup($id);

        if (!$group) {
            show_error("There is no group with ID " . $id);

            die();
        }

        // Change the title
        $this->administrator->setTitle($group['name']);

        // Prepare my data
        $data = array(
            "group" => $group,
            "modules" => $this->getAllRoles(),
            "members" => $this->acl_model->getGroupMembers($id),
            "guestId" => $this->config->item('default_guest_group'),
            "playerId" => $this->config->item('default_player_group'),
            "links" => $this->cms_model->getLinks("all"),
            "sideboxes" => $this->cms_model->getSideboxes(),
            "pages" => $this->cms_model->getPages()
        );

        // Links
        foreach ($data['links'] as $key => $value) {
            $data['links'][$key]['has'] = $this->acl_model->groupHasRole($id, $value['id'], "--MENU--");
        }

        // Sideboxes
        foreach ($data['sideboxes'] as $key => $value) {
            $data['sideboxes'][$key]['has'] = $this->acl_model->groupHasRole($id, $value['id'], "--SIDEBOX--");
        }

        // Pages
        foreach ($data['pages'] as $key => $value) {
            $data['pages'][$key]['has'] = $this->acl_model->groupHasRole($id, $value['id'], "--PAGE--");
        }

        // Modules
        foreach ($data['modules'] as $key => $value) {
            // Database roles
            if ($data['modules'][$key]['db']) {
                foreach ($data['modules'][$key]['db'] as $subKey => $subValue) {
                    $data['modules'][$key]['db'][$subKey]['has'] = $this->acl_model->groupHasRole($id, $subValue['name'], $key);
                }
            }

            // Manifest roles
            if ($data['modules'][$key]['manifest']) {
                foreach ($data['modules'][$key]['manifest'] as $subKey => $subValue) {
                    $data['modules'][$key]['manifest'][$subKey]['has'] = $this->acl_model->groupHasRole($id, $subKey, $key);
                }
            }
        }

        // Load my view
        $output = $this->template->loadPage("aclmanager/edit_group.tpl", $data);

        $content = $this->administrator->box('<a href="' . $this->template->page_url . 'admin/aclmanager/groups">Groups</a> &rarr; ' . $group['name'], $output);

        $this->administrator->view($content, "modules/admin/css/aclmanager.css", "modules/admin/js/groups.js");
    }

    /**
     * Delete a group
     *
     * @param Int $id
     */
    public function groupDelete($id)
    {
        requirePermission("deletePermissions");

        $this->acl_model->deleteGroup($id);
    }

    /**
     * Create a group
     */
    public function groupCreate()
    {
        requirePermission("addPermissions");

        $name = $this->input->post('name');
        $color = $this->input->post('color');
        $description = $this->input->post('description');
        $roles = array();

        // Make sure we have a group name
        if (!$name) {
            die('Please specify a group name!');
        }

        // Loop all POST data to grab the roles
        foreach ($_POST as $k => $v) {
            // Make sure it is a role
            if (!in_array($k, array("name", "description", "color"))) {
                if ($v == "true") {
                    array_push($roles, $k);
                }
            }
        }

        $id = $this->acl_model->createGroup($name, $color, $description);

        foreach ($roles as $role) {
            // Handle visibility permissions
            if (preg_match("/^(PAGE|SIDEBOX|MENU)_/", $role)) {
                /**
                 * [0] visibility type
                 * [1] ID/role
                 */
                $parts = explode("_", $role);
                $roleName = $parts[1];
                $moduleName = "--" . $parts[0] . "--";

                $this->acl_model->addRoleToGroup($id, $roleName, $moduleName);
            } elseif (preg_match("/-/", $role)) {
                /**
                 * [0] module
                 * [1] role
                 */
                $roleParts = explode("-", $role);

                $this->acl_model->addRoleToGroup($id, $roleParts[1], $roleParts[0]);
            } else {
                // Unknown POST data
            }
        }

        die('1');
    }

    /**
     * Save a group
     *
     * @param Int $id
     */
    public function groupSave($id)
    {
        requirePermission("editPermissions");

        $name = $this->input->post('name');
        $color = $this->input->post('color');
        $description = $this->input->post('description');
        $roles = array();

        // Make sure we have a group name
        if (!$name) {
            die('Please specify a group name!');
        }

        // Loop all POST data to grab the roles
        foreach ($_POST as $k => $v) {
            // Make sure it is a role
            if (!in_array($k, array("name", "description", "color"))) {
                if ($v == "true") {
                    array_push($roles, $k);
                }
            }
        }

        $this->acl_model->saveGroup($id, array('name' => $name, 'color' => $color, 'description' => $description));

        $this->acl_model->deleteAllRoleFromGroup($id);

        foreach ($roles as $role) {
            // Handle visibility permissions
            if (preg_match("/^(PAGE|SIDEBOX|MENU)_/", $role)) {
                /**
                 * [0] visibility type
                 * [1] ID/role
                 */
                $parts = explode("_", $role);
                $roleName = $parts[1];
                $moduleName = "--" . $parts[0] . "--";

                $this->acl_model->addRoleToGroup($id, $roleName, $moduleName);
            } elseif (preg_match("/-/", $role)) {
                /**
                 * [0] module
                 * [1] role
                 */
                $roleParts = explode("-", $role);

                $this->acl_model->addRoleToGroup($id, $roleParts[1], $roleParts[0]);
            } else {
                // Unknown POST data
            }
        }

        die('1');
    }

    public function addMember()
    {
        $groupId = $this->input->post('groupId');
        $account = $this->input->post('name');

        $accountId = $this->user->getId($account);

        if (!$accountId) {
            die("invalid");
        }

        $this->acl_model->assignGroupToUser($groupId, $accountId);
    }

    public function removeMember()
    {
        $groupId = $this->input->post('groupId');
        $account = $this->input->post('name');

        $accountId = $this->user->getId($account);

        $this->acl_model->removeGroupFromUser($groupId, $accountId);
    }

    // --- Role related methods ---

    /**
     * Manage the roles
     */
    public function roles()
    {
        $data = array(
            "modules" => $this->getAllRoles()
        );

        $output = $this->template->loadPage("aclmanager/roles.tpl", $data);

        $output = $this->administrator->box("<a href='" . pageURL . "admin/aclmanager'>User groups &amp; permissions</a> &rarr; Roles", $output);

        $this->administrator->view($output, "modules/admin/css/aclmanager.css", "modules/admin/js/roles.js");
    }

    /**
     * Delete a role
     *
     * @param Int $id
     */
    public function roleDelete($id)
    {
        requirePermission("deletePermissions");

        $this->acl_model->deleteRole($id);
    }

    /**
     * Create a role
     */
    public function roleCreate()
    {
        requirePermission("addPermissions");
    }

    /**
     * Save a role
     *
     * @param Int $id
     */
    public function roleSave($id)
    {
        requirePermission("editPermissions");
    }

    // --- User related methods ---

    /**
     * Manage the users
     */
    public function users()
    {
        $data = array();

        $output = $this->template->loadPage("aclmanager/users.tpl", $data);

        $output = $this->administrator->box("<a href='" . pageURL . "admin/aclmanager'>User groups &amp; permissions</a> &rarr; Users permissions", $output);

        $this->administrator->view($output, "modules/admin/css/aclmanager.css", "modules/admin/js/users.js");
    }

    // --- Getters and stuff ---

    /**
     * Get all roles
     *
     * @return Array
     */
    private function getAllRoles()
    {
        $modules = array();
        $dangerLevel = array(
            3 => "#A11500", // Owner actions
            2 => "#DF5500", // Admin actions
            1 => "#A11D73" // Moderator actions
        );

        foreach (glob("application/modules/*") as $module) {
            if (is_dir($module)) {
                $data = file_get_contents($module . "/manifest.json");
                $manifest = json_decode($data, true);

                $module = preg_replace("/^application\/modules\//", "", $module);

                if (is_array($manifest)) {
                    $modules[$module]['name'] = (array_key_exists("name", $manifest)) ? $manifest['name'] : $module;
                    $modules[$module]['manifest'] = (array_key_exists("roles", $manifest)) ? $manifest['roles'] : false;

                    if ($modules[$module]['manifest']) {
                        foreach ($modules[$module]['manifest'] as $k => $v) {
                            if (array_key_exists("dangerLevel", $v) && array_key_exists($v['dangerLevel'], $dangerLevel)) {
                                $modules[$module]['manifest'][$k]['color'] = $dangerLevel[$v['dangerLevel']];
                            }
                        }
                    }

                    $modules[$module]['db'] = $this->acl_model->getRolesByModule($module);
                }
            }
        }

        return $modules;
    }
}
