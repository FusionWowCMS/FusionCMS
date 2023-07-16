<?php

class Admin extends MX_Controller
{
    private $coreModules;

    public function __construct()
    {
        parent::__construct();

        $this->load->config('performance');

        $this->coreModules = array('admin', 'login', 'logout', 'errors', 'news', 'mod');

        $this->load->library('administrator');

        require_once('application/libraries/Prettyjson.php');

        $this->load->model('dashboard_model');

        requirePermission("view");
    }

    public function index()
    {
        $this->administrator->setTitle("Dashboard");

        $this->administrator->loadModules();

        // Load realm objects
        $realms = $this->realms->getRealms();

        $uptimes = $this->flush_uptime($realms);

        $data = array(
            'url' => $this->template->page_url,
            'enabled_modules' => $this->administrator->getEnabledModules(),
            'disabled_modules' => $this->administrator->getDisabledModules(),
            'theme' => $this->template->theme_data,
            'version' => $this->administrator->getVersion(),
            'php_version' => phpversion(),
            'ci_version' => CI_VERSION,
            'theme_value' => $this->config->item('theme'),
            'unique' => $this->getUnique(),
            'views' => $this->getViews(),
            'income' => $this->getIncome(),
            'votes' => $this->getVotes(),
            "nickname" => $this->user->getNickname(),
            "avatar" => $this->user->getAvatar($this->user->getId()),
            "groups" => $this->acl_model->getGroupsByUser($this->user->getId()),
            "email" => $this->user->getEmail(),
            "location" => $this->internal_user_model->getLocation(),
            "register_date" => $this->user->getRegisterDate(),
            'signups' => $this->getSignups(),
            'graphMonthly' => $this->graphMonthly(),
            'graphDaily' => $this->graphDaily(),
            "realm_status" => $this->config->item('disable_realm_status'),
            "realms" => $realms,
            "uptimes" => $uptimes,
        );

        $output = $this->template->loadPage("dashboard.tpl", $data);

        $content = $this->administrator->box('Dashboard', $output);

        $this->administrator->view($content, false);
    }

    private function getUnique()
    {
        $data['today'] = $this->dashboard_model->getUnique("today");
        $data['month'] = $this->dashboard_model->getUnique("month");

        return $data;
    }

    private function getViews()
    {
        $data['today'] = $this->dashboard_model->getViews("today");
        $data['month'] = $this->dashboard_model->getViews("month");

        return $data;
    }

    private function getIncome()
    {
        $data['this'] = $this->dashboard_model->getIncome("this");
        $data['last'] = $this->dashboard_model->getIncome("last");
        $data['growth'] = $data['this'] > 0 ? ((($data['this'] - $data['last']) / $data['last']) * 100) : 0;

        return $data;
    }

    private function getVotes()
    {
        $data['this'] = $this->dashboard_model->getVotes("this");
        $data['last'] = $this->dashboard_model->getVotes("last");
        $data['growth'] = $data['this'] > 0 ? ((($data['this'] - $data['last']) / $data['last']) * 100) : 0;

        return $data;
    }

    private function getSignups()
    {
        $data['today'] = $this->dashboard_model->getSignupsDaily("today");
        $data['month'] = $this->dashboard_model->getSignupsDaily("month");
        $data['this'] = $this->dashboard_model->getSignupsMonthly("this");
        $data['last'] = $this->dashboard_model->getSignupsMonthly("last");
        $data['growth'] = $data['this'] > 0 ? ((($data['this'] - $data['last']) / $data['last']) * 100) : 0;

        $cache = $this->cache->get("total_accounts");

        if ($cache !== false)
        {
            $data['total'] = $cache;
        } else {
            $data['total'] = $this->external_account_model->getAccountCount();
            $this->cache->save("total_accounts", $data['total'], 60 * 60 * 24);
        }

        return $data;
    }

    private function graphMonthly()
    {
        if ($this->config->item('disable_visitor_graph'))
        {
            return false;
        }

        $cache = $this->cache->get("dashboard_monthly");

        if ($cache !== false)
        {
            $data = $cache;
        } else {
            $rows = $this->dashboard_model->getGraph();
            $fullGraph = array();

            foreach ($rows as $row)
            {
                $expld = explode("-", $row["date"]);

                $year = $expld[0];
                $month = $expld[1];
                $date = $expld[2];

                $date = new DateTime();
                $fullYear = array();
                for ($i = 1; $i <= 12; $i++)
                {
                    if ($date->format("Y") == $year && $i > $date->format("m"))
                    {
                        continue;
                    }

                    if ($date->format("Y") != $year && $i < $date->format("m"))
                    {
                        continue;
                    }

                    $fullYear[($i < 10 ? "0" : "") . $i] = 0;
                }

                if (!isset($fullGraph[$year]["month"]))
                {
                    $fullGraph[$year]["month"] = $fullYear;
                }

                if (isset($fullGraph[$year]["month"][$month]))
                {
                    $fullGraph[$year]["month"][$month] = $fullGraph[$year]["month"][$month] + $row["ipCount"];
                }
            }

            $data = $fullGraph;

            $this->cache->save("dashboard_monthly", $data, 60 * 60 * 24);
        }

        return $data;
    }
    
    private function graphDaily()
    {
        if ($this->config->item('disable_visitor_graph'))
        {
            return false;
        }
    
        $cache = $this->cache->get("dashboard_daily");
    
        if ($cache !== false)
        {
            $data = $cache;
        } else {
            $rows = $this->dashboard_model->getGraph(true);
    
            $fullMonth = array();
    
            foreach ($rows as $row)
            {
                $expld = explode("-", $row["date"]);
    
                $year = $expld[0];
                $month = $expld[1];
                $day = $expld[2];
    
                $date = new DateTime();
                $fullDays = array();
                for ($i = 1; $i <= 31; $i++)
                {
                    if ($date->format("Y") == $year && $date->format("m") == $month && $i > $date->format("d"))
                    {
                        continue;
                    }
    
                    $fullDays[($i < 10 ? "0" : "") . $i] = 0;
                }
    
                if (!isset($fullMonth[$year]["day"]))
                {
                    $fullMonth[$year]["day"] = $fullDays;
                }
    
                if (isset($fullMonth[$year]["day"][$day]))
                {
                    $fullMonth[$year]["day"][$day] += $row["ipCount"];
                }
            }
    
            $currentYear = date('Y');
            $currentMonth = date('m');
    
            $data = $fullMonth[$currentYear]["day"];

            if (!isset($data))
            {
                $data = array();
            }

            $this->cache->save("dashboard_daily", $data, 60 * 60 * 24);
        }

        return $data;
    }

    public function checkSoap()
    {
        if (!extension_loaded('soap'))
        {
            show_error('SOAP not installed');
        }

        $realms = $this->realms->getRealms();

        foreach ($realms as $realm)
        {
            if ($realm->isOnline(true))
            {
                $this->realms->getRealm($realm->getId())->getEmulator()->sendCommand('.server info');
            }
        }
    }
	
	public function realmstatus()
    {
        $data = array(
			"realmstatus" => $this->realms->getRealms(),
        );

		$out = $this->template->loadPage("ajax_files/realmstatus.tpl", $data);

        die($out);
    }

    public function destroySession()
    {
        $this->session->unset_userdata('admin_access');
    }

    public function notifications($count = false)
    {
        if ($count)
        {
            $notifications = $this->cms_model->getNotifications($this->user->getId(), true);

            echo $notifications;
			die();
        } else {
            $notifications = $this->cms_model->getNotifications($this->user->getId(), false);

            $data = array(
                'notifications' => $notifications,
            );

            $out = $this->template->loadPage("notifications.tpl", $data);

            echo $out;
			die();
        }
    }

    public function markReadNotification($id, $all = false)
    {
        if ($all)
        {
            $uid = $this->user->getId();
            $this->cms_model->setReadNotification($id, $uid, true);
            die('yes');
        } else {
            $uid = $this->user->getId();
            $this->cms_model->setReadNotification($id, $uid, false);
            die('yes');
        }
    }

    private function flush_uptime($realms)
    {
        $uptimes = array();
        foreach ($realms as $k => $realm) {
            $uptimes[$realm->getId()] = $this->uptime($realm->getId());
        }
        return $uptimes;
    }

    private function uptime($realm_id)
    {
        $this->connection = $this->load->database("account", true);
        $this->connection->where('realmid', $realm_id);
        $query = $this->connection->get('uptime');
        $last = $query->last_row('array');
        if (isset($last)) {
            $first_date = new DateTime(date('Y-m-d h:i:s', $last['starttime']));
            $second_date = new DateTime(date('Y-m-d h:i:s'));

            $difference = $first_date->diff($second_date);

            return $this->format_interval($difference);
        } else {
            return "Offline";
        }
    }

    private function format_interval(DateInterval $interval)
    {
        $result = "";
        if ($interval->y) {
            $result .= $interval->format("<span>%y</span>y ");
        }
        if ($interval->m) {
            $result .= $interval->format("<span>%m</span>m ");
        }
        if ($interval->d) {
            $result .= $interval->format("<span>%d</span>d ");
        }
        if ($interval->h) {
            $result .= $interval->format("<span>%h</span>h ");
        }
        if ($interval->i) {
            $result .= $interval->format("<span>%i</span>m ");
        }
        if ($interval->s) {
            $result .= $interval->format("<span>%s</span>s ");
        }

        return $result;
    }
}
