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
									ORDER BY store_groups.orderNumber ASC, store_items.group ASC, store_items.id ASC;", [$realm]);

        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        } else {
            return false;
        }
    }

    public function getItem($id)
    {
        $query = $this->db->table('store_items')->select()->where(['id' => $id])->orderBy('group', 'ASC')->get();

        if ($query->getNumRows() > 0) {
            $result = $query->getResultArray();

            return $result[0];
        } else {
            return false;
        }
    }

    public function getGroupTitle($id)
    {
        $query = $this->db->table('store_groups')->select()->where(['id' => $id])->get();

        if ($query->getNumRows() > 0) {
            $result = $query->getResultArray();

            return $result[0]['title'];
        } else {
            return false;
        }
    }

    public function getGroupId($title)
    {
        $query = $this->db->table('store_groups')->select()->where(['title' => $title])->get();

        if ($query->getNumRows() > 0) {
            $result = $query->getResultArray();

            return $result[0]['id'];
        } else {
            return false;
        }
    }

    public function logOrder($vp, $dp, $cart)
    {
        $data = [
            'vp_cost'   => $vp,
            'dp_cost'   => $dp,
            'cart'      => json_encode($cart),
            'completed' => 0,
            'user_id'   => $this->user->getId(),
            'timestamp' => time()
        ];

        $this->db->table('order_log')->insert($data);
    }

    public function completeOrder()
    {
        $this->db->query("UPDATE order_log SET completed = '1' WHERE user_id = ? ORDER BY id DESC LIMIT 1", [$this->user->getId()]);
    }

    public function getOrders($completed)
    {
        if ($completed) {
            $query = $this->db->query("SELECT * FROM order_log WHERE completed = ? ORDER BY id DESC LIMIT 10", [$completed]);
        } else {
            $query = $this->db->query("SELECT * FROM order_log WHERE completed = ? AND `timestamp` > ? ORDER BY id DESC", [$completed, time() - 60 * 60 * 24 * 7]);
        }

        if ($query->getNumRows()) {
            return $query->getResultArray();
        } else {
            return false;
        }
    }

    public function getOrder($id)
    {
        $query = $this->db->query("SELECT * FROM order_log WHERE id = ?", [$id]);

        if ($query->getNumRows()) {
            $row = $query->getResultArray();

            return $row[0];
        } else {
            return false;
        }
    }

    public function findByUserId($type, $string)
    {
        $query = $this->db->query("SELECT * FROM order_log WHERE `user_id` = ? AND `completed` = ?", [$string, $type]);

        if ($query->getNumRows()) {
            $row = $query->getResultArray();

            return $row;
        } else {
            return false;
        }
    }

    public function refund($user_id, $vp, $dp)
    {
        $this->db->query("UPDATE account_data SET vp = vp + ?, dp = dp + ? WHERE id = ?", [$vp, $dp, $user_id]);
    }

    public function deleteLog($id)
    {
        $this->db->query("DELETE FROM order_log WHERE id = ?", [$id]);
    }
}
