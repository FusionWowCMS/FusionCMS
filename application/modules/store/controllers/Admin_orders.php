<?php

class Admin_orders extends MX_Controller
{
    public function __construct()
    {
        // Make sure to load the administrator library!
        $this->load->library('administrator');
        $this->load->model('store_model');

        parent::__construct();

        requirePermission("canViewOrders");
    }

    public function index()
    {
        // Change the title
        $this->administrator->setTitle("Orders");

        $completed = $this->store_model->getOrders(1);
        $failed = $this->store_model->getOrders(0);

        if ($completed) {
            foreach ($completed as $k => $v) {
                $completed[$k]["username"] = $this->user->getUsername($v['user_id']);
                $completed[$k]["json"] = json_decode($v['cart'], true);

                foreach ($completed[$k]["json"] as $key => $value) {
                    $item = $this->store_model->getItem($value['id']);

                    if ($item && isset($value['character'])) {
                        $character = $this->realms->getRealm($item['realm'])->getCharacters()->getNameByGuid($value['character']);
                    }

                    $completed[$k]['json'][$key]['itemName'] = $item ? $item['name'] : 'Unknown';
                    $completed[$k]['json'][$key]['characterName'] = (isset($character)) ? $character : 'Unknown';
                }
            }
        }

        if ($failed) {
            foreach ($failed as $k => $v) {
                $failed[$k]["username"] = $this->user->getUsername($v['user_id']);
                $failed[$k]["json"] = json_decode($v['cart'], true);

                foreach ($failed[$k]["json"] as $key => $value) {
                    $item = $this->store_model->getItem($value['id']);

                    if ($item && isset($value['character'])) {
                        $character = $this->realms->getRealm($item['realm'])->getCharacters()->getNameByGuid($value['character']);
                    }

                    $failed[$k]['json'][$key]['itemName'] = $item ? $item['name'] : 'Unknown';
                    $failed[$k]['json'][$key]['characterName'] = (isset($character)) ? $character : 'Unknown';
                }
            }
        }

        // Prepare my data
        $data = array(
            'completed' => $completed,
            'failed' => $failed,
            'url' => $this->template->page_url,
        );

        // Load my view
        $output = $this->template->loadPage("admin_orders.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->administrator->box('Orders', $output);

        // Output my content. The method accepts the same arguments as template->view
        $this->administrator->view($content, false, "modules/store/js/admin_orders.js");
    }

    public function search($type)
    {
        $string = $this->input->post('string');

        if (!$string || !$type || !in_array($type, array('successful', 'failed'))) {
            die();
        } else {
            $type = ($type == 'successful');

            if (preg_match("/^[a-zA-Z0-9]*$/", $string) && strlen($string) > 3 && strlen($string) < 15) {
                // Username
                $user_id = $this->user->getId($string);

                if (!$user_id) {
                    die("<span>Unknown account</span>");
                }

                $results = $this->store_model->findByUserId($type, $user_id);
            } else {
                $results = $this->store_model->getOrders($type);
            }

            if (!$results) {
                die("<span>No matches</span>");
            }

            foreach ($results as $k => $v) {
                $results[$k]["username"] = $this->user->getUsername($v['user_id']);
                $results[$k]["json"] = json_decode($v['cart'], true);

                foreach ($results[$k]["json"] as $key => $value) {
                    $item = $this->store_model->getItem($value['id']);

                    if ($item && isset($value['character'])) {
                        $character = $this->realms->getRealm($item['realm'])->getCharacters()->getNameByGuid($value['character']);
                    }

                    $results[$k]['json'][$key]['itemName'] = $item ? $item['name'] : 'Unknown';
                    $results[$k]['json'][$key]['characterName'] = (isset($character)) ? $character : 'Unknown';
                }
            }

            $data = array(
                'url' => $this->template->page_url,
                'results' => $results
            );

            $output = $this->template->loadPage('admin_list.tpl', $data);

            die($output);
        }
    }

    public function refund($id = false)
    {
        requirePermission("canRefundOrders");

        if (!$id || !is_numeric($id)) {
            die("Bad ID");
        }

        $order = $this->store_model->getOrder($id);

        if ($order) {
            $this->store_model->refund($order['user_id'], $order['vp_cost'], $order['dp_cost']);
            $this->store_model->deleteLog($id);

            // Add log
            $this->logger->createLog("admin", "refund", "Refunded order", ['ID' => $id, 'User' =>  $order['user_id'], 'VP' =>  $order['vp_cost'], 'DP' =>  $order['dp_cost']]);

            $this->plugins->onRefund($id, $order['user_id'], $order['vp_cost'], $order['dp_cost']);
        } else {
            die("Invalid order");
        }

        die("done");
    }
}
