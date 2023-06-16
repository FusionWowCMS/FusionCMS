<?php

class Comments extends MX_Controller
{
    public function __construct()
    {
        //Call the constructor of MX_Controller
        parent::__construct();

        $this->load->model('comments_model');
        $this->load->model('news_model');

        $this->load->config('news');
    }

    /**
     * Load the comments of one article
     *
     * @param Int $id
     */
    public function get($id)
    {
        requirePermission("canViewComments");

        $cache = $this->cache->get("comments_" . $id . "_" . getLang());

        if ($cache !== false) {
            $comments = $cache;
        } else {
            $comments = $this->comments_model->getComments($id);

            if (is_array($comments)) {
                // Loop through and format the comments
                foreach ($comments as $key => $comment) {
                    $comments[$key]['profile'] = $this->template->page_url . "profile/" . $comment['author_id'];
                    $comments[$key]['avatar'] = $this->user->getAvatar($comment['author_id'], "small");
                    $comments[$key]['author'] = $this->user->getNickname($comment['author_id']);
                }
            }

            $this->cache->save("comments_" . $id . "_" . getLang(), $comments);
        }

        $comments_html = '';

        if (is_array($comments)) {
            $comments_html = $this->template->loadPage("comments.tpl", array('url' => $this->template->page_url, 'comments' => $comments, 'user_is_gm' => hasPermission('canRemoveComment')));
        }

        $values = array(
                    "form" => ($this->user->isOnline()) ? "onSubmit='Ajax.submitComment(" . $id . ");return false'" : "onSubmit='UI.alert(\"Please log in to comment!\");return false'",
                    "online" => $this->user->isOnline(),
                    "field_id" => "id='comment_field_" . $id . "'",
                    "comments" => $comments_html,
                    "comments_id" => "id='comments_area_" . $id . "'",
                    "id" => $id,
                );

        $output = $this->template->loadPage("article_comments.tpl", $values);

        die($output);
    }

    /**
     * Submit a comment to an article
     *
     * @param Int $id
     */
    public function add($id = false)
    {
        requirePermission("canAddComment");

        if (!$id) {
            die();
        }

        // Check if article exist and if you can comment it
        if ($this->news_model->articleExists($id, true) && $this->user->isOnline()) {
            $message = $this->input->post('content');

            if (strlen($message) > 0 && $message && strlen($message) <= 255) {
                // Format the comment
                $comment = array(
                    "timestamp" => time(),
                    "article_id" => $id,
                    "author_id" => $this->user->getId(),
                    "content" => $message,
                    "is_gm" => (hasPermission('postCommentAsStaff')) ? 1 : 0
                );

                $this->comments_model->addComment($comment);

                // Add log
                $this->logger->createLog("user", "add", "Added comment", ['ID' => $id]);

                $this->plugins->onAddComment($id, $message);

                // Get last comment
                $comment_arr = $this->comments_model->getLastComment($id);

                // Add values
                $comment_arr['profile'] = $this->template->page_url . "profile/" . $comment_arr['author_id'];
                $comment_arr['avatar'] = $this->user->getAvatar($comment_arr['author_id'], "small");
                $comment_arr['author'] = $this->user->getNickname($comment_arr['author_id']);
                $comment_arr['content'] = $this->template->format($message, true, true, 45);
                $comment_arr['url'] = $this->template->page_url;
                $comment_arr['is_gm'] = $comment['is_gm'];

                // Clear cache
                $this->cache->delete('news_*.cache');
                $this->cache->delete('comments_' . $id . '_*.cache');

                // Load the comment template, also check if we are a staff member
                $data = array(
                    'comments' => array($comment_arr),
                    'user_is_gm' => hasPermission('postCommentAsStaff'),
                    'url' => $this->template->page_url
                );

                die($this->template->loadPage("comments.tpl", $data));
            }
        }
    }

    /**
     * Delete the comment with the given id.
     *
     * @param bool $id
     */
    public function delete($id = false)
    {
        requirePermission("canRemoveComment");

        if (!$id) {
            die();
        }

        $articleId = $this->comments_model->deleteComment($id);
        $this->cache->delete('news_*.cache');
        $this->cache->delete('comments_' . $articleId . '_*.cache');

        // Add log
		$this->logger->createLog("admin", "delete", "Deleted comment", ['ID' => $id]);

        $this->plugins->onDeleteComment($id, $articleId);

        die('Success');
    }
}
