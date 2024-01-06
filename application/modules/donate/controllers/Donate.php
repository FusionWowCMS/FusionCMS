<?php

use MX\MX_Controller;

require './vendor/autoload.php';

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

    public function index()
    {
        requirePermission("view");

        $this->template->setTitle(lang("donate_title", "donate"));

        $user_id = $this->user->getId();

        $paypal = array(
            "values" => $this->paypal_model->getDonations()
        );

        if ($this->input->post())
        {
            if ($this->input->post("donation_type") == "paypal")
            {
                $this->getDonate($this->input->post("data_id"));
            }
        }

        $data = array(
            "paypal" => $paypal,
            "user_id" => $user_id,
            "server_name" => $this->config->item('server_name'),
            "currency" => $this->config->item('donation_currency'),
            "currency_sign" => $this->config->item('donation_currency_sign'),
        );

        $data['use_paypal'] = !empty($this->config->item("paypal_userid")) && !empty($this->config->item("paypal_secretpass")) && $this->config->item("use_paypal");

        $output = $this->template->loadPage("donate.tpl", $data);

        // Load the top site page and format the page contents
        $pageData = array(
            "module" => "default",
            "headline" => breadcumb(array(
                            "ucp" => lang("ucp"),
                            "donate" => lang("donate_panel", "donate")
                        )),
            "content" => $output
        );

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

                redirect(base_url('/donate/success'));
            }
        } catch (Exception $e) {
            $this->paypal_model->setStatus($payment_id, "3");
            $this->paypal_model->setError($payment_id, $e);

            log_message('error', $e);

            redirect(base_url('/donate/error'));
        }
    }

    public function success()
    {
        $this->user->getUserData();

        $page = $this->template->loadPage("success.tpl", array('url' => $this->template->page_url));

        $this->template->box(lang("donate_thanks", "donate"), $page, true);
    }

    public function error()
    {
        $data = array('msg' => $this->session->userdata('paypal_error'));

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

        $setTax = '0.00';
        $setPrice = $this->paypal_model->getSpecifyDonate($id)['price'];
        $setTotal = ($setTax + $setPrice);

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
            ->setDescription('Purchase ' . $this->paypal_model->getSpecifyDonate($id)['points'] . ' points for user ' . $this->user->getId() . '')
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

            $url_parts = parse_url($payment->links[1]->href,);

            parse_str($url_parts['query'], $query_parts);

            $token = $query_parts['token'];

            //prepare and execute
            $dataInsert = array(
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
            );

            $this->db->insert('paypal_logs', $dataInsert);
        } catch (PayPalConnectionException $e) {
            log_message('error', $e);

            if (preg_match('[500|501|502|503|504|60000]', $e)) {
                $this->session->set_tempdata('paypal_error', 'PayPal is currently experiencing problems. Please try later', 10);
                redirect(base_url('/donate/error'));
            }
            else
            {
                die($e);
            }
        }

        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirectUrl = $link->getHref();
            }
        }
        redirect($redirectUrl);
    }
}
