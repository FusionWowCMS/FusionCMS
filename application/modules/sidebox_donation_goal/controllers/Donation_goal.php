<?php

class Donation_goal extends MX_Controller
{
    private $db;

    public function __construct()
    {
        parent::__construct();

        $this->load->config('sidebox_donation_goal/donation_goal');
    }

    public function view()
    {
        $goal = $this->config->item('donation_goal');
        $currency_sign = $this->config->item('donation_goal_currency_sign');

        $current = $this->getCurrent();

        // Prepare data
        $data = array(
                    "module" => "sidebox_donation_goal",
                    "current" => $current,
                    "goal" => $goal,
                    "currency_sign" => $currency_sign,
                    "percentage" => $this->getPercentage($current, $goal)
                );

        // Load the template file and format
        $out = $this->template->loadPage("goal.tpl", $data);

        return $out;
    }

    private function getPercentage($part, $whole)
    {
        if ($part >= $whole) {
            return 100;
        }

        if (!$part || !$whole) {
            return 0;
        }

        return round(($part / $whole) * 100);
    }

    /**
     * Sorry for not having it in a model, but it simply didn't let me :(
     */
    private function getCurrent()
    {
        $this->db = $this->load->database("cms", true);

        $query = $this->db->query("SELECT amount from monthly_income WHERE month=?", array(date("Y-m")));

        if ($query->num_rows()) {
            $row = $query->result_array();

            return $row[0]['amount'];
        } else {
            return 0;
        }
    }
}
