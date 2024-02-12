<?php

use MX\MX_Controller;

class Tooltip extends MX_Controller
{
    public function Index($realm = false, $id = false)
    {
        // Make sure item and realm are set
        if (!$id || !$realm) {
            die("No item or realm specified!");
        }

        $item = $this->items->getItem($id, $realm, 'htmlTooltip');

        if (!$item) {
            $item = lang("unknown_item", "tooltip");
        }

        $data = [
            'module' => 'tooltip',
            'item' => $item
        ];

        $out = $this->template->loadPage("tooltip.tpl", $data);

        die($out);
    }
}
