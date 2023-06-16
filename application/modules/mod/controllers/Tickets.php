<?php

class Tickets extends MX_Controller
{
    private $id;
    private $name;
    private $class;
    private $className;
    private $race;
    private $raceName;
    private $level;
    private $gender;
    private $account;

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('text');
        $this->load->model('tickets_model');
        $this->load->config('mod_config');
        $this->load->library('moderator');
        requirePermission("view");
    }

    public function index()
    {
        $output = "";

        foreach ($this->realms->getRealms() as $realm) {
            $tickets = $this->tickets_model->getTickets($realm);

            if ($tickets) {
                foreach ($tickets as $key => $value) {
                    $tickets[$key]['name'] = $realm->getCharacters()->getNameByGuid($value['guid']);
                    $tickets[$key]['ago'] = $this->template->formatTime(time() - $value['createTime']) . " ago";
                    $tickets[$key]['message_short'] = character_limiter($value['message'], 20);
                }
            }

            $data = array(
                'url' => pageURL,
                'tickets' => $tickets,
                'hasConsole' => $realm->getEmulator()->hasConsole(),
                'realmId' => $realm->getId(),
                'realmName' => $realm->getName()
            );

            $content = $this->template->loadPage('tickets/tickets.tpl', $data);

            $output .= $this->moderator->box('Tickets', $content);
        }

        $this->moderator->view($output, false, "modules/mod/js/mod.js");
    }

    public function view($realmId, $id)
    {
        if (!$realmId || !$id || !is_numeric($id) || !is_numeric($realmId)) {
            die("Ticket/Realm ID doesn't exist");
        }

        $realm = $this->realms->getRealm($realmId);


        $ticket = $this->tickets_model->getTicket($realm, $id);

        if ($ticket) {
            $character = $this->tickets_model->characterExists($ticket['guid'], $realm->getCharacters()->getConnection(), $realm->getId());
            $this->tickets_model->setId($ticket['guid']);
            $this->tickets_model->setRealm($realmId);
            $character_data = $this->tickets_model->getCharacter();

            if ($character) {
                $ticket['name'] = $realm->getCharacters()->getNameByGuid($ticket['guid']);
                $ticket['createTime'];
                $ticket['message'];
                foreach ($character_data as $key => $value) {
                    $this->$key = $value;
                }
            }
        } else {
            die("Ticket doesn't exist");
        }

        if (in_array($this->race, array(4,10))) {
            if ($this->race == 4) {
                $this->raceName = "Night elf";
            } else {
                $this->raceName = "Blood elf";
            }
        } else {
            $this->raceName = $this->tickets_model->realms->getRace($this->race);
        }

        $this->className = $this->tickets_model->realms->getClass($this->class);
        $avatarArray = array(
            'class' => $this->class,
            'race' => $this->race,
            'level' => $this->level,
            'gender' => $this->gender
        );

        $data = array(
            'url' => pageURL,
            'tickets' => $ticket,
            'hasConsole' => $realm->getEmulator()->hasConsole(),
            'realmId' => $realm->getId(),
            "raceName" => $this->raceName,
            "className" => $this->className,
            "race" => $this->race,
            "class" => $this->class,
            "level" => $this->level,
            "gender" => $this->gender,
            "avatar" => $this->tickets_model->realms->formatAvatarPath($avatarArray),
            "status" => $this->realms->getRealm($realmId)->getCharacters()->isOnline($ticket['guid']),
            "account" => $this->account
        );

        $output = $this->template->loadPage('tickets/tickets_view.tpl', $data);

        $content = $this->moderator->box('Ticket #' . $id . '', $output);

        $this->moderator->view($output, false, "modules/mod/js/mod.js");
    }

    public function unstuck($realmId = false, $id = false)
    {
        if (!$realmId || !$id || !is_numeric($id) || !is_numeric($realmId)) {
            die('Invalid values');
        }

        //Get the realm
        $realm = $this->realms->getRealm($realmId);

        //Get the ticket
        $ticket = $this->tickets_model->getTicket($realm, $id);

        if ($ticket) {
            //Check if the character is offline and exists.
            $character_exists = $this->tickets_model->characterExists($ticket['guid'], $realm->getCharacters()->getConnection(), $realm->getId());

            if ($this->realms->getRealm($realmId)->getCharacters()->isOnline($ticket['guid'])) {
                die('Character is online');
            }

            if ($character_exists) {
                $x = $this->config->item('mod_unstuck_position_x');
                $y = $this->config->item('mod_unstuck_position_y');
                $z = $this->config->item('mod_unstuck_position_z');
                $o = $this->config->item('mod_unstuck_orientation');
                $m = $this->config->item('mod_unstuck_map');

                $this->tickets_model->setLocation($x, $y, $z, $o, $m, $ticket['guid'], $realm->getCharacters()->getConnection(), $realm->getId());

                $this->plugins->onUnstuck($realmId, $ticket['guid'], $x, $y, $z, $o, $m);

                $this->logger->createModLog("Character unstucked", $ticket['guid'], 0, $realmId);

                die('1');
            } else {
                //Die 2 to mark failure because char is online.
                die('2');
            }
        } else {
            die('2');
        }
    }

    public function answer($realmId = false, $id = false)
    {
        if (!$realmId || !$id || !is_numeric($id) || !is_numeric($realmId)) {
            die('Invalid values');
        }

        //Get the realm
        $realm = $this->realms->getRealm($realmId);

        //Get the ticket
        $ticket = $this->tickets_model->getTicket($realm, $id);

        if (!$realm->isOnline(true)) {
            die("Realm is offline");
        }

        if ($ticket) {
            $title = $this->config->item('mod_answertitle');
            $body = $this->input->post('message');
            if (strlen($body) >= 8000) {
                die(lang("message_too_long", "mod"));
            }

            $realm->getEmulator()->sendMail($realm->getCharacters()->getNameByGuid($ticket['guid']), $title, $body);

            $this->plugins->onAnswer($realmId, $ticket['guid'], $title, $body);

            $this->logger->createModLog("Answered to ticket #" . $ticket['id'] . "", $ticket['guid'], 0, $realmId);

            die('1');
        } else {
            die('2');
        }
    }

    public function close($realmId = false, $id = false)
    {
        if (!$realmId || !$id || !is_numeric($id) || !is_numeric($realmId)) {
            die('Invalid values');
        }

        //Get the realm
        $realm = $this->realms->getRealm($realmId);

        //Get the ticket
        $ticket = $this->tickets_model->getTicket($realm, $id);

        if (column("gm_tickets", "completed")) {
            //A row exists, update it
            $this->tickets_model->setTicketCompleted($realm->getCharacters()->getConnection(), $id, $realm->getId());
            die('1');
        } else {
            //Remove it
            $this->tickets_model->deleteTicket($realm->getCharacters()->getConnection(), $id, $realm->getId());
            die('1');
        }

        $this->plugins->onClose($realmId, $id);
        $this->logger->createModLog("Ticket #" . $ticket['id'] . " closed", $ticket['guid'], 0, $realmId);
    }

    public function kick($realmId = false, $charName = false)
    {
        if (!$realmId || !$charName || !is_numeric($realmId)) {
            die('Invalid values');
        }

        //Get the realm
        $realm = $this->realms->getRealm($realmId);

        if (!$realm->isOnline(true)) {
            die('Realm is offline');
        }

        if ($realm->getEmulator()->hasConsole() == true) {
            $realm->getEmulator()->send($this->config->item('mod_kickcommand') . " " . $charName);

            $this->plugins->onKick($realmId, $charName);
            $this->logger->createModLog("Character kicked", $realm->getCharacters()->getGuidByName($charName), 0, $realmId);
            die('1');
        } else {
            die('Emulator doesn\'t support console');
        }
    }
}
