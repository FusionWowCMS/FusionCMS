<?php

class Settings extends MX_Controller
{
    public function __construct()
    {
        //Call the constructor of MX_Controller
        parent::__construct();

        $this->load->config('settings');
        $this->load->config('links');

        //Make sure that we are logged in
        $this->user->userArea();
    }

    public function index()
    {
        requirePermission("canUpdateAccountSettings");

        clientLang("nickname_error", "ucp");
        clientLang("location_error", "ucp");
        clientLang("pw_doesnt_match", "ucp");
        clientLang("changes_saved", "ucp");
        clientLang("invalid_pw", "ucp");
        clientLang("nickname_taken", "ucp");
        clientLang("invalid_language", "ucp");

        $this->template->setTitle(lang("settings", "ucp"));

        $settings_data = array(
            'nickname' => $this->user->getNickname(),
            'location' => $this->internal_user_model->getLocation(),
            'show_language_chooser' => $this->config->item('show_language_chooser'),
            'userLanguage' => $this->language->getLanguage(),
            "avatar" => $this->user->getAvatar($this->user->getId()),

            "config" => array(
                "vote" => $this->config->item('ucp_vote'),
                "donate" => $this->config->item('ucp_donate'),
                "store" => $this->config->item('ucp_store'),
                "settings" => $this->config->item('ucp_settings'),
                "teleport" => $this->config->item('ucp_teleport'),
                "admin" => $this->config->item('ucp_admin'),
                "mod" => $this->config->item('ucp_mod')
            )
        );

        if ($this->config->item('show_language_chooser')) {
            $settings_data['languages'] = $this->language->getAllLanguages();
        }

        $data = array(
            "module" => "default",
            "headline" => lang("user_panel", "ucp"),
            "content" => $this->template->loadPage("settings.tpl", $settings_data)
        );

        $page = $this->template->loadPage("page.tpl", $data);

        //Load the template form
        $this->template->view($page, "modules/ucp/css/ucp.css", "modules/ucp/js/settings.js");
    }

    public function submit()
    {
        $oldPassword = $this->input->post('old_password');
        $newPassword = $this->input->post('new_password');

        if ($oldPassword && $newPassword) {
            // Get the current password
            $currentPassword = $this->user->getPassword();

            // Hash the entered password
            $passwordHash = $this->user->createHash($this->user->getUsername(), $oldPassword);

            // Check if passwords match
            if (strtoupper($currentPassword) == strtoupper($passwordHash["verifier"])) {
                $hash = $this->user->createHash($this->user->getUsername(), $newPassword);

                $this->user->setPassword($hash["verifier"]);

                $this->plugins->onChangePassword($this->user->getId(), $hash);
            } else {
                die('no');
            }
        }

        die('yes');
    }

    public function submitInfo()
    {
        $this->load->model("settings_model");

        // Gather the values

        $nickname = $this->input->post("nickname");
        $location = $this->input->post("location");

        if (!is_string($nickname) || !is_string($location)) {
            die("4");
        }

        $values = array(
            // Update sanitization according to CMS standards.
            'nickname' => $this->template->format($nickname, false, true, false),
            'location' => $this->template->format($location, false, true, false),
        );

        // Change language
        if ($this->config->item('show_language_chooser')) {
            $values['language'] = $this->input->post("language");

            if (!is_dir("application/language/" . $values['language'])) {
                die("3");
            } else {
                $this->user->setLanguage($values['language']);

                $this->plugins->onSetLanguage($this->user->getId(), $values['language']);
            }
        }

        // Remove the nickname field if it wasn't changed
        if ($values['nickname'] == $this->user->getNickname()) {
            $values = array('location' => $location);
        } elseif (
            strlen($values['nickname']) < 4
            || strlen($values['nickname']) > 14
            || !preg_match("/[A-Za-z0-9]*/", $values['nickname'])
        ) {
            die(lang("nickname_error", "ucp"));
        } elseif ($this->internal_user_model->nicknameExists($values['nickname'])) {
            die("2");
        }

        if (strlen($values['location']) > 32 && !ctype_alpha($values['location'])) {
            die(lang("location_error", "ucp"));
        }

        $this->settings_model->saveSettings($values);

        $this->plugins->onSaveSettings($this->user->getId(), $values);

        die("1");
    }
}
