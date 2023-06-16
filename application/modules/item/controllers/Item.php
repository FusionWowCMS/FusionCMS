<?php

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

        $cache = $this->cache->get("items/tooltip_" . $realm . "_" . $id . "_" . getLang());
        $cache2 = $this->cache->get("items/item_" . $realm . "_" . $id);

        if ($cache2 !== false) {
            $itemName = $cache2['name'];
        } else {
            $itemName = lang("view_item", "item");
        }

        $this->template->setTitle($itemName);

        $icon = $this->getIcon($id);

        if ($cache !== false) {
            $item = $cache;
        } else {
            $item = $this->template->loadPage("ajax.tpl", array('module' => 'item', 'id' => $id, 'realm' => $realm, 'icon' => $icon));
        }

        $content = $this->template->loadPage("item.tpl", array('module' => 'item', 'item' => $item, 'icon' => $icon));

        $data3 = array(
                "module" => "default",
                "headline" => "<span style='cursor:pointer;' onClick='window.location=\"" . $this->template->page_url . "armory\"'>" . lang("armory", "item") . "</span> &rarr; " . $itemName,
                "content" => $content
            );

        $page = $this->template->loadPage("page.tpl", $data3);

        $this->template->view($page, "modules/item/css/item.css");
    }

    private function getIcon($id)
    {
        $cache = $this->cache->get("items/item_" . $this->realm . "_" . $id);

        if ($cache !== false) {
            $cache2 = $this->cache->get("items/display_iconname_" . $id);

            if ($cache2 != false) {
                return "<div class='item'><a></a><img src='https://icons.wowdb.com/retail/large/" . $cache2 . ".jpg' /></div>";
            } else {
                return "<div class='item'><a></a><img src='https://icons.wowdb.com/retail/large/inv_misc_questionmark.jpg' /></div>";
            }
        } else {
            return $this->template->loadPage("icon_ajax.tpl", array('id' => $id, 'realm' => $this->realm, 'url' => $this->template->page_url));
        }
    }
}
