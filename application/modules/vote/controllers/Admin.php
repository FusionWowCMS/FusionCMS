<?php

// todo: NO PERMISSIONS!

class Admin extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Make sure to load the administrator library!
        $this->load->library('administrator');
        $this->load->model('vote_model');

        requirePermission("canViewAdmin");
    }

    public function index()
    {
        // Change the title
        $this->administrator->setTitle("Topsites");

        $topsites = $this->vote_model->getVoteSites();

        // Prepare my data
        $data = array(
            'url' => $this->template->page_url,
            'topsites' => $topsites
        );

        // Load my view
        $output = $this->template->loadPage("admin.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->administrator->box('Topsites', $output);

        // Output my content. The method accepts the same arguments as template->view
        $this->administrator->view($content, false, "modules/vote/js/admin.js");
    }

    /**
     * Create a new vote site.
     */
    public function create()
    {
        requirePermission('canCreate');

        $data["vote_sitename"] = $this->input->post("vote_sitename");
        $data["vote_url"] = $this->input->post("vote_url");
        $data["vote_image"] = $this->input->post("vote_image");
        $data["hour_interval"] = $this->input->post("hour_interval");
        $data["points_per_vote"] = $this->input->post("points_per_vote");
        $data["callback_enabled"] = $this->input->post("callback_enabled");

        if (empty($data["vote_url"])) {
            die("Vote URL can't be empty");
        }

        if (empty($data["vote_sitename"])) {
            die("Vote name can't be empty");
        }

        $this->vote_model->add($data);

        // Add log
        $this->logger->createLog('admin', 'add', 'Added topsite', ['Name' => $data['vote_sitename']]);

        $this->plugins->onCreateSite($data);

        die("yes");
    }

    public function new()
    {
        // Check for the permission
        requirePermission("canCreate");

        // Change the title
        $this->administrator->setTitle('New topsite');

        // Prepare my data
        $data = array(
            'url' => $this->template->page_url,
        );

        // Load my view
        $output = $this->template->loadPage("admin_add.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->administrator->box('New topsite', $output);

        // Output my content. The method accepts the same arguments as template->view
        $this->administrator->view($content, false, "modules/vote/js/admin.js");
    }

    /**
     * Edit the vote site with the given id
     *
     * @param bool $id
     */
    public function edit($id = false)
    {
        // Check for the permission
        requirePermission("canEdit");

        if (!is_numeric($id) || !$id) {
            die();
        }

        $topsite = $this->vote_model->getTopsite($id);

        if (!$topsite) {
            show_error("There is no topsite with ID " . $id);

            die();
        }

        // Change the title
        $this->administrator->setTitle($topsite['vote_sitename']);

        // Prepare my data
        $data = array(
            'url' => $this->template->page_url,
            'topsite' => $topsite
        );

        $autofill = $this->getAutoFillData($topsite['vote_url']);
        if ($autofill['callback_support']) {
            $data['topsite']['topsite_url'] = $autofill['url'];
            $data['topsite']['votelink_format'] = $autofill['votelink_format'];
            $data['topsite']['callback_help'] = $autofill['callback_help'];
            $data['topsite']['callback_support'] = $autofill['callback_support'];
        } else {
            $data['topsite']['callback_support'] = false;
        }

        // Load my view
        $output = $this->template->loadPage("admin_edit.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->administrator->box('<a href="' . $this->template->page_url . 'vote/admin">Topsites</a> &rarr; ' . $topsite['vote_sitename'], $output);

        // Output my content. The method accepts the same arguments as template->view
        $this->administrator->view($content, false, "modules/vote/js/admin.js");
    }

    /**
     * Save the details to the vote site with the given id.
     *
     * @param bool $id
     */
    public function save($id = false)
    {
        // Check for the permission
        requirePermission("canEdit");

        if (!$id || !is_numeric($id)) {
            die();
        }

        $data["vote_sitename"] = $this->input->post("vote_sitename");
        $data["vote_url"] = $this->input->post("vote_url");
        $data["vote_image"] = $this->input->post("vote_image");
        $data["hour_interval"] = $this->input->post("hour_interval");
        $data["points_per_vote"] = $this->input->post("points_per_vote");
        $data["callback_enabled"] = $this->input->post("callback_enabled");

        $this->vote_model->edit($id, $data);

        // Add log
        $this->logger->createLog('admin', 'edit', 'Edited topsite', ['ID' => $id]);

        $this->plugins->onEditSite($id, $data);

        die('window.location="' . $this->template->page_url . 'vote/admin"');
    }

    /**
     * Delete the vote site with the given id.
     *
     * @param bool $id
     */
    public function delete($id = false)
    {
        // Check for the permission
        requirePermission("canDelete");

        if (!$id || !is_numeric($id)) {
            die();
        }

        $this->vote_model->delete($id);

        // Add log
        $this->logger->createLog('admin', 'delete', 'Deleted topsite', ['ID' => $id]);

        $this->plugins->onDelete($id);
    }

    /**
     * Get autofill data and display as JSON
     */
    public function ajaxAutoFillData()
    {
        die(json_encode($this->getAutoFillData($this->input->post('url'))));
    }

    protected function getAutoFillData($url)
    {
        $url = strtolower($url);
        if (! preg_match('#^https?://.+$#', $url)) {
            $url = 'http://' . $url;
        }

        $host = parse_url($url, PHP_URL_HOST);

        // return empty response if url is malformed
        if (! $host) {
            return false;
        }

        // remove www. from hostname
        $name = preg_replace('/^(?:www\.)?(.+)$/', '$1', $host);

        $data = array(
            'name' => $name,
            'callback_support' => false,
            'image' => null,
        );

        // check if image exists for this site
        if ($files = glob(APPPATH . 'modules/vote/images/vote_sites/' . $name . '.*')) {
            $data['image'] =
                base_url() . 'application/modules/vote/images/vote_sites/' .
                substr($files[0], strrpos($files[0], '/') + 1);
        }

        // check if the site has a callback plugin
        $plugins = $this->plugins->getPlugins();

        foreach ($plugins as $plugin) {
            if (isset($plugin->url) && strpos($plugin->url, $name) !== false) {
                $data['callback_support'] = true;
                $data['votelink_format'] = $plugin->voteLinkFormat;
                $data['url'] = $plugin->url;

                $tpl = strtolower(get_class($plugin)) . '.tpl';
                if (! file_exists(APPPATH . 'modules/vote/views/callbackHelp/' . $tpl)) {
                    $tpl = 'default.tpl';
                }

                $data['callback_help'] = $this->template->loadPage('callbackHelp/' . $tpl, array(
                    'callback_url' => base_url() . 'vote/callback/' . $name
                ));
            }
        }

        return $data;
    }
}
