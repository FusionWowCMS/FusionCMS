<?php

/**
 * top100arena.com incentive voting
 * described at: http://www.top100arena.com/incentive.asp
 *
 * @package FusionCMS
 * @author  Maxi Arnicke
 * @link    http://fusion-hub.com
 */

require_once(APPPATH . 'modules/vote/libraries/classes/VoteCallback.php');

class Top100arena extends VoteCallback
{
    public string $name = "Top100arena";
    public string $url = "top100arena.com";
    public string $voteLinkFormat = "{vote_link}?incentive={user_id}";

    protected function checkAccess(): bool
    {
        return $this->CI->input->ip_address() == gethostbyname('api.top100arena.com');
    }

    protected function readUserId()
    {
        return $this->CI->input->post('postback');
    }
}
