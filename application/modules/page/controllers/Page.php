<?php

class Page extends MX_Controller
{
    public function index($page = "error")
    {
        if ($page == "error") {
            redirect('error');
        } else {
            $cache = $this->cache->get("page_" . $page . "_" . getLang());

            $this->template->setCustomPage($page);

            if ($cache !== false) {
                $this->template->setTitle($cache['title']);
                $out = $cache['content'];

                if ($cache['permission'] && !hasViewPermission($cache['permission'], "--PAGE--")) {
                    $this->template->showError(lang("permission_denied", "error"));
                }
            } else {
                $page_content = $this->cms_model->getPage($page);

                if ($page_content == false) {
                    redirect('error');
                } else {
                    $this->template->setTitle(langColumn($page_content['name']));

                    $page_data = array(
                        "module" => "default",
                        "headline" => langColumn($page_content['name']),
                        "content" => langColumn($page_content['content'])
                    );

                    $out = $this->template->loadPage("page.tpl", $page_data);

                    $this->cache->save(
                        "page_" . $page . "_" . getLang(),
                        array(
                        "title" => langColumn($page_content['name']),
                        "content" => $out,
                        "permission" => $page_content['permission'])
                    );

                    if ($page_content['permission'] && !hasViewPermission($page_content['permission'], "--PAGE--")) {
                        $this->template->showError(lang("permission_denied", "error"));
                    }
                }
            }
        }

        $this->template->view($out);
    }
}
