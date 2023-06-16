<?php

/**
 * @package FusionCMS
 * @author  Jesper Lindström
 * @author  Xavier Geerinck
 * @author  Elliott Robbins
 * @link    http://fusion-hub.com
 */

class Internal_user_model extends CI_Model
{
    private $connection;
    private $vp;
    private $dp;
    private $nickname;
    private $permissionCache;
    private $language;

    public function __construct()
    {
        parent::__construct();

        $this->connection = $this->load->database("cms", true);
        $this->permissionCache = array();

        if ($this->user->getOnline()) {
            $this->initialize();
        } else {
            $this->vp = 0;
            $this->dp = 0;
            $this->location = "";
            $this->nickname = "";
            $this->language = $this->config->item('language');
            $this->avatarId = 1;
        }
    }

    public function initialize($id = false)
    {
        if (!$id) {
            $id = $this->session->userdata('uid');
        }

        $this->connection->select('*')->from('account_data')->where(array('id' => $id));
        $query = $this->connection->get();

        if ($this->connection->error()) {
            $error = $this->connection->error();
            if ($error['code'] != 0) {
                die($error["message"]);
            }
        }

        if ($query->num_rows() > 0) {
            $result = $query->result_array();

            $this->vp = $result[0]['vp'];
            $this->dp = $result[0]['dp'];
            $this->location = $result[0]['location'];
            $this->nickname = $result[0]['nickname'];
            $this->language = $result[0]['language'];
            $this->avatarId = $result[0]['avatar'];
        } else {
            $this->makeNew();
        }
    }

    /**
     * Creates the internal-stored user info
     */
    public function makeNew()
    {
        $array = array(
            'id' => $this->external_account_model->getId(),
            'vp' => 0,
            'dp' => 0,
            'location' => "Unknown",
            'nickname' => $this->external_account_model->getUsername(),
            'language' => $this->config->item('language'),
            'avatar' => 1
        );

        $this->connection->insert("account_data", $array);

        $this->vp = 0;
        $this->dp = 0;
        $this->location = "Unknown";
        $this->nickname = $this->external_account_model->getUsername();
        $this->avatarId = 1;
    }

    public function nicknameExists($nickname)
    {
        $count = $this->connection->from('account_data')->where(array('nickname' => $nickname))->count_all_results();

        if ($count) {
            return true;
        } else {
            return false;
        }
    }

    /*
    | -------------------------------------------------------------------
    |  Getters
    | -------------------------------------------------------------------
    */

    /**
     * Get the nickname
     *
     * @param  Int $id
     * @return String
     */
    public function getNickname($id = false)
    {
        if (!$id) {
            return $this->nickname;
        } else {
            $this->connection->select('nickname')->from('account_data')->where(array('id' => $id));
            $query = $this->connection->get();

            if ($query->num_rows() > 0) {
                $result = $query->result_array();
            } else {
                $result[0]['nickname'] = "";
            }

            if (strlen($result[0]['nickname']) > 0) {
                return $result[0]['nickname'];
            } else {
                return $this->external_account_model->getUsername($id);
            }
        }
    }

    /**
     * Gets the value of the specified table, column where value = value
     *
     * @param  String $table
     * @param  String $column
     * @param  String $value
     * @return String, bool
     */
    public function getValue($table, $column, $value, $columns = "*")
    {
        //Continue with selecting data.
        $this->connection->select($columns)->from($table)->where(array($column => $value));
        $query = $this->connection->get();
        $result = $query->result_array();

        if ($query->num_rows() > 0) {
            return $result[0];
        } else {
            return "";
        }
    }

    public function getAccessId($rankId)
    {
        $query = $this->connection->query("SELECT access_id FROM ranks WHERE id = ?", array($rankId));
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result[0]['access_id'];
        } else {
            return false;
        }
    }

    public function getIdByNickname($nickname)
    {
        $query = $this->connection->query("SELECT id FROM account_data WHERE nickname = ?", array($nickname));

        if ($query->num_rows() > 0) {
            $result = $query->result_array();

            return $result[0]['id'];
        } else {
            return false;
        }
    }

    public function getTotalVotes()
    {
        $query = $this->connection->query("SELECT total_votes FROM account_data WHERE nickname = ?", array($this->nickname));

        if ($query->num_rows() > 0) {
            $result = $query->result_array();

            return $result[0]['id'];
        } else {
            return false;
        }
    }

    public function getVp()
    {
        return $this->vp;
    }

    public function getDp()
    {
        return $this->dp;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function getAvatar($id = false)
    {
        $avatarId = !$id ? $this->avatarId : $this->getAvatarId($id);

        $query = $this->connection->query("SELECT avatar FROM avatars WHERE id = ?", array($avatarId));

        if($query->num_rows() > 0)
        {
            $result = $query->result_array();

            return $result[0]['avatar'];
        }

        return false;
    }

	public function getAvatarId($id = false)
    {
		if(!$id)
        {
			return $this->avatarId;
		} else {
			$query = $this->connection->query("SELECT avatar FROM account_data WHERE id = ?", array($id));

			if($query->num_rows() > 0)
            {
				$result = $query->result_array();

				return $result[0]['avatar'];
			}
		}
	}

    /*
    | -------------------------------------------------------------------
    |  Setters
    | -------------------------------------------------------------------
    */
    public function setVp($userId, $vp)
    {
        $this->connection->query("UPDATE account_data SET vp = ? WHERE id = ?", array($vp, $userId));
    }

    public function setLanguage($userId, $language)
    {
        $this->connection->query("UPDATE account_data SET language = ? WHERE id = ?", array($language, $userId));
    }

    public function setDp($userId, $dp)
    {
        $this->connection->query("UPDATE account_data SET dp = ? WHERE id = ?", array($dp, $userId));
    }

    public function setLocation($userId, $location)
    {
        $this->connection->query("UPDATE account_data SET location = ? WHERE id = ?", array($location, $userId));
    }

    public function setAvatar($userId, $avatarId)
    {
        $this->connection->query("UPDATE account_data SET avatar = ? WHERE id = ?", array($avatarId, $userId));
    }
}
