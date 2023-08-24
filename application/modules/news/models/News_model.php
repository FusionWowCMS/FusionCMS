<?php

class News_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get news entries
     *
     * @param  Int $start
     * @param  Int $limit
     * @return Array
     */
    public function getArticles($start = 0, $limit = 1)
    {
        if ($start === true) {
            $this->db->select('*');
        } else {
            $this->db->select('*');
            $this->db->limit($limit, $start);
        }

        $this->db->order_by('id', 'desc');
        $query = $this->db->get('articles');
        $result = $query->result_array();

        // Did we have any results?
        if ($result) {
            return $this->template->format($result);
        } else {
            // Instead of showing a blank space, we show a default article
            $default_lang = $this->language->getAbbreviationByLanguage($this->language->getDefaultLanguage());
            return array(
                        array(
                            'id'                             => 0,
                            'headline'                       => 'Welcome to your new FusionCMS powered website!',
                            'content'                        => 'Your website has been successfully installed and we, the FusionCMS team, sincerely hope that you will have a nice time using it.<div><br></div><div>To proceed, log into the administrator panel using an administrator account and the security code you specified during the installation.</div><div><br></div><br><div>Best regards,</div><div>the FusionCMS team</div>',
                            'author_id'                      => 0,
                            'timestamp'                      => time(),
                            'type'                           => 0,
                            'type_content'                   => null,
                            'comments'                       => -1
                        )
                    );
        }
    }

    /**
     * Get the article with the specified id.
     *
     * @param  $id
     * @return bool
     */
    public function getArticle($id)
    {
        $query = $this->db->query("SELECT * FROM articles WHERE id=?", array($id));

        if ($query->num_rows() > 0) {
            $result = $query->result_array();

            return $result[0];
        } else {
            return false;
        }
    }

    /**
     * Get the tags for the given article id
     *
     * @param  $articleId
     * @return array|bool
     */
    public function getTags($articleId)
    {
        $this->db->select('t.name');
        $this->db->where('at.article_id', $articleId);
        $this->db->where('at.tag_id = t.id');
        $query = $this->db->get('tag t, article_tag at');

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Count the articles
     *
     * @return Int
     */
    public function countArticles()
    {
        return $this->db->count_all('articles');
    }

    /**
     * Check whether an article exists or not
     *
     * @param  Int $id
     * @param  Boolean $comment Check if comments are enabled
     * @return bool
     */
    public function articleExists($id, $comment = false)
    {
        if (!$id) {
            return false;
        }

        $this->db->select('comments');
        $this->db->where('id', $id);
        $query = $this->db->get('articles');

        $result = $query->result_array();

        // If comments are enabled
        if ($comment && count($result) && $result[0]['comments'] != -1) {
            return true;
        }
        // If article exists
        elseif (!$comment && count($result)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Create a news article
     *
     * @param $type
     * @param $type_content
     * @param  $comments
     * @param  $headline
     * @param  $content
     * @return bool
     */
    public function create($type, $type_content, $comments, $headline, $content)
    {
        $data = array(
            'type' => $type,
            'type_content' => $type_content,
            'comments' => $comments,
            'timestamp' => time(),
            'author_id' => $this->user->getId(),
            'headline'  => $headline,
            'content'   => $content,
        );

        $this->db->insert("articles", $data);

        return true;
    }

    /**
     * Update the article with the given id
     *
     * @param  $id
     * @param $type
     * @param $type_content
     * @param  $comments
     * @param  $headline
     * @param  $content
     * @return bool
     */
    public function update($id, $type, $type_content, $comments, $headline, $content)
    {
        if (!is_numeric($id)) {
            return false;
        }

        $data = array(
            'type'         => $type,
            'type_content' => $type_content,
            'comments'     => $comments,
            'headline'     => $headline,
            'content'      => $content,
        );

        if ($data['comments'] == 0) {
            $query = $this->db->query("SELECT COUNT(*) as `total` FROM comments WHERE article_id=?", array($id));
            $result = $query->result_array();

            if ($result[0]['total'] != 0) {
                $data['comments'] = $result[0]['total'];
            }
        }

        $this->db->where('id', $id);
        $this->db->update("articles", $data);

        return true;
    }

    /**
     * Delete the article with the given id.
     *
     * @param  $articleId
     * @return bool
     */
    public function delete($articleId)
    {
        if (!is_numeric($articleId)) {
            return false;
        }

        $this->db->where('id', $articleId);
        $this->db->delete('articles');

        return true;
    }
}
