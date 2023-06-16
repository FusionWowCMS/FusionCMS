<?php

class Admin extends MX_Controller
{
    private $logsToLoad = 10;

    public function __construct()
    {
        parent::__construct();

        $this->load->library('administrator');
        $this->load->model('donate_model');
        $this->load->config('paypal');

        requirePermission("viewAdmin");
    }

    public function index()
    {
        $this->administrator->setTitle("Donation log");

        $paypal_enabled = $this->config->item('donate_paypal');

        $logs = $this->donate_model->getLogs(0, 10);

        $data = array(
            'use_paypal' => $this->config->item('use_paypal'),
            'paypal_logs' => $logs,
            'url' => $this->template->page_url,
            'currency' => $this->config->item('donation_currency'),
            'show_more' => $this->donate_model->getLogCount() - count((array)$logs)
        );

        $output = $this->template->loadPage("admin.tpl", $data);

        $content = $this->administrator->box('Donation log', $output);

        $this->administrator->view($content, false, "modules/donate/js/admin.js");
    }

    public function search($type = false)
    {
        $string = $this->input->post('string');

        if (!$string || !$type || !in_array($type, array('paypal'))) {
            die();
        } else {
            if ($type == "paypal") {
                if (filter_var($string, FILTER_VALIDATE_EMAIL)) {
                    // Email
                    $results = $this->donate_model->findByEmail($type, $string);
                } elseif (preg_match("/^[A-Z0-9]{17}$/", $string)) {
                    // TXN-ID
                    $results = $this->donate_model->findByTxn($type, $string);
                } elseif (preg_match("/^[a-zA-Z0-9]*$/", $string) && strlen($string) > 3 && strlen($string) < 15) {
                    // Username
                    $user_id = $this->user->getId($string);

                    if (!$user_id) {
                        die("<span>Unknown account</span>");
                    }

                    $results = $this->donate_model->findById($type, $user_id);
                } else {
                    $results = $this->donate_model->getDonationLog($type);
                }

                if (!$results) {
                    die("<span>No matches</span>");
                }
            }

            foreach ($results as $k => $v) {
                if ($type == "paypal") {
                    $results[$k]["nickname"] = $this->user->getUsername($v['user_id']);
                } else {
                    $results[$k]["nickname"] = $this->user->getUsername($v['custom']);
                }
            }

            $data = array(
                'url' => $this->template->page_url,
                'results' => $results,
                'type' => $type
            );

            $output = $this->template->loadPage("admin_list.tpl", $data);

            die($output);
        }
    }

    public function give($id = false)
    {
        if (!$id || !is_numeric($id)) {
            die();
        }

        $log = $this->donate_model->getPayPalLog($id);

        if (!$log) {
            die();
        }

        $dp = $log["points"];

        $this->donate_model->giveDp($log['user_id'], $dp);

        $data["status"] = 1;

        $this->donate_model->updateMonthlyIncome($log['total']);
        $this->donate_model->updatePayPal($id, $data);

        // Add log
        $this->logger->createLog("admin", "add", "Manually completed transaction", ['ID' => $id]);
    }

    public function settings()
    {
        $values = $this->donate_model->getAllValues();
		
		$data = array(
			'values' => $values
		);

		$output = $this->template->loadPage("admin_settings.tpl", $data);

		$content = $this->administrator->box('<a href="' . $this->template->page_url . 'donate/admin">Donate admin</a> <i class="fa-solid fa-arrow-right"></i> Donation Settings', $output);

		$this->administrator->view($content, "modules/donate/css/donate.css", "modules/donate/js/admin.js");
	}

    public function save($id = false)
    {
        $price = $this->input->post('price');
        $points = $this->input->post('points');

        if ($id)
        {
            if ($this->donate_model->updateValue($id, $price, $points))
            {
                die('1');
            }
            else
            {
                die('Something went wrong');
            }
        }
        else
        {
            if ($this->donate_model->addValue($price, $points))
            {
                $last = $this->db->select('id')->order_by('id',"desc")->limit(1)->get('paypal_donate')->result_array()[0]['id'];
                die($last);
            }
            else
            {
                die('Something went wrong');
            }
        }
    }

    public function deleteValue($id = false)
    {
        if (!$id || !is_numeric($id)) {
            die();
        }

        $this->donate_model->deleteValue($id);
        die('yes');
    }

    public function loadMoreLogs()
    {
        $offset = $this->input->post('offset');
        $count = $this->input->post('count');
        $extraLogCount = $this->input->post('show_more');

        $extraLogCount -= $this->logsToLoad;

        $logs = $this->donate_model->getLogs($offset, $count);

        if ($logs)
        {
            $data = array(
                'paypal_logs' => $logs,
                'show_more' => $extraLogCount
            );

            $output = $this->template->loadPage("logging_found.tpl", $data);

            die($output);
        } else {
            die("<span>No results</span>");
        }
    }
}
