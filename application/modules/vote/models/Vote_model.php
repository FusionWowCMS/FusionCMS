<?php

use Config\Services;

class Vote_model extends CI_Model
{
    private $vote_sites;

    /**
     * Connect to the database
     */
    public function __construct()
    {
        parent::__construct();

        if ($this->config->item('delete_old_votes')) {
            $this->deleteOld();
        }

        //init our vote sites
        $this->vote_sites = $this->getVoteSites();

        if ($this->vote_sites) {
            foreach ($this->vote_sites as $key => $value) {
                $this->vote_sites[$key]['canVote'] = $this->canVote($value['id']);
                $this->vote_sites[$key]['nextVote'] = $this->getNextTime($this->vote_sites[$key]['canVote'], $value['id']);
            }
        }
    }

    public function getVoteSites()
    {
        if ($this->vote_sites) {
            return $this->vote_sites;
        } else {
            $query = $this->db->query("SELECT * FROM vote_sites");

            if ($query->getNumRows()) {
                return $query->getResultArray();
            } else {
                return false;
            }
        }
    }

    public function getVoteSite($id)
    {
        foreach ($this->vote_sites as $key => $value) {
            if ($value['id'] == $id) {
                return $this->vote_sites[$key];
            }
        }
    }

    public function getTopsite($id)
    {
        $query = $this->db->query("SELECT * FROM vote_sites WHERE id=?", array($id));

        if ($query->getNumRows()) {
            $result = $query->getResultArray();

            return $result[0];
        } else {
            return false;
        }
    }

    /**
     * Gets the vote site by url, handy for the postback scripts.
     */
    public function getVoteSiteByUrl($url)
    {
        $query = $this->db->query("SELECT * FROM vote_sites WHERE vote_url LIKE '%" . $url . "%'");

        if ($query->getNumRows()) {
            $result = $query->getResultArray();

            return $result[0];
        } else {
            return false;
        }
    }

    public function getVoteLog($vote_site_id, $user_ip, $time_back, $ipLock = false)
    {
        if (!$ipLock) {
            $builder = $this->db->table('vote_log')->select()->where('vote_site_id', $vote_site_id)->where(['ip' => $user_ip, 'time > ' => $time_back, 'user_id' => $this->user->getId()]);
        } else {
            $builder = $this->db->table('vote_log')->select()->where('vote_site_id', $vote_site_id)->where(['user_id' => $this->user->getId(), 'time > ' => $time_back]);
        }

        $query = $builder->get();

        if ($query->getNumRows() > 0) {
            //Voted already
            return false;
        } else {
            return true;
        }
    }

    private function deleteOld()
    {
        $time_back = time() - (24 * 60 * 60);
        $this->db->query("DELETE FROM vote_log WHERE `time` < (SELECT MAX(hour_interval) * 3600 FROM vote_sites)", [$time_back]);
    }

    public function getNextTime($canVote, $vote_site_id)
    {
        if (!$canVote) {
            $user_ip = $this->input->ip_address();

            $vote_site = $this->getVoteSite($vote_site_id);
            $time_interval = $vote_site['hour_interval'];
            $time_back = time() - ($time_interval * 60 * 60);

            // Check for account or not
            if (!$this->config->item('vote_ip_lock') && !$vote_site['callback_enabled']) {
                $builder = $this->db->table('vote_log')->select()->where('vote_site_id', $vote_site_id)->where(['ip' => $user_ip, 'time > ' => $time_back, 'user_id' => $this->user->getId()]);
            } else {
                $builder = $this->db->table('vote_log')->select()->where('vote_site_id', $vote_site_id)->where(['user_id' => $this->user->getId(), 'time > ' => $time_back]);
            }

            $query = $builder->get();

            if ($query->getNumRows()) {
                $row = $query->getResultArray();

                $nextTime = $row[0]['time'] + ($time_interval * 60 * 60);
                $untilNext = $nextTime - time();

                return $this->template->formatTime($untilNext);
            } else {
                return false;
            }
        }
    }

    public function vote_log($user_id, $user_ip, $voteSiteId)
    {
        //Insert into the logs.
        $data = [
            'vote_site_id' => $voteSiteId,
            'user_id'      => $user_id,
            'ip'           => $user_ip,
            'time'         => time()
        ];

        $insert = $this->db->table('vote_log')->insert($data);

        if ($insert) {
            $this->db->query("UPDATE account_data SET total_votes = total_votes + 1 WHERE id = ?", [$this->user->getId()]);

            //Return true if we voted
            return true;
        } else {
            return false;
        }
    }

    public function updateVp($user_id, $extra_vp)
    {
        //Update account vp
        $this->db->query("UPDATE account_data SET `vp` = vp + ? WHERE id = ?", [$extra_vp, $user_id]);

        //Update the session
        Services::session()->set('vp', $this->user->getVp() + $extra_vp);

        $this->updateMonthlyVotes();
    }

    private function updateMonthlyVotes()
    {
        $query = $this->db->query("SELECT COUNT(*) AS `total` FROM monthly_votes WHERE month = ?", [date("Y-m")]);

        $row = $query->getResultArray();

        if ($row[0]['total']) {
            $this->db->query("UPDATE monthly_votes SET amount = amount + 1 WHERE month=?", [date("Y-m")]);
        } else {
            $this->db->query("INSERT INTO monthly_votes(month, amount) VALUES(?, ?)", [date("Y-m"), 1]);
        }
    }

    /**
     * Checks if the current user can vote for the given site
     * at this time.
     *
     * @param $vote_site_id ID of the vote site
     * @param $user_id Optional: ID of the user to check
     * @param $user_ip Optional: IP of the user to check
     */
    public function canVote($vote_site_id, $user_id = null, $user_ip = null)
    {
        // Get the vote site
        $vote_site = $this->getVoteSite($vote_site_id);

        // Get the hours between each vote
        $time_interval = $vote_site['hour_interval'];

        // Calculate the that should tell if they voted already or not.
        $time_back = time() - ($time_interval * 60 * 60);

        // check if there are vote logs for this user / ip and time
        if ($user_ip === null && $user_id === null) {
            $user_ip = $this->input->ip_address();
        }

        if ($user_id === null) {
            $user_id = $this->user->getId();
        }

        $sql = '
			SELECT * 
			FROM `vote_log`
			WHERE 
			`vote_site_id` = ? AND `time` > ?
		';

        if ($this->config->item('vote_ip_lock') && $user_ip) {
            $sql .= " AND (user_id = " . $this->db->escape($user_id) . " OR ip = " . $this->db->escape($user_ip) . ")";
        } else {
            $sql .= " AND user_id = " . $this->db->escape($user_id);
        }

        $query = $this->db->query($sql, array($vote_site_id, $time_back));

        if ($query->getNumRows() > 0) {
            //Voted already
            return false;
        } else {
            return true;
        }
    }

    public function add($data)
    {
        $this->db->table('vote_sites')->insert($data);
    }

    public function edit($id, $data)
    {
        $this->db->table('vote_sites')->where('id', $id)->update($data);
    }

    public function delete($id)
    {
        $this->db->query("DELETE FROM vote_sites WHERE id = ?", [$id]);
    }
}
