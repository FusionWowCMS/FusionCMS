<?php

/**
 * Xtremetop100 vote postback
 * described at: http://xtremetop100.com/???
 *
 * @package FusionCMS
 * @author  Maxi Arnicke
 * @link    http://fusion-hub.com
 */

require_once(APPPATH . 'modules/vote/libraries/classes/VoteCallback.php');

class Xtremetop100 extends VoteCallback
{
    public string $name = "Xtremetop100";
    public string $url = "xtremetop100.com";
    public string $voteLinkFormat = "{vote_link}-{user_id}";

    protected function checkAccess(): bool
    {
        return $this->CI->input->ip_address() == gethostbyname('xtremetop100.com');
    }

    protected function readUserId()
    {
        return $this->CI->input->get('p_resp');
    }
}
