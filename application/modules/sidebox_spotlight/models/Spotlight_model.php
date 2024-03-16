<?php defined('BASEPATH') or exit('No direct script access allowed');

class Spotlight_model extends CI_Model
{
    public function getData()
    {
        // Prepare query
        $query = $this->db->table('sideboxes_spotlight')->orderBy('order', 'ASC')->get();

        // Query has no results
        if (!$query->getNumRows() || $query->getNumRows() == 0)
            return false;

        return $query->getResultArray();
    }

    public function getDataId($id)
    {
        $query = $this->db->query("SELECT * FROM sideboxes_spotlight WHERE id=?", [$id]);

        if ($query->getNumRows() > 0) {

            $row = $query->getResultArray();

            return $row[0];
        } else {
            return false;
        }
    }

    public function add($data)
    {
        $this->db->table('sideboxes_spotlight')->insert($data);

        $query = $this->db->query("SELECT id FROM sideboxes_spotlight ORDER BY id DESC LIMIT 1");
        $row = $query->getResultArray();

        $this->db->query("UPDATE sideboxes_spotlight SET `order` = ? WHERE id = ?", [$row[0]['id'], $row[0]['id']]);

        return true;
    }

    public function delete($id)
    {
        $this->db->query("DELETE FROM sideboxes_spotlight WHERE id = ?", array($id));

    }

    public function getOrder($id)
    {
        $query = $this->db->query("SELECT `order` FROM sideboxes_spotlight WHERE `id` = ? LIMIT 1", array($id));

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

            return $row[0]['order'];
        } else {
            return false;
        }
    }

    public function getPreviousOrder($order)
    {
        $query = $this->db->query("SELECT `order`, id FROM sideboxes_spotlight WHERE `order` < ? ORDER BY `order` DESC LIMIT 1", array($order));

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

            return $row[0];
        } else {
            return false;
        }
    }

    public function getNextOrder($order)
    {
        $query = $this->db->query("SELECT `order`, id FROM sideboxes_spotlight WHERE `order` > ? ORDER BY `order` ASC LIMIT 1", array($order));

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

            return $row[0];
        } else {
            return false;
        }
    }

    public function setOrder($id, $order)
    {
        $this->db->query("UPDATE sideboxes_spotlight SET `order` = ? WHERE `id` = ? LIMIT 1", array($order, $id));
    }

    public function edit($id, $data)
    {
        $this->db->table('sideboxes_spotlight')->where('id', $id)->update($data);
    }
}
