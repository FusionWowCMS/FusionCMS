<?php

use App\Config\Services;

/**
 * Class InternalUserModel
 *
 * Handles internal user data stored in the `account_data` table.
 */
class Internal_user_model extends CI_Model
{
    private int $vp;
    private int $dp;
    private string $nickname;
    private string $location;
    private int $avatarId;
    private int $total_votes;
    private ?string $language;

    public function __construct()
    {
        parent::__construct();

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
            $result = $query->getRowArray();

            $this->vp = $result['vp'];
            $this->dp = $result['dp'];
            $this->total_votes = $result['total_votes'];
            $this->location = $result['location'];
            $this->nickname = $result['nickname'];
            $this->language = $result['language'];
            $this->avatarId = $result['avatar'];
        } else {
            $this->makeNew();
        }
    }

    /**
     * Creates the internal-stored user info
     */
    public function makeNew()
    {
        $array = [
            'id' => $this->external_account_model->getId(),
            'vp' => 0,
            'dp' => 0,
            'location' => "Unknown",
            'nickname' => $this->external_account_model->getUsername(),
            'language' => $this->config->item('language'),
            'avatar' => 1
        ];

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
        $query = $this->db->table($table)->select($columns)->where([$column => $value])->get();
        $result = $query->getRowArray();

        if ($query->getNumRows() > 0) {
            return $result;
        } else {
            return '';
        }
    }

    public function getAccessId($rankId)
    {
        $query = $this->db->table('ranks')->select('access_id')->where('id', $rankId)->get();

        if ($query->getNumRows() > 0) {
            $result = $query->getRowArray();
            return $result['access_id'];
        } else {
            return false;
        }
    }

    public function getIdByNickname($nickname)
    {
        $query = $this->db->table('account_data')->select('id')->where('nickname', $nickname)->get();

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

        $query = $this->db->table('avatars')->select('avatar')->where('id', $avatarId)->get();

        if($query->getNumRows() > 0)
        {
            $result = $query->getRowArray();

            return $result['avatar'];
        }

        return false;
    }

	public function getAvatarId($id = false): int
    {
		if(!$id)
        {
			return $this->avatarId;
		} else {
            $query = $this->db->table('account_data')->select('avatar')->where('id', $id)->get();

			if($query->getNumRows() > 0)
            {
				$result = $query->getRowArray();

				return $result['avatar'];
			}
		}

        return 1;
	}

    /*
    | -------------------------------------------------------------------
    |  Setters
    | -------------------------------------------------------------------
    */
    public function setVp($userId, $vp): void
    {
        $this->db->table('account_data')->where('id', $userId)->update(['vp' => $vp]);
    }

    public function setLanguage($userId, $language): void
    {
        $this->db->table('account_data')->where('id', $userId)->update(['language' => $language]);
    }

    public function setDp($userId, $dp): void
    {
        $this->db->table('account_data')->where('id', $userId)->update(['dp' => $dp]);
    }

    public function setLocation($userId, $location): void
    {
        $this->db->table('account_data')->where('id', $userId)->update(['location' => $location]);
    }

    public function setAvatar($userId, $avatarId): void
    {
        $this->db->table('account_data')->where('id', $userId)->update(['avatar' => $avatarId]);
    }
}
