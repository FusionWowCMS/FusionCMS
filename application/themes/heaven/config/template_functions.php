<?php

# Import required classes
use MX\CI;

# Make sure we're in CI
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('FN_formatTitle'))
{
    /**
     * Smarty plugin formatTitle
     * @param  array  $params
     * @param  object $smarty
     * @return string
     */
    function FN_formatTitle($params, $smarty)
    {
        // Initialize title
        $title = '';

        // Set title
        if(isset($params['title']) && $params['title'])
            $title = $params['title'];

        // Explode title
        $title = explode(' ', $title);

        // Modify last item
        if(count($title) > 1)
            $title[count($title) - 1] = '<span>' . $title[count($title) - 1] . '</span>';

        return implode(' ', $title);
    }

    # Register plugin to smarty template
    CI::$APP->smarty->registerPlugin('function', 'formatTitle', 'FN_formatTitle');
}

# Prevent errors
$config = [];
