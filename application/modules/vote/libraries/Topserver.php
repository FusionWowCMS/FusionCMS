<?php

/**
 * topserver.live incentive voting
 * described at: https://www.topserver.live/faq
 *
 * @package FusionCMS
 * @author  Haritz Lopez
 * @link    https://www.topserver.live/
 */

require_once(APPPATH . 'modules/vote/libraries/classes/VoteCallback.php');

class Topserver extends VoteCallback
{
    public string $name = "TopServer.Live";
    public string $url = "topserver.live";
    public string $voteLinkFormat = "{vote_link}/{user_id}";

    protected function checkAccess(): bool
    {
        return $this->CI->input->ip_address() == gethostbyname('topserver.live');
    }

    protected function readUserId()
    {
        return $this->CI->input->get('reward');
    }
}
