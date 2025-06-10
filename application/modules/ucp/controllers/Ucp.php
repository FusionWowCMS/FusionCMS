<?php

use MX\MX_Controller;

/**
 * Ucp Controller Class
 * @property ucp_model $ucp_model ucp_model Class
 */
class Ucp extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->user->userArea();

        $this->load->config('links');

        $this->load->library("dblogger");
    }

    public function index()
    {
        requirePermission("view");

        $this->template->setTitle(lang("user_panel", "ucp"));

        $recent_activity = $this->dblogger->getLogs('user', 0, 5, $this->user->getId(), ['login', 'logout', 'recovery', 'service']);

        $recent_activities = [];
        foreach ($recent_activity as $activityLog) {
            $time = date("H:i", $activityLog['time']);
            $date = date("Y-m-d", $activityLog['time']);
            $today = date("Y-m-d");
            $yesterday = date("Y-m-d", strtotime("-1 day"));

            if ($date == $today) {
                $date_label = lang('today', 'ucp');
            } elseif ($date == $yesterday) {
                $date_label = lang('yesterday', 'ucp');
            } else {
                $date_label = date("F j, Y", $activityLog['time']);
            }

            $activity_time = "{$date_label}, {$time} — " . lang('ip', 'ucp') . ": {$activityLog['ip']}";
            $title = '';
            $icon = '';

            switch ($activityLog['event']) {
                case 'login':
                    $title = lang('account_login', 'ucp');
                    $icon = 'fa-sign-in-alt';
                    break;
                case 'logout':
                    $title = lang('account_logout', 'ucp');
                    $icon = 'fa-sign-out-alt';
                    break;
                case 'recovery':
                    $title = lang('account_recovery', 'ucp');
                    $icon = 'fa-clock-rotate-left';
                    break;
                case 'donate':
                    $title = lang('donate', 'main') . ": {$activityLog['message']} | " . lang('donation_points', 'main') . ": {$activityLog['custom']}";
                    $icon = 'fa-circle-dollar-to-slot';
                    break;
                case 'service':
                    $title = "{$activityLog['message']} | " . lang('character', 'ucp') . ": {$activityLog['custom']}";
                    $icon = ' fa-users-gear';
                    break;
                default:
                    break;
            }

            $recent_activities[] = [
                'icon' => $icon,
                'title' => $title,
                'event' => strtolower($activityLog['event']),
                'activity_time' => $activity_time,
            ];
        }

        $data = [
            "username" => $this->user->getUsername(),
            "nickname" => $this->user->getNickname(),
            "vp" => $this->internal_user_model->getVp(),
            "dp" => $this->internal_user_model->getDp(),
            "url" => $this->template->page_url,
            "location" => $this->internal_user_model->getLocation(),
            "total_votes" => $this->internal_user_model->getTotalVotes(),
            "groups" => $this->acl_model->getGroupsByUser($this->user->getId()),
            "register_date" => $this->user->getRegisterDate(),
            "status" => $this->user->getAccountStatus(),
            "avatar" => $this->user->getAvatar($this->user->getId()),
            "id" => $this->user->getId(),

            "config" => [
                "vote" => $this->config->item('ucp_vote'),
                "donate" => $this->config->item('ucp_donate'),
                "store" => $this->config->item('ucp_store'),
                "settings" => $this->config->item('ucp_settings'),
                "security" => $this->config->item('ucp_security'),
                "teleport" => $this->config->item('ucp_teleport'),
                "admin" => $this->config->item('ucp_admin'),
                "gm" => $this->config->item('ucp_mod')
            ],

            "characters" => $this->realms->getTotalCharacters(),
            "realms" => $this->realms->getRealms(),
            "realmObj" => $this->realms,
            "recent_activity" => $recent_activities,
        ];
        
        $data['email'] = false;

        if ($this->user->getEmail())
        {
            $data['email'] = $this->mask_email($this->user->getEmail());
        }

        $this->template->view($this->template->loadPage("page.tpl", [
            "module" => "default",
            "headline" => lang("user_panel", "ucp"),
            "content" => $this->template->loadPage("ucp.tpl", $data)
        ]), "modules/ucp/css/ucp.css");
    }

    public function characters()
    {
        $characters_data = [
            "characters" => $this->realms->getTotalCharacters(),
            "realms" => $this->realms->getRealms(),
            "url" => $this->template->page_url,
            "realmObj" => $this->realms,
            "avatar" => $this->user->getAvatar($this->user->getId()),

            "config" => [
                "vote" => $this->config->item('ucp_vote'),
                "donate" => $this->config->item('ucp_donate'),
                "store" => $this->config->item('ucp_store'),
                "settings" => $this->config->item('ucp_settings'),
                "security" => $this->config->item('ucp_security'),
                "teleport" => $this->config->item('ucp_teleport'),
                "admin" => $this->config->item('ucp_admin'),
                "gm" => $this->config->item('ucp_mod')
            ]
        ];

        $content = $this->template->loadPage("ucp_characters.tpl", $characters_data);
        $this->template->view($content, "modules/ucp/css/ucp.css");
    }
	
    private function mask_email($email)
    {
        $mail_parts = explode("@", $email);
        $len = strlen($mail_parts[0]);

        $mail_parts[0] = substr($mail_parts[0], 0, 2).str_repeat('*', 5).substr($mail_parts[0], $len - 1, 2); // show first 2 letters and last 1 letter

        return implode("@", $mail_parts);
    }
}
