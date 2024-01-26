<?php

class Topvoters_model extends CI_Model
{
    private $db;

    public function __construct()
    {
        parent::__construct();

        $this->db = $this->load->database("cms", true);
    }

    public function getThisWeekAccounts($limit = 5)
    {
        $weekRange = $this->getWeekStartAndEnd();

        $query = $this->db->query("Select COUNT(`vote_log`.`user_id`) AS vote, `vote_log`.`user_id`, `account_data`.`nickname` FROM `vote_log` Right Join `account_data` ON `account_data`.`id` = `vote_log`.`user_id` WHERE `time` > ? GROUP BY `vote_log`.`user_id` ORDER BY vote DESC LIMIT ?;", [strtotime($weekRange[0]), $limit]);

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function getWeekStartAndEnd()
    {
        $time = time();

        if (date('w', $time) == 1) {
            $startWeek = strtotime('today', $time);
        } else {
            $startWeek = strtotime('this week last monday', $time);
        }
        if (date('w', $time) == 0) {
            $endWeek = strtotime('today', $time);
        } else {
            $endWeek = strtotime('this week next sunday', $time);
        }

        return [date('Y-m-d H:i', $startWeek), date('Y-m-d H:i', $endWeek + 60 * 60 * 23 + 60 * 59)];
    }
}