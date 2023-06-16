<?php

class Profile extends MX_Controller
{
    private $js;
    private $css;
    private $id;
    private $username;
    private $location;
    private $register_date;
    private $rank_name;

    public function __construct()
    {
        parent::__construct();

        requirePermission("view");
    }

    /**
     * Determinate which Id to assign
     */
    public function setId($id)
    {
        // Id isn't set - default to current user
        if (
            $id == false
            && $this->user->isOnline()
        ) {
            redirect('profile/' . $this->user->getId());
        }

        // Id is set and exists
        elseif (
            $id != false
            && $this->external_account_model->userExists($id)
        ) {
            $this->id = $id;
        }

        // Id isn't set and user isn't logged in
        else {
            $this->id = false;
        }
    }

    public function index($id = false)
    {
        // Find out which ID to use
        $this->setId($id);

        // Is id set?
        if (is_numeric($this->id)) {
            $own = ($this->id == $this->user->getId()) ? "_own" : null;

            // Check if we can use the cache
            $cache = $this->cache->get("profile_" . $this->id . $own);

            if ($cache !== false) {
                // Use the cache
                $out = $cache['content'];
                $this->username = $cache['username'];
            } else {
                // No cache available, load profile
                $out = $this->getProfile();

                $this->cache->save("profile_" . $this->id . $own, array("content" => $out, "username" => $this->username), 60 * 60);
            }

            $this->template->setTitle($this->username);
        } else {
            // User isn't set, show error
            $out = $this->getError();
        }

        //Load the template form
        $this->template->view($out, "modules/profile/css/profile.css");
    }

    private function getInfo()
    {
        $internal = $this->internal_user_model->getValue("account_data", "id", $this->id, "location");
        $external = $this->external_account_model->getInfo($this->id, "joindate, username");

        $this->username = $this->user->getNickname($this->id);
        $this->register_date = preg_replace("/\s.*/", "", $external['joindate']);
        $this->location = ($internal) ? $internal['location'] : "Unknown";
        $this->groups = $this->acl_model->getGroupsByUser($this->id);
    }

    private function getProfile()
    {
        $cache = $this->cache->get("profile_characters_" . $this->id);

        if ($cache !== false) {
            $characters = $cache;
        } else {
            $characters = $this->template->loadPage("ucp_characters.tpl", array(
                "characters" => $this->realms->getTotalCharacters($this->id),
                "realms" => $this->realms->getRealms(),
                "realmsObj" => $this->realms,
                "url" => $this->template->page_url,
                "id" => $this->id
            ));

            $this->cache->save("profile_characters_" . $this->id, $characters, 60 * 60);
        }

        $this->getInfo();

        $profile_data = array(
            "characters" => $characters,
            "username" => $this->username,
            "location" => $this->location,
            "status" => $this->user->getAccountStatus($this->id),
            "register_date" => $this->register_date,
            "url" => $this->template->page_url,
            "avatar" => $this->user->getAvatar($this->id, "small"),
            "not_me" => ($this->id == $this->user->getId()) ? false : true,
            "online" => $this->user->isOnline(),
            "id" => $this->id,
            "groups" => $this->groups
        );

        $data = array(
            "module" => "default",
            "headline" => $this->username,
            "content" => $this->template->loadPage("profile.tpl", $profile_data)
        );

        return $this->template->loadPage("page.tpl", $data);
    }

    private function getError()
    {
        $data = array(
            "module" => "default",
            "headline" => lang("doesnt_exist", "profile"),
            "content" => "<center style='margin:10px;font-weight:bold;'>" . lang("doesnt_exist_long", "profile") . "</center>"
        );

        return $this->template->loadPage("page.tpl", $data);
    }
}
