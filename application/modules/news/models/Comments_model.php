<?php

class Comments_model extends CI_Model
{
    /**
     * Get comments
     *
     * @param  Int $id
     * @return Array
     */
    public function getComments($id)
    {
        $query = $this->db->table('comments')->select()->where('article_id', $id)->orderBy('id', 'desc')->get();

        if ($query->getNumRows() > 0) {
            $result = $query->getResultArray();

            foreach ($result as $key => $value) {
                //Remove the empty comments since they are useless…
                if ($value['content'] == "") {
                    unset($result[$key]);
                }
                //Format the comments we have to enable xss protection :D
                else {
                    $result[$key]['content'] = $this->template->format($value['content']);
                }
            }

            return $result;
        } else {
            return [];
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
        $query = $this->db->table('comments')->select()->where('article_id', $id)->where('author_id', $this->user->getId())->orderBy('id', 'desc')->limit(1)->get();

        if ($query->getNumRows() > 0) {
            $result = $query->getResultArray();

            return $result[0];
        } else {
            return [];
        }
    }

    /**
     * Submit a comment
     *
     * @param Array $comment
     */
    public function addComment($comment)
    {
        $this->db->table('comments')->insert($comment);

        $this->db->query("UPDATE articles SET comments = comments + 1 WHERE id=?", array($comment['article_id']));
    }

    public function deleteComment($id)
    {
        $query = $this->db->query("SELECT article_id FROM comments WHERE id=?", array($id));

        if ($query->getNumRows() > 0) {
            $row = $query->getResultArray();
        } else {
            die("Comment doesn't exist. Yay");
        }

        $this->db->transStart();
        $this->db->query("DELETE FROM comments WHERE id=?", array($id));
        $this->db->query("UPDATE articles SET comments = comments - 1 WHERE id=?", array($row[0]['article_id']));
        $this->db->transComplete();

        return $row[0]['article_id'];
    }
}
