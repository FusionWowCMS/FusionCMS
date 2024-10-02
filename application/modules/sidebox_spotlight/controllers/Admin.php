<?php

use MX\MX_Controller;

/**
 * Admin Spotlight Controller Class
 * @property spotlight_model $spotlight_model spotlight_model Class
 */
class Admin extends MX_Controller
{
    public function __construct()
    {
        // Make sure to load the administrator library!
        $this->load->library('administrator');
        $this->load->model('spotlight_model');

        parent::__construct();

        requirePermission("canViewAdmin", "sidebox_spotlight");
    }

    public function index()
    {
        // Change the title
        $this->administrator->setTitle("Manage Spotlight");

        // Prepare my data
        $data = array(
            'url' => $this->template->page_url,
            'spotlights' => $this->spotlight_model->getData()
        );

        // Load my view
        $output = $this->template->loadPage("admin.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->administrator->box('spotlight', $output);

        // Output my content. The method accepts the same arguments as template->view
        $this->administrator->view($content, false, "modules/sidebox_spotlight/assets/js/admin.js");
    }

    public function create()
    {
        $data["image"] = $this->input->post("image");
        $data["title"] = $this->input->post("title");
        $data["contents"] = $this->input->post("contents");

        $this->spotlight_model->add($data);

        die("yes");
    }


    public function delete($id = false)
    {
        if (!$id || !is_numeric($id)) {
            die();
        }

        $this->spotlight_model->delete($id);

        die("yes");
    }

    public function move($id = false, $direction = false)
    {
        if (!$id || !$direction) {
            die();
        } else {
            $order = $this->spotlight_model->getOrder($id);

            if (!$order) {
                die();
            } else {
                if ($direction == "up") {
                    $target = $this->spotlight_model->getPreviousOrder($order);
                } else {
                    $target = $this->spotlight_model->getNextOrder($order);
                }

                if (!$target) {
                    die();
                } else {
                    $this->spotlight_model->setOrder($id, $target['order']);
                    $this->spotlight_model->setOrder($target['id'], $order);
                }
            }
        }
    }

    public function edit($id)
    {
        // Change the title
        $this->administrator->setTitle("Manage Spotlight");

        // Prepare my data
        $data = array(
            'url' => $this->template->page_url,
            'spotlights' => $this->spotlight_model->getDataId($id),
            'id' => $id
        );

        // Load my view
        $output = $this->template->loadPage("edit.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->administrator->box('spotlight', $output);

        // Output my content. The method accepts the same arguments as template->view
        $this->administrator->view($content, false, "modules/sidebox_spotlight/assets/js/admin.js");
    }

    public function save($id = false)
    {
        if (!$id || !is_numeric($id)) {
            die();
        }

        $data["image"] = $this->input->post("image");
        $data["title"] = $this->input->post("title");
        $data["contents"] = $this->input->post("contents");

        $this->spotlight_model->edit($id, $data);

        die('yes');
    }
}
