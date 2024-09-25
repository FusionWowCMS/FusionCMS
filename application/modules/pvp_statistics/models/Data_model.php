<?php

use CodeIgniter\Database\BaseConnection;

class Data_model extends CI_Model
{
    public $realm;
    private BaseConnection $connection;
    private bool|string $emuStr = false;

    public function GetStatement($key): false|string
    {
        if (!$this->emuStr) {
            return false;
        }

        switch ($this->emuStr) {
            case 'cmangos':
            case 'mangos_three':
            case 'mangos_one_two':
            {
                $statements = [
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
                ];
                break;
            }
            default:
            {
                $statements = [
                    'TopArenaTeams' => "SELECT `arenaTeamId` AS arenateamid, `rating`, `rank`, `arena_team`.`name`, `captainGuid` AS captain, `seasonWins`, `type`, `characters`.`race` AS race FROM `arena_team` RIGHT JOIN `characters` ON `characters`.`guid` = `arena_team`.`captainGuid` WHERE `type` = ? ORDER BY rating DESC LIMIT ?;",

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
                ];
                break;
            }
        }

        return $statements[$key];
    }

    /**
     * Assign the realm object to the model
     */
    public function setRealm($id): void
    {
        $this->realm = $this->realms->getRealm($id);

        $this->emuStr = $this->realm->getConfig('emulator');
    }

    /**
     * Connect to the character database
     */
    public function connect(): void
    {
        $this->realm->getCharacters()->connect();
        $this->connection = $this->realm->getCharacters()->getConnection();
    }

    /***************************************
     *            TOP ARENA FUNCTIONS
     ***************************************/

    public function getTeams(int $count = 5, int $type = 2): array|bool
    {
        $this->connect();

        $result = $this->connection->query($this->GetStatement('TopArenaTeams'), [$type, $count]);

        if ($result && $result->getNumRows() > 0) {
            $teams = $result->getResultArray();

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

    public function getTeamMembers($team): array|bool
    {
        $this->connect();

        $result = $this->connection->query($this->GetStatement('TeamMembers'), [$team]);

        if ($result && $result->getNumRows() > 0) {
            return $result->getResultArray();
        }

        unset($result);
        return false;
    }

    public function getTopHKPlayers(int $count = 10): array|bool
    {
        $this->connect();

        $result = $this->connection->query($this->GetStatement('TopHKPlayers'), [$count]);

        if ($result && $result->getNumRows() > 0) {
            $players = $result->getResultArray();

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

    private function addNumberSuffix($num): string
    {
        if (!in_array(($num % 100), array(11, 12, 13))) {
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
