<?php

class Data_model extends CI_Model
{
    public $realm;
    private $connection;
    private $emuStr = false;
    private $statements = array();

    public function __construct()
    {
        parent::__construct();

        /* Let's prepare our SQL statements */
        $this->statements['trinity'] = array(
            'TopArenaTeams' => "SELECT `arenaTeamId` AS arenateamid, `rating`, `rank`, `name`, `captainGuid` AS captain, `type` FROM `arena_team` WHERE `type` = ? ORDER BY rating DESC LIMIT ?;",
            'TeamMembers' => "SELECT 
                                    `arena_team_member`.`arenaTeamId` AS arenateamid, 
                                    `arena_team_member`.`guid` AS guid, 
                                    `arena_team_member`.`personalRating` AS rating,
                                    `arena_team_member`.`seasonGames` AS games,
                                    `arena_team_member`.`seasonWins` AS wins,
                                    `characters`.`name` AS name,
                                    `characters`.`class` AS class,
                                    `characters`.`level` AS level
                                FROM `arena_team_member` 
                                RIGHT JOIN `characters` ON `characters`.`guid` = `arena_team_member`.`guid` 
                                WHERE `arena_team_member`.`arenateamid` = ? ORDER BY guid ASC;",
            'TopHKPlayers' => "SELECT `guid`, `name`, `level`, `race`, `class`, `gender`, `totalKills` AS kills FROM `characters` WHERE `totalKills` > 0 ORDER BY `totalKills` DESC LIMIT ?;"
        );

        $this->statements['azerothcore'] = array(
            'TopArenaTeams' => "SELECT `arenaTeamId` AS arenateamid, `rating`, `rank`, `name`, `captainGuid` AS captain, `type` FROM `arena_team` WHERE `type` = ? ORDER BY rating DESC LIMIT ?;",
            'TeamMembers' => "SELECT 
                                    `arena_team_member`.`arenaTeamId` AS arenateamid, 
                                    `arena_team_member`.`guid` AS guid, 
                                    `arena_team_member`.`personalRating` AS rating,
                                    `arena_team_member`.`seasonGames` AS games,
                                    `arena_team_member`.`seasonWins` AS wins,
                                    `characters`.`name` AS name,
                                    `characters`.`class` AS class,
                                    `characters`.`level` AS level
                                FROM `arena_team_member` 
                                RIGHT JOIN `characters` ON `characters`.`guid` = `arena_team_member`.`guid` 
                                WHERE `arena_team_member`.`arenateamid` = ? ORDER BY guid ASC;",
            'TopHKPlayers' => "SELECT `guid`, `name`, `level`, `race`, `class`, `gender`, `totalKills` AS kills FROM `characters` WHERE `totalKills` > 0 ORDER BY `totalKills` DESC LIMIT ?;"
        );

        $this->statements['azerothcore_sph'] = array(
            'TopArenaTeams' => "SELECT `arenaTeamId` AS arenateamid, `rating`, `rank`, `name`, `captainGuid` AS captain, `type` FROM `arena_team` WHERE `type` = ? ORDER BY rating DESC LIMIT ?;",
            'TeamMembers' => "SELECT 
                                    `arena_team_member`.`arenaTeamId` AS arenateamid, 
                                    `arena_team_member`.`guid` AS guid, 
                                    `arena_team_member`.`personalRating` AS rating,
                                    `arena_team_member`.`seasonGames` AS games,
                                    `arena_team_member`.`seasonWins` AS wins,
                                    `characters`.`name` AS name,
                                    `characters`.`class` AS class,
                                    `characters`.`level` AS level
                                FROM `arena_team_member` 
                                RIGHT JOIN `characters` ON `characters`.`guid` = `arena_team_member`.`guid` 
                                WHERE `arena_team_member`.`arenateamid` = ? ORDER BY guid ASC;",
            'TopHKPlayers' => "SELECT `guid`, `name`, `level`, `race`, `class`, `gender`, `totalKills` AS kills FROM `characters` WHERE `totalKills` > 0 ORDER BY `totalKills` DESC LIMIT ?;"
        );

        $this->statements['mop'] = array(
            'TopArenaTeams' => "SELECT `arenaTeamId` AS arenateamid, `rating`, `rank`, `name`, `captainGuid` AS captain, `type` FROM `arena_team` WHERE `type` = ? ORDER BY rating DESC LIMIT ?;",
            'TeamMembers' => "SELECT 
                                    `arena_team_member`.`arenaTeamId` AS arenateamid, 
                                    `arena_team_member`.`guid` AS guid, 
                                    `arena_team_member`.`personalRating` AS rating,
                                    `arena_team_member`.`seasonGames` AS games,
                                    `arena_team_member`.`seasonWins` AS wins,
                                    `characters`.`name` AS name,
                                    `characters`.`class` AS class,
                                    `characters`.`level` AS level
                                FROM `arena_team_member` 
                                RIGHT JOIN `characters` ON `characters`.`guid` = `arena_team_member`.`guid` 
                                WHERE `arena_team_member`.`arenateamid` = ? ORDER BY guid ASC;",
            'TopHKPlayers' => "SELECT `guid`, `name`, `level`, `race`, `class`, `gender`, `totalKills` AS kills FROM `characters` WHERE `totalKills` > 0 ORDER BY `totalKills` DESC LIMIT ?;"
        );

        $this->statements['cmangos'] = array(
            'TopArenaTeams' => "SELECT `arena_team`.`arenateamid` AS arenateamid, 
                                        `arena_team_stats`.`rating` AS rating, 
                                        `arena_team_stats`.`rank` AS rank, 
                                        `arena_team`.`name` AS name, 
                                        `arena_team`.`captainguid` AS captain, 
                                        `arena_team`.`type` AS type
                                    FROM `arena_team`, `arena_team_stats`
                                    WHERE `arena_team`.`arenateamid` = `arena_team_stats`.`arenateamid` AND `arena_team`.`type` = ? 
                                    ORDER BY `arena_team_stats`.`rating` DESC LIMIT ?;",
            'TeamMembers' => "SELECT 
                                    `arena_team_member`.`arenateamid` AS arenateamid, 
                                    `arena_team_member`.`guid` AS guid, 
                                    `arena_team_member`.`personal_rating` AS rating,
                                    `arena_team_member`.`played_season` AS games,
                                    `arena_team_member`.`wons_season` AS wins,
                                    `characters`.`name` AS name,
                                    `characters`.`class` AS class,
                                    `characters`.`level` AS level
                                FROM `arena_team_member` 
                                RIGHT JOIN `characters` ON `characters`.`guid` = `arena_team_member`.`guid` 
                                WHERE `arena_team_member`.`arenateamid` = ? ORDER BY guid ASC;",
            'TopHKPlayers' => "SELECT `guid`, `name`, `level`, `race`, `class`, `gender`, `totalKills` AS kills FROM `characters` WHERE `totalKills` > 0 ORDER BY `totalKills` DESC LIMIT ?;"
        );
    }

    public function GetStatement($key)
    {
        if (!$this->emuStr) {
            return false;
        }

        if (!isset($this->statements[$this->emuStr][$key])) {
            return false;
        }

        return $this->statements[$this->emuStr][$key];
    }

    /**
     * Assign the realm object to the model
     */
    public function setRealm($id)
    {
        $this->realm = $this->realms->getRealm($id);

        $replace      = array(
            '_ra',
            '_soap',
            '_rbac'
        );
        //Remove the ra/soap crap
        $this->emuStr = str_replace($replace, '', $this->realm->getConfig('emulator'));
    }

    /**
     * Connect to the character database
     */
    public function connect()
    {
        $this->realm->getCharacters()->connect();
        $this->connection = $this->realm->getCharacters()->getConnection();
    }

    /***************************************
     *            TOP ARENA FUNCTIONS
     ***************************************/

    public function getTeams($count = 5, $type = 2)
    {
        //make sure the count param is digit
        if (!ctype_digit($count)) {
            $count = 5;
        }

        $this->connect();

        $result = $this->connection->query($this->GetStatement('TopArenaTeams'), array(
            $type,
            $count
        ));

        if ($result && $result->num_rows() > 0) {
            $teams = $result->result_array();

            // Get the team members
            if ($teams) {
                foreach ($teams as $key => $arr) {
                    $members = $this->getTeamMembers((int)$arr['arenateamid']);
                    //Save the team members
                    $teams[$key]['members'] = $members;
                }
            }
            return $teams;
        }

        unset($result);

        return false;
    }

    public function getTeamMembers($team)
    {
        // Different handling for arcemu
        if ($this->emuStr == 'arcemu') {
            return $this->getTeamMembersArcemu($team);
        }

        $this->connect();

        $result = $this->connection->query($this->GetStatement('TeamMembers'), array(
            $team
        ));

        if ($result && $result->num_rows() > 0) {
            return $result->result_array();
        }

        unset($result);
        return false;
    }

    public function getTeamMembersArcemu($team)
    {
        $this->connect();

        $result = $this->connection->query($this->GetStatement('TeamMembers'), array(
            $team
        ));

        if ($result && $result->num_rows() > 0) {
            $members = array();
            $row     = $result->result_array();
            $row     = $row[0];

            // Get the team members
            for ($i = 1; $i <= 10; $i++) {
                if ($row['player_data' . $i] == '') {
                    continue;
                }

                list($guid, $weekGames, $weekWins, $seasonGames, $seasonWins, $rating) = explode(' ', $row['player_data' . $i]);

                settype($guid, "integer");

                // Check if there is a player at this pos
                if ($guid == 0) {
                    continue;
                }

                //Get some character data
                $result2 = $this->connection->query($this->GetStatement('Character'), array(
                    $guid
                ));

                if ($result2 && $result2->num_rows() > 0) {
                    $char = $result2->result_array();
                    $char = $char[0];

                    array_push($members, array(
                        'guid' => $guid,
                        'rating' => $rating,
                        'games' => $seasonGames,
                        'wins' => $seasonWins,
                        'name' => $char['name'],
                        'class' => $char['class'],
                        'level' => $char['level']
                    ));

                    unset($char);
                }
                unset($result2, $guid, $weekGames, $weekWins, $seasonGames, $seasonWins, $rating);
            }
            unset($row);

            //check if the team has any players
            if (count($members) > 0) {
                return $members;
            }
        }

        unset($result);
        return false;
    }

    public function getTopHKPlayers($count = 10)
    {
        //make sure the count param is digit
        if (!ctype_digit($count)) {
            $count = 10;
        }

        $this->connect();

        $result = $this->connection->query($this->GetStatement('TopHKPlayers'), array(
            $count
        ));

        if ($result && $result->num_rows() > 0) {
            $players = $result->result_array();

            // Add rank
            $i = 1;
            foreach ($players as $key => $player) {
                $players[$key]['rank'] = $this->addNumberSuffix($i);
                $i++;
            }

            return $players;
        }

        unset($result);

        return false;
    }

    private function addNumberSuffix($num)
    {
        if (!in_array(($num % 100), array(11,12,13))) {
            switch ($num % 10) {
                // Handle 1st, 2nd, 3rd
                case 1:
                    return $num . 'st';
                case 2:
                    return $num . 'nd';
                case 3:
                    return $num . 'rd';
            }
        }

        return $num . 'th';
    }
}
