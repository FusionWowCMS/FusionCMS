<?php

class Store_model extends CI_Model
{
    public function getItems($realm)
    {
        $query = $this->db->query("SELECT DISTINCT store_items.*
									FROM store_items
									INNER JOIN store_groups ON store_items.group = store_groups.id
									WHERE store_items.realm = ?
									GROUP BY store_items.id
									ORDER BY store_groups.orderNumber ASC, store_items.id ASC;", array($realm));

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return false;
        }
    }

    public function getItem($id)
    {
        $this->db->select('*')->from('store_items')->where(array('id' => $id))->order_by('group', 'ASC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();

            return $result[0];
        } else {
            return false;
        }
    }

    public function getGroupTitle($id)
    {
        $this->db->select('*')->from('store_groups')->where(array('id' => $id));
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();

            return $result[0]['title'];
        } else {
            return false;
        }
    }

    public function getGroupId($title)
    {
        $this->db->select('*')->from('store_groups')->where(array('title' => $title));
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();

            return $result[0]['id'];
        } else {
            return false;
        }
    }

    public function logOrder($vp, $dp, $cart)
    {
        $data = array(
            'vp_cost' => $vp,
            'dp_cost' => $dp,
            'cart' => json_encode($cart),
            'completed' => 0,
            'user_id' => $this->user->getId(),
            'timestamp' => time()
        );

        $this->db->insert('order_log', $data);
    }

    public function completeOrder()
    {
        $this->db->query("UPDATE order_log SET completed='1' WHERE user_id=? ORDER BY id DESC LIMIT 1", array($this->user->getId()));
    }

    public function getOrders($completed)
    {
        if ($completed) {
            $query = $this->db->query("SELECT * FROM order_log WHERE completed=? ORDER BY id DESC LIMIT 10", array($completed));
        } else {
            $query = $this->db->query("SELECT * FROM order_log WHERE completed=? AND `timestamp` > ? ORDER BY id DESC", array($completed, time() - 60 * 60 * 24 * 7));
        }

        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function getOrder($id)
    {
        $query = $this->db->query("SELECT * FROM order_log WHERE id=?", array($id));

        if ($query->num_rows()) {
            $row = $query->result_array();

            return $row[0];
        } else {
            return false;
        }
    }

    public function findByUserId($type, $string)
    {
        $query = $this->db->query("SELECT * FROM order_log WHERE `user_id`=? AND `completed`=?", array($string, $type));

        if ($query->num_rows()) {
            $row = $query->result_array();

            return $row;
        } else {
            return false;
        }
    }

    public function refund($user_id, $vp, $dp)
    {
        $this->db->query("UPDATE account_data SET vp = vp + ?, dp = dp + ? WHERE id=?", array($vp, $dp, $user_id));
    }

    public function deleteLog($id)
    {
        $this->db->query("DELETE FROM order_log WHERE id=?", array($id));
    }
}
