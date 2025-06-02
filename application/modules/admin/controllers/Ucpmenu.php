<?php

use MX\MX_Controller;

/**
 * Menu Controller Class
 * @property ucpmenu_model $ucpmenu_model ucpmenu_model Class
 */
class Ucpmenu extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library("administrator");
        $this->load->model("ucpmenu_model");
        $this->load->model("menu_model");

        requirePermission("viewMenuLinks");
    }

    /**
     * Loads the page
     */
    public function index()
    {
        //Set the title to menu
        $this->administrator->setTitle("UCP Menu links");

        $links = $this->ucpmenu_model->getMenuLinks();

        if ($links) {
            foreach ($links as $key => $value) {
                // Shorten the link if necessary
                if (strlen($value['link']) > 12) {
                    $links[$key]['link_short'] = mb_substr($value['link'], 0, 12) . '...';
                } else {
                    $links[$key]['link_short'] = $value['link'];
                }

                // Add the website path if internal link
                if (!preg_match("/https?:\/\//", $value['link'])) {
                    $links[$key]['link'] = $this->template->page_url . $value['link'];
                }

                $links[$key]['name'] = langColumn($links[$key]['name']);

                // Shorten the name if necessary
                if (strlen($links[$key]['name']) > 15) {
                    $links[$key]['name'] = mb_substr($links[$key]['name'], 0, 15) . '...';
                }

                $links[$key]['description'] = langColumn($links[$key]['description']);
            }
        }

        if ($pages = $this->menu_model->getPages()) {
            foreach ($pages as $k => $v) {
                $pages[$k]['name'] = langColumn($v['name']);
            }
        }

        // Prepare my data
        $data = [
            'url' => $this->template->page_url,
            'links' => $links,
            'pages' => $pages
        ];

        // Load my view
        $output = $this->template->loadPage('menu/ucp_menu.tpl', $data);

        // Put my view in the main box with a headline
        $content = $this->administrator->box('UCP Menu links', $output);

        // Output my content. The method accepts the same arguments as template->view
        $this->administrator->view($content, false, 'modules/admin/js/ucp_menu.js');
    }

    public function create()
    {
        requirePermission('addMenuLinks');

        $name = $this->input->post('name');
        $description = $this->input->post('description');
        $link = $this->input->post('link');
        $icon = $this->input->post('icon');
        $group = $this->input->post('group');
        $permission = $this->input->post('permission');
        $permissionModule = $this->input->post('permissionModule');

		$array = json_decode($name, true);

		foreach ($array as $key => $value)
		{
			if (empty($value))
			{
				die("$key name can't be empty");
			}
		}

        if (empty($link)) {
            die("Link can't be empty");
        }

        $this->ucpmenu_model->add($name, $description, $link, $icon, $group, $permission, $permissionModule);

        die("yes");
    }

    public function delete($id)
    {
        requirePermission("deleteMenuLinks");

        if ($this->ucpmenu_model->delete($id)) {
            die("success");
        } else {
            die("An error occurred while trying to delete this menu link.");
        }
    }

    public function edit($id = false)
    {
        requirePermission("editMenuLinks");

        if (!is_numeric($id) || !$id) {
            die();
        }

        $link = $this->ucpmenu_model->getMenuLink($id);

        if (!$link) {
            show_error("There is no link with ID " . $id, 400);
        }

        // Change the title
        $this->administrator->setTitle(langColumn($link['name']));

        if ($pages = $this->menu_model->getPages()) {
            foreach ($pages as $k => $v) {
                $pages[$k]['name'] = langColumn($v['name']);
            }
        }

        // Prepare my data
        $data = [
            'url' => $this->template->page_url,
            'links' => $this->ucpmenu_model->getMenuLinks(),
            'link' => $link,
            'pages' => $pages
        ];

        // Load my view
        $output = $this->template->loadPage("menu/edit_ucp_menu.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->administrator->box('<a href="' . $this->template->page_url . 'admin/ucpmenu">Menu links</a> &rarr; ' . langColumn($link['name']), $output);

        // Output my content. The method accepts the same arguments as template->view
        $this->administrator->view($content, false, "modules/admin/js/ucp_menu.js");
    }

    public function move($id = false, $direction = false)
    {
        requirePermission("editMenuLinks");

        if (!$id || !$direction) {
            die();
        } else {
            $order = $this->ucpmenu_model->getOrder($id);

            if (!$order) {
                die();
            } else {
                if ($direction == "up") {
                    $target = $this->ucpmenu_model->getPreviousOrder($order);
                } else {
                    $target = $this->ucpmenu_model->getNextOrder($order);
                }

                if (!$target) {
                    die();
                } else {
                    $this->ucpmenu_model->setOrder($id, $target['order']);
                    $this->ucpmenu_model->setOrder($target['id'], $order);
                }
            }
        }
    }

    public function save($id = false)
    {
        requirePermission("editMenuLinks");

        if (!$id || !is_numeric($id)) {
            die();
        }

        $data['name'] = $this->input->post('name');
        $data['description'] = $this->input->post('description');
        $data['link'] = $this->input->post('link');
        $data['icon'] = $this->input->post('icon');
        $data['group'] = $this->input->post('group');
        $data['permission'] = $this->input->post('permission');
        $data['permissionModule'] = $this->input->post('permissionModule');

        $this->ucpmenu_model->edit($id, $data);

        die('yes');
    }
}
