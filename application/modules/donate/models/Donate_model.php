<?php

class Donate_model extends CI_Model
{
    public function getDonationLog($type = 'paypal')
    {
        $query = $this->db->query("SELECT * FROM `paypal_logs` GROUP BY `payment_id` ORDER BY `status` DESC, `id` DESC LIMIT 10");

        if ($query && $query->getNumRows() > 0)
        {
            return $query->getResultArray();
        } else {
            return false;
        }
    }

    public function giveDp($user, $dp)
    {
        $this->db->query("UPDATE account_data SET dp = dp + ? WHERE id = ?", [$dp, $user]);
    }

    public function findByEmail($type, $string)
    {
        $query = $this->db->query("SELECT * FROM " . $type . "_logs WHERE `payer_email` LIKE ?", ["%" . $string . "%"]);

        if ($query->getNumRows())
        {
            return $query->getResultArray();
        } else {
            return false;
        }
    }

    public function findByTxn($type, $string)
    {
        if ($type == "paypal") {
            $query = $this->db->query("SELECT * FROM " . $type . "_logs WHERE `payment_id` LIKE ?", ["%" . $string . "%"]);
        } else {
            $query = $this->db->query("SELECT * FROM " . $type . "_logs WHERE `txn_id` LIKE ?", ["%" . $string . "%"]);
        }

        if ($query->getNumRows())
        {
            return $query->getResultArray();
        } else {
            return false;
        }
    }

    public function findById($type, $string)
    {
        $query = $this->db->query("SELECT * FROM " . $type . "_logs WHERE `" . (($type == "paygol") ? "custom" : "user_id") . "`=?", [$string]);

        if ($query->getNumRows())
        {
            return $query->getResultArray();
        } else {
            return false;
        }
    }

    public function getPayPalLog($id)
    {
        $query = $this->db->query("SELECT * FROM paypal_logs WHERE id = ?", [$id]);

        if ($query->getNumRows())
        {
            $row = $query->getResultArray();

            return $row[0];
        } else {
            return false;
        }
    }

    public function updatePayPal($id, $data)
    {
        $this->db->table('paypal_logs')->where('id', $id)->update($data);
    }

    /**
     * Update the monthly income log
     *
     * @param Int $payment_amount
     */
    public function updateMonthlyIncome($payment_amount)
    {
        $query = $this->db->query("SELECT COUNT(*) AS `total` FROM monthly_income WHERE month=?", array(date("Y-m")));

        $row = $query->getResultArray();

        if ($row[0]['total'])
        {
            $this->db->query("UPDATE monthly_income SET amount = amount + " . floor($payment_amount) . " WHERE month=?", array(date("Y-m")));
        } else {
            $this->db->query("INSERT INTO monthly_income(month, amount) VALUES(?, ?)", array(date("Y-m"), floor($payment_amount)));
        }
    }

    public function getAllValues()
    {
		$query = $this->db->table('paypal_donate')->get();
		
		if($query->getNumRows() > 0)
        {
			return $query->getResultArray();
		}
		
		return false;
	}

    public function addValue($price, $points)
    {
        $data = [
            'price' => $price,
            'points' => $points
        ];

        $query = $this->db->table('paypal_donate')->insert($data);
        
        if($query)
        {
			return true;
		}
		
		return false;
    }

    public function updateValue($id, $price, $points)
    {
        $data = [
            'price' => $price,
            'points' => $points
        ];

        $query = $this->db->table('paypal_donate')->where('id', $id)->update($data);
        
        if($query)
        {
			return true;
		}
		
		return false;
    }

    public function deleteValue($id)
    {
        $this->db->table('paypal_donate')->where('id', $id)->delete();
    }

    public function getLogs($offset = 0, $limit = 0)
    {
        $builder = $this->db->table('paypal_logs')->select('*');
        $builder->orderBy('create_time', 'DESC');
        if ($limit > 0 && $offset == 0)
        {
            $builder->limit($limit);
        }

        if ($limit > 0 && $offset > 0)
        {
            $builder->limit($limit, $offset);
        }
        $query = $builder->get();

        if ($query->getNumRows() > 0)
        {
            return $query->getResultArray();
        } else {
            return null;
        }
    }

    public function getLogCount()
    {
        $query = $this->db->table('paypal_logs')->select("COUNT(id) 'count'")->get();

        if ($query->getNumRows() > 0)
        {
            $result = $query->getResultArray();
            return $result[0]['count'];
        } else {
            return null;
        }
    }
}
