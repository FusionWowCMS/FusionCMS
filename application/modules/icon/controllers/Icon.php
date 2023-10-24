<?php

class Icon extends MX_Controller
{
    /**
     * Get an item's icon display name
     *
     * @param false|Int $realm
     * @param false|Int $item
     * @return String
     */
    public function get(false|int $realm = false, false|int $item = false): string
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
