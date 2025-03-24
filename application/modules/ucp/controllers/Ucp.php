<?php

use MX\MX_Controller;

/**
 * Ucp Controller Class
 * @property ucp_model $ucp_model ucp_model Class
 */
class Ucp extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->user->userArea();

        $this->load->config('links');

        $this->load->model("ucp_model");
    }

    public function index()
    {
        requirePermission("view");

        $this->template->setTitle(lang("user_panel", "ucp"));

        $menus = $this->ucp_model->getMenu();

        $groupedMenus = [];
        foreach ($menus as &$menu) {
            $menu['name'] = $this->template->format(langColumn($menu['name']), false, false);

            // Add the website path if internal link
            if (!preg_match("/https?:\/\//", $menu['link'])) {
                $menu['link'] = $this->template->page_url . $menu['link'];
            }

            if ($menu['permission'] == 'securityAccount') {
                if ($this->config->item('totp_secret')) {
                    $groupedMenus[$menu['group']][] = $menu;
                }
                continue;
            }

            if (hasPermission($menu['permission'], $menu['permissionModule']))
                $groupedMenus[$menu['group']][] = $menu;
        }

        $data = [
            "username" => $this->user->getUsername(),
            "nickname" => $this->user->getNickname(),
            "vp" => $this->internal_user_model->getVp(),
            "dp" => $this->internal_user_model->getDp(),
            "url" => $this->template->page_url,
            "location" => $this->internal_user_model->getLocation(),
            "groups" => $this->acl_model->getGroupsByUser($this->user->getId()),
            "register_date" => $this->user->getRegisterDate(),
            "status" => $this->user->getAccountStatus(),
            "avatar" => $this->user->getAvatar($this->user->getId()),
            "id" => $this->user->getId(),

            "config" => [
                "vote" => $this->config->item('ucp_vote'),
                "donate" => $this->config->item('ucp_donate'),
                "store" => $this->config->item('ucp_store'),
                "settings" => $this->config->item('ucp_settings'),
                "security" => $this->config->item('ucp_security'),
                "teleport" => $this->config->item('ucp_teleport'),
                "admin" => $this->config->item('ucp_admin'),
                "gm" => $this->config->item('ucp_mod')
            ],

            "characters" => $this->realms->getTotalCharacters(),
            "realms" => $this->realms->getRealms(),
            "realmObj" => $this->realms,
            "menus" => $groupedMenus,
        ];
        
        $data['email'] = false;

        if ($this->user->getEmail())
        {
            $data['email'] = $this->mask_email($this->user->getEmail());
        }

        $this->template->view($this->template->loadPage("page.tpl", [
            "module" => "default",
            "headline" => lang("user_panel", "ucp"),
            "content" => $this->template->loadPage("ucp.tpl", $data)
        ]), "modules/ucp/css/ucp.css");
    }

    public function characters()
    {
        $characters_data = [
            "characters" => $this->realms->getTotalCharacters(),
            "realms" => $this->realms->getRealms(),
            "url" => $this->template->page_url,
            "realmObj" => $this->realms,
            "avatar" => $this->user->getAvatar($this->user->getId()),

            "config" => [
                "vote" => $this->config->item('ucp_vote'),
                "donate" => $this->config->item('ucp_donate'),
                "store" => $this->config->item('ucp_store'),
                "settings" => $this->config->item('ucp_settings'),
                "security" => $this->config->item('ucp_security'),
                "teleport" => $this->config->item('ucp_teleport'),
                "admin" => $this->config->item('ucp_admin'),
                "gm" => $this->config->item('ucp_mod')
            ]
        ];

        $content = $this->template->loadPage("ucp_characters.tpl", $characters_data);
        $this->template->view($content, "modules/ucp/css/ucp.css");
    }
	
    private function mask_email($email)
    {
        $mail_parts = explode("@", $email);
        $len = strlen($mail_parts[0]);

        $mail_parts[0] = substr($mail_parts[0], 0, 2).str_repeat('*', 5).substr($mail_parts[0], $len - 1, 2); // show first 2 letters and last 1 letter

        return implode("@", $mail_parts);
    }
}
