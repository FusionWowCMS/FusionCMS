<?php

use MX\MX_Controller;

/**
 * Shoutbox Controller Class
 * @property shoutbox_model $shoutbox_model shoutbox_model Class
 */
class Shoutbox extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('sidebox_shoutbox/shoutbox_model');
        $this->load->config('sidebox_shoutbox/shoutbox_config');
    }

    public function view()
    {
        $shouts = $this->get();

        $data = [
            "module" => "sidebox_shoutbox",
            "shouts" => $shouts,
            "logged_in" => $this->user->getOnline(),
            "count" => $this->getCount(),
            "shoutsPerPage" => $this->config->item("shouts_per_page")
        ];

        return $this->template->loadPage("shoutbox_view.tpl", $data);
    }

    public function get($id = false)
    {
        // Is it loaded via ajax or not?
        if ($id === false) {
            $id = 0;
            $die = false;
        } else {
            $die = true;
        }

        $cache = $this->cache->get("shoutbox_" . $id . "_" . getLang());

        if ($cache !== false) {
            $shouts = $cache;
        } else {
            // Load the shouts
            $shouts = $this->shoutbox_model->getShouts($id, $this->config->item('shouts_per_page'));

            // Format the shout data
            foreach ($shouts as $key => $value) {
                $shouts[$key]['nickname'] = $this->internal_user_model->getNickname($value['author']);
                $shouts[$key]['content'] = $this->template->format($shouts[$key]['content'], true);
            }

            $this->cache->save("shoutbox_" . $id . "_" . getLang(), $shouts);
        }

        foreach ($shouts as $key => $value) {
            $shouts[$key]['date'] = $this->template->formatTime(time() - $value['date']);
        }

        // Prepare the data
        $data = [
            "module" => "sidebox_shoutbox",
            "shouts" => $shouts,
            "url" => $this->template->page_url,
            "user_is_gm" => hasPermission("removeShout", "sidebox_shoutbox")
        ];

        $shouts = $this->template->loadPage("shouts.tpl", $data);

        // To be or not to be, that's the question :-)
        if ($die) {
            die($shouts);
        } else {
            return $shouts;
        }
    }

    public function submit()
    {
        // Check for the permission
        requirePermission("shout", "sidebox_shoutbox");

        $content = $this->input->post('message');

        if ($this->user->isOnline() && $content) {
            $this->cache->delete('shoutbox_*');
            $this->shoutbox_model->insertShout($content);

            $data = [
                'uniqueId' => uniqid(),
                'message' => $this->template->format($content, true),
                'name' => $this->user->getNickname(),
                'id' => $this->user->getId(),
                'time' => $this->template->formatTime(1)
            ];

            die(json_encode($data));
        }
    }

    private function getCount()
    {
        $cache = $this->cache->get("shoutbox_count");

        if ($cache !== false) {
            return $cache;
        } else {
            $count = $this->shoutbox_model->getCount();

            $this->cache->save("shoutbox_count", $count);

            return $count;
        }
    }

    public function delete($id = false)
    {
        // Check for the permission
        requirePermission("removeShout", "sidebox_shoutbox");

        if (!$id) {
            die();
        }

        $this->shoutbox_model->deleteShout($id);
        $this->cache->delete('shoutbox_*');

        // Add log
        $this->dblogger->createLog("admin", "delete", 'Deleted shout', ['ID' => $id]);

        die('Success');
    }
}
