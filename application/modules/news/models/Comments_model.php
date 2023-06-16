<?php

class Comments_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get comments
     *
     * @param  Int $id
     * @return Array
     */
    public function getComments($id)
    {
        $this->db->select('*')->from('comments')->where('article_id', $id)->order_by('id', 'desc');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();

            foreach ($result as $key => $value) {
                //Remove the empty comments since they are useless....
                if ($result[$key]['content'] == "") {
                    unset($result[$key]);
                }
                //Format the comments we have to enable xss protection :D
                else {
                    $result[$key]['content'] = $this->template->format($result[$key]['content']);
                }
            }

            return $result;
        } else {
            return;
        }
    }

    /**
     * Get last comment by the user
     *
     * @param  Int $id
     * @return Array
     */
    public function getLastComment($id)
    {
        $this->db->select('*')->from('comments')->where('article_id', $id)->where('author_id', $this->user->getId())->order_by('id', 'desc')->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();

            return $result[0];
        } else {
            return;
        }
    }

    /**
     * Submit a comment
     *
     * @param Array $comment
     */
    public function addComment($comment)
    {
        $this->db->insert("comments", $comment);

        $this->db->query("UPDATE articles SET comments = comments + 1 WHERE id=?", array($comment['article_id']));
    }

    public function deleteComment($id)
    {
        $query = $this->db->query("SELECT article_id FROM comments WHERE id=?", array($id));

        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        } else {
            die("Comment doesn't exist. Yay");
        }

        $this->db->trans_start();
        $this->db->query("DELETE FROM comments WHERE id=?", array($id));
        $this->db->query("UPDATE articles SET comments = comments - 1 WHERE id=?", array($row[0]['article_id']));
        $this->db->trans_complete();

        return $row[0]['article_id'];
    }
}
