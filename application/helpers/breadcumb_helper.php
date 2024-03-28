<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Create a breadcrumb for headline
 * Item A → Item B → Item C
 *
 * @param Array $items
 * @return String
 */
function breadcrumb(array $items): string
{
    $CI = &get_instance();

    $data = [
        "links" => $items,
        "url" => pageURL
    ];

    $breadcrumbView = "application/" . $CI->template->theme_path . "views/breadcrumb.tpl";

    // Check if this theme wants to replace our view with its own
    if (file_exists($breadcrumbView))
    {
        return $CI->smarty->view($breadcrumbView, $data, true);
    }
    else
    {
        // Load default
        return $CI->smarty->view($CI->template->view_path . 'breadcrumb.tpl', $data, true);
    }
}
