<?php

use MX\MX_Controller;

class Online extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        requirePermission('view');
        $this->load->config('online');
    }

    public function index()
    {
        clientLang("no_players", "online");
        clientLang("offline", "online");

        $this->template->setTitle(lang('online_players', 'online'));

        $content_data = [
            'realms' => $this->realms->getRealms(),
            'url' => $this->template->page_url,
        ];

        $page_content = $this->template->loadPage('online.tpl', $content_data);

        //Load the page
        $page_data = [
            'module' => 'default',
            'headline' => lang('online_players', 'online'),
            'content' => $page_content
        ];

        $page = $this->template->loadPage('page.tpl', $page_data);

        $this->template->view($page, 'modules/online/css/online.css', 'modules/online/js/online.js');
    }

    public function online_refresh($realm_id = 0)
    {
        $realm = $this->realms->getRealm($realm_id);

        if (!$realm || !$realm->isOnline()) {
            echo json_encode(['status' => 'offline']);
            return;
        }

        $cache = $this->cache->get('online_list_' . $realm_id);

        if ($cache !== false) {
            echo json_encode(['status' => 'ok', 'data' => $cache]);
            return;
        }

        $hide_gms = $this->config->item('hide_gms');
        $players = $realm->getCharacters()->getOnlinePlayers($hide_gms);

        if (empty($players)) {
            echo json_encode(['status' => 'empty', 'data' => []]);
            return;
        }

        $data = [];

        foreach ($players as $character) {
            $data[] = [
                "guid" => $character['guid'],
                "name" => $character['name'],
                "level" => $character['level'],
                "race" => $character['race'],
                "gender" => $character['gender'],
                "class" => $character['class'],
                "zone" => $this->realms->getZone($character['zone'])
            ];
        }

        $this->cache->save('online_list_' . $realm_id, $data, 60 * 5);

        echo json_encode(['status' => 'ok', 'data' => $data]);
    }

}
