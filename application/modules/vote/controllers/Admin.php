<?php

use CodeIgniter\Events\Events;
use MX\MX_Controller;

/**
 * Admin Vote Controller Class
 * @property vote_model $vote_model vote_model Class
 */
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
        $data = [
            'url' => $this->template->page_url,
            'topsites' => $topsites
        ];

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
        $this->dblogger->createLog('admin', 'add', 'Added topsite', ['Name' => $data['vote_sitename']]);

        Events::trigger('onCreateSiteVote', $data);

        die("yes");
    }

    public function new()
    {
        // Check for the permission
        requirePermission("canCreate");

        // Change the title
        $this->administrator->setTitle('New topsite');

        // Prepare my data
        $data = [
            'url' => $this->template->page_url,
        ];

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
            show_error("There is no topsite with ID " . $id, 400);
        }

        // Change the title
        $this->administrator->setTitle($topsite['vote_sitename']);

        // Prepare my data
        $data = [
            'url' => $this->template->page_url,
            'topsite' => $topsite
        ];

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
        $this->dblogger->createLog('admin', 'edit', 'Edited topsite', ['ID' => $id]);

        Events::trigger('onEditSiteVote', $id, $data);

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
        $this->dblogger->createLog('admin', 'delete', 'Deleted topsite', ['ID' => $id]);

        Events::trigger('onDeleteSiteVote', $id);
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
        if (!preg_match('#^https?://.+$#', $url)) {
            $url = 'https://' . $url;
        }

        $host = parse_url($url, PHP_URL_HOST);

        // return empty response if url is malformed
        if (! $host) {
            return false;
        }

        $data = [
            'callback_support' => false,
            'image' => null,
        ];

        // remove www. from hostname
        $name = preg_replace('/^(?:www\.)?(.+)$/', '$1', $host);

        // check if image exists for this site
        if ($files = glob(APPPATH . 'modules/vote/images/vote_sites/' . $name . '.*')) {
            $data['image'] = base_url() . 'application/modules/vote/images/vote_sites/' . substr($files[0], strrpos($files[0], '/') + 1);
        }

        $topWebsite = preg_replace('/\.[a-z]{2,}$/', '', $name);

        $libraryPath = APPPATH . 'modules/vote/libraries/' . ucfirst($topWebsite) . '.php';

        if (file_exists($libraryPath))
            $this->load->library($topWebsite);

        if (isset($this->$topWebsite->url) && str_contains($this->$topWebsite->url, $name)) {
            $data['callback_support'] = true;
            $data['votelink_format'] = $this->$topWebsite->voteLinkFormat;
            $data['url'] = $this->$topWebsite->url;
            $data['name'] = $this->$topWebsite->name;

            $tpl = $topWebsite . '.tpl';
            if (! file_exists(APPPATH . 'modules/vote/views/callbackHelp/' . $tpl)) {
                $tpl = 'default.tpl';
            }

            $data['callback_help'] = $this->template->loadPage('callbackHelp/' . $tpl, ['callback_url' => base_url() . 'vote/callback/' . $data['name']]);
        }

        return $data;
    }
}
