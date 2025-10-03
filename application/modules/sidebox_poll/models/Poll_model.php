<?php

class Poll_model extends CI_Model
{
    public function getPolls(): array|false
    {
        $query = $this->db->query("SELECT * FROM sideboxes_poll_questions ORDER BY questionid DESC");

        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        } else {
            return false;
        }
    }

    public function pollExists(int $questionid): bool
    {
        $query = $this->db->query("SELECT COUNT(*) as total FROM sideboxes_poll_questions WHERE questionid = ? LIMIT 1", [$questionid]);

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

            if ($row[0]['total']) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getMyVote(int $questionId)
    {
        $query = $this->db->query("SELECT answerid FROM sideboxes_poll_votes WHERE questionid=? AND userid = ?", [$questionId, $this->user->getId()]);

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

            return $row[0]['answerid'];
        } else {
            return false;
        }
    }

    public function getAnswers(int $questionId): array|false
    {
        $query = $this->db->query("SELECT * FROM sideboxes_poll_answers WHERE questionid=? ORDER BY answerid ASC", [$questionId]);

        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        } else {
            return false;
        }
    }

    public function getVoteCount(int $questionId, int $answerId)
    {
        $query = $this->db->query("SELECT COUNT(*) AS `total` FROM sideboxes_poll_votes WHERE questionid=? AND answerid=?", [$questionId, $answerId]);

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();

            return $row[0]['total'];
        } else {
            return 0;
        }
    }

    public function insertAnswer(int $questionId, int $answerId, int $userId): bool
    {
        //Make sure something is filled in.
        if (!$questionId || !$answerId || !$userId) {
            return false;
        } else {
            $query = $this->db->query("INSERT INTO `sideboxes_poll_votes` (`questionid`, `answerid`, `userid`, `time`) VALUES (?, ?, ?, ?)", [$questionId, $answerId, $userId, time()]);
            if ($query) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function hasVoted(int $pollId, int $userId): bool
    {
        if (!$pollId || !$userId) {
            return false;
        } else {
            $query = $this->db->query("SELECT COUNT(*) voted FROM `sideboxes_poll_votes` WHERE questionid = ? AND userid = ?", [$pollId, $userId]);

            if ($query->getNumRows() > 0) {
                $row = $query->getResultArray();

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

    public function add($data, $answers): void
    {
        $this->db->table('sideboxes_poll_questions')->insert($data);

        $query = $this->db->query("SELECT questionid FROM sideboxes_poll_questions ORDER BY questionid DESC LIMIT 1");
        $row = $query->getResultArray();
        $id = $row[0]['questionid'];

        foreach ($answers as $answer) {
            $answer['questionid'] = $id;

            $this->db->table('sideboxes_poll_answers')->insert($answer);
        }
    }

    public function delete(int $id): void
    {
        $this->db->query("DELETE FROM sideboxes_poll_questions WHERE questionid=?", [$id]);
        $this->db->query("DELETE FROM sideboxes_poll_votes WHERE questionid=?", [$id]);
        $this->db->query("DELETE FROM sideboxes_poll_answers WHERE questionid=?", [$id]);
    }
}
