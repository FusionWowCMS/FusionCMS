<?php

use MX\MX_Controller;

/**
 * Messages Create Controller Class
 * @property create_model $create_model create_model Class
 */
class Create extends MX_Controller
{
    /**
     * Load model and make sure we're logged in
     */
    public function __construct()
    {
        parent::__construct();

        // Load our model
        $this->load->model('create_model');
        $this->load->library('bbcode');

        // Make sure they are logged in
        $this->user->userArea();

        requirePermission('view', 'messages');
        requirePermission('compose', 'messages');
    }

    /**
     * Display the compose page
     * @param bool|String $username
     */
    public function index(bool|string $username = false)
    {
        // Pass some language strings to the client
        clientLang("message_limit", "messages");
        clientLang("title_limit", "messages");
        clientLang("recipient_empty", "messages");
        clientLang("invalid_recipient", "messages");
        clientLang("sent", "messages");
        clientLang("the_inbox", "messages");
        clientLang("error", "messages");
        clientLang("title_cant_be_empty", "messages");

        $this->template->setTitle(lang("compose", "messages"));

        // Load the create view
        $data = [
            'username' => ($username) ? $this->user->getNickname($username) : '',
            'url' => $this->template->page_url
        ];

        $content = $this->template->loadPage("create.tpl", $data);

        // Define our box values
        $page_data = [
            'module' => 'default',
            'headline' => "<span style='cursor:pointer;' onClick='window.location=\"" . $this->template->page_url . "messages\"'>" . lang('messages', 'messages') . '</span> &rarr; ' . lang('compose', 'messages'),
            'content' => $content
        ];

        // Load the box
        $page = $this->template->loadPage('page.tpl', $page_data);

        // View our content
        $this->template->view($page, 'modules/messages/css/create.css', 'modules/messages/js/create.js');
    }

    /**
     * Add the message to the database
     * @param bool|String $username
     */
    public function submit(bool|string $username = false)
    {
        // Username must be set
        if (!$username) {
            die("no username");
        }

        $content = $this->input->post('content', false);
        $title = $this->input->post('title');

        // Message must be set and more than 3 characters
        if (!$content || strlen($content) <= 3) {
            die("content length");
        }

        $user_id = $this->internal_user_model->getIdByNickname($username);

        // You can't send it to yourself
        if ($user_id == $this->user->getId()) {
            die("yourself");
        }

        if (empty($user_id)) {
            die("invalid user");
        }

        $bbCode  = new Bbcode(Bbcode::HTML_TO_BBCODE);
        $content = $bbCode->convert($content);

        $content = $this->security->xss_clean($content);

        // Add it to the database
        $this->create_model->insertMessage($user_id, $this->user->getId(), $title, $content);

        // Clear the sender and receiver's PM cache
        $this->cache->delete('messages/' . $user_id . "_*");
        $this->cache->delete('messages/' . $this->user->getId() . "_*");

        die('sent');
    }

    /**
     *
     * @param bool|String $username
     */
    public function check(bool|string $username = false)
    {
        if (!$username) {
            die();
        }

        $results = $this->create_model->getUsersLike($username);

        if (!$results) {
            $json = [
                'status' => 0,
                'exact' => false,
                'users' => []
            ];
        } elseif ($results === true) {
            $json = [
                'status' => 1,
                'exact' => true,
                'users' => [$username]
            ];
        } else {
            $json = [
                'status' => 1,
                'exact' => false,
                'users' => $results
            ];
        }

        die(json_encode($json));
    }
}