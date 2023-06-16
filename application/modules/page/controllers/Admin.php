<?php

class Admin extends MX_Controller
{
    public function __construct()
    {
        // Make sure to load the administrator library!
        $this->load->library('administrator');
        $this->load->helper('tinymce_helper');
        $this->load->model('page_model');

        requirePermission("canViewAdmin");

        parent::__construct();
    }

    public function index()
    {
        // Change the title
        $this->administrator->setTitle("Pages");

        $pages = $this->page_model->getPages(true);

        if ($pages) {
            foreach ($pages as $key => $value) {
                $pages[$key]['name'] = langColumn($pages[$key]['name']);

                if (strlen($pages[$key]['name']) > 20) {
                    $pages[$key]['name'] = mb_substr($pages[$key]['name'], 0, 20) . '...';
                }
            }
        }

        // Prepare my data
        $data = array(
            'url' => $this->template->page_url,
            'pages' => $pages
        );

        // Load my view
        $output = $this->template->loadPage("admin.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->administrator->box('Custom pages', $output);

        // Output my content. The method accepts the same arguments as template->view
        $this->administrator->view($content, false, "modules/page/js/admin.js");
    }

    public function new()
    {
        requirePermission("canAdd");

        // Change the title
        $this->administrator->setTitle('Page - New');

        // Prepare my data
        $data = array(
            'url' => $this->template->page_url,
        );

        // Load my view
        $output = $this->template->loadPage("admin_new.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->administrator->box('New Page', $output);

        // Output my content. The method accepts the same arguments as template->view
        $this->administrator->view($content, false, "modules/page/js/admin.js");
    }

    public function edit($id = false)
    {
        requirePermission("canEdit");

        if (!$id || !is_numeric($id)) {
            die();
        }

        $page = $this->page_model->getPage($id);

        if ($page == false) {
            show_error("There is no page with ID " . $id);

            die();
        }

        // Change the title
        $this->administrator->setTitle(langColumn($page['name']));

        // Prepare my data
        $data = array(
            'url' => $this->template->page_url,
            'page' => $page
        );

        // Load my view
        $output = $this->template->loadPage("admin_edit.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->administrator->box('' . langColumn($page['name']), $output);

        // Output my content. The method accepts the same arguments as template->view
        $this->administrator->view($content, false, "modules/page/js/admin.js");
    }

    public function delete($id = false)
    {
        requirePermission("canRemove");

        if (!$id) {
            die();
        }

        $this->cache->delete('page_*.cache');
        $this->page_model->delete($id);

        // Add log
		$this->logger->createLog("admin", "delete", "Deleted page", ['ID' => $id]);

        $this->plugins->onDelete($id);
    }

    public function create($id = false)
    {
        requirePermission("canAdd");

        $headline = $this->input->post('name');
        $identifier = $this->input->post('identifier');
        $content = $this->input->post('content', false);

        if (strlen($headline) > 70 || strlen($headline) < 15 || empty($headline)) {
            die("The headline must be between 1-70 characters long");
        }

        if (empty($content)) {
            die("Content can't be empty");
        }

        if (empty($identifier) || !preg_match("/^[A-Za-z0-9]*$/", $identifier)) {
            die("Identifier can't be empty and may only contain numbers and letters");
        }

        $identifier = strtolower($identifier);

        if ($identifier == "admin") {
            die("The identifier <b>admin</b> is reserved by the system");
        }

        if ($this->page_model->pageExists($identifier, $id)) {
            die("The identifier is already in use");
        }

        if ($id) {
            $this->page_model->update($id, $headline, $identifier, $content);
            $this->cache->delete('page_*.cache');

            $hasPermission = $this->page_model->hasPermission($id);

            if ($this->input->post('visibility') == "group" && !$hasPermission) {
                $this->page_model->setPermission($id);
            } elseif ($this->input->post('visibility') != "group" && $hasPermission) {
                $this->page_model->deletePermission($id);
            }

            // Add log
            $this->logger->createLog("admin", "edit", "Edited page", ['ID' => $id, 'Page' => $headline]);

            $this->plugins->onUpdate($id, $headline, $identifier, $content);
        } else {
            $id = $this->page_model->create($headline, $identifier, $content);

            if ($this->input->post('visibility') == "group") {
                $this->page_model->setPermission($id);
            }

            // Add log
            $this->logger->createLog("admin", "add", "Added page", ['ID' => $id, 'Page' => $headline]);

            $this->plugins->onCreate($id, $headline, $identifier, $content);
        }

        die("yes");
    }
}
