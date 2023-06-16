<?php

/**
 * Abstraction layer for supporting different emulators
 */

class Mop_soap implements Emulator
{
    protected $config;

    /**
     * Whether or not this emulator supports remote console
     */
    protected $hasConsole = true;

    /**
     * Whether or not this emulator supports character stats
     */
    protected $hasStats = true;

    /**
     * Console object
     */
    protected $console;

    /**
     * Encryption
     */
    protected $encryption = 'SPH';
    protected $battlenet = false;

    /**
     * Array of expansion ids and their corresponding names
     */
    protected $expansions = array(
        4 => "Mists of Pandaria",
        3 => "Cataclysm",
        2 => "WotLK",
        1 => "TBC",
        0 => "None"
    );

    /**
     * Array of table names
     */
    protected $tables = array(
        "account"         => "account",
        "account_access"  => "account_access",
        "account_banned"  => "account_banned",
        'ip_banned'       => 'ip_banned',
        "characters"      => "characters",
        "item_template"   => "item_template",
        "character_stats" => "character_stats",
        "guild_member"    => "guild_member",
        "guild"           => "guild",
        "gm_tickets"      => "gm_tickets"
    );

    /**
     * Array of column names
     */
    protected $columns = array(

        "account" => array(
            "id"         => "id",
            "username"   => "username",
            "password"   => "sha_pass_hash",
            "email"      => "email",
            "joindate"   => "joindate",
            "last_ip"    => "last_ip",
            "last_login" => "last_login",
            "expansion"  => "expansion",
            "v"          => "v",
            "s"          => "s",
            "sessionkey" => "sessionkey"
        ),

        "account_access" => array(
            "id"      => "id",
            "gmlevel" => "gmlevel"
        ),

        "account_banned" => array(
            "id"        => "id",
            "banreason" => "banreason",
            "active"    => "active",
            "bandate"   => "bandate",
            "unbandate" => "unbandate",
            "bannedby"  => "bannedby"
        ),

        'ip_banned' => array(
            'ip'        => 'ip',
            'bandate'   => 'bandate',
            'unbandate' => 'unbandate',
            'bannedby'  => 'bannedby',
            'banreason' => 'banreason',
        ),

        "characters" => array(
            "guid"             => "guid",
            "account"          => "account",
            "name"             => "name",
            "race"             => "race",
            "class"            => "class",
            "gender"           => "gender",
            "level"            => "level",
            "zone"             => "zone",
            "online"           => "online",
            "money"            => "money",
            "totalKills"       => "totalKills",
            "totalHonorPoints" => "totalHonorPoints",
            "position_x"       => "position_x",
            "position_y"       => "position_y",
            "position_z"       => "position_z",
            "orientation"      => "orientation",
            "map"              => "map"
        ),

        "item_template" => array(
            "entry"         => "entry",
            "name"          => "name",
            "Quality"       => "Quality",
            "InventoryType" => "InventoryType",
            "RequiredLevel" => "RequiredLevel",
            "ItemLevel"     => "ItemLevel",
            "class"         => "class",
            "subclass"      => "subclass"
        ),

        "character_stats" => array(
            "guid"          => "guid",
            "maxhealth"     => "maxhealth",
            "maxpower1"     => "maxpower1",
            "maxpower2"     => "maxpower2",
            "maxpower3"     => "maxpower3",
            "maxpower4"     => "maxpower4",
            "maxpower5"     => "maxpower5",
            "maxpower6"     => "maxpower6",
            "maxpower7"     => "maxpower7",
            "strength"      => "strength",
            "agility"       => "agility",
            "stamina"       => "stamina",
            "intellect"     => "intellect",
            "spirit"        => "spirit",
            "armor"         => "armor",
            "blockPct"      => "blockPct",
            "dodgePct"      => "dodgePct",
            "parryPct"      => "parryPct",
            "critPct"       => "critPct",
            "rangedCritPct" => "rangedCritPct",
            "spellCritPct"  => "spellCritPct",
            "attackPower"   => "attackPower",
            "spellPower"    => "spellPower",
            "resilience"    => "resilience"
        ),

        "guild" => array(
            "guildid"    => "guildid",
            "name"       => "name",
            "leaderguid" => "leaderguid"
        ),

        "guild_member" => array(
            "guildid" => "guildid",
            "guid"    => "guid"
        ),

        "gm_tickets" => array(
            "ticketId"   => "ticketId",
            "guid"       => "guid",
            "message"    => "message",
            "createTime" => "createTime",
            "completed"  => "completed",
            "closedBy"   => "closedBy"
        )
    );

    /**
     * Array of queries
     */
    protected $queries = array(
        "get_character" => "SELECT * FROM characters WHERE guid=?",
        "get_item" => "SELECT entry, Flags, name, Quality, bonding, InventoryType, MaxDurability, RequiredLevel, ItemLevel, class, subclass, delay, socketColor_1, socketColor_2, socketColor_3, spellid_1, spellid_2, spellid_3, spellid_4, spellid_5, spelltrigger_1, spelltrigger_2, spelltrigger_3, spelltrigger_4, spelltrigger_5, displayid, stat_type1, stat_value1, stat_type2, stat_value2, stat_type3, stat_value3, stat_type4, stat_value4, stat_type5, stat_value5, stat_type6, stat_value6, stat_type7, stat_value7, stat_type8, stat_value8, stat_type9, stat_value9, stat_type10, stat_value10, stackable FROM item_template WHERE entry=?",
        "get_rank" => "SELECT id id, gmlevel gmlevel, RealmID RealmID FROM account_access WHERE id=?",
        "get_banned" => "SELECT id id, bandate bandate, bannedby bannedby, banreason banreason, active active FROM account_banned WHERE id=? AND active=1",
        "get_account_id" => "SELECT id id, username username, sha_pass_hash password, email email, joindate joindate, last_ip last_ip, last_login last_login, expansion expansion FROM account WHERE id = ?",
        "get_account" => "SELECT id id, username username, sha_pass_hash password, email email, joindate joindate, last_ip last_ip, last_login last_login, expansion expansion FROM account WHERE username = ?",
        "get_charactername_by_guid" => "SELECT name name FROM characters WHERE guid = ?",
        "find_guilds" => "SELECT g.guildid guildid, g.name name, COUNT(g_m.guid) GuildMemberCount, g.leaderguid leaderguid, c.name leaderName FROM guild g, guild_member g_m, characters c WHERE g.leaderguid = c.guid AND g_m.guildid = g.guildid AND g.name LIKE ? GROUP BY g.guildid",
        "get_inventory_item" => "SELECT slot slot, item item, itemEntry itemEntry FROM character_inventory, item_instance WHERE character_inventory.item = item_instance.guid AND character_inventory.slot >= 0 AND character_inventory.slot <= 18 AND character_inventory.guid=? AND character_inventory.bag=0",
        "get_guild_members" => "SELECT m.guildid guildid, m.guid guid, c.name name, c.race race, c.class class, c.gender gender, c.level level, m.rank member_rank, r.rname rname, r.rights rights FROM guild_member m JOIN guild_rank r ON m.guildid = r.guildid AND m.rank = r.rid JOIN characters c ON c.guid = m.guid WHERE m.guildid = ? ORDER BY r.rights DESC",
        "get_guild" => "SELECT guildid guildid, name guildName, leaderguid leaderguid, motd motd, createdate createdate FROM guild WHERE guildid = ?"
    );

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * Get the name of a table
     *
     * @param  String $name
     * @return String
     */
    public function getTable($name)
    {
        if (array_key_exists($name, $this->tables)) {
            return $this->tables[$name];
        }
    }

    /**
     * Get the name of a column
     *
     * @param  String $table
     * @param  String $name
     * @return String
     */
    public function getColumn($table, $name)
    {
        if (array_key_exists($table, $this->columns) && array_key_exists($name, $this->columns[$table])) {
            return $this->columns[$table][$name];
        }
    }

    /**
     * Get a set of all columns
     *
     * @param  String $name
     * @return String
     */
    public function getAllColumns($table)
    {
        if (array_key_exists($table, $this->columns)) {
            return $this->columns[$table];
        }
    }

    /**
     * Get a pre-defined query
     *
     * @param  String $name
     * @return String
     */
    public function getQuery($name)
    {
        if (array_key_exists($name, $this->queries)) {
            return $this->queries[$name];
        }
    }

    /**
     * Expansion getter
     *
     * @return Array
     */
    public function getExpansions()
    {
        return $this->expansions;
    }

    /**
     * Get the name of an expansion by the id
     *
     * @param  Int $id
     * @return String
     */
    public function getExpansionName($id)
    {
        if (array_key_exists($id, $this->expansions)) {
            return $this->expansions[$id];
        }
    }

    /**
     * Get the name of an expansion by the name
     *
     * @param  String $name
     * @return Int
     */
    public function getExpansionId($name)
    {
        if (in_array($name, $this->expansions)) {
            return array_search($name, $this->expansions);
        }
    }

    /**
     * Whether or not console actions are enabled for this emulator
     *
     * @return Boolean
     */
    public function hasConsole()
    {
        return $this->hasConsole;
    }

    /**
     * Get encryption for this emulator
     *
     * @return String
     */
    public function encryption()
    {
        return $this->encryption;
    }

    /**
     * Whether or not emulator uses battlenet accounts
     *
     * @return Boolean
     */
    public function battlenet()
    {
        return $this->battlenet;
    }

    /**
     * Whether or not character stats are logged in the database
     *
     * @return Boolean
     */
    public function hasStats()
    {
        return $this->hasStats;
    }

    /**
     * Password encryption
     */
    public function encrypt($username, $password)
    {
        if (!is_string($username)) {
            $username = "";
        }
        if (!is_string($password)) {
            $password = "";
        }
        $sha_pass_hash = sha1(strtoupper($username) . ':' . strtoupper($password));

        return array(
           "verifier" => $sha_pass_hash
        );
    }

    /**
     * Send mail via ingame mail to a specific character
     *
     * @param String $character
     * @param String $subject
     * @param String $body
     */
    public function sendMail($character, $subject, $body)
    {
        $this->send(".send mail " . $character . " \"" . $subject . "\" \"" . $body . "\"");
    }

    /**
     * Send console command
     *
     * @param String $command
     */
    public function sendCommand($command)
    {
        $this->send($command);
    }

    /**
     * Send items via ingame mail to a specific character
     *
     * @param String $character
     * @param String $subject
     * @param String $body
     * @param Array $items
     */
    public function sendItems($character, $subject, $body, $items)
    {
        $item_command = array();
        $mail_id = 0;
        $item_count = 0;
        $item_stacks = array();

        foreach ($items as $i) {
            // Check if item has been added
            if (array_key_exists($i['id'], $item_stacks)) {
                // If stack is full
                if ($item_stacks[$i['id']]['max_count'] == $item_stacks[$i['id']]['count'][$item_stacks[$i['id']]['stack_id']]) {
                    // Create a new stack
                    $item_stacks[$i['id']]['stack_id']++;
                    $item_stacks[$i['id']]['count'][$item_stacks[$i['id']]['stack_id']] = 0;
                }

                // Add one to the currently active stack
                $item_stacks[$i['id']]['count'][$item_stacks[$i['id']]['stack_id']]++;
            } else {
                // Load the item row
                $item_row = get_instance()->realms->getRealm($this->config['id'])->getWorld()->getItem($i['id']);

                // Add the item to the stacks array
                $item_stacks[$i['id']] = array(
                    'id' => $i['id'],
                    'count' => array(1),
                    'stack_id' => 0,
                    'max_count' => $item_row['stackable']
                );
            }
        }

        // Loop through all items
        foreach ($item_stacks as $item) {
            foreach ($item['count'] as $count) {
                // Limit to 8 items per mail
                if ($item_count > 8) {
                    // Reset item count
                    $item_count = 0;

                    // Queue a new mail
                    $mail_id++;
                }

                // Increase the item count
                $item_count++;

                if (!isset($item_command[$mail_id])) {
                    $item_command[$mail_id] = "";
                }

                // Append the command
                $item_command[$mail_id] .= " " . $item['id'] . ":" . $count;
            }
        }

        // Send all the queued mails
        for ($i = 0; $i <= $mail_id; $i++) {
            // .send item
            $this->send("send items " . $character . " \"" . $subject . "\" \"" . $body . "\"" . $item_command[$i]);
        }
    }

    /**
     * Send a console command
     *
     * @param  String $command
     * @return Array
     */
    public function send($command)
    {
        $client = new SoapClient(
            null,
            array(
                "location" => "http://" . $this->config['hostname'] . ":" . $this->config['console_port'],
                "uri" => "urn:SF",
                'login' => $this->config['console_username'],
                'password' => $this->config['console_password']
            )
        );

        try {
            $result = $client->executeCommand(new SoapParam($command, "command"));
        } catch (Exception $e) {
            die("Something went wrong! An administrator has been noticed and will send your order as soon as possible.<br /><br /><b>Error:</b> <br />" . $e->getMessage());
        }
    }
}
