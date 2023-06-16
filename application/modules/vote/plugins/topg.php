<?php

/**
 * topg.org vote postback
 * described at: http://topg.org/voting_check
 *
 * @package FusionCMS
 * @author  Maxi Arnicke
 * @link    http://fusion-hub.com
 */

require_once(APPPATH . 'modules/vote/plugins/classes/VoteCallbackPlugin.php');

class Topg extends VoteCallbackPlugin
{
    public $url = "topg.org";
    public $voteLinkFormat = "{vote_link}-{user_id}";

    protected function checkAccess()
    {
        return $this->CI->input->ip_address() == gethostbyname('monitor.topg.org');
    }

    protected function readUserId()
    {
        return $this->CI->input->get('p_resp');
    }
}
