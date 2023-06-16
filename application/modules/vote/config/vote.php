<?php

/*
|--------------------------------------------------------------------------
| Allow only one vote per account (even on multiple IPs)
|--------------------------------------------------------------------------
|
| If set to false, the user may vote from different IPs, such as proxies.
|
*/

$config['vote_ip_lock'] = true;
$config['delete_old_votes'] = true;
