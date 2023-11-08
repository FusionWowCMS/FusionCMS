<?php defined('BASEPATH') or exit('No direct script access allowed');

class Spotlight_model extends CI_Model
{
    public function __construct()
    {
        // Call `CI_Model` construct
        parent::__construct();
    }

    public function getData()
    {
        // Prepare query
        $query = $this->db->order_by('order', 'ASC')->get('sideboxes_spotlight');

        // Query has no results
        if (!$query->num_rows() || $query->num_rows() == 0)
            return false;

        return $query->result_array();
    }

    public function getDataId($id)
    {
        $query = $this->db->query("SELECT * FROM sideboxes_spotlight WHERE id=?", array($id));

        if ($query->num_rows() > 0) {

            $row = $query->result_array();

            return $row[0];
        } else {
            return false;
        }
    }

    public function add($data)
    {
        $this->db->insert("sideboxes_spotlight", $data);

        $query = $this->db->query("SELECT id FROM sideboxes_spotlight ORDER BY id DESC LIMIT 1");
        $row = $query->result_array();

        $this->db->query("UPDATE sideboxes_spotlight SET `order`=? WHERE id=?", array($row[0]['id'], $row[0]['id']));

        return true;
    }

    public function delete($id)
    {
        $this->db->query("DELETE FROM sideboxes_spotlight WHERE id=?", array($id));

    }

    public function getOrder($id)
    {
        $query = $this->db->query("SELECT `order` FROM sideboxes_spotlight WHERE `id`=? LIMIT 1", array($id));

        if ($query->num_rows() > 0) {
            $row = $query->result_array();

            return $row[0]['order'];
        } else {
            return false;
        }
    }

    public function getPreviousOrder($order)
    {
        $query = $this->db->query("SELECT `order`, id FROM sideboxes_spotlight WHERE `order` < ? ORDER BY `order` DESC LIMIT 1", array($order));

        if ($query->num_rows() > 0) {
            $row = $query->result_array();

            return $row[0];
        } else {
            return false;
        }
    }

    public function getNextOrder($order)
    {
        $query = $this->db->query("SELECT `order`, id FROM sideboxes_spotlight WHERE `order` > ? ORDER BY `order` ASC LIMIT 1", array($order));

        if ($query->num_rows() > 0) {
            $row = $query->result_array();

            return $row[0];
        } else {
            return false;
        }
    }

    public function setOrder($id, $order)
    {
        $this->db->query("UPDATE sideboxes_spotlight SET `order`=? WHERE `id`=? LIMIT 1", array($order, $id));
    }

    public function edit($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('sideboxes_spotlight', $data);
    }
}
