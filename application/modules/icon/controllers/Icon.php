<?php

use MX\MX_Controller;

class Icon extends MX_Controller
{
    /**
     * Get an item's icon display name
     *
     * @param bool|Int $realm
     * @param bool|Int $item
     * @return String
     */
    public function get(bool|int $realm = false, bool|int $item = false): string
    {
        // Check if item ID and realm is valid
        if ($item && is_numeric($item) && $realm) {
            // get item data
            $item_in_cache = $this->items->getItem($item, $realm, 'icon');

            if ($item_in_cache) {
                die($item_in_cache);
            }
        }

        return 'inv_misc_questionmark';
    }
}
