<?php

/**
 * Base class for vote callback plugins
 *
 * @package FusionCMS
 * @author  Maxi Arnicke
 * @link    http://fusion-hub.com
 */

abstract class VoteCallbackPlugin extends Plugin
{
    public $url = 'undefined';
    public $voteLinkFormat = 'undefined';

    abstract protected function readUserId();
    abstract protected function checkAccess();

    public function handleCallback()
    {
        if (! $this->checkAccess()) {
            die('No access.');
        }

        $this->CI->load->model('vote/vote_model');
        $vote_site = $this->CI->vote_model->getVoteSiteByUrl($this->url);
        $user_id = $this->readUserId();

        // check if user can vote at this time
        if ($vote_site && $user_id && $this->CI->vote_model->canVote($vote_site['id'], $user_id)) {
            // log vote, credit VPs
            $this->CI->vote_model->vote_log($user_id, $this->CI->input->ip_address(), $vote_site['id']);
            $this->CI->vote_model->updateVp($user_id, $vote_site['points_per_vote']);

            $this->CI->plugins->onVote($user_id, $vote_site);

            die('Points given.');
        }

        die('User cannot vote at this time.');
    }
}
