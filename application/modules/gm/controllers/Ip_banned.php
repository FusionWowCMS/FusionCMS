<?php

use MX\MX_Controller;

/**
 * Ip_banned Controller Class
 * @property gm_model $gm_model gm_model Class
 */
class Ip_banned extends MX_Controller
{
	public function __construct()
	{
		parent::__construct();

		requirePermission("view");

		$this->load->helper('text');
		$this->load->model('gm_model');
	}

	public function index(): void
    {
		// Pass a language strings to client side
		clientLang("account_name", "gm");
		clientLang("ban_reason", "gm");
		clientLang("account", "gm");
		clientLang("has_been_banned", "gm");
		clientLang("character_name", "gm");
		clientLang("ip", "gm");
		clientLang("day", "gm");

        $ipsBanned = $this->gm_model->getIPsBan($this->external_account_model->getConnection());

        $data = array(
            'url' => pageURL,
            'link_active' => 'ip_banned',
            'ipsBanned' => $ipsBanned,
        );

        $content = $this->template->loadPage('ip_banned.tpl', $data);

        $output = $this->template->box(breadcrumb([
            "gm" => lang("gm_panel", "gm"),
            "gm/account_banned" => lang("banned_ip_list", "gm")
            ]), $content);

		$this->template->view($output, "modules/gm/css/gm.css", "modules/gm/js/gm.js");
	}

    public function banIP()
    {
        requirePermission("ban");
        $bannedBy = $this->user->getUsername();
        $ip = $this->input->post('ip');
        $banReason = $this->input->post('reason');
        $day = $this->input->post('day');

        if (empty($ip)) {
            die("Ip can't be empty");
        }

        if (empty($banReason)) {
            die("Ban Reason can't be empty");
        }

        if (!$day || !is_numeric($day) || $day < 1) {
            die('Invalid day');
        }

        $this->gm_model->setBanIP($this->external_account_model->getConnection(), $ip, $bannedBy, $banReason, $day);

        $this->dblogger->createGMLog("IP banned", $ip, 'ip', 1);

        die('1');
    }

    public function unbanIP()
    {
        requirePermission("unban");

        $ip = $this->input->post('ip');

        if (empty($ip)) {
            die(lang("invalid", "gm"));
        }

        $this->gm_model->setUnBanIP($this->external_account_model->getConnection(), $ip);

        $this->dblogger->createGMLog("Ip UnBanned", $ip, 'ip', 1);

        die('1');
    }
}