<?php

use CodeIgniter\Events\Events;

/**
 * Base class for vote callback
 */
abstract class VoteCallback
{
    protected Controller $CI;
    protected $vote_model;
    public string $name = 'undefined';
    public string $url = 'undefined';
    public string $voteLinkFormat = 'undefined';

    abstract protected function readUserId();

    abstract protected function checkAccess();

    public function __construct()
    {
        $this->CI = &get_instance();

        // Load the vote model
        $this->CI->load->model('vote/vote_model');
        $this->vote_model = $this->CI->vote_model;
    }

    // Handle the vote callback process
    public function handleCallback(): string
    {
        if (!$this->checkAccess()) {
            die('No access.');
        }

        $vote_site = $this->vote_model->getVoteSiteByUrl($this->url);
        $user_id = $this->readUserId();

        if ($user_id && !is_numeric($user_id))
            $user_id = $this->CI->user->getUsername($user_id);

        // check if user can vote at this time
        if ($vote_site && $user_id && $this->vote_model->canVote($vote_site['id'], $user_id)) {
            // log vote, credit VPs
            $this->vote_model->vote_log($user_id, $this->CI->input->ip_address(), $vote_site['id']);
            $this->vote_model->updateVp($user_id, $vote_site['points_per_vote']);

            Events::trigger('onVote', $user_id, $vote_site);

            die('Points given.');
        }

        die('User cannot vote at this time.');
    }
}
