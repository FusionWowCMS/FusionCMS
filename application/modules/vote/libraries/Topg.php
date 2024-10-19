<?php

/**
 * topg.org vote postback
 * described at: http://topg.org/voting_check
 *
 * @package FusionCMS
 * @author  Maxi Arnicke
 * @link    http://fusion-hub.com
 */

require_once(APPPATH . 'modules/vote/libraries/classes/VoteCallback.php');

class Topg extends VoteCallback
{
    public string $name = "Topg";
    public string $url = "topg.org";
    public string $voteLinkFormat = "{vote_link}-{username}";

    protected function checkAccess(): bool
    {
        return $this->CI->input->ip_address() == gethostbyname('monitor.topg.org');
    }

    protected function readUserId()
    {
        return $this->CI->input->get('p_resp');
    }
}
