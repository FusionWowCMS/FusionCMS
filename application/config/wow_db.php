<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * @package FusionCMS
 * @version 8.2
 * @link    https://github.com/FusionWowCMS/FusionCMS
 */

/*
|--------------------------------------------------------------------------
| API link to get item icons
|--------------------------------------------------------------------------
*/

$config['api_item_icons'] = "https://icons.wowdb.com/retail";
$config['api_item_custom'] = false;

$config['wow_db'] = [
    ['name' => 'WowDB', 'link' => 'https://icons.wowdb.com/retail'],
    ['name' => 'WowHead', 'link' => 'https://wow.zamimg.com/images/wow/icons'],
    ['name' => 'Cavern Of Time (Max expansion Mop)', 'link' => 'https://cdn.cavernoftime.com/mop/icons'],
    ['name' => 'Custom', 'link' => 'custom']
];