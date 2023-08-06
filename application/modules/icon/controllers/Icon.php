<?php

class Icon extends MX_Controller
{
    /**
     * Get an item's icon display name
     *
     * @param  Int $realm
     * @param  Int $item
     * @return String
     */
    public function get($realm = false, $item = false)
    {
        // Check if item ID and realm is valid
        if ($item != false && is_numeric($item) && $realm != false) {
            // get item data
            $item_in_cache = $this->items->getItem($item, $realm, 'icon');

            if ($item_in_cache) {
                $icon = $item_in_cache;
                die($icon);
            } else {
                $icon = "inv_misc_questionmark";
                die($icon);
            }
        }
    }
}
