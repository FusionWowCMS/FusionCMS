<?php

use App\Config\Services;
use CodeIgniter\Database\BaseConnection;

/**
 * Class InternalUserModel
 *
 * Handles internal user data stored in the `account_data` table.
 */
class Internal_user_model extends CI_Model
{
    private $vp;
    private $dp;
    private $nickname;
    private $location;
    private $avatarId;
    private $total_votes;
    private $permissionCache;
    private $language;

    public function __construct()
    {
        parent::__construct();

        $this->permissionCache = [];

        if ($this->user->getOnline()) {
            $this->initialize();
        } else {
            $this->vp = 0;
            $this->dp = 0;
            $this->total_votes = 0;
            $this->location = "";
            $this->nickname = "";
            $this->language = $this->config->item('language');
            $this->avatarId = 1;
        }
    }

    public function initialize($id = false)
    {
        if (!$id) {
            $id = Services::session()->get('uid');
        }

        $query = $this->db->table('account_data')->select()->where(['id' => $id])->get();

        if ($this->db->error()) {
            $error = $this->db->error();
            if ($error['code'] != 0) {
                die($error["message"]);
            }
        }

        if ($query->getNumRows() > 0) {
            $result = $query->getResultArray();

            $this->vp = $result[0]['vp'];
            $this->dp = $result[0]['dp'];
            $this->total_votes = $result[0]['total_votes'];
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

        $this->db->table('account_data')->insert($array);

        $this->vp = 0;
        $this->dp = 0;
        $this->location = "Unknown";
        $this->nickname = $this->external_account_model->getUsername();
        $this->avatarId = 1;
    }

    public function nicknameExists($nickname)
    {
        $count = $this->db->table('account_data')->where(array('nickname' => $nickname))->countAllResults();

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
     * @param bool|Int $id
     * @return string|null
     */
    public function getNickname(bool|int $id = false): ?string
    {
        if (!$id) {
            return $this->nickname;
        } else {
            $query = $this->db->table('account_data')->select('nickname')->where(['id' => $id])->get();

            if ($query->getNumRows() > 0) {
                $result = $query->getRowArray();
            } else {
                $result['nickname'] = '';
            }

            if (strlen($result['nickname']) > 0) {
                return $result['nickname'];
            } else {
                return $this->external_account_model->getUsername($id);
            }
        }
    }

    /**
     * Gets the value of the specified table, column where value = value
     *
     * @param string $table
     * @param string $column
     * @param string $value
     * @param string $columns
     * @return string|array
     */
    public function getValue(string $table, string $column, string $value, string $columns = "*"): array|string
    {
        //Continue with selecting data.
        $query = $this->db->table($table)->select($columns)->where(array($column => $value))->get();
        $result = $query->getRowArray();

        if ($query->getNumRows() > 0) {
            return $result;
        } else {
            return '';
        }
    }

    public function getAccessId($rankId)
    {
        $query = $this->db->query("SELECT access_id FROM ranks WHERE id = ?", array($rankId));
        if ($query->getNumRows() > 0) {
            $result = $query->getRowArray();
            return $result['access_id'];
        } else {
            return false;
        }
    }

    public function getIdByNickname($nickname)
    {
        $query = $this->db->query("SELECT id FROM account_data WHERE nickname = ?", array($nickname));

        if ($query->getNumRows() > 0) {
            $result = $query->getRowArray();

            return $result['id'];
        } else {
            return false;
        }
    }

    public function getTotalVotes(): int
    {
        return $this->total_votes;
    }

    public function getVp(): int
    {
        return $this->vp;
    }

    public function getDp(): int
    {
        return $this->dp;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function getAvatar($id = false)
    {
        $avatarId = !$id ? $this->avatarId : $this->getAvatarId($id);

        $query = $this->db->query("SELECT avatar FROM avatars WHERE id = ?", array($avatarId));

        if($query->getNumRows() > 0)
        {
            $result = $query->getRowArray();

            return $result['avatar'];
        }

        return false;
    }

	public function getAvatarId($id = false)
    {
		if(!$id)
        {
			return $this->avatarId;
		} else {
			$query = $this->db->query("SELECT avatar FROM account_data WHERE id = ?", [$id]);

			if($query->getNumRows() > 0)
            {
				$result = $query->getRowArray();

				return $result['avatar'];
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
        $this->db->query("UPDATE account_data SET vp = ? WHERE id = ?", [$vp, $userId]);
    }

    public function setLanguage($userId, $language)
    {
        $this->db->query("UPDATE account_data SET language = ? WHERE id = ?", [$language, $userId]);
    }

    public function setDp($userId, $dp)
    {
        $this->db->query("UPDATE account_data SET dp = ? WHERE id = ?", array($dp, $userId));
    }

    public function setLocation($userId, $location)
    {
        $this->db->query("UPDATE account_data SET location = ? WHERE id = ?", array($location, $userId));
    }

    public function setAvatar($userId, $avatarId)
    {
        $this->db->query("UPDATE account_data SET avatar = ? WHERE id = ?", array($avatarId, $userId));
    }
}
