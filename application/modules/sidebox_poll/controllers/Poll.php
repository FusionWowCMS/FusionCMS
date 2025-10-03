<?php

use MX\MX_Controller;

/**
 * Poll Controller Class
 * @property poll_model $poll_model poll_model Class
 */
class Poll extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('sidebox_poll/poll_model');
    }

    public function view()
    {
        $polls = $this->poll_model->getPolls();
        $allPolls = [];

        if ($polls) {
            foreach ($polls as $poll) {
                $poll['answers'] = $this->poll_model->getAnswers($poll['questionid']);

                $total = 0;
                if ($poll['answers'] !== false) {
                    $myVote = $this->poll_model->getMyVote($poll['questionid']);

                    foreach ($poll['answers'] as $key => $value) {
                        $poll['answers'][$key]['votes'] = $this->poll_model->getVoteCount($poll['questionid'], $value['answerid']);
                        $total += (is_numeric($poll['answers'][$key]['votes'])) ? $poll['answers'][$key]['votes'] : 0;
                    }

                    foreach ($poll['answers'] as $key => $value) {
                        $poll['answers'][$key]['percent'] = ($total > 0 && $poll['answers'][$key]['votes'] > 0)
                            ? round(($poll['answers'][$key]['votes'] / $total) * 100, 1)
                            : 0;
                    }
                } else {
                    $myVote = false;
                    $poll['answers'] = [];
                }

                $poll['total'] = $total;
                $poll['myVote'] = $myVote;

                $allPolls[] = $poll;
            }
        }

        $data = [
            "online" => $this->user->isOnline(),
            "module" => "sidebox_poll",
            "polls"  => $allPolls,
        ];

        return $this->template->loadPage("poll_view.tpl", $data);
    }

    public function vote(int|bool $questionid = false, int|bool $answerid = false)
    {
        // Check for the permission
        requirePermission("vote", "sidebox_poll");

        if (!$questionid || !$answerid || !$this->user->isOnline()) {
            die('undefined data');
        } else {
            if (!$this->poll_model->pollExists($questionid)) {
                die('unknown poll');
            } else {
                if ($this->poll_model->hasVoted($questionid, $this->user->getId())) {
                    die('has voted');
                } else {
                    $this->poll_model->insertAnswer($questionid, $answerid, $this->user->getId());

                    die('successfully voted');
                }
            }
        }
    }
}
