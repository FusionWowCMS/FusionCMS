<?php

use App\Config\Services;
use CodeIgniter\Events\Events;
use MX\MX_Controller;

//API Container
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\PaymentExecution;

//API Functions
use PayPal\Api\Item;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Payment;
use PayPal\Api\Details;
use PayPal\Api\ItemList;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Exception\PayPalConnectionException;

/**
 * Donate Controller Class
 * @property donate_model $donate_model donate_model Class
 */
class Donate extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->user->userArea();

        $this->load->config('paypal');
        $this->load->model('donate_model');
        $this->load->model('paypal_model');
    }

    public function index(): void
    {
        requirePermission("view");

        $this->template->setTitle(lang("donate_title", "donate"));

        $user_id = $this->user->getId();

        $paypal = ["values" => $this->paypal_model->getDonations()];

        if ($this->input->post())
        {
            if ($this->input->post("donation_type") == "paypal")
            {
                $this->getDonate($this->input->post("data_id"));
            }
        }

        // Modules path: Forge
        $modulesPath = rtrim(str_replace(['\\', '/'], DIRECTORY_SEPARATOR, realpath(APPPATH)), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'modules';

        // Donate gateways: Initialize
        $donateGateways = [];

        // Donate gateways: Find
        foreach(glob($modulesPath . DIRECTORY_SEPARATOR . 'donate_*', GLOB_ONLYDIR) as $key => $module)
        {
            // Donate gateways: Append
            $donateGateways[$key] = [
                'url'  => base_url() . basename($module),
                'name' => ucfirst(strtolower(str_replace('donate_', '', basename($module)))),
                'icon' => base_url() . strtolower(basename(APPPATH)) . '/' . strtolower(basename($modulesPath)) . '/' . strtolower($this->router->fetch_module()) . '/images/unknown.png'
            ];

            // Module: Loop through tree | Find icon
            foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($module, FilesystemIterator::SKIP_DOTS)) as $file)
            {
                // SKIP.. invalid file
                if(!$file->isFile())
                    continue;

                // Icon: Found
                if(in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png']) && strpos(strtolower($file->getFilename()), strtolower($donateGateways[$key]['name'] . '.')) !== false)
                {
                    // Donate gateways: Fill (icon)
                    $donateGateways[$key]['icon'] = base_url() . str_replace(FCPATH, '', $file->getPathname());

                    // STOP.. no need to go any further
                    break;
                }
            }
        }

        $data = [
            "paypal" => $paypal,
            "user_id" => $user_id,
            "server_name" => $this->config->item('server_name'),
            "currency" => $this->config->item('donation_currency'),
            "currency_sign" => $this->config->item('donation_currency_sign'),
            "additionalGateways" => $donateGateways
        ];

        $data['use_paypal'] = !empty($this->config->item("paypal_userid")) && !empty($this->config->item("paypal_secretpass")) && $this->config->item("use_paypal");

        $output = $this->template->loadPage("donate.tpl", $data);

        // Load the top site page and format the page contents
        $pageData = [
            "module" => "default",
            "headline" => breadcrumb([
                            "ucp" => lang("ucp"),
                            "donate" => lang("donate_panel", "donate")
            ]),
            "content" => $output
        ];

        $page = $this->template->loadPage("page.tpl", $pageData);

        //Load the template form
        $this->template->view($page, "modules/donate/css/donate.css", "modules/donate/js/donate.js");
    }

    private function getApi()
    {
        $api = new ApiContext(
            new OAuthTokenCredential($this->config->item('paypal_userid'), $this->config->item('paypal_secretpass'))
        );

        $api->setConfig([
            'mode' => $this->config->item('paypal_mode'),
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => false,
            'log.FileName' => 'paypal_logs',
            'log.LogLevel' => 'FINE',
            'validation.level' => 'log'
        ]);

        return $api;
    }

    public function checkPaypal($id)
    {
        $execute = new PaymentExecution();

        $payment_id = $_GET['paymentId'] ?? '';
        $payerId = $_GET['PayerID'] ?? '';
        $payment = Payment::get($payment_id, $this->getApi());

        $execute->setPayerId($payerId);
        try {
            $result = $payment->execute($execute, $this->getApi());

            $payment_data = array(
                'payer_email' => $result->payer->payer_info->email,
                'invoice_number' => $result->transactions[0]->invoice_number,
                'transactions_code' => $result->transactions[0]->related_resources[0]->sale->id,
            );
            $this->paypal_model->update_payment($payment_id, $payment_data);

            $status = $this->paypal_model->getStatus($payment_id);

            if ($status == '1') {
                redirect(base_url('/donate'));
            } else {
                // transaction status
                $this->paypal_model->setStatus($payment_id, "1");

                $specify_donate = $this->paypal_model->getSpecifyDonate($id);

                // update account
                $this->donate_model->giveDp($this->user->getId(), $specify_donate['points']);

                // update income
                $this->donate_model->updateMonthlyIncome($specify_donate['price']);

                Events::trigger('onSuccessDonate', $this->user->getId(), $specify_donate);

                $this->dblogger->createLog("user", "donate", $specify_donate['price'].$this->config->item('donation_currency_sign'), $specify_donate['points'], Dblogger::STATUS_SUCCEED, $this->user->getId());

                redirect(base_url('/donate/success'));
            }
        } catch (Exception $e) {
            $this->paypal_model->setStatus($payment_id, "3");
            $this->paypal_model->setError($payment_id, $e);

            log_message('error', $e);

            Events::trigger('onErrorDonate', $payment_id, $e);

            redirect(base_url('/donate/error'));
        }
    }

    public function success()
    {
        $this->user->getUserData();

        $page = $this->template->loadPage("success.tpl", ['url' => $this->template->page_url]);

        $this->template->box(lang("donate_thanks", "donate"), $page, true);
    }

    public function error()
    {
        $data = ['msg' => Services::session()->getTempdata('paypal_error')];

        $page = $this->template->loadPage("error.tpl", $data);

        $this->template->box(lang("donate_error", "donate"), $page, true);
    }

    public function canceled()
    {
        $this->paypal_model->setCanceled($this->input->get("token"), '2');
        redirect(base_url('/donate'));
    }

    private function getDonate($id)
    {
        $item = new Item();
        $payer = new Payer();
        $amount = new Amount();
        $details = new Details();
        $payment = new Payment();
        $itemList = new ItemList();
        $transaction = new Transaction();
        $redirectUrls = new RedirectUrls();

        $setTax = $this->config->item('paypal_tax');
        $setPrice = $this->paypal_model->getSpecifyDonate($id)['price'];
        $setTotal = ((float)$setTax + $setPrice);

        //Payer
        $payer->setPaymentMethod('paypal');

        //item
        $item->setName($this->paypal_model->getSpecifyDonate($id)['points'] . ' points')
            ->setCurrency($this->config->item('donation_currency'))
            ->setQuantity(1)
            ->setPrice($setPrice);

        //item list
        $itemList->setItems([$item]);

        //details
        $details->setShipping('0.00')
            ->setTax($setTax)
            ->setSubtotal($setPrice);

        $amount->setCurrency($this->config->item('donation_currency'))
            ->setTotal($setTotal)
            ->setDetails($details);

        //transaction
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription('Purchase ' . $this->paypal_model->getSpecifyDonate($id)['points'] . ' points for user ' . $this->user->getId())
            ->setInvoiceNumber(uniqid());

        //payment
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions([$transaction]);

        //redirect urls
        $redirectUrls->setReturnUrl(base_url('/donate/checkPaypal/' . $id))
            ->setCancelUrl(base_url('/donate/canceled'));

        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);

        try {
            $payment->create($this->getApi());

            $hash = md5($payment->getId());

            $date = new DateTime($payment->create_time);

            $url_parts = parse_url($payment->links[1]->href);

            parse_str($url_parts['query'], $query_parts);

            $token = $query_parts['token'];

            //prepare and execute
            $dataInsert = [
                'user_id' => $this->user->getId(),
                'payment_id' => $payment->getId(),
                'hash' => $hash,
                'total' => $payment->transactions[0]->amount->total,
                'points' => $this->paypal_model->getSpecifyDonate($id)['points'],
                'create_time' => $date->getTimestamp(),
                'currency' => $this->config->item('donation_currency'),
                'error' => '',
                'status' => '0',
                'invoice_number' => '',
                'payer_email' => '',
                'token' => $token,
            ];

            $this->db->table('paypal_logs')->insert($dataInsert);
        } catch (PayPalConnectionException $e) {
            log_message('error', $e);

            if (preg_match('[500|501|502|503|504|60000]', $e)) {
                Services::session()->setTempdata('paypal_error', 'PayPal is currently experiencing problems. Please try later', 10);
                redirect(base_url('/donate/error'));
            } else if (str_contains($e, '401')) {
                Services::session()->setTempdata('paypal_error', 'Check Credentials (Client ID, Secret Password) and make sure you switch the PayPal mode to Live or Sandbox mode for whichever you need and match it in the config.', 10);
                redirect(base_url('/donate/error'));
            } else {
                die($e);
            }
        }

        redirect($payment->getApprovalLink());
    }
}
