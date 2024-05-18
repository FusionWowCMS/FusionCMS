<?php

declare(strict_types=1);

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CodeIgniter\Debug\Toolbar\Collectors;

use App\Config\App;

/**
 * Debug toolbar configuration
 */
class Config
{
    /**
     * Return toolbar config values as an array.
     */
    public static function display(): string
    {
        $config = config(App::class);

        $data = [
            'ciVersion'   => CI_VERSION,
            'phpVersion'  => PHP_VERSION,
            'phpSAPI'     => PHP_SAPI,
            'environment' => ENVIRONMENT,
            'baseURL'     => base_url(),
            'timezone'    => app_timezone(),
            'locale'      => service('request')->getLocale(),
            'cspEnabled'  => $config->CSPEnabled,
        ];

        return get_instance()->smarty->view(realpath(SYSTEMPATH) . DIRECTORY_SEPARATOR . 'Debug'  . DIRECTORY_SEPARATOR . 'Toolbar' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . '_config.tpl', $data, true);
    }
}
