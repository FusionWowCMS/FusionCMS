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

        $row = $query->getResultArray();

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

        $row = $query->getResultArray();

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

        if ($query->getNumRows()) {
            $row = $query->getResultArray();

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

        if ($query->getNumRows()) {
            $row = $query->getResultArray();

            return $row[0]['amount'];
        } else {
            return 0;
        }
    }

    public function getSignupsMonthly($type)
    {
        if ($type == "this") {
            $date = date("Y-m") . "-01";
        } else {
            $date = date("Y-m", time() - 60 * 60 * 24 * 30) . "-01";
            $next = date("Y-m") . "-01";
        }

        if ($type == "this") {
            $query = $this->db->query("SELECT amount FROM daily_signups WHERE `date` >= ?", [$date]);
        } else {
            $query = $this->db->query("SELECT amount FROM daily_signups WHERE `date` >= ? AND `date` < ?", [$date, $next]);
        }

        if ($query->getNumRows()) {
            $row = $query->getResultArray();

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

        if ($query->getNumRows()) {
            $row = $query->getResultArray();

            return $row[0]['amount'];
        } else {
            return 0;
        }
    }

    public function getGraph(bool $daily = false, array $agos = [0]): array
    {
        $unionQueries = [];

        foreach ($agos as $ago) {
            if ($daily) {
                $from = "DATE_FORMAT(CURRENT_DATE - INTERVAL {$ago} MONTH, '%Y-%m-01')";
                $to   = "LAST_DAY(CURRENT_DATE - INTERVAL {$ago} MONTH)";
            } else {
                $from = "DATE_FORMAT(CURRENT_DATE - INTERVAL {$ago} YEAR, '%Y-01-01')";
                $to   = "DATE_FORMAT(CURRENT_DATE - INTERVAL {$ago} YEAR, '%Y-12-31')";
            }

            $unionQueries[] = "SELECT visitor_log.date, COUNT(DISTINCT ip) as ipCount, {$ago} as ago FROM visitor_log WHERE visitor_log.date BETWEEN {$from} AND {$to} GROUP BY visitor_log.date";
        }

        $finalQuery = implode(" UNION ALL ", $unionQueries);

        $query = $this->db->query($finalQuery);

        return $query->getResultArray();
    }

    /* Modules */
    public function getEnabledModules()
    {
        $query = $this->db->query("SELECT id, name, display_name, enabled, type, creator, description, date_added FROM modules WHERE enabled = 1");

        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        }

        return null;
    }

    public function getDisabledModules()
    {
        $query = $this->db->query("SELECT id, name, display_name, enabled, type, creator, description, date_added FROM modules WHERE enabled = 0");

        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
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

        if ($query->getNumRows()) {
            return $query->getResultArray();
        } else {
            return false;
        }
    }
}
