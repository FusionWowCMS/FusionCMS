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
    public string $name = "Topg";
    public string $url = "topg.org";
    public string $voteLinkFormat = "{vote_link}-{user_id}";

    protected function checkAccess(): bool
    {
        return $this->CI->input->ip_address() == gethostbyname('monitor.topg.org');
    }

    protected function readUserId()
    {
        return $this->CI->input->get('p_resp');
    }
}
