<?php

use MX\MX_Controller;

/**
 * Messages Controller Class
 * @property inbox_model $inbox_model inbox_model Class
 */
class Messages extends MX_Controller
{
    /**
     * Load our resources
     */
    public function __construct()
    {
        parent::__construct();

        //Load libs and models.
        $this->load->library('pagination');
        $this->load->model('inbox_model');
        $this->load->config('messages');

        $this->user->userArea();

        requirePermission('view', 'messages');
    }

    /**
     * Display the inbox and sent page
     * @param Int $startIndex Start row for inbox pagination
     * @param bool|Int $sentIndex Start row for sent pagination
     */
    public function index(int $startIndex = 0, bool|int $sentIndex = false)
    {
        clientLang("deleting", "messages");
        clientLang("no_messages", "messages");

        // Auto-delete messages that are marked as deleted by both sender and receiver
        $this->inbox_model->clearDeleted($this->user->getId());

        $this->template->setTitle(lang("messages", "messages"));

        // Used to automatically show the sent page on load
        if ($sentIndex !== false) {
            $is_sent = true;
        } else {
            $sentIndex = 0;
            $is_sent = false;
        }

        // Is there cache available?
        $cache = $this->cache->get("messages/" . $this->user->getId() . "_" . $startIndex . "_" . $sentIndex . "_" . getLang());

        // Can we use it?
        if ($cache !== false) {
            $page = $cache;
        } else {
            // Get inbox messages
            $messages = $this->inbox_model->getMessages($this->user->getId(), $startIndex, ($startIndex + $this->config->item('pm_per_page')));

            // There are no messages
            if ($messages === false) {
                $messages = [];
            }

            // Get all nicknames
            foreach ($messages as $key => $value) {
                $messages[$key]['sender_name'] = $this->user->getNickname($value['sender_id']);
            }

            // Get sent messages
            $sent = $this->inbox_model->getSent($this->user->getId(), $sentIndex, ($sentIndex + $this->config->item('pm_per_page')));

            if ($sent === false) {
                $sent = [];
            }

            // Get all nicknames
            foreach ($sent as $key => $value) {
                $sent[$key]['receiver_name'] = $this->user->getNickname($value['user_id']);
            }

            // Gather all data
            $data = [
                'messages' => $messages,
                'sent' => $sent,
                'pagination' => $this->getPagination('inbox', $startIndex, $sentIndex),
                'sent_pagination' => $this->getPagination('sent', $startIndex, $sentIndex),
                'url' => $this->template->page_url,
                'sent_count' => $this->inbox_model->countSent($this->user->getId()),
                'inbox_count' => $this->inbox_model->countMessages($this->user->getId()),
                'is_sent' => $is_sent
            ];

            $content = $this->template->loadPage("inbox.tpl", $data);

            $page_data = [
                "module" => "default",
                "headline" => lang("pm", "messages"),
                "content" => $content
            ];

            $page = $this->template->loadPage("page.tpl", $page_data);

            // Cache it forever
            $this->cache->save("messages/" . $this->user->getId() . "_" . $startIndex . "_" . $sentIndex . "_" . getLang(), $page);
        }

        // Build template
        $this->template->view($page, "modules/messages/css/messages.css", "modules/messages/js/messages.js");
    }

    /**
     * Mark all received messages as deleted by the receiver
     */
    public function clear()
    {
        $this->inbox_model->clear($this->user->getId());

        die();
    }

    /**
     * Mark all sent messages as deleted by the sender
     */
    public function clearSent()
    {
        $this->inbox_model->clear($this->user->getId(), true);

        die();
    }

    /**
     * Make the pagination
     * @param String $type inbox or sent
     * @param Int $inbox Current index
     * @param Int $sent Current index
     * @return String
     */
    private function getPagination(string $type, int $inbox, int $sent)
    {
        if ($type == "inbox") {
            $count = $this->inbox_model->countMessages($this->user->getId());

            if ($inbox + $this->config->item('pm_per_page') <= $count
                && $inbox - $this->config->item('pm_per_page') >= 0) {
                $link = '<a href="' . base_url() . 'messages/page/' . ($inbox - $this->config->item('pm_per_page')) . '">&larr; ' . lang("newer", "messages") . '</a>';
                $link .= '<a href="' . base_url() . 'messages/page/' . ($inbox + $this->config->item('pm_per_page')) . '">' . lang("older", "messages") . ' &rarr;</a>';
            } elseif ($inbox + $this->config->item('pm_per_page') <= $count) {
                $link = '<a href="' . base_url() . 'messages/page/' . ($inbox + $this->config->item('pm_per_page')) . '">' . lang("older", "messages") . ' &rarr;</a>';
            } elseif ($inbox + $this->config->item('pm_per_page') > $count && $inbox != 0) {
                $link = '<a href="' . base_url() . 'messages/page/' . ($inbox - $this->config->item('pm_per_page')) . '">&larr; ' . lang("newer", "messages") . '</a>';
            } else {
                $link = '';
            }
        } else {
            $count = $this->inbox_model->countSent($this->user->getId());

            if ($sent + $this->config->item('pm_per_page') <= $count
                && $sent - $this->config->item('pm_per_page') >= 0) {
                $link = '<a href="' . base_url() . 'messages/page/' . $inbox . '/' . ($sent - $this->config->item('pm_per_page')) . '">&larr; ' . lang("newer", "messages") . '</a>';
                $link .= '<a href="' . base_url() . 'messages/page/' . $inbox . '/' . ($sent + $this->config->item('pm_per_page')) . '">' . lang("older", "messages") . ' &rarr;</a>';
            } elseif ($sent + $this->config->item('pm_per_page') <= $count) {
                $link = '<a href="' . base_url() . 'messages/page/' . $inbox . '/' . ($sent + $this->config->item('pm_per_page')) . '">' . lang("older", "messages") . ' &rarr;</a>';
            } elseif ($sent + $this->config->item('pm_per_page') > $count && $sent != 0) {
                $link = '<a href="' . base_url() . 'messages/page/' . $inbox . '/' . ($sent - $this->config->item('pm_per_page')) . '">&larr; ' . lang("newer", "messages") . '</a>';
            } else {
                $link = '';
            }
        }

        return '<div id="messages_pagination">' . $link . '</div>';
    }
}
