<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * @package FusionCMS
 * @since 8.3.2
 * @version 8.3.2
 * @link    https://github.com/FusionWowCMS/FusionCMS
 */

$config['account_encryption'] = "SPH"; // SPH, SRP, SRP6

$config['rbac'] = true;

$config['battle_net'] = true;

$config['battle_net_encryption'] = "SPH"; // SRP6_V2, SRP6_V1, SPH
