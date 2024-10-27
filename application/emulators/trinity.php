<?php

use MX\CI;

defined('BASEPATH') or die('Silence is golden.');

/**
 * @package FusionCMS
 * @version 6.x
 */

/**
 * Abstraction layer for supporting different emulators
 */
class Trinity implements Emulator
{
    protected $config;

    /**
     * Whether or not this emulator supports remote console
     */
    protected bool $hasConsole = true;

    /**
     * Whether or not this emulator supports character stats
     */
    protected bool $hasStats = true;

    /**
     * Console object
     */
    protected $console;

    /**
     * Array of table names
     */
    protected $tables = [
        'account'           => 'account',
        'account_access'    => 'account_access',
        'account_banned'    => 'account_banned',
        'ip_banned'         => 'ip_banned',
        'characters'        => 'characters',
        'item_template'     => 'item_template',
        'character_stats'   => 'character_stats',
        'guild_member'      => 'guild_member',
        'guild'             => 'guild',
        'gm_tickets'        => 'gm_ticket',
        'arena_team'        => 'arena_team',
        'arena_team_member' => 'arena_team_member',
    ];

    /**
     * Array of column names
     */
    protected $columns = [

        'account' => [
            'id'            => 'id',
            'username'      => 'username',
            'sha_pass_hash' => 'sha_pass_hash',
            'salt'          => 'salt',
            'verifier'      => 'verifier',
            'email'         => 'email',
            'joindate'      => 'joindate',
            'last_ip'       => 'last_ip',
            'last_login'    => 'last_login',
            'expansion'     => 'expansion',
        ],

        'account_access' => [
            'id'      => 'AccountId', 
            'gmlevel' => 'SecurityLevel'
        ],

        'account_banned' => [
            'id'        => 'id',
            'banreason' => 'banreason',
            'active'    => 'active',
            'bandate'   => 'bandate',
            'unbandate' => 'unbandate',
            'bannedby'  => 'bannedby'
        ],

        'ip_banned' => [
            'ip'        => 'ip',
            'bandate'   => 'bandate',
            'unbandate' => 'unbandate',
            'bannedby'  => 'bannedby',
            'banreason' => 'banreason',
        ],

        'characters' => [
            'guid'             => 'guid',
            'account'          => 'account',
            'name'             => 'name',
            'race'             => 'race',
            'class'            => 'class',
            'gender'           => 'gender',
            'level'            => 'level',
            'zone'             => 'zone',
            'online'           => 'online',
            'money'            => 'money',
            'totalKills'       => 'totalKills',
            'todayKills'       => 'todayKills',
            'yesterdayKills'   => 'yesterdayKills',
            'arenaPoints'      => 'arenaPoints',
            'totalHonorPoints' => 'totalHonorPoints',
            'position_x'       => 'position_x',
            'position_y'       => 'position_y',
            'position_z'       => 'position_z',
            'orientation'      => 'orientation',
            'map'              => 'map'
        ],

        'item_template' => [
            'entry'         => 'entry',
            'name'          => 'name',
            'Quality'       => 'Quality',
            'InventoryType' => 'InventoryType',
            'RequiredLevel' => 'RequiredLevel',
            'ItemLevel'     => 'ItemLevel',
            'class'         => 'class',
            'subclass'      => 'subclass'
        ],

        'character_stats' => [
            'guid'          => 'guid',
            'maxhealth'     => 'maxhealth',
            'maxpower1'     => 'maxpower1',
            'maxpower2'     => 'maxpower2',
            'maxpower3'     => 'maxpower3',
            'maxpower4'     => 'maxpower4',
            'maxpower5'     => 'maxpower5',
            'maxpower6'     => 'maxpower6',
            'maxpower7'     => 'maxpower7',
            'strength'      => 'strength',
            'agility'       => 'agility',
            'stamina'       => 'stamina',
            'intellect'     => 'intellect',
            'spirit'        => 'spirit',
            'armor'         => 'armor',
            'blockPct'      => 'blockPct',
            'dodgePct'      => 'dodgePct',
            'parryPct'      => 'parryPct',
            'critPct'       => 'critPct',
            'rangedCritPct' => 'rangedCritPct',
            'spellCritPct'  => 'spellCritPct',
            'attackPower'   => 'attackPower',
            'spellPower'    => 'spellPower',
            'resilience'    => 'resilience'
        ],

        'guild' => [
            'guildid'    => 'guildid',
            'name'       => 'name',
            'leaderguid' => 'leaderguid'
        ],

        'guild_member' => [
            'guildid' => 'guildid',
            'guid'    => 'guid'
        ],

        'gm_tickets' => [
            'ticketId'   => 'Id',
            'guid'       => 'playerGuid',
            'message'    => 'description',
            'createTime' => 'createTime',
            'completed'  => 'completed',
            'closedBy'   => 'closedBy'
        ],

        'arena_team' => [
            'arenaTeamId'  => 'arenaTeamId',
            'teamName'     => 'name',
            'captainGuid'  => 'captainGuid',
            'teamRating'   => 'rating',
            'teamRank'     => 'rank',
            'teamType'     => 'type',
            'seasonGames'  => 'seasonGames',
            'seasonWins'   => 'seasonWins',
            'weekGames'    => 'weekGames',
            'weekWins'     => 'weekWins',
        ],

        'arena_team_member' => [
            'arenaTeamId'   => 'arenaTeamId',
            'guid'          => 'guid',
            'rating'        => 'personalRating',
            'seasonGames'   => 'seasonGames',
            'seasonWins'    => 'seasonWins',
            'weekGames'     => 'weekGames',
            'weekWins'      => 'weekWins',
            'teamType'      => 'type',
        ]
    ];

    /**
     * Array of queries
     */
    protected array $queries = [
        'get_ip_banned'             => 'SELECT ip, bandate, bannedby, banreason, unbandate FROM ip_banned WHERE ip=? AND unbandate > ?',
        'get_character'             => 'SELECT * FROM characters WHERE guid=?',
        'get_item'                  => 'SELECT entry, Flags, name, displayid, Quality, bonding, InventoryType, MaxDurability, armor, RequiredLevel, ItemLevel, class, subclass, dmg_min1, dmg_max1, dmg_type1, holy_res, fire_res, nature_res, frost_res, shadow_res, arcane_res, delay, socketColor_1, socketColor_2, socketColor_3, spellid_1, spellid_2, spellid_3, spellid_4, spellid_5, spelltrigger_1, spelltrigger_2, spelltrigger_3, spelltrigger_4, spelltrigger_5, displayid, stat_type1, stat_value1, stat_type2, stat_value2, stat_type3, stat_value3, stat_type4, stat_value4, stat_type5, stat_value5, stat_type6, stat_value6, stat_type7, stat_value7, stat_type8, stat_value8, stat_type9, stat_value9, stat_type10, stat_value10, stackable, socketBonus, AllowableClass, AllowableRace FROM item_template WHERE entry=?',
        'get_rank'                  => 'SELECT AccountId id, SecurityLevel gmlevel, RealmID RealmID FROM account_access WHERE AccountId=?',
        'get_banned'                => 'SELECT id id, bandate bandate, bannedby bannedby, banreason banreason, active active FROM account_banned WHERE id=? AND active=1',
        'get_charactername_by_guid' => 'SELECT name name FROM characters WHERE guid = ?',
        'find_guilds'               => 'SELECT g.guildid guildid, g.name name, COUNT(g_m.guid) GuildMemberCount, g.leaderguid leaderguid, c.name leaderName FROM guild g, guild_member g_m, characters c WHERE g.leaderguid = c.guid AND g_m.guildid = g.guildid AND g.name LIKE ? GROUP BY g.guildid',
        'get_inventory_item'        => 'SELECT slot slot, item item, itemEntry itemEntry, enchantments enchantments FROM character_inventory, item_instance WHERE character_inventory.item = item_instance.guid AND character_inventory.slot >= 0 AND character_inventory.slot <= 18 AND character_inventory.guid=? AND character_inventory.bag=0',
        'get_guild_members'         => 'SELECT m.guildid guildid, m.guid guid, c.name name, c.race race, c.class class, c.gender gender, c.level level, m.rank member_rank, r.rname rname, r.rights rights FROM guild_member m JOIN guild_rank r ON m.guildid = r.guildid AND m.rank = r.rid JOIN characters c ON c.guid = m.guid WHERE m.guildid = ? ORDER BY r.rights DESC',
        'get_guild'                 => 'SELECT guildid guildid, name guildName, leaderguid leaderguid, motd motd, createdate createdate FROM guild WHERE guildid = ?',
        'get_arena_team'            => 'SELECT `arena_team_member`.`arenaTeamId` AS arenateamid, `arena_team`.`name` AS teamName, `arena_team`.`rating` AS teamRating, `arena_team`.`rank` AS teamRank FROM `arena_team_member`, `arena_team` WHERE `arena_team_member`.`guid` = ? AND `arena_team`.`arenaTeamId` = `arena_team_member`.`arenaTeamId` AND `arena_team`.`type` = ? LIMIT 1',
        'get_arena_team_member'     => 'SELECT `arena_team_member`.`guid`, `arena_team_member`.`personalRating` AS rating, `arena_team_member`.`seasonGames` AS games, `arena_team_member`.`seasonWins` AS wins, `characters`.`name`, `characters`.`class`, `characters`.`race`, `characters`.`level` FROM `arena_team_member` RIGHT JOIN `characters` ON `characters`.`guid` = `arena_team_member`.`guid` WHERE `arena_team_member`.`arenateamid` = ? ORDER BY guid ASC'
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
     * Send console command
     *
     * @param String $command
     */
    public function sendCommand($command, $realm = false)
    {
        $this->send($command, $realm);
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
     * Send money via ingame mail to a specific character
     *
     * @param String $character
     * @param String $subject
     * @param String $text
     * @param String $money
     */
    public function sendMoney($character, $subject, $text, $money)
    {
        $this->send(".send money " . $character . " \"" . $subject . "\" \"" . $text . "\" " . $money);
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
        $item_command = [];
        $mail_id = 0;
        $item_count = 0;
        $item_stacks = [];

        foreach ($items as $i) {
            // Check if item has been added
            if (!isset($item_stacks[$i['id']])) {
                // Load the item row
                $item_row = CI::$APP->realms->getRealm($this->config['id'])->getWorld()->getItem($i['id']);

                // Add the item to the stacks array
                $item_stacks[$i['id']] = [
                    'id'        => $i['id'],
                    'count'     => [1],
                    'stack_id'  => 0,
                    'max_count' => $item_row['stackable'],
                ];

                continue;
            }

            // If stack is full
            if ($item_stacks[$i['id']]['max_count'] == $item_stacks[$i['id']]['count'][$item_stacks[$i['id']]['stack_id']]) {
                // Create a new stack
                $item_stacks[$i['id']]['stack_id']++;
                $item_stacks[$i['id']]['count'][$item_stacks[$i['id']]['stack_id']] = 0;
            }

            // Add one to the currently active stack
            $item_stacks[$i['id']]['count'][$item_stacks[$i['id']]['stack_id']]++;
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
                    $item_command[$mail_id] = '';
                }

                // Append the command
                $item_command[$mail_id] .= ' ' . $item['id'] . ':' . $count;
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
    public function send($command, $realm = false)
    {
        $blacklistCommands = ['account set', 'server shutdown', 'server exit', 'server restart', 'disable add', 'disable remove'];

        foreach ($blacklistCommands as $blacklist) {
            if (strpos($command, $blacklist))
                die("Something went wrong! There is no access to execute this command." . ($realm ? '<br/><br/><b>Realm:</b> <br />' . $realm->getName() : ''));
        }

        $client = new SoapClient(null, [
            'location' => 'http://' . $this->config['hostname'] . ':' . $this->config['console_port'],
            'uri'      => 'urn:TC',
            'login'    => $this->config['console_username'],
            'password' => $this->config['console_password'],
        ]); // ..opens a new socket to the server using the initial configs

        try {
            $client->executeCommand(new SoapParam($command, 'command'));
        } catch (Exception $e) {
            die('Something went wrong! An administrator has been noticed and will send your order as soon as possible.<br/><br/>
                <b>Error:</b> <br/>' . $e->getMessage()); // @note this isn't dev friendly and make impossible to catch errors
        }
    }
}
