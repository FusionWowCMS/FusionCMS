<?php

/**
 * topstatus.net incentive voting
 * described at: http://www.topstatus.net/???
 *
 * @package FusionCMS
 * @author  Maxi Arnicke
 * @link    http://fusion-hub.com
 */

require_once(APPPATH . 'modules/vote/plugins/classes/VoteCallbackPlugin.php');

class Topstatus extends VoteCallbackPlugin
{
    public $url = "topstatus.net";
    public $voteLinkFormat = "{vote_link}-{user_id}";

    protected function checkAccess()
    {
        return $this->CI->input->ip_address() == gethostbyname('topstatus.net');
    }

    protected function readUserId()
    {
        return $this->CI->input->get('p_resp');
    }
}
