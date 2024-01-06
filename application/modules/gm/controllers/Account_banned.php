<?php

use MX\MX_Controller;

class Account_banned extends MX_Controller
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
		clientLang("day", "gm");

        $AccountsBanActive = $this->gm_model->getAccountsBan($this->external_account_model->getConnection(), 1);
        $AccountsBanExpired = $this->gm_model->getAccountsBan($this->external_account_model->getConnection(), 0);

        $data = array(
            'url' => pageURL,
            'link_active' => 'account_banned',
            'accountsBanActive' => $AccountsBanActive,
            'accountsBanExpired' => $AccountsBanExpired,
        );

        $content = $this->template->loadPage('account_banned.tpl', $data);

        $output = $this->template->box(breadcumb(array(
            "gm" => lang("gm_panel", "gm"),
            "gm/account_banned" => lang("banned_account_list", "gm")
            )), $content);

		$this->template->view($output, "modules/gm/css/gm.css", "modules/gm/js/gm.js");
	}

    public function unban($id)
    {
        requirePermission("unban");

        if (!$id || !is_numeric($id)) {
            die(lang("invalid", "gm"));
        }

        $this->gm_model->setUnBanAccount($this->external_account_model->getConnection(), $id);

        $this->logger->createGMLog("Account unbanned", $id, 'account', 1);

        die('1');
    }
}