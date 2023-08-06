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

        $cache = $this->cache->get("items/item_" . $realm . "_" . $id);

        if ($cache !== false) {
            $itemName = $cache['name'];
            $displayId = $cache['displayid'];
            $icon = "<div class='item'><a></a><img src='https://icons.wowdb.com/retail/large/" . ($cache['icon'] != null ? $cache['icon'] : 'inv_misc_questionmark') . ".jpg' /></div>";
            $item = $cache['htmlTooltip'];
        } else {
            $itemName = lang("view_item", "item");
            $displayId = false;
            $icon = $this->template->loadPage("icon_ajax.tpl", array('id' => $id, 'realm' => $this->realm, 'url' => $this->template->page_url));
            $item = $this->template->loadPage("ajax.tpl", array('module' => 'item', 'id' => $id, 'realm' => $realm, 'icon' => $icon, 'displayid' => $displayId));
        }

        $this->template->setTitle($itemName);

        $content = $this->template->loadPage("item.tpl", array('module' => 'item', 'item' => $item, 'icon' => $icon, 'displayid' => $displayId));

        $data3 = array(
            "module" => "default",
            "headline" => "<span style='cursor:pointer;' onClick='window.location=\"" . $this->template->page_url . "armory\"'>" . lang("armory", "item") . "</span> &rarr; " . $itemName,
            "content" => $content
        );

        $page = $this->template->loadPage("page.tpl", $data3);

        $this->template->view($page, "modules/item/css/item.css");
    }
}
