<?php

class Sidebox extends MX_Controller
{
    private $sideboxModules;

    public function __construct()
    {
        // Make sure to load the administrator library!
        $this->load->library('administrator');
        $this->load->model('sidebox_model');
        $this->load->helper('tinymce_helper');

        parent::__construct();

        requirePermission("viewSideboxes");
    }

    public function index()
    {
        $this->sideboxModules = $this->getSideboxModules();

        // Change the title
        $this->administrator->setTitle("Sideboxes");

        $sideboxes = $this->cms_model->getSideboxes();

        if ($sideboxes)
        {
            foreach ($sideboxes as $key => $value)
            {
                $sideboxes[$key]['name'] = $this->sideboxModules["sidebox_" . $value['type']]['name'];

                $sideboxes[$key]['displayName'] = langColumn($sideboxes[$key]['displayName']);

                if (strlen($sideboxes[$key]['displayName']) > 15)
                {
                    $sideboxes[$key]['displayName'] = mb_substr($sideboxes[$key]['displayName'], 0, 15) . '...';
                }
            }
        }

        // Prepare my data
        $data = array(
            'url' => $this->template->page_url,
            'sideboxes' => $sideboxes,
            'sideboxModules' => $this->sideboxModules
        );

        // Load my view
        $output = $this->template->loadPage("sidebox/sidebox.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->administrator->box('', $output);

        // Output my content. The method accepts the same arguments as template->view
        $this->administrator->view($content, false, "modules/admin/js/sidebox.js");
    }

    private function getSideboxModules()
    {
        $sideboxes = array();

        $this->administrator->loadModules();

        foreach ($this->administrator->getModules() as $name => $manifest)
        {
            if (preg_match("/sidebox_/i", $name))
            {
                $sideboxes[$name] = $manifest;
            }
        }

        return $sideboxes;
    }

    public function create_submit()
    {
        requirePermission("addSideboxes");

        $data['type'] = preg_replace("/sidebox_/", "", $this->input->post('type'));
        $data['displayName'] = $this->input->post('displayName');
        $data['location'] = $this->input->post('location');

        if (!$data["displayName"])
        {
            die('Name can\'t be empty');
        }

        $id = $this->sidebox_model->add($data);

        if ($this->input->post('visibility') == "group")
        {
            $this->sidebox_model->setPermission($id);
        }

        // Handle custom sidebox text
        if ($data['type'] == "custom")
        {
            $data["content"] = $this->input->post("content");

            if (!$data["content"]) {
                die('Content can\'t be empty');
            }

            $text = $this->input->post('content', false);

            $this->sidebox_model->addCustom($text);
        }

        die("yes");
    }

    public function new()
    {
        requirePermission("editSideboxes");

        $this->sideboxModules = $this->getSideboxModules();

        // Change the title
        $this->administrator->setTitle('Add Sidebox');

        // Prepare my data
        $data = array(
            'url' => $this->template->page_url,
            'sideboxModules' => $this->sideboxModules
        );

        // Load my view
        $output = $this->template->loadPage("sidebox/add_sidebox.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->administrator->box('', $output);

        // Output my content. The method accepts the same arguments as template->view
        $this->administrator->view($content, false, "modules/admin/js/sidebox.js");
    }

    public function edit($id = false)
    {
        requirePermission("editSideboxes");

        if (!is_numeric($id) || !$id)
        {
            die();
        }

        $sidebox = $this->sidebox_model->getSidebox($id);
        $sideboxCustomText = $this->sidebox_model->getCustomText($id);

        if (!$sidebox)
        {
            show_error("There is no sidebox with ID " . $id);

            die();
        }

        $this->sideboxModules = $this->getSideboxModules();

        // Change the title
        $this->administrator->setTitle(langColumn($sidebox['displayName']));

        // Prepare my data
        $data = array(
            'url' => $this->template->page_url,
            'sidebox' => $sidebox,
            'sideboxModules' => $this->sideboxModules,
            'sideboxCustomText' => $sideboxCustomText
        );

        // Load my view
        $output = $this->template->loadPage("sidebox/edit_sidebox.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->administrator->box('', $output);

        // Output my content. The method accepts the same arguments as template->view
        $this->administrator->view($content, false, "modules/admin/js/sidebox.js");
    }

    public function move($id = false, $direction = false)
    {
        requirePermission("editSideboxes");

        if (!$id || !$direction)
        {
            die();
        } else {
            $order = $this->sidebox_model->getOrder($id);

            if (!$order)
            {
                die();
            } else {
                if ($direction == "up")
                {
                    $target = $this->sidebox_model->getPreviousOrder($order);
                } else {
                    $target = $this->sidebox_model->getNextOrder($order);
                }

                if (!$target)
                {
                    die();
                } else {
                    $this->sidebox_model->setOrder($id, $target['order']);
                    $this->sidebox_model->setOrder($target['id'], $order);
                }
            }
        }
    }

    public function save($id = false)
    {
        requirePermission("editSideboxes");

        if (!$id || !is_numeric($id)) {
            die("No ID");
        }

        $data["type"] = preg_replace("/sidebox_/", "", $this->input->post("type"));
        $data["displayName"] = $this->input->post("displayName");

        foreach ($data as $value)
        {
            if (!$value)
            {
                die("The fields can\'t be empty");
            }
        }

        $this->sidebox_model->edit($id, $data);

        // Handle custom sidebox text
        if ($data["type"] == "custom")
        {
            $text = $this->input->post("content", false);
            $this->sidebox_model->editCustom($id, $text);
        }

        $hasPermission = $this->sidebox_model->hasPermission($id);

        if ($this->input->post('visibility') == "group" && !$hasPermission)
        {
            $this->sidebox_model->setPermission($id);
        } elseif ($this->input->post('visibility') != "group" && $hasPermission)
        {
            $this->sidebox_model->deletePermission($id);
        }

        die("yes");
    }

    public function delete($id = false)
    {
        requirePermission("deleteSideboxes");

        if (!$id || !is_numeric($id))
        {
            die();
        }

        $this->sidebox_model->delete($id);
    }
}
