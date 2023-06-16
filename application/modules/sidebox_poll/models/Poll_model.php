<?php

class Poll_model extends CI_Model
{
    private $db;

    public function __construct()
    {
        parent::__construct();

        $this->db = $this->load->database("cms", true);
    }

    public function getPolls()
    {
        $query = $this->db->query("SELECT * FROM sideboxes_poll_questions ORDER BY questionid DESC");

        if ($query->num_rows() > 0) {
            $row = $query->result_array();

            return $row;
        } else {
            return false;
        }
    }

    public function getPoll()
    {
        $query = $this->db->query("SELECT * FROM sideboxes_poll_questions ORDER BY questionid DESC LIMIT 1");

        if ($query->num_rows() > 0) {
            $row = $query->result_array();

            return $row[0];
        } else {
            return false;
        }
    }

    public function pollExists($questionid)
    {
        $query = $this->db->query("SELECT COUNT(*) as total FROM sideboxes_poll_questions WHERE questionid=? LIMIT 1", array($questionid));

        if ($query->num_rows() > 0) {
            $row = $query->result_array();

            if ($row[0]['total']) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getMyVote($questionId)
    {
        $query = $this->db->query("SELECT answerid FROM sideboxes_poll_votes WHERE questionid=? AND userid=?", array($questionId, $this->user->getId()));

        if ($query->num_rows() > 0) {
            $row = $query->result_array();

            return $row[0]['answerid'];
        } else {
            return false;
        }
    }

    public function getAnswers($questionId)
    {
        $query = $this->db->query("SELECT * FROM sideboxes_poll_answers WHERE questionid=? ORDER BY answerid ASC", array($questionId));

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function getVoteCount($questionId, $answerId)
    {
        $query = $this->db->query("SELECT COUNT(*) AS `total` FROM sideboxes_poll_votes WHERE questionid=? AND answerid=?", array($questionId, $answerId));

        if ($query->num_rows() > 0) {
            $row = $query->result_array();

            return $row[0]['total'];
        } else {
            return 0;
        }
    }

    public function insertAnswer($questionId, $answerId, $userId)
    {
        //Make sure something is filled in.
        if (!$questionId || !$answerId || !$userId) {
            return false;
        } else {
            $query = $this->db->query("INSERT INTO `sideboxes_poll_votes` (`questionid`, `answerid`, `userid`, `time`) VALUES (?, ?, ?, ?)", array($questionId, $answerId, $userId, time()));
            if ($query) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function hasVoted($pollId, $userId)
    {
        if (!$pollId || !$userId) {
            return false;
        } else {
            $query = $this->db->query("SELECT COUNT(*) voted FROM `sideboxes_poll_votes` WHERE questionid = ? AND userid = ?", array($pollId, $userId));

            if ($query->num_rows() > 0) {
                $row = $query->result_array();

                if ($row[0]['voted'] == 0) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        }
    }

    public function add($data, $answers)
    {
        $this->db->insert("sideboxes_poll_questions", $data);

        $query = $this->db->query("SELECT questionid FROM sideboxes_poll_questions ORDER BY questionid DESC LIMIT 1");
        $row = $query->result_array();
        $id = $row[0]['questionid'];

        foreach ($answers as $answer) {
            $answer['questionid'] = $id;

            $this->db->insert("sideboxes_poll_answers", $answer);
        }
    }

    public function delete($id)
    {
        $this->db->query("DELETE FROM sideboxes_poll_questions WHERE questionid=?", array($id));
        $this->db->query("DELETE FROM sideboxes_poll_votes WHERE questionid=?", array($id));
        $this->db->query("DELETE FROM sideboxes_poll_answers WHERE questionid=?", array($id));
    }
}
