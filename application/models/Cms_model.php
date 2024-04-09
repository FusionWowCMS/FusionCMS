<?php

use Config\Services;

/**
 * @package FusionCMS
 * @link    https://github.com/FusionWowCMS/FusionCMS
 */

class Cms_model extends CI_Model
{
    //private $db;
    /**
     * Connect to the database
     */
    public function __construct()
    {
        parent::__construct();

        //$this->db = $this->load->database("cms", true);

        $this->logVisit();

        if ($this->config->item('detect_language')) {
            $this->setLangugage();
        }
    }

    private function logVisit()
    {
        if (!$this->input->is_ajax_request() && !isset($_GET['is_json_ajax'])) {
            $data = [
                'date'      => date("Y-m-d"),
                'ip'        => $this->input->ip_address(),
                'timestamp' => time()
            ];

            $this->db->table('visitor_log')->upsert($data);
        }
    }

    public function getSideboxes(string $type = 'side', string $page = '*')
    {
        // Query: Prepare
        $query = $this->db->table('sideboxes')
                          ->select('*')
                          ->orderBy('order', 'ASC');

        // Query: Filter (Type)
        if($type && in_array($type, ['top', 'side', 'bottom']))
            $query = $query->where('location', $type);

        // Query: Filter (Page)
        if($page && $page !== '*')
            $query = $query->groupStart()
                           ->like('pages', str_replace(':page', $page, '":page"'), 'both')
                           ->orLike('pages', '"*"', 'both')
                           ->groupEnd();

        // Query: Execute
        $query = $query->get();

        // Query: Make sure we have results
        if($query->getNumRows())
            return $query->getResultArray();

        return [];
    }

    /**
     * Load the slider images
     *
     * @return array|null
     */
    public function getSlides(): ?array
    {
        $query = $this->db->query("SELECT * FROM image_slider ORDER BY `order` ASC");

        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        }

        return null;
    }

    /**
     * Get the links of one direction
     *
     * @param string $type ID of the specific menu
     * @return array|null
     */
    public function getLinks(string $type = "top"): ?array
    {
        if (in_array($type, array("top", "side", "bottom"))) {
            $query = $this->db->query("SELECT * FROM menu WHERE type = ? ORDER BY `parent_id` ASC, `order` ASC", [$type]);
        } else {
            $query = $this->db->query("SELECT * FROM menu ORDER BY `order` ASC");
        }

        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        }

        return null;
    }

    /**
     * Get the selected page from the database
     *
     * @param string $page
     * @return array|null
     */
    public function getPage(string $page): ?array
    {
        $query = $this->db->table('pages')->select('*')->where('identifier', $page)->get();

        if ($query->getNumRows() > 0) {
            $result = $query->getResultArray();
            return $result[0];
        }

        return null;
    }

    /**
     * Get any old rank ID (to avoid foreign key errors)
     *
     * @return bool|int
     */
    public function getAnyOldRank(): bool|int
    {
        $query = $this->db->query("SELECT id FROM `ranks` ORDER BY id ASC LIMIT 1");

        if ($query->getNumRows() > 0) {
            $result = $query->getResultArray();
            return $result[0]['id'];
        }

        return false;
    }

    /**
     * Get all pages
     *
     * @return array|null
     */
    public function getPages(): ?array
    {
        $query = $this->db->table('pages')->select()->get();

        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        }

        return null;
    }

    /**
     * Get all data from the realms table
     *
     * @return array|null
     */
    public function getRealms(): ?array
    {
        $query = $this->db->table('realms')->select()->get();

        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        }

        return null;
    }

    /**
     * Get the realm database information
     *
     * @param Int $id
     * @return array|null
     */
    public function getRealm(int $id): ?array
    {
        $query = $this->db->table('realms')->select()->where('id', $id)->get();

        if ($query->getNumRows() > 0) {
            $result = $query->getResultArray();
            return $result[0];
        }

        return null;
    }

    public function getBackups($id = false)
    {
        if ($id) {
            $query = $this->db->query("SELECT backup_name FROM backup where id = ?", [$id]);

            if ($query->getNumRows() > 0) {
                $result = $query->getResultArray();
                return $result[0]['backup_name'];
            } else {
                return false;
            }
        } else {
            $query = $this->db->query("SELECT * FROM backup ORDER BY `id` ASC");

            if ($query->getNumRows() > 0) {
                return $query->getResultArray();
            } else {
                return false;
            }
        }
    }

    public function getBackupCount()
    {
        $query = $this->db->table('backup')->select("COUNT(id) 'count'")->get();

        if ($query->getNumRows() > 0) {
            $result = $query->getResultArray();
            return $result[0]['count'];
        }

        return null;
    }

    public function deleteBackups($id)
    {
        $this->db->query("delete FROM backup WHERE id = ?", [$id]);
    }

    public function getTemplate($id)
    {
        $query = $this->db->query("SELECT * FROM email_templates WHERE id= ? LIMIT 1", [$id]);

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

            return $row[0];
        } else {
            return false;
        }
    }

    public function getNotifications($id, $count = false)
    {
        if ($count) {
            return $this->db->table('notifications')->select()->where('uid', $id)->where('read', 0)->countAllResults();
        } else {
            $query = $this->db->table('notifications')->select()->where('uid', $id)->get();

            if ($query->getNumRows() > 0) {
                return $query->getResultArray();
            }
        }

        return null;
    }

    public function setReadNotification($id, $uid, $all = false)
    {
        $builder = $this->db->table('notifications')->set('read', 1);
        if (!$all) {
            $builder->where('id', $id);
        }
        $builder->where('uid', $uid);
        $builder->update();
    }

    private function setLangugage()
    {
        $langs = $this->agent->languages();

        foreach ($langs as $lang) {
            // Check if its in the array
            if (in_array($lang, array_keys($this->config->item('supported_languages')))) {
                $setLang = $this->config->item('supported_languages')[$lang]['name'];
                break;
            }
        }

        // If no language has been worked out - or it is not supported - use the default
        if (!in_array($lang, array_keys($this->config->item('supported_languages')))) {
            $setLang = $this->config->item('default_language');
        }

        if (Services::session()->get('online')) {
            $this->user->setLanguage($setLang);
        } else {
            Services::session()->set(['language' => $setLang]);
        }
    }

    private function getSession($session)
    {
        $builder = $this->db->table("ci_sessions");
        $builder->where('ip_address', $session['ip_address']);
        $builder->where('user_agent', $session['user_agent']);
        $query = $builder->get();

        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        } else {
            return false;
        }
    }

    public function getMessagesCount(): int
    {
        return 0;
    }
}
