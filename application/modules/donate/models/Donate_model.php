<?php

class Donate_model extends CI_Model
{
    public function getDonationLog($type = 'paypal')
    {
        switch ($type)
        {
            case 'paypal':
                $query = $this->db->query("SELECT * FROM `paypal_logs` GROUP BY `payment_id` ORDER BY `status` DESC, `id` DESC LIMIT 10");
                break;
        }

        if ($query) {
            if ($query->num_rows() > 0)
            {
                $result = $query->result_array();
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function giveDp($user, $dp)
    {
        $this->db->query("UPDATE account_data SET dp = dp + ? WHERE id=?", array($dp, $user));
    }

    public function findByEmail($type, $string)
    {
        $query = $this->db->query("SELECT * FROM " . $type . "_logs WHERE `payer_email` LIKE ?", array("%" . $string . "%"));

        if ($query->num_rows())
        {
            $row = $query->result_array();

            return $row;
        } else {
            return false;
        }
    }

    public function findByTxn($type, $string)
    {
        if ($type == "paypal") {
            $query = $this->db->query("SELECT * FROM " . $type . "_logs WHERE `payment_id` LIKE ?", array("%" . $string . "%"));
        } else {
            $query = $this->db->query("SELECT * FROM " . $type . "_logs WHERE `txn_id` LIKE ?", array("%" . $string . "%"));
        }

        if ($query->num_rows())
        {
            $row = $query->result_array();

            return $row;
        } else {
            return false;
        }
    }

    public function findById($type, $string)
    {
        $query = $this->db->query("SELECT * FROM " . $type . "_logs WHERE `" . (($type == "paygol") ? "custom" : "user_id") . "`=?", array($string));

        if ($query->num_rows())
        {
            $row = $query->result_array();

            return $row;
        } else {
            return false;
        }
    }

    public function getPayPalLog($id)
    {
        $query = $this->db->query("SELECT * FROM paypal_logs WHERE id=?", array($id));

        if ($query->num_rows())
        {
            $row = $query->result_array();

            return $row[0];
        } else {
            return false;
        }
    }

    public function findByMessageId($type, $string)
    {
        $query = $this->db->query("SELECT * FROM " . $type . "_logs WHERE `message_id`=?", array($string));

        if ($query->num_rows())
        {
            $row = $query->result_array();

            return $row;
        } else {
            return false;
        }
    }

    public function findByNumber($type, $string)
    {
        $query = $this->db->query("SELECT * FROM " . $type . "_logs WHERE `sender`=?", array($string));

        if ($query->num_rows())
        {
            $row = $query->result_array();

            return $row;
        } else {
            return false;
        }
    }

    public function updatePayPal($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('paypal_logs', $data);
    }

    /**
     * Update the monthly income log
     *
     * @param Int $payment_amount
     */
    public function updateMonthlyIncome($payment_amount)
    {
        $query = $this->db->query("SELECT COUNT(*) AS `total` FROM monthly_income WHERE month=?", array(date("Y-m")));

        $row = $query->result_array();

        if ($row[0]['total'])
        {
            $this->db->query("UPDATE monthly_income SET amount = amount + " . floor($payment_amount) . " WHERE month=?", array(date("Y-m")));
        } else {
            $this->db->query("INSERT INTO monthly_income(month, amount) VALUES(?, ?)", array(date("Y-m"), floor($payment_amount)));
        }
    }

    public function getAllValues()
    {
		$query = $this->db->get('paypal_donate');
		
		if($query->num_rows() > 0)
        {
			return $query->result_array();
		}
		
		return false;
	}

    public function addValue($price, $points)
    {
        $data = array(
            'price' => $price,
            'points' => $points
        );

        $query = $this->db->insert('paypal_donate', $data);
        
        if($query)
        {
			return true;
		}
		
		return false;
    }

    public function updateValue($id, $price, $points)
    {
        $data = array(
            'price' => $price,
            'points' => $points
        );

        $this->db->where('id', $id);
        $query = $this->db->update('paypal_donate', $data);
        
        if($query)
        {
			return true;
		}
		
		return false;
    }

    public function deleteValue($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('paypal_donate');
    }

    public function getLogs($offset = 0, $limit = 0)
    {
        $this->db->select('*');
        $this->db->order_by('create_time', 'DESC');
        if ($limit > 0 && $offset == 0)
        {
            $this->db->limit($limit);
        }

        if ($limit > 0 && $offset > 0)
        {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get('paypal_logs');

        if ($query->num_rows() > 0)
        {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function getLogCount()
    {
        $this->db->select("COUNT(id) 'count'");
        $query = $this->db->get('paypal_logs');

        if ($query->num_rows() > 0)
        {
            $result = $query->result_array();
            return $result[0]['count'];
        }
    }
}
