<?php

class Logging extends MX_Controller
{
    private $logsToLoad = 10; // 10 at the time

    public function __construct()
    {
        parent::__construct();

        $this->load->library("administrator");
        $this->load->model('logging_model');

        requirePermission("viewLogs");
    }

    /**
     * Loads the page
     */
    public function index()
    {
        //Set the title to menu
        $this->administrator->setTitle("Logs");

        $logs = $this->logger->getLogs("", 0, 10);

        // Prepare my data
        $data = array(
            'logs' => $logs, // Get the logs from 0 till 10
            'modules' => $this->administrator->getEnabledModules(),
            'show_more' => $this->logger->getLogCount() - count((array)$logs)
        );

        // Load my view
        $output = $this->template->loadPage("logging/logging.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->administrator->box('Website logs', $output);

        // Output my content. The method accepts the same arguments as template->view
        $this->administrator->view($content, false, "modules/admin/js/logging.js");
    }

    public function loadMoreLogs()
    {
        $offset = $this->input->post('offset');
        $count = $this->input->post('count');
        $extraLogCount = $this->input->post('show_more');

        $extraLogCount -= $this->logsToLoad;

        // Validation, checking is done in the model.
        $logs = $this->logger->getLogs("", $offset, $count);

        if ($logs) {
            // Prepare my data
            $data = array(
                'logs' => $logs,
                'show_more' => $extraLogCount
            );

            // Load my view
            $output = $this->template->loadPage("logging/logging_found.tpl", $data);

            die($output);
        } else {
            die("<span>No results</span>");
        }
    }

    /**
     * Applies search for the given parameters.
     * POST: module the module name
     * POST: search the on search text, username,ip,userid
     */
    public function search()
    {
        $module = $this->input->post('module');
        $search = $this->input->post('search');

        // Validation, checking is done in the model.
        $logs = $this->logging_model->findLogs($search, $module);

        if ($logs) {
            // Prepare my data
            $data = array(
                'logs' => $logs,
                'show_more' => ''
            );

            // Load my view
            $output = $this->template->loadPage("logging/logging_found.tpl", $data);

            die($output);
        } else {
            die("<span>No results</span>");
        }
    }
}
