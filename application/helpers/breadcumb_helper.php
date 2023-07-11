<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Create a breadcumb for headlines
 * Item A → Item B → Item C
 *
 * @param  Array $items
 * @return String
 */
function breadcumb($items)
{
    $CI = &get_instance();

    $data = array(
        "links" => $items,
        "url" => pageURL
    );

    $breadcumbView = "application/" . $CI->template->theme_path . "views/breadcumb.tpl";

    // Check if this theme wants to replace our view with it's own
    if (file_exists($breadcumbView))
    {
        return $CI->smarty->view($breadcumbView, $data, true);
    }
    else
    {
        // Load default
        return $CI->smarty->view($CI->template->view_path . "breadcumb.tpl", $data, true);
    }
}
