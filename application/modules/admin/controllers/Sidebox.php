<?php

use MX\MX_Controller;

/**
 * Sidebox Controller Class
 * @property sidebox_model $sidebox_model sidebox_model Class
 */
class Sidebox extends MX_Controller
{
    private $sideboxModules;

    public function __construct()
    {
        // Make sure to load the administrator library!
        $this->load->library('administrator');
        $this->load->model('sidebox_model');

        parent::__construct();

        requirePermission("viewSideboxes");
    }

    public function index()
    {
        $this->sideboxModules = $this->getSideboxModules();

        // Change the title
        $this->administrator->setTitle("Sideboxes");

        $sideboxes = $this->sidebox_model->getSideboxes();

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
        // Make sure visitor has required permissions
        requirePermission('addSideboxes');

        // Prepare sidebox data
        $data = [
            'type'        => preg_replace('/sidebox_/', '', $this->input->post('type')),
            'pages'       => $this->input->post('pages'),
            'location'    => $this->input->post('location'),
            'displayName' => $this->input->post('displayName')
        ];

        // Validate pages
        if(!$data['pages'] || !is_array($data['pages']))
            die('Select at least one page.');

        // Format pages
        $data['pages'] = json_encode($data['pages'], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);

        // Make sure `displayName` filled
        if(!$data['displayName'])
            die('Name can\'t be empty');

        // Add sidebox
        $id = $this->sidebox_model->add($data);

        // Set sidebox permission (if required)
        if($this->input->post('visibility') == 'group') {
            $this->sidebox_model->setPermission($id);

            $this->acl->clearCache();
        }

        // Handle custom sidebox text
        if($data['type'] == 'custom')
        {
            // Grab sidebox text
            $text = $this->input->post('content', false);

            // Make sure `text` filled
            if(!$text)
                die('Content can\'t be empty');

            // Add sidebox (custom text)
            $this->sidebox_model->addCustom($text);
        }

        die('yes');
    }

    public function new()
    {
        // Make sure visitor has required permissions
        requirePermission('editSideboxes');

        // Set the title
        $this->administrator->setTitle('Add Sidebox');

        // Fill sidebox modules
        $this->sideboxModules = $this->getSideboxModules();

        // Prepare page data
        $data = array(
            'url'            => $this->template->page_url,
            'pages'          => self::getModules(),
            'sideboxModules' => $this->sideboxModules
        );

        // Load page view
        $output = $this->template->loadPage('sidebox/add_sidebox.tpl', $data);

        // Put page view in the main box with a headline
        $content = $this->administrator->box('', $output);

        // Output page content. The method accepts the same arguments as template->view
        $this->administrator->view($content, false, 'modules/admin/js/sidebox.js');
    }

    public function edit($id = false)
    {
        // Make sure visitor has required permissions
        requirePermission('editSideboxes');

        // Invalid id
        if(!is_numeric($id) || !$id)
            die();

        // Get sidebox data
        $sidebox           = $this->sidebox_model->getSidebox($id);
        $sideboxCustomText = $this->sidebox_model->getCustomText($id);

        // Invalid sidebox
        if(!$sidebox)
            show_error('There is no sidebox with ID ' . $id, 400);

        // Format pages
        $sidebox['pages'] = json_decode($sidebox['pages'], true);

        // Validate pages
        if(!$sidebox['pages'] || !is_array($sidebox['pages']))
            $sidebox['pages'] = [];

        // Set the title
        $this->administrator->setTitle(langColumn($sidebox['displayName']));

        // Fill sidebox modules
        $this->sideboxModules = $this->getSideboxModules();

        // Prepare page data
        $data = array(
            'url'               => $this->template->page_url,
            'pages'             => self::getModules(),
            'sidebox'           => $sidebox,
            'sideboxModules'    => $this->sideboxModules,
            'sideboxCustomText' => $sideboxCustomText
        );

        // Load page view
        $output = $this->template->loadPage('sidebox/edit_sidebox.tpl', $data);

        // Put page view in the main box with a headline
        $content = $this->administrator->box('', $output);

        // Output page content. The method accepts the same arguments as template->view
        $this->administrator->view($content, false, 'modules/admin/js/sidebox.js');
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
        // Make sure visitor has required permissions
        requirePermission('editSideboxes');

        // Invalid id
        if(!$id || !is_numeric($id))
            die('No ID');

        // Prepare sidebox data
        $data = [
            'type'        => preg_replace('/sidebox_/', '', $this->input->post('type')),
            'pages'       => $this->input->post('pages'),
            'location'    => $this->input->post('location'),
            'displayName' => $this->input->post('displayName'),
        ];

        // Validate pages
        if(!$data['pages'] || !is_array($data['pages']))
            die('Select at least one page.');

        // Format pages
        $data['pages'] = json_encode($data['pages'], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);

        // Make sure everythings filled
        foreach($data as $value)
            if(!$value)
                die('The fields can\'t be empty');

        // Save changes
        $this->sidebox_model->edit($id, $data);

        // Handle custom sidebox text
        if($data['type'] == 'custom')
            $this->sidebox_model->editCustom($id, $this->input->post('content', false));

        // Check for sidebox permission
        $hasPermission = $this->sidebox_model->hasPermission($id);

        // Set sidebox permission
        if($this->input->post('visibility') == 'group' && !$hasPermission)
        {
            $this->sidebox_model->setPermission($id);
        }
        elseif($this->input->post('visibility') != 'group' && $hasPermission)
        {
            $this->sidebox_model->deletePermission($id);
        }

        $this->acl->clearCache();

        die('yes');
    }

    public function delete($id = false)
    {
        requirePermission("deleteSideboxes");

        if (!$id || !is_numeric($id))
        {
            die();
        }

        $this->sidebox_model->delete($id);

        $this->acl->clearCache();
    }

    /**
     * Get modules
     * Returns available modules
     *
     * @return array $modules
     */
    private static function getModules()
    {
        // Modules: Initialize
        $modules = [];

        // Blacklist: Initialize
        $blacklist = ['admin', 'api', 'icon'];

        // Modules: Get
        if(!empty($modules = glob(realpath(APPPATH) . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR)))
        {
            // Loop through modules
            foreach($modules as $key => $module)
            {
                // Grab trailing name component
                $modules[$key] = basename($modules[$key]);

                // Filter
                if(in_array($modules[$key], $blacklist) || strpos($modules[$key], 'sidebox_') === 0)
                    unset($modules[$key]);
            }
        }

        return $modules;
    }
}
