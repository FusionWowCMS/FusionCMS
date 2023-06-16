<?php

class Guild extends MX_Controller
{
    private $realm;
    private $guild;
    private $members;
    private $guildLeader;

    public function __construct()
    {
        $this->load->model('guild_model');
    }

    public function index($realm = false, $id = false)
    {
        // Make sure item and realm are set
        if (!$id || !$realm) {
            die(lang("invalid", "guild"));
        }

        $cache = $this->cache->get('guild_' . $realm . '_' . $id . "_" . getLang());

        if ($cache !== false) {
            $page = $cache;
        } else {
            $this->realm = $realm;
            $this->loadGuild($realm, $id);

            if (!$this->guild) {
                $this->template->setTitle(lang("invalid_guild", "guild"));
            } else {
                $this->template->setTitle($this->guild['guildName']);
            }

            $guild_data = array(
                'module' => 'guild',
                'guild' => $this->guild,
                'members' => $this->members,
                'leader' => $this->guildLeader,
                'realmId' => $realm,
                'realmName' => $this->realms->getRealm($realm)->getName(),
                'url' => $this->template->page_url
            );
            if ($this->guild) {
                $guild_data['guildMotd'] = $this->template->format($this->guild['motd'], false, true, false);
            }

            $content = $this->template->loadPage("guild.tpl", $guild_data);

            $data = array(
                "module" => "default",
                "headline" => "<span style='cursor:pointer;' onClick='window.location=\"" . $this->template->page_url . "armory\"'>" . lang("armory", "guild") . "</span> &rarr; " . ((!$this->guild) ? lang("invalid_guild", "guild") : $this->guild['guildName']),
                "content" => $content
            );

            $page = $this->template->loadPage("page.tpl", $data);

            $this->cache->save('guild_' . $realm . '_' . $id . "_" . getLang(), $page, 60 * 60);
        }

        $this->template->view($page, "modules/guild/css/guild.css");
    }

    public function loadGuild($realm, $id)
    {
        $this->guild = $this->guild_model->getGuild($realm, $id);
        if (!empty($this->guild['leaderguid']) && $this->realms->getRealm($realm)->getCharacters()->characterExists($this->guild['leaderguid']))
        {
            $this->guildLeader = $this->guild_model->loadMember($realm, $this->guild['leaderguid']);
        }

        $this->members = $this->guild_model->getGuildMembers($realm, $id);

        if ($this->guild)
        {
            if ($this->realms->getRealm($realm)->getCharacters()->characterExists($this->guild['leaderguid']))
            {
                $this->guildLeader['classId'] = $this->guildLeader['class'];
                $this->guildLeader['raceId'] = $this->guildLeader['race'];
                $this->guildLeader['gender'] = $this->guildLeader['gender'];
                $this->guildLeader['faction'] = $this->realms->getRealm($realm)->getCharacters()->getFaction($this->guild['leaderguid']);
            }

            if ($this->members)
            {
                foreach ($this->members as $key => $value)
                {
                    $this->members[$key]['classId'] = $this->members[$key]['class'];
                    $this->members[$key]['raceId'] = $this->members[$key]['race'];
                    $this->members[$key]['gender'] = $this->members[$key]['gender'];
                    $this->members[$key]['faction'] = $this->realms->getRealm($realm)->getCharacters()->getFaction($this->members[$key]['guid']);
                }
            }
        }
    }
}
