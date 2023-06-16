<?php

defined('BASEPATH') or exit('No direct script access allowed');

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

class Paypal_model extends CI_Model
{
    public function __construct()
    {
        $this->load->config("paypal");
        $this->load->model("donate_model");

        parent::__construct();
    }

    public function getApi()
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

    public function getSpecifyDonate($id)
    {
        $query = $this->db->select("*")
                                ->where("id", $id)
                                ->get("paypal_donate");

        if ($query && $query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows[0];
        }

        return false;
    }

    public function getDonations()
    {
        $query = $this->db->select("*")
                                ->get("paypal_donate");

        if ($query && $query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows;
        }

        return false;
    }

    public function getStatus($id)
    {
        $query = $this->db->select("*")
                                ->where("payment_id", $id)
                                ->get("paypal_logs");

        if ($query && $query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows[0]["status"];
        }

        return false;
    }

    public function setStatus($id, $status)
    {
        $data = array('status' => $status);
        $this->db->where('payment_id', $id)->update('paypal_logs', $data);
    }

    public function setError($id, $error)
    {
        $data = array('error' => $error);
        $this->db->where('payment_id', $id)->update('paypal_logs', $data);
    }

    public function setCanceled($token, $status)
    {
        $data = array('status' => $status);
        $this->db->where('token', $token)->update('paypal_logs', $data);
    }

    public function getDonate($id)
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
        $setPrice = $this->getSpecifyDonate($id)['price'];
        $setTotal = ($setTax + $setPrice);

        //Payer
        $payer->setPaymentMethod('paypal');

        //item
        $item->setName($this->getSpecifyDonate($id)['points'] . ' points')
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
        ->setDescription('Purchase ' . $this->getSpecifyDonate($id)['points'] . ' points for user ' . $this->user->getId() . '')
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
                'points' => $this->getSpecifyDonate($id)['points'],
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

        foreach ($payment->getLinks() as $key => $link) {
            if ($link->getRel() == 'approval_url') {
                $redirectUrl = $link->getHref();
            }
        }
            redirect($redirectUrl);
           
    }

    public function check($id)
    {
        $execute = new PaymentExecution();

        $payment_id = $_GET['paymentId'];
        $payerId = $_GET['PayerID'];
        $payment = Payment::get($payment_id, $this->getApi());

        $execute->setPayerId($payerId);
        try {
            $result = $payment->execute($execute, $this->getApi());
            
            $payment_data = array(
                'payer_email' => $result->payer->payer_info->email,
                'invoice_number' => $result->transactions[0]->invoice_number,
                'transactions_code' => $result->transactions[0]->related_resources[0]->sale->id,
            );
            $this->update_payment($payment_id, $payment_data);

            $this->completeTransaction($id, $payment_id);
        } catch (Exception $e) {
            $this->setStatus($payment_id, "3");
            $this->setError($payment_id, $e);

            log_message('error', $e);

            redirect(base_url('/donate/error'));
        }
    }

    public function completeTransaction($donate, $id)
    {
        $qq = $this->getStatus($id);

        if ($qq == '1') {
            redirect(base_url('/donate'));
        } else {
            //transaction status
            $this->setStatus($id, "1");

            //update account
            $obtained_points = $this->getSpecifyDonate($donate)['points'];

            $this->donate_model->giveDp($this->user->getId(), $obtained_points);

            redirect(base_url('/donate/success'));
        }
    }
    
    private function update_payment($payment_id, $payment_data) {
        $this->db->where('payment_id', $payment_id);
        $this->db->update('paypal_logs', $payment_data);
        return true;
    }
}
