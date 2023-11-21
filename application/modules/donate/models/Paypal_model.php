<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Paypal_model extends CI_Model
{
    public function __construct()
    {
        $this->load->config("paypal");
        $this->load->model("donate_model");

        parent::__construct();
    }

    public function getSpecifyDonate($id): array|false
    {
        $query = $this->db->select("*")->where("id", $id)->get("paypal_donate");

        if ($query && $query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows[0];
        }

        return false;
    }

    public function getDonations(): array|false
    {
        $query = $this->db->select("*")->get("paypal_donate");

        if ($query && $query->num_rows() > 0) {
            return $query->result_array();
        }

        return false;
    }

    public function getStatus($id): array|false
    {
        $query = $this->db->select("*")->where("payment_id", $id)->get("paypal_logs");

        if ($query && $query->num_rows() > 0) {
            $rows = $query->result_array();
            return $rows[0]["status"];
        }

        return false;
    }

    public function setStatus($id, $status): void
    {
        $data = array('status' => $status);
        $this->db->where('payment_id', $id)->update('paypal_logs', $data);
    }

    public function setError($id, $error): void
    {
        $data = array('error' => $error);
        $this->db->where('payment_id', $id)->update('paypal_logs', $data);
    }

    public function setCanceled($token, $status): void
    {
        $data = array('status' => $status);
        $this->db->where('token', $token)->update('paypal_logs', $data);
    }
    
    public function update_payment($payment_id, $payment_data): void
    {
        $this->db->where('payment_id', $payment_id);
        $this->db->update('paypal_logs', $payment_data);
    }
}
