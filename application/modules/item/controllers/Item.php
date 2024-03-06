<?php

use MX\MX_Controller;

class Item extends MX_Controller
{
    private $realm;

    public function Index($realm = false, $id = false)
    {
        clientLang("loading", "item");

        // Make sure item and realm are set
        if (!$id || !$realm) {
            die(lang("no_item", "item"));
        }

        $this->realm = $realm;

        $cache = $this->cache->get("items/item_" . $realm . "_" . $id);

        if ($cache !== false) {
            $itemName = $cache['name'];
            $displayid = $cache['displayid'];
            $icon = str_replace(['_baseURL_', '_icon_'], [$this->config->item('api_item_icons'), ($cache['icon'] != null ? $cache['icon'] : 'inv_misc_questionmark')], '<div class="item"><a></a><img src="_baseURL_/large/_icon_.jpg" /></div>');
            $item = $cache['htmlTooltip'];
        } else {
            $itemName = lang("view_item", "item");
            $displayid = false;
            $icon = $this->template->loadPage("icon_ajax.tpl", ['id' => $id, 'realm' => $this->realm, 'url' => $this->template->page_url]);
            $item = $this->template->loadPage("ajax.tpl", ['module' => 'item', 'id' => $id, 'realm' => $realm, 'icon' => $icon, 'displayid' => $displayid]);
        }

        $this->template->setTitle($itemName);

        $content = $this->template->loadPage("item.tpl", ['module' => 'item', 'item' => $item, 'icon' => $icon, 'displayid' => $displayid]);

        $data3 = array(
            "module" => "default",
            "headline" => breadcrumb([
                "armory" => lang("armory", "item"),
                uri_string() => $itemName
            ]),
            "content" => $content
        );

        $page = $this->template->loadPage("page.tpl", $data3);

        $this->template->view($page, "modules/item/css/item.css");
    }

    public function ajax(int $realm = 0, int $item = 0)
    {
        if (!$this->input->is_ajax_request()) {
            die('No direct script access allowed');
        }

        // Make sure item and realm are set
        if (!$item || !$realm) {
            die(lang("no_item", "item"));
        }

        die(json_encode($this->items->getItem($item, $realm)));
    }
}
