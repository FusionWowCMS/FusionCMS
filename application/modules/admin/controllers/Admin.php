<?php

use App\Config\Services;
use MX\MX_Controller;

/**
 * Admin Controller Class
 * @property dashboard_model $dashboard_model dashboard_model Class
 */
class Admin extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('administrator');

        $this->load->model('dashboard_model');

        requirePermission("view");
    }

    public function index()
    {
        $benchmark = Services::timer(true);
        $benchmark->start('admin_execution');

        $this->administrator->setTitle("Dashboard");

        // Load realm objects
        $realms = $this->realms->getRealms();

        $uptimes = $this->flush_uptime($realms);

        $data = [
            'url' => $this->template->page_url,
            'theme' => $this->template->theme_data,
            'version' => $this->administrator->getVersion(),
            'php_version' => phpversion(),
            'ci_version' => CI_VERSION,
            'os' => $this->getOsName(),
            'php_sapi' => PHP_SAPI,
            'server_software' => $_SERVER['SERVER_SOFTWARE'],
            'theme_value' => $this->config->item('theme'),
            'unique' => $this->getUnique(),
            'views' => $this->getViews(),
            'income' => $this->getIncome(),
            'votes' => $this->getVotes(),
            'nickname' => $this->user->getNickname(),
            'avatar' => $this->user->getAvatar($this->user->getId()),
            'groups' => $this->acl_model->getGroupsByUser($this->user->getId()),
            'email' => $this->user->getEmail(),
            'location' => $this->internal_user_model->getLocation(),
            'register_date' => $this->user->getRegisterDate(),
            'signups' => $this->getSignups(),
            'graphMonthly' => [$this->graphMonthly(), $this->graphMonthly(1)],
            'graphDaily' => [$this->graphDaily(), $this->graphDaily(1), $this->graphDaily(2)],
            'realm_status' => $this->config->item('disable_realm_status'),
            'realms' => $realms,
            'uptimes' => $uptimes,
            'latestVersion' => $this->getLatestVersion(),
            'isOldTheme' => empty($this->template->theme_data['min_required_version']),
        ];

        $data['benchmark'] = $benchmark->stop('admin_execution')->getElapsedTime('admin_execution')  * 1000 . ' ms';
        $data['memory_usage'] = round(memory_get_usage() / 1024 / 1024, 2) . 'MB';

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
        $data['growth'] = ($data['this'] > 0 && $data['last'] > 0) ? ((($data['this'] - $data['last']) / $data['last']) * 100) : 0;

        return $data;
    }

    private function getVotes()
    {
        $data['this'] = $this->dashboard_model->getVotes("this");
        $data['last'] = $this->dashboard_model->getVotes("last");
        $data['growth'] = ($data['this'] > 0 && $data['last'] > 0) ? ((($data['this'] - $data['last']) / $data['last']) * 100) : 0;

        return $data;
    }

    private function getSignups()
    {
        $data['today'] = $this->dashboard_model->getSignupsDaily("today");
        $data['month'] = $this->dashboard_model->getSignupsDaily("month");
        $data['this'] = $this->dashboard_model->getSignupsMonthly("this");
        $data['last'] = $this->dashboard_model->getSignupsMonthly("last");
        $data['growth'] = ($data['this'] > 0 && $data['last'] > 0) ? ((($data['this'] - $data['last']) / $data['last']) * 100) : 0;

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

    private function graphMonthly($ago = 0)
    {
        if ($this->config->item('disable_visitor_graph'))
        {
            return false;
        }

        if ($ago == 0)
            $cache = $this->cache->get("dashboard_monthly");
        else
            $cache = $this->cache->get('dashboard_monthly_'.$ago.'_year_ago');

        if ($cache !== false)
        {
            $data = $cache;
        } else {
            $rows = $this->dashboard_model->getGraph(false, $ago);
            $fullGraph = [];

            if($rows)
            {
                foreach ($rows as $row)
                {
                    $expld = explode("-", $row["date"]);

                    $year = $expld[0];
                    $month = $expld[1];

                    $date = new DateTime();
                    $fullYear = [];
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
            }

            $data = $fullGraph;

            if ($ago == 0)
                $this->cache->save('dashboard_monthly', $data, 60 * 60 * 24 * 15); // Every two weeks
            else
                $this->cache->save('dashboard_monthly_'.$ago.'_year_ago', $data, 60 * 60 * 24 * 9 * 30); // every 9 months
        }

        return $data;
    }
    
    private function graphDaily($ago = 0)
    {
        if ($this->config->item('disable_visitor_graph'))
        {
            return false;
        }

        if ($ago == 0)
            $cache = $this->cache->get("dashboard_daily");
        else
            $cache = $this->cache->get('dashboard_daily_'.$ago.'_month_ago');
    
        if ($cache !== false)
        {
            $data = $cache;
        } else {
            $rows = $this->dashboard_model->getGraph(true, $ago);
    
            $fullMonth = [];

            if ($rows) {
                foreach ($rows as $row)
                {
                    $expld = explode("-", $row["date"]);

                    $year = $expld[0];
                    $day = $expld[2];

                    $fullDays = [];
                    for ($i = 1; $i <= 31; $i++)
                    {
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
            } else {
                $fullDays = [];
                for ($i = 1; $i <= 31; $i++)
                {
                    $fullDays[($i < 10 ? "0" : "") . $i] = 0;
                }
                $year = date('Y');
                $fullMonth[$year]["day"] = $fullDays;
            }

            $currentYear = $ago > 0 && date('m') == '01' ? (date('Y') - 1) : date('Y');

            $data = $fullMonth[$currentYear]["day"] ?? null;

            if (!isset($data))
            {
                $data = [];
            }

            if ($ago == 0)
                $this->cache->save('dashboard_daily', $data, 60 * 60 * 24);
            else
                $this->cache->save('dashboard_daily_'.$ago.'_month_ago', $data, 60 * 60 * 24);
        }

        return $data;
    }

    public function checkSoap()
    {
        if (!extension_loaded('soap'))
        {
            show_error('SOAP not installed', 501);
        }

        $realms = $this->realms->getRealms();

        foreach ($realms as $realm)
        {
            if ($realm->isOnline(true))
            {
                $this->realms->getRealm($realm->getId())->getEmulator()->sendCommand('.server info', $realm);
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
        Services::session()->remove('admin_access');
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
        foreach ($realms as $realm) {
            $uptimes[$realm->getId()] = $this->uptime($realm->getId());
        }
        return $uptimes;
    }

    private function uptime($realm_id)
    {
        $this->connection = $this->load->database("account", true);
        $query = $this->connection->table('uptime')->where('realmid', $realm_id)->get();
        $last = $query->getLastRow('array');
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

    private function getLatestVersion(): bool
    {
        $response = Services::curlrequest()->get('https://raw.githubusercontent.com/FusionWowCMS/FusionCMS/master/application/config/version.php');
        $content = $response->getBody();
        if ($content)
            $newVersion = substr($content, 37, 5);
        else
            $newVersion = false;

        if ($this->template->compareVersions($newVersion, $this->config->item('FusionCMSVersion'), true))
            return true;

        return false;
    }

	private function getOsName(): string
	{
        if (strtoupper(substr(PHP_OS_FAMILY, 0, 3)) === 'WIN') {
            $os = substr(php_uname('v'), strpos(strtolower(php_uname('v')), 'windows'), -1);
        } else {
            $build = '';

            if (strpos(php_uname('v'), 'Ubuntu'))
                $build = 'Ubuntu';
            else if (strpos(php_uname('v'), 'Debian'))
                $build = 'Debian';

            $os = PHP_OS_FAMILY . $build;
        }

        return $os;
	}
}
