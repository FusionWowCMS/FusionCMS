<?php

class Icon extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('wowheaditems');
    }

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
        if ($item != false && is_numeric($item) && $realm != false)
        {
            // check if item is in cache
            $item_in_cache = $this->wowheaditems->get_item_cache($item, $realm);

            if ($item_in_cache)
            {
                $icon = $item_in_cache;
                die($icon);
            } else {
                // check if item is in database
                $item_in_db = $this->wowheaditems->get_item_db($item, $realm);

                if ($item_in_db)
                {
                    $icon = $item_in_db;
                    die($icon);
                } else {
                    // check if item is on Wowhead
                    $item_wowhead = $this->wowheaditems->get_item_wowhead($item, $realm);

                    if ($item_wowhead)
                    {
                        $icon = $item_wowhead;
                        die($icon);
                    } else {
                        $icon = "inv_misc_questionmark";
                        die($icon);
                    }
                }
            }
        }
    }
}
