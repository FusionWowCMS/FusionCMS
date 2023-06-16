<?php

class Bans extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('text');
        $this->load->model('mod_model');
        $this->load->library('moderator');
        requirePermission("view");
    }

    public function index()
    {
        $activeBannedAccs = $this->mod_model->getActiveBans();
        $expiredBannedAccs = $this->mod_model->getExpiredBans();

        $data = array(
            'url' => pageURL,
            'activeBannedAccs' => $activeBannedAccs,
            'expiredBannedAccs' => $expiredBannedAccs,
        );

        $output = $this->template->loadPage("bans.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->moderator->box('Ban list', $output);

        $this->moderator->view($output, false, "modules/mod/js/mod.js");
    }

    public function banAcc($username = "")
    {
        if (!$username || empty($username)) {
            die('Invalid username');
        }

        $bannedBy = $this->user->getUsername();
        $banReason = $this->input->post('reason');
        $dateObject = $this->input->post('date');
        $date = strtotime($dateObject) + 86399; // add 23 hours, 59 minutes and 59 seconds

        if (empty($banReason)) {
            die("Banreason can't be empty");
        }

        if (!is_numeric($date)) {
            die('Invalid date');
        }

        $ban = $this->mod_model->getBan($this->external_account_model->getConnection(), $this->external_account_model->getId($username));

        if (!$username || !$ban)
        {
            die("Invalid username");
        }

        if ($ban['banCount'] == 0) {
            $this->mod_model->setBan($this->external_account_model->getConnection(), $this->external_account_model->getId($username), $bannedBy, $banReason, $date);
        } else {
            //Update ban
            $this->mod_model->updateBan($this->external_account_model->getConnection(), $this->external_account_model->getId($username), $bannedBy, $banReason, $date);
        }

        $this->plugins->onBan($username, $ban['banCount'], $bannedBy, $banReason);
        $this->logger->createModLog("Account banned", $this->external_account_model->getId($username), 1, 1);

        die('1');
    }

    public function unban($id)
    {
        if (!is_numeric($id)) {
            die('Invalid acc id');
        }

        $this->mod_model->unBanAcc($this->external_account_model->getConnection(), $id);

        $this->logger->createModLog("Account unbanned", $id, 1, 1);

        die('1');
    }

    public function banIP()
    {
        $bannedBy = $this->user->getUsername();
        $ip = $this->input->post('ip');
        $banReason = $this->input->post('reason');
        $dateObject = $this->input->post('date');
        $date = strtotime($dateObject) + 86399; // add 23 hours, 59 minutes and 59 seconds

        if (empty($ip)) {
            die("Ip can't be empty");
        }

        if (empty($banReason)) {
            die("Banreason can't be empty");
        }

        if (!is_numeric($date) || empty($date) || is_null($date)) {
            die('Invalid date');
        }

        $this->mod_model->setIPBan($this->external_account_model->getConnection(), $ip, $bannedBy, $banReason, $date);

        $this->logger->createModLog("IP banned", $ip, 1, 1);

        die('1');
    }
}
