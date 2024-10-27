<?php

use MX\CI;

/**
 * Abstraction layer for supporting different emulators
 */

class Oregoncore implements Emulator
{
    protected $config;

    /**
     * Whether or not this emulator supports remote console
     */
    protected bool $hasConsole = true;

    /**
     * Whether or not this emulator supports character stats
     */
    protected bool $hasStats = false;

    /**
     * Console object
     */
    protected $console;

    /**
     * Array of table names
     */
    protected $tables = [
        "account"            => "account",
        "account_access"     => "account_access",
        "account_banned"     => "account_banned",
        "characters"         => "characters",
        "item_template"      => "item_template",
        "character_stats"    => "character_stats",
        "guild_member"       => "guild_member",
        "guild"              => "guild",
        "gm_tickets"         => "gm_tickets",
        'arena_team'         => 'arena_team',
        'arena_team_member'  => 'arena_team_member',
        'arena_team_stats'   => 'arena_team_member',
    ];

    /**
     * Array of column names
     */
    protected array $columns = [

        "account" => [
            "id"            => "id",
            "username"      => "username",
            "sha_pass_hash" => "sha_pass_hash",
            "email"         => "email",
            "joindate"      => "joindate",
            "last_ip"       => "last_ip",
            "last_login"    => "last_login",
            "expansion"     => "expansion",
            "v"             => "v",
            "s"             => "s",
            "sessionkey"    => "sessionkey"
        ],

        "account_access" => [
            "id"      => "id",
            "gmlevel" => "gmlevel"
        ],

        "account_banned" => [
            "id"        => "id",
            "banreason" => "banreason",
            "active"    => "active",
            "bandate"   => "bandate",
            "unbandate" => "unbandate",
            "bannedby"  => "bannedby"
        ],

        "characters" => [
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
            "position_x"       => "position_x",
            "position_y"       => "position_y",
            "position_z"       => "position_z",
            "orientation"      => "orientation",
            "map"              => "map",
            "totalKills"       => "totalKills",
            "arenaPoints"      => "arenaPoints",
            "totalHonorPoints" => "totalHonorPoints"
        ],

        "item_template" => [
            "entry"         => "entry",
            "name"          => "name",
            "Quality"       => "Quality",
            "InventoryType" => "InventoryType",
            "RequiredLevel" => "RequiredLevel",
            "ItemLevel"     => "ItemLevel",
            "class"         => "class",
            "subclass"      => "subclass"
        ],

        "character_stats" => [],

        "guild" => [
            "guildid"    => "guildid",
            "name"       => "name",
            "leaderguid" => "leaderguid"
        ],

        "guild_member" => [
            "guildid"  => "guildid",
            "guid"     => "guid"
        ],

        "gm_tickets" => [
            "ticketId" => "guid",
            "guid" => "playerGuid",
            "message" => "message",
            "createTime" => "createtime",
            "completed" => "closed",
        ],

        'arena_team' => [
            'arenaTeamId'  => 'arenateamid',
            'teamName'     => 'name',
            'captainGuid'  => 'captainguid',
            'teamType'     => 'type',
        ],

        'arena_team_member' => [
            'arenaTeamId'   => 'arenateamid',
            'guid'          => 'guid',
            'rating'        => 'personal_rating',
            'games'         => 'played_season',
            'wins'          => 'wons_season',
            'weekGames'     => 'played_week',
            'weekWins'      => 'wons_week',
            'teamType'      => 'type',
        ],

        'arena_team_stats' => [
            'arenaTeamId'  => 'arenateamid',
            'teamRating'   => 'rating',
            'teamRank'     => 'rank',
            'seasonGames'  => 'games',
            'seasonWins'   => 'wins',
        ]
    ];

    /**
     * Array of queries
     */
    protected array $queries = [
        "get_ip_banned"             => "SELECT ip, bandate, bannedby, banreason, unbandate FROM ip_banned WHERE ip=? AND unbandate > ?",
        "pvp_character"             => "SELECT * FROM characters WHERE totalKills > 0 ORDER BY totalKills DESC LIMIT ",
        "get_character"             => "SELECT * FROM characters WHERE guid=?",
        "get_item"                  => "SELECT entry, Flags, name, displayid, Quality, bonding, InventoryType, MaxDurability, armor, RequiredLevel, ItemLevel, class, subclass, dmg_min1, dmg_max1, dmg_type1, holy_res, fire_res, nature_res, frost_res, shadow_res, arcane_res, delay, socketColor_1, socketColor_2, socketColor_3, spellid_1, spellid_2, spellid_3, spellid_4, spellid_5, spelltrigger_1, spelltrigger_2, spelltrigger_3, spelltrigger_4, spelltrigger_5, displayid, stat_type1, stat_value1, stat_type2, stat_value2, stat_type3, stat_value3, stat_type4, stat_value4, stat_type5, stat_value5, stat_type6, stat_value6, stat_type7, stat_value7, stat_type8, stat_value8, stat_type9, stat_value9, stat_type10, stat_value10, stackable, socketBonus, AllowableClass, AllowableRace FROM item_template WHERE entry=?",
        "get_rank"                  => "SELECT id id, gmlevel gmlevel FROM account_access WHERE id=?",
        "get_banned"                => "SELECT id id, bandate bandate, bannedby bannedby, banreason banreason, active active FROM account_banned WHERE id=? AND active=1",
        "get_charactername_by_guid" => "SELECT name name FROM characters WHERE guid = ?",
        "find_guilds"               => "SELECT g.guildid guildid, g.name name, COUNT(g_m.guid) GuildMemberCount, g.leaderguid leaderguid, c.name leaderName FROM guild g, guild_member g_m, characters c WHERE g.leaderguid = c.guid AND g_m.guildid = g.guildid AND g.name LIKE ? GROUP BY g.guildid",
        "get_inventory_item"        => "SELECT slot slot, item item, item_template itemEntry, enchantments enchantments FROM character_inventory, item_instance WHERE character_inventory.item = item_instance.guid AND character_inventory.slot >= 0 AND character_inventory.slot <= 18 AND character_inventory.guid=? AND character_inventory.bag=0",
        "get_guild_members"         => "SELECT m.guildid guildid, m.guid guid, c.name name, c.race race, c.class class, c.gender gender, c.level level, m.rank rank, r.rname rname, r.rights rights FROM guild_member m, guild_rank r, characters c WHERE m.guildid = r.guildid AND m.rank = r.rid AND c.guid = m.guid AND m.guildid = ? ORDER BY r.rights DESC",
        "get_guild"                 => "SELECT guildid guildid, name guildName, leaderguid leaderguid, motd motd, createdate createdate FROM guild WHERE guildid = ?",
        'get_arena_team'            => 'SELECT `arena_team_member`.`arenateamid`, `arena_team`.`name` AS teamName, `arena_team_stats`.`rating` AS teamRating, `arena_team_stats`.`rank` AS teamRank FROM `arena_team_member`, `arena_team`, `arena_team_stats` WHERE `arena_team_member`.`guid` = ? AND `arena_team`.`arenateamid` = `arena_team_member`.`arenateamid` AND `arena_team`.`arenateamid` = `arena_team_stats`.`arenateamid` AND `arena_team`.`type` = ? LIMIT 1',
        'get_arena_team_member'     => 'SELECT `arena_team_member`.`guid`, `arena_team_member`.`personal_rating` AS rating, `arena_team_member`.`played_season` AS games, `arena_team_member`.`wons_season` AS wins, `characters`.`name`, `characters`.`class`, `characters`.`race`, `characters`.`level` FROM `arena_team_member` RIGHT JOIN `characters` ON `characters`.`guid` = `arena_team_member`.`guid` WHERE `arena_team_member`.`arenateamid` = ? ORDER BY guid ASC'

    ];

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * Get the name of a table
     *
     * @param String $name
     * @return string|null
     */
    public function getTable($name): string|null
    {
        if (array_key_exists($name, $this->tables)) {
            return $this->tables[$name];
        }

        return null;
    }

    /**
     * Get the name of a column
     *
     * @param String $table
     * @param String $name
     * @return string|null
     */
    public function getColumn($table, $name): string|null
    {
        if (array_key_exists($table, $this->columns) && array_key_exists($name, $this->columns[$table])) {
            return $this->columns[$table][$name];
        }

        return null;
    }

    /**
     * Get a set of all columns
     *
     * @param $table
     * @return array|string|null
     */
    public function getAllColumns($table): array|string|null
    {
        if (array_key_exists($table, $this->columns)) {
            return $this->columns[$table];
        }

        return null;
    }

    /**
     * Get a pre-defined query
     *
     * @param String $name
     * @return string|null
     */
    public function getQuery($name): string|null
    {
        if (array_key_exists($name, $this->queries)) {
            return $this->queries[$name];
        }

        return null;
    }

    /**
     * Whether or not console actions are enabled for this emulator
     *
     * @return Boolean
     */
    public function hasConsole(): bool
    {
        return $this->hasConsole;
    }

    /**
     * Whether or not character stats are logged in the database
     *
     * @return Boolean
     */
    public function hasStats(): bool
    {
        return $this->hasStats;
    }

    /**
     * Send mail via ingame mail to a specific character
     * @param String $character
     * @param String $subject
     * @param String $body
     */
    public function sendMail($character, $subject, $body)
    {
        $this->send("sendmail ".$character." \"".$subject."\" \"".$body."\"");
    }

    /**
     * Send console command
     *
     * @param String $command
     */
    public function sendCommand($command, $realm = false)
    {
        $this->send($command, $realm);
    }

    /**
     * Send items via ingame mail to a specific character
     * @param String $character
     * @param String $subject
     * @param String $body
     * @param Array $items
     */
    public function sendItems($character, $subject, $body, $items)
    {
        $item_command = [];
        $mail_id = 0;
        $item_count = 0;
        $item_stacks = [];

        foreach($items as $i)
        {
            // Check if item has been added
            if(array_key_exists($i['id'], $item_stacks))
            {
                // If stack is full
                if($item_stacks[$i['id']]['max_count'] == $item_stacks[$i['id']]['count'][$item_stacks[$i['id']]['stack_id']])
                {
                    // Create a new stack
                    $item_stacks[$i['id']]['stack_id']++;
                    $item_stacks[$i['id']]['count'][$item_stacks[$i['id']]['stack_id']] = 0;
                }

                // Add one to the currently active stack
                $item_stacks[$i['id']]['count'][$item_stacks[$i['id']]['stack_id']]++;
            }
            else
            {
                // Load the item row
                $item_row = get_instance()->realms->getRealm($this->config['id'])->getWorld()->getItem($i['id']);

                // Add the item to the stacks array
                $item_stacks[$i['id']] = [
                    'id' => $i['id'],
                    'count' => [1],
                    'stack_id' => 0,
                    'max_count' => $item_row['stackable']
                ];
            }
        }

        // Loop through all items
        foreach($item_stacks as $item)
        {
            foreach($item['count'] as $count)
            {
                // Limit to 8 items per mail
                if($item_count > 8)
                {
                    // Reset item count
                    $item_count = 0;

                    // Queue a new mail
                    $mail_id++;
                }

                // Increase the item count
                $item_count++;

                if(!isset($item_command[$mail_id]))
                {
                    $item_command[$mail_id] = "";
                }

                // Append the command
                $item_command[$mail_id] .= " ".$item['id'].":".$count;
            }
        }

        // Send all the queued mails
        for($i = 0; $i <= $mail_id; $i++)
        {
            // .send item
            $this->send("senditems ".$character." \"".$subject."\" \"".$body."\"".$item_command[$i]);
        }
    }

    /**
     * Send a console command
     *
     * @param  String $command
     * @return void
     */
    public function send($command, $realm = false)
    {
        $blacklistCommands = ['account set', 'server shutdown', 'server exit', 'server restart', 'disable add', 'disable remove'];

        foreach ($blacklistCommands as $blacklist) {
            if (strpos($command, $blacklist))
                die("Something went wrong! There is no access to execute this command." . ($realm ? '<br/><br/><b>Realm:</b> <br />' . $realm->getName() : ''));
        }

        $client = new SoapClient(NULL,
            [
                "location" => "http://".$this->config['hostname'].":".$this->config['console_port'],
                "uri" => "urn:Oregon",
                'login' => $this->config['console_username'],
                'password' => $this->config['console_password']
            ]
        );

        try {
            $client->executeCommand(new SoapParam($command, "command"));
        }
        catch (Exception $e) {
            die("Something went wrong! An administrator has been noticed and will send your order as soon as possible.<br /><br /><b>Error:</b> <br />" . $e->getMessage() . ($realm ? '<br/><br/><b>Realm:</b> <br />' . $realm->getName() : ''));
        }
    }
}