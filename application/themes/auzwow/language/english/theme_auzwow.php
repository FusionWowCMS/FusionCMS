<?php defined('BASEPATH') OR exit('No direct script access allowed');

# Initialize lang
if(!isset($lang) || !is_array($lang))
    $lang = [];

/**
 *  - RTL -----------------------------------------------------
 *  -----------------------------------------------------------
 */
$lang['isRTL'] = 0;

/**
 *  - Global --------------------------------------------------
 *  -----------------------------------------------------------
 */
$lang['global_d']           = 'D';
$lang['global_h']           = 'H';
$lang['global_m']           = 'M';
$lang['global_s']           = 'S';
$lang['global_okay']        = 'Okay';
$lang['global_cancel']      = 'Cancel';
$lang['global_online']      = 'Online';
$lang['global_offline']     = 'Offline';
$lang['global_loading']     = 'Loading...';
$lang['global_readmore']    = 'Read more';
$lang['global_avatar']      = 'Avatar';
$lang['global_user_avatar'] = '%s\'s Avatar';

/**
 *  - Main Template -------------------------------------------
 *  -----------------------------------------------------------
 */
$lang['uinfo_welcome']      = 'Welcome back,';
$lang['message_no_pm']      = 'No new messages.';
$lang['message_one_pm']     = 'You have <i>%u</i> new message.';
$lang['message_x_pm']       = 'You have <i>%u</i> new messages.';
$lang['accmenu_panel']      = 'Account Panel';
$lang['accmenu_logout']     = 'Logout';
$lang['nluinfo_welcome']    = 'Welcome, <i>Guest</i>!';
$lang['nluinfo_msg']        = 'Please login to unlock more features.';
$lang['nlaccmenu_register'] = 'Create an account';
$lang['nlaccmenu_login']    = 'Login';

$lang['logo_title'] = 'Welcome to %s';

$lang['welcome_title']    = 'Welcome to <i>%s!</i>';
$lang['welcome_btn_1']    = 'Logout';
$lang['welcome_btn_2']    = 'Account';
$lang['welcome_link_1']   = 'How to connect';
$lang['welcome_link_2']   = 'Read more';
$lang['nlwelcome_btn_1']  = 'Login';
$lang['nlwelcome_btn_2']  = 'Register';
$lang['nlwelcome_link_1'] = 'How to connect';
$lang['nlwelcome_link_2'] = 'Forgot password';

$lang['announcement'] = 'Announcement:';

$lang['countdown']          = 'Countdown';
$lang['countdown_oops']     = 'Oops';
$lang['countdown_disabled'] = 'Countdown is <i>disabled</i>';

$lang['realmstatus_not_found'] = 'Please add realm status widget.';

$lang['footer_msg_title'] = 'Thanks for visiting <i>%s!</i>';
$lang['footer_nav_title'] = '<i>%s</i> Site Navigation';
$lang['footer_zafire']    = 'Designed by <a target="_blank" href="http://zafirehd.deviantart.com">Zafire.me</a>';
$lang['footer_darksider'] = 'Coded by <a href="skype:darkstriders?chat">E. Darksider</a>';
$lang['footer_copyright'] = 'Copyrights <strong>%s</strong>';

/**
 *  - News ----------------------------------------------------
 *  -----------------------------------------------------------
 */
$lang['news_latest_news'] = '<i>%s</i> Latest News';
$lang['news_send_pm']     = 'Send pm to %s';

/**
 *  - Sidebox: Status -----------------------------------------
 *  -----------------------------------------------------------
 */
$lang['sidebox_status_onlineplayers'] = 'Players online';
$lang['sidebox_status_uptime']        = 'uptime';
$lang['sidebox_status_setrealmlist']  = 'set realmlist';

/**
 *  - Sidebox: Socials ----------------------------------------
 *  -----------------------------------------------------------
 */
$lang['sidebox_socials_title']    = '<i>%s</i> on social networks';
$lang['sidebox_socials_facebook'] = 'Follow us on <i>Facebook</i>';
$lang['sidebox_socials_twitter']  = 'Follow us on <i>Twitter</i>';
$lang['sidebox_socials_youtube']  = 'Follow us on <i>Youtube</i>';

/**
 *  - Sidebox: Top PvP ----------------------------------------
 *  -----------------------------------------------------------
 */
$lang['sidebox_pvp_N']         = 'N';
$lang['sidebox_pvp_charname']  = 'Name';
$lang['sidebox_pvp_charclass'] = 'Class';
$lang['sidebox_pvp_charkills'] = 'Kills';
