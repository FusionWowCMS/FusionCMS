<?php

class Dashboard_model extends CI_Model
{
    public function getUnique($type)
    {
        if ($type == "today") {
            $date = date("Y-m-d");
        } else {
            $date = date("Y-m-d", time() - 60 * 60 * 24 * 30);
        }

        if ($type == "today") {
            $query = $this->db->query("SELECT COUNT(DISTINCT ip,`date`) as `total` FROM visitor_log WHERE `date` >= ?", array($date));
        } else {
            $query = $this->db->query("SELECT COUNT(DISTINCT ip) as `total` FROM visitor_log WHERE `date` >= ?", array($date));
        }

        $row = $query->result_array();

        return $row[0]['total'];
    }

    public function getViews($type)
    {
        if ($type == "today") {
            $date = date("Y-m-d");
        } else {
            $date = date("Y-m-d", time() - 60 * 60 * 24 * 30);
        }

        $query = $this->db->query("SELECT COUNT(*) as `total` FROM visitor_log WHERE `date` >= ?", array($date));

        $row = $query->result_array();

        return $row[0]['total'];
    }

    public function getIncome($type)
    {
        if ($type == "this") {
            $date = date("Y-m");
        } else {
            $date = date("Y-m", time() - 60 * 60 * 24 * 30);
        }

        $query = $this->db->query("SELECT amount FROM monthly_income WHERE month=?", array($date));

        if ($query->num_rows()) {
            $row = $query->result_array();

            return $row[0]['amount'];
        } else {
            return 0;
        }
    }

    public function getVotes($type)
    {
        if ($type == "this") {
            $date = date("Y-m");
        } else {
            $date = date("Y-m", time() - 60 * 60 * 24 * 30);
        }

        $query = $this->db->query("SELECT amount FROM monthly_votes WHERE month=?", array($date));

        if ($query->num_rows()) {
            $row = $query->result_array();

            return $row[0]['amount'];
        } else {
            return 0;
        }
    }

    public function getSignupsMonthly($type)
    {
        if ($type == "this") {
            $date = date("Y-m") . "-0";
        } else {
            $date = date("Y-m", time() - 60 * 60 * 24 * 30) . "-0";
            $next = date("Y-m") . "-0";
        }

        if ($type == "this") {
            $query = $this->db->query("SELECT amount FROM daily_signups WHERE `date` >= ?", array($date));
        } else {
            $query = $this->db->query("SELECT amount FROM daily_signups WHERE `date` >= ? AND `date` < ?", array($date, $next));
        }

        if ($query->num_rows()) {
            $row = $query->result_array();

            $total = 0;

            foreach ($row as $item) {
                $total += $item['amount'];
            }

            return $total;
        } else {
            return 0;
        }
    }

    public function getSignupsDaily($type)
    {
        if ($type == "today") {
            $date = date("Y-m-d");
        } else {
            $date = date("Y-m-d", time() - 60 * 60 * 24 * 30);
        }

        $query = $this->db->query("SELECT amount FROM daily_signups WHERE `date` >= ?", array($date));

        if ($query->num_rows()) {
            $row = $query->result_array();

            return $row[0]['amount'];
        } else {
            return 0;
        }
    }

    public function getGraph($daily = false)
    {
        if ($daily)
        {
            $query = $this->db->query("SELECT date, COUNT(DISTINCT ip) ipCount FROM visitor_log WHERE YEAR(date) = YEAR(CURRENT_DATE()) AND MONTH(date) = MONTH(CURRENT_DATE()) GROUP BY date");
        } else {
            $query = $this->db->query("SELECT date, COUNT(DISTINCT ip) ipCount FROM visitor_log GROUP BY date");
            
        }

        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /* Modules */
    public function getEnabledModules()
    {
        $query = $this->db->query("SELECT id, name, display_name, enabled, type, creator, description, date_added FROM modules WHERE enabled = 1");

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return null;
    }

    public function getDisabledModules()
    {
        $query = $this->db->query("SELECT id, name, display_name, enabled, type, creator, description, date_added FROM modules WHERE enabled = 0");

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return null;
    }

    /* Enable / Disable modules */
    public function enableModule($moduleId)
    {
        $moduleId = (int)$moduleId;

        if (!is_int($moduleId)) {
            throw new Exception("Not a number");
        }

        $query = $this->db->query("UPDATE modules SET enabled = 1 WHERE id = ?", array($moduleId));

        if ($query) {
            return;
        }

        throw new Exception("Could not enable module with id: " . $moduleId);
    }

    public function disableModule($moduleId)
    {
        $moduleId = (int)$moduleId;

        if (!is_int($moduleId)) {
            throw new Exception("Not a number");
        }

        $query = $this->db->query("UPDATE modules SET enabled = 0 WHERE id = ?", array($moduleId));

        if ($query) {
            return;
        }

        throw new Exception("Could not disable module with id: " . $moduleId);
    }

    public function getEmailLogs()
    {
        $query = $this->db->query("SELECT * FROM email_log ORDER BY timestamp DESC");

        if ($query->num_rows()) {
            return $query->result_array();
        } else {
            return false;
        }
    }
}
