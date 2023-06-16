<?php

class Pay extends MX_Controller
{
    private $vp;
    private $dp;

    public function __construct()
    {
        parent::__construct();

        $this->vp = 0;
        $this->dp = 0;

        $this->user->userArea();

        $this->load->model("store_model");
        $this->load->config("store");

        requirePermission("view");
    }

    /**
     * Main method to serve the checkout action
     */
    public function index()
    {
        $cart = $this->input->post("data");

        // Make sure they sent us a cart object
        if (!$cart) {
            die("Please provide a cart object");
        }

        try {
            // Decode the JSON object
            $cart = json_decode($cart, true);
        } catch (Exception $error) {
            die("Please provide a valid cart object");
        }

        // Make sure they don't submit an empty array
        if (count($cart) == 0) {
            die(lang("empty_cart", "store"));
        }

        $items = array();

        // Load all items
        foreach ($cart as $item) {
            // Load the item
            $items[$item['id']] = $this->store_model->getItem($item['id']);

            // Make sure the item exists
            if ($items[$item['id']] != false && in_array($item['type'], array('vp', 'dp'))) {
                // Keep track of how much it costs
                if ($item['type'] == "vp" && !empty($items[$item['id']]['vp_price'])) {
                    $this->vp += $items[$item['id']]['vp_price'];
                } elseif ($item['type'] == "dp" && !empty($items[$item['id']]['dp_price'])) {
                    $this->dp += $items[$item['id']]['dp_price'];
                } else {
                    die(lang("free_items", "store"));
                }
            } else {
                die('Invalid item');
            }
        }

        // Make sure the user can afford it
        if (!$this->canAfford()) {
            $output = $this->template->loadPage("checkout_error.tpl", array('link' => true, 'url' => $this->template->page_url));

            die($output);
        }

        // An array to hold all items in a sub-array for each realm
        $realmItems = array();

        // Make sure all realms are online
        foreach ($cart as $item) {
            $realm = $this->realms->getRealm($items[$item['id']]['realm']);

            // Create a realm item array if it doesn't exist
            if (!isset($realmItems[$realm->getId()])) {
                $realmItems[$realm->getId()] = array();
            }

            if (!$realm->isOnline(true)) {
                $data = array('type' => 'offline', 'url' => $this->template->page_url);
                $output = $this->template->loadPage("failure.tpl", $data);

                die($output);
            }
        }

        // Send all items
        foreach ($cart as $item) {
            // Is it a query or command?
            if (empty($items[$item['id']]['query']) && empty($items[$item['id']]['command'])) {
                // Make sure they enter a character
                if (!isset($item['character'])) {
                    $output = $this->template->loadPage("failure.tpl", array('type' => 'character', 'url' => $this->template->page_url));

                    die($output);
                }

                // Make sure the character exists
                if (!$this->realms->getRealm($items[$item['id']]['realm'])->getCharacters()->characterExists($item['character'])) {
                    $output = $this->template->loadPage("failure.tpl", array('type' => 'character_exists', 'url' => $this->template->page_url));

                    die($output);
                }

                // Make sure the character belongs to this account
                if (!$this->realms->getRealm($items[$item['id']]['realm'])->getCharacters()->characterBelongsToAccount($item['character'], $this->user->getId())) {
                    $output = $this->template->loadPage("failure.tpl", array('type' => 'character_not_mine', 'url' => $this->template->page_url));

                    die($output);
                }

                // Make sure the character array exists in the realm array
                if (!isset($realmItems[$items[$item['id']]['realm']][$item['character']])) {
                    $realmItems[$items[$item['id']]['realm']][$item['character']] = array();
                }

                // Check for multiple items
                if (preg_match("/,/", $items[$item['id']]['itemid'])) {
                    // Split it per item ID
                    $temp = explode(",", $items[$item['id']]['itemid']);

                    // Loop through the item IDs
                    foreach ($temp as $id) {
                        // Add them individually to the array
                        array_push($realmItems[$items[$item['id']]['realm']][$item['character']], array('id' => $id));
                    }
                } else {
                    array_push($realmItems[$items[$item['id']]['realm']][$item['character']], array('id' => $items[$item['id']]['itemid']));
                }
            } elseif (!empty($items[$item['id']]['command'])) {
                // Make sure the realm actually supports console commands
                if (!$this->realms->getRealm($items[$item['id']]['realm'])->getEmulator()->hasConsole()) {
                    $output = $this->template->loadPage("failure.tpl", array('type' => 'no_console', 'url' => $this->template->page_url));

                    die($output);
                }
            }

            // Make sure the character is offline, if this item requires it
            if ($items[$item['id']]['require_character_offline'] && $this->realms->getRealm($items[$item['id']]['realm'])->getCharacters()->isOnline($item['character'])) {
                $output = $this->template->loadPage("failure.tpl", array('type' => 'character_not_offline', 'url' => $this->template->page_url));

                die($output);
            }
        }

        // Let the user pay before we start sending any items!
        $this->subtractPoints();

        $this->store_model->logOrder($this->vp, $this->dp, $cart);

        foreach ($cart as $item) {
            // Is it a query?
            if (!empty($items[$item['id']]['query'])) {
                $this->handleQuery($items[$item['id']]['query'], $items[$item['id']]['query_database'], (isset($item['character']) ? $item['character'] : false), $items[$item['id']]['realm']);
            }
            // Or a command?
            elseif (!empty($items[$item['id']]['command'])) {
                $commands = preg_split('/\r\n|\r|\n/', $items[$item['id']]['command']);

                foreach ($commands as $command) {
                    $command = preg_replace("/\{ACCOUNT\}/", $this->external_account_model->getUsername(), $command);
                    $command = preg_replace("/\{CHARACTER\}/", (isset($item['character']) ? $this->realms->getRealm($items[$item['id']]['realm'])-> getCharacters()->getNameByGuid($item['character']) : false), $command);

                    $this->realms->getRealm($items[$item['id']]['realm'])->getEmulator()->sendCommand($command);
                }
            }
        }

        // Loop through all realms
        foreach ($realmItems as $realm => $characters) {
            // Loop through all characters
            foreach ($characters as $character => $items) {
                $characterName = $this->realms->getRealm($realm)->getCharacters()->getConnection()->query(query("get_charactername_by_guid"), array($character));
                $characterName = $characterName->result_array();

                $this->realms->getRealm($realm)->getEmulator()->sendItems($characterName[0]['name'], $this->config->item("store_subject"), $this->config->item("store_body"), $items);
            }
        }

        // Load the checkout view
        $output = $this->template->loadPage("success.tpl", array('url' => $this->template->page_url, 'message' => $this->config->item('success_message')));

        $this->store_model->completeOrder();

        $this->plugins->onCompleteOrder($cart);

        // Output the content
        die($output);
    }

    /**
     * Update the user's VP and DP
     */
    private function subtractPoints()
    {
        $this->user->setVp($this->user->getVp() - $this->vp);
        $this->user->setDp($this->user->getDp() - $this->dp);
    }

    /**
     * Handle custom queries
     *
     * @param String $query
     * @param String $database
     * @param Int $character
     * @param Int $realm
     */
    private function handleQuery($query_raw, $database, $character, $realm)
    {
        $queries = explode(";", $query_raw);

        foreach ($queries as $query) {
            switch ($database) {
                case "cms":
                    $db = $this->load->database("cms", true);
                    break;

                case "realmd":
                    $db = $this->external_account_model->getConnection();
                    break;

                case "realm":
                    $db = $this->realms->getRealm($realm)->getCharacters()->getConnection();
                    break;

                    //When none of the above were entered return false.
                default:
                    return false;
            }

            $data = array(
                0 => $this->user->getId(),
                1 => $character,
                2 => $realm
            );

            $positions = array(
                'account' => strpos($query, "{ACCOUNT}"),
                'character' => strpos($query, "{CHARACTER}"),
                'realm' => strpos($query, "{REALM}")
            );

            asort($positions);
            $positions = array_reverse($positions);

            foreach ($positions as $key => $value) {
                if (!is_numeric($value) || empty($value)) {
                    switch ($key) {
                        case "account":
                            array_splice($data, 0, 1);
                            break;

                        case "character":
                            array_splice($data, 1, 1);
                            break;

                        case "realm":
                            array_splice($data, 2, 1);
                            break;
                    }
                }
            }

            $query = preg_replace("/\{ACCOUNT\}/", "?", $query);
            $query = preg_replace("/\{CHARACTER\}/", "?", $query);
            $query = preg_replace("/\{REALM\}/", "?", $query);

            $db->query($query, $data);
        }
    }

    /**
     * Check if the user can afford what he's trying to buy
     *
     * @return Boolean
     */
    private function canAfford()
    {
        if ($this->vp > 0 && $this->vp > $this->user->getVp()) {
            return false;
        } elseif ($this->dp > 0 && $this->dp > $this->user->getDp()) {
            return false;
        } else {
            return true;
        }
    }
}
