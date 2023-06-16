<?php

/**
 * Xtremetop100 vote postback
 * described at: http://xtremetop100.com/???
 *
 * @package FusionCMS
 * @author  Maxi Arnicke
 * @link    http://fusion-hub.com
 */

require_once APPPATH . 'modules/vote/plugins/classes/VoteCallbackPlugin.php';

class Xtremetop100 extends VoteCallbackPlugin
{
    public $url            = "xtremetop100.com";
    public $voteLinkFormat = "{vote_link}-{user_id}";

    protected function checkAccess()
    {
        return $this->CI->input->ip_address() == gethostbyname('xtremetop100.com');
    }

    protected function readUserId()
    {
        return $this->CI->input->get('p_resp');
    }
}
