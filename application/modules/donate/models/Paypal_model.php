<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Paypal_model extends CI_Model
{
    public function __construct()
    {
        $this->load->config('paypal');
        $this->load->model('donate_model');

        parent::__construct();
    }

    public function getSpecifyDonate($id): array|bool
    {
        $query = $this->db->table('paypal_donate')->select()->where('id', $id)->get();

        if ($query && $query->getNumRows() > 0) {
            $rows = $query->getResultArray();
            return $rows[0];
        }

        return false;
    }

    public function getDonations(): array|bool
    {
        $query = $this->db->table('paypal_donate')->select()->get();

        if ($query && $query->getNumRows() > 0) {
            return $query->getResultArray();
        }

        return false;
    }

    public function getStatus($id): array|bool|string
    {
        $query = $this->db->table('paypal_logs')->select("*")->where('payment_id', $id)->get();

        if ($query && $query->getNumRows() > 0) {
            $rows = $query->getResultArray();
            return $rows[0]["status"];
        }

        return false;
    }

    public function setStatus($id, $status): void
    {
        $data = ['status' => $status];
        $this->db->table('paypal_logs')->where('payment_id', $id)->update($data);
    }

    public function setError($id, $error): void
    {
        $data = ['error' => $error];
        $this->db->table('paypal_logs')->where('payment_id', $id)->update($data);
    }

    public function setCanceled($token, $status): void
    {
        $data = ['status' => $status];
        $this->db->table('paypal_logs')->where('token', $token)->update($data);
    }
    
    public function update_payment($payment_id, $payment_data): void
    {
        $this->db->table('paypal_logs')->where('payment_id', $payment_id)->update($payment_data);
    }
}
