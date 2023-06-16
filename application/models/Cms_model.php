<?php

/**
 * @package FusionGen
 * @author  Jesper Lindström
 * @author  Xavier Geerinck
 * @author  Elliott Robbins
 * @author  Err0r
 * @link    https://fusiongen.net
 */

class Cms_model extends CI_Model
{
    /**
     * Connect to the database
     */
    public function __construct()
    {
        $this->db = $this->load->database("cms", true);

        $this->load->library('user_agent');
        $this->load->library('tasks');

        $this->logVisit();

        if ($this->config->item('detect_language')) {
            $this->setLangugage();
        }
    }

    private function logVisit()
    {
        if (!$this->input->is_ajax_request() && !isset($_GET['is_json_ajax'])) {
            $this->db->query("INSERT INTO visitor_log(`date`, `ip`, `timestamp`) VALUES(?, ?, ?)", array(date("Y-m-d"), $this->input->ip_address(), time()));
        }

        $session = array(
            'ip_address' => $this->input->ip_address(),
            'user_agent' => substr($this->input->user_agent(), 0, 120),
        );

        $this->db->where('ip_address', $session['ip_address']);
        $this->db->update("ci_sessions", $session);

        $query = $this->getSession($session);

        $data = array(
            "ip_address" => $session['ip_address'],
        );

        if($session["user_agent"])
        {
            $data['user_agent'] = $session["user_agent"];
        }

        $this->db->where('ip_address', $session['ip_address']);
        $this->db->update("ci_sessions", $data);
    }

    public function getModuleConfigKey($moduleId, $key)
    {
        $query = $this->db->query("SELECT m.id, m.module_id, m.key, m.value, m.date_added, m.date_changed FROM modules_configs m WHERE m.module_id = ? AND m.key = ?", array((int)$moduleId, (string)$key));

        // Return results
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result[0];
        }

        return null;
    }

    public function getSideboxes()
    {
        $query = $this->db->query("SELECT * FROM sideboxes ORDER BY `order` ASC");

        return $query->result_array();
    }

    /**
     * Load the slider images
     *
     * @return Array
     */
    public function getSlides()
    {
        $query = $this->db->query("SELECT * FROM image_slider ORDER BY `order` ASC");

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return null;
    }

    /**
     * Get the links of one direction
     *
     * @param  Int $side ID of the specific menu
     * @return Array
     */
    public function getLinks($side = "top")
    {
        if (in_array($side, array("top", "side", "bottom"))) {
            $query = $this->db->query("SELECT * FROM menu WHERE side = ? ORDER BY `order` ASC", array($side));
        } else {
            $query = $this->db->query("SELECT * FROM menu ORDER BY `order` ASC", array($side));
        }

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return null;
    }

    /**
     * Get the selected page from the database
     *
     * @param  String $page
     * @return Array
     */
    public function getPage($page)
    {
        $this->db->select('*')->from('pages')->where('identifier', $page);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result[0];
        }

        return null;
    }

    /**
     * Get any old rank ID (to avoid foreign key errors)
     *
     * @return Int
     */
    public function getAnyOldRank()
    {
        $query = $this->db->query("SELECT id FROM `ranks` ORDER BY id ASC LIMIT 1");

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result[0]['id'];
        }

        return false;
    }

    /**
     * Get all pages
     *
     * @return Array
     */
    public function getPages()
    {
        $this->db->select('*')->from('pages');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }

        return null;
    }

    /**
     * Get all data from the realms table
     *
     * @return Array
     */
    public function getRealms()
    {
        $this->db->select('*')->from('realms');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        }

        return null;
    }

    /**
     * Get the realm database information
     *
     * @param  Int $id
     * @return Array
     */
    public function getRealm($id)
    {
        $this->db->select('*')->from('realms')->where('id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result[0];
        }

        return null;
    }

    public function getBackups($id = false)
    {
        if ($id) {
            $query = $this->db->query("SELECT backup_name FROM backup where id = ?", array($id));

            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                return $result[0]['backup_name'];
            } else {
                return false;
            }
        } else {
            $query = $this->db->query("SELECT * FROM backup ORDER BY `id` ASC");

            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                return $result;
            } else {
                return false;
            }
        }
    }

    public function getBackupCount()
    {
        $this->db->select("COUNT(id) 'count'");
        $query = $this->db->get('backup');

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result[0]['count'];
        }

        return null;
    }

    public function deleteBackups($id)
    {
        $this->db->query("delete FROM backup WHERE id = ?", array($id));
    }

    public function getTemplate($id)
    {
        $query = $this->db->query("SELECT * FROM email_templates WHERE id= ? LIMIT 1", array($id));

        if ($query->num_rows() > 0) {
            $row = $query->result_array();

            return $row[0];
        } else {
            return false;
        }
    }

    public function getNotifications($id, $count = false)
    {
        if ($count) {
            $this->db->select('*');
            $this->db->where('uid', $id);
            $this->db->where('read', 0);
            $result = $this->db->count_all_results('notifications');

            return $result;
        } else {
            $this->db->select('*')->from('notifications')->where('uid', $id);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                return $result;
            }
        }

        return null;
    }

    public function setReadNotification($id, $uid, $all = false)
    {
        if ($all) {
            $this->db->set('read', 1);
            $this->db->where('uid', $uid);
            $this->db->update('notifications');
        } else {
            $this->db->set('read', 1);
            $this->db->where('id', $id);
            $this->db->where('uid', $uid);
            $this->db->update('notifications');
        }
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

        if ($this->session->userdata('online')) {
            $this->user->setLanguage($setLang);
        } else {
            $this->session->set_userdata(array('language' => $setLang));
        }
    }

    private function getSession($session)
    {
        $this->db->where('ip_address', $session['ip_address']);
        $this->db->where('user_agent', $session['user_agent']);
        $query = $this->db->get("ci_sessions");

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return false;
        }
    }
}
