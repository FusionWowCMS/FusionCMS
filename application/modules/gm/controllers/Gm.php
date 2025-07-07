<?php

use MX\MX_Controller;

/**
 * Gm Controller Class
 * @property gm_model $gm_model gm_model Class
 */
class Gm extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        requirePermission("view");

        $this->load->helper('text');
        $this->load->model('gm_model');
        $this->load->config('gm_config');
    }

    public function index(): void
    {
        // Pass a language strings to client side
        clientLang("account_name", "gm");
        clientLang("ban_reason", "gm");
        clientLang("account", "gm");
        clientLang("has_been_banned", "gm");
        clientLang("character_name", "gm");
        clientLang("character_has_been_kicked", "gm");
        clientLang("close_ticket", "gm");
        clientLang("close_short", "gm");
        clientLang("ban_short", "gm");
        clientLang("kick_short", "gm");
        clientLang("send", "gm");
        clientLang("mail_sent", "gm");
        clientLang("teleported", "gm");
        clientLang("must_be_offline", "gm");
        clientLang("item_sent", "gm");
        clientLang("day", "gm");

        $data = [];

        foreach($this->realms->getRealms() as $realm)
        {
            $data[$realm->getId()]['name'] = $realm->getName();
            $data[$realm->getId()]['id'] = $realm->getId();
            $data[$realm->getId()]['hasConsole'] = $realm->getEmulator()->hasConsole();
            $tickets = $this->gm_model->getTickets($realm);

            if($tickets)
            {
                foreach($tickets as $key => $value)
                {
                    $tickets[$key]['name'] = $realm->getCharacters()->getNameByGuid($value['guid']);
                    $tickets[$key]['ago'] = $this->template->formatTime(time() - $value['createTime']) . " ago";
                    $tickets[$key]['message_short'] = character_limiter($value['message'], 20);
                }
            }
            $data[$realm->getId()]['tickets'] = $tickets;
        }

        $content_data = [
            'url' => pageURL,
            'link_active' => 'gm',
            'realms' => $data,
            'disable_items' => $this->config->item('gm_disable_send_item')
        ];

        $content = $this->template->loadPage('gm.tpl', $content_data);

        $output = $this->template->box(lang('gm_panel', 'gm'), $content);

        $this->template->view($output, "modules/gm/css/gm.css", "modules/gm/js/gm.js");
    }

    public function sendItem($realmId = false, $id = false)
    {
        requirePermission("sendItem");

        if(!$realmId || !$id || !is_numeric($id) || !is_numeric($realmId))
        {
            die(lang("invalid", "gm"));
        }

        //get the realm object
        $realm = $this->realms->getRealm($realmId);

        //Get the ticket from the database
        $ticket = $this->gm_model->getTicket($realm, $id);

        if($ticket)
        {
            //Set parameters
            $itemId = [['id' => $this->input->post('item')]];
            
            $title = $this->config->item('gm_senditemtitle');
            $body = $this->config->item('gm_senditembody');
            if(strlen($body) >= 8000)
                die(lang("message_too_long", "gm"));

            //Send the email
            $realm->getEmulator()->sendItems($realm->getCharacters()->getNameByGuid($ticket['guid']), $title, $body, $itemId);

            $this->dblogger->createGMLog("Send Item with ticket " . $id, $ticket['guid'], 'characters', $realmId);

            //Finish
            die('1');
        }
        else
        {
            die('2');
        }
        
    }

    public function unstuck($realmId = false, $id = false)
    {
        requirePermission("unstuck");

        if(!$realmId || !$id || !is_numeric($id) || !is_numeric($realmId))
        {
            die(lang("invalid", "gm"));
        }

        //Get the realm
        $realm = $this->realms->getRealm($realmId);

        //Get the ticket
        $ticket = $this->gm_model->getTicket($realm, $id);

        if($ticket)
        {
            //Check if the character is offline and exists.
            $character_exists = $this->gm_model->characterExists($ticket['guid'], $realm->getCharacters()->getConnection(), $realm->getId());

            if($character_exists)
            {
                $x = $this->config->item('gm_unstuck_position_x');
                $y = $this->config->item('gm_unstuck_position_y');
                $z = $this->config->item('gm_unstuck_position_z');
                $o = $this->config->item('gm_unstuck_orientation');
                $m = $this->config->item('gm_unstuck_map');

                $this->gm_model->setLocation($x, $y, $z, $o, $m, $ticket['guid'], $realm->getCharacters()->getConnection(), $realm->getId());

                $this->dblogger->createGMLog("Unstuck with ticket " . $id, $ticket['guid'], 'characters', $realmId);

                //Die('1') to mark success
                die('1');
            }
            else
            {
                //Die 2 to mark failure because char is online.
                die('3');
            }
        }
        else
        {
            die('2');
        }
    }

    public function answer($realmId = false, $id = false)
    {
        requirePermission("answer");

        if(!$realmId || !$id || !is_numeric($id) || !is_numeric($realmId))
        {
            die(lang("invalid", "gm"));
        }

        //Get the realm
        $realm = $this->realms->getRealm($realmId);

        //Get the ticket
        $ticket = $this->gm_model->getTicket($realm, $id);

        if($ticket)
        {
            $title = $this->config->item('gm_answertitle');
            $body = $this->input->post('message');
            if(strlen($body) >= 8000)
                die(lang("message_too_long", "gm"));

            $realm->getEmulator()->sendMail($realm->getCharacters()->getNameByGuid($ticket['guid']), $title, $body);

            $this->dblogger->createGMLog("Ticket Answer " . $id, $ticket['guid'], 'characters', $realmId);

            die('1');
        }
        else
        {
            die('2');
        }
    }

    public function close($realmId = false, $id = false)
    {
        requirePermission("answer");

        if(!$realmId || !$id || !is_numeric($id) || !is_numeric($realmId))
        {
            die(lang("invalid", "gm"));
        }

        //Get the realm
        $realm = $this->realms->getRealm($realmId);

        //Get the ticket
        $ticket = $this->gm_model->getTicket($realm, $id);

        if($realm->getEmulator()->hasConsole())
        {
            $realm->getEmulator()->send(".ticket close " . $id);

            $this->dblogger->createGMLog("Ticket Close " . $id, $ticket['guid'], 'ticket', $realmId);

            die('1');
        }
        else
        {
            die('2');
        }
    }

    public function kick($realmId = false, $charName = false)
    {
        requirePermission("kick");

        if(!$realmId || !$charName || !is_numeric($realmId))
        {
            die(lang("invalid", "gm"));
        }

        //Get the realm
        $realm = $this->realms->getRealm($realmId);

        if($realm->getEmulator()->hasConsole())
        {
            $realm->getEmulator()->send($this->config->item('gm_kickcommand')." ".$charName);

            $this->dblogger->createGMLog("Kick", $realm->getCharacters()->getGuidByName($charName), 'characters', $realmId);

            die('1');
        }
        else
        {
            die('2');
        }
    }

    public function ban($username = "")
    {
        requirePermission("ban");

        $bannedBy = $this->user->getUsername();
        $banReason = $this->input->post('reason');
        $day = $this->input->post('day');

        if(!$username || !$day || !is_numeric($day) || $day < 1)
        {
            die(lang("invalid", "gm"));
        }

        $ban = $this->gm_model->getBan($this->external_account_model->getConnection(), $this->external_account_model->getId($username));
        
        if($ban['banCount'] == 0)
        {
            $this->gm_model->setBan($this->external_account_model->getConnection(), $this->external_account_model->getId($username), $bannedBy, $banReason, $day * 3600 * 24);
        }
        else 
        {
            //Update the row.
            $this->gm_model->updateBan($this->external_account_model->getConnection(), $this->external_account_model->getId($username), $bannedBy, $banReason, $day * 3600 * 24);
        }

        $this->dblogger->createGMLog("Ban Account", $this->external_account_model->getId($username), 'account', 1);

        die('1');
    }
}