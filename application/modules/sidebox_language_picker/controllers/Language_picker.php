<?php

class Language_picker extends MX_Controller
{
    public function view()
    {
        $data = array(
            "module" => "sidebox_language_picker",
            "languages" => $this->language->getAllLanguages(),
            "current" => $this->language->getLanguage()
        );

        $page = $this->template->loadPage("language.tpl", $data);

        return $page;
    }

    public function set($language)
    {
        $language = urldecode($language);
        requirePermission("use", "sidebox_language_picker");

        $this->language->setLanguage($language);

        if ($this->user->isOnline()) {
            $this->user->setLanguage($language);
        } else {
            $this->session->set_userdata(array('language' => $language));
        }

        $this->plugins->onSetLanguage($this->user->getId(), $language);

        die();
    }
}
