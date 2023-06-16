<?php

class Poll extends MX_Controller
{
    private $total = 0;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('sidebox_poll/poll_model');
    }

    public function view()
    {
        $poll = $this->poll_model->getPoll();

        if ($poll) {
            $poll['answers'] = $this->poll_model->getAnswers($poll['questionid']);

            if ($poll['answers'] !== false) {
                $myVote = $this->poll_model->getMyVote($poll['questionid']);

                foreach ($poll['answers'] as $key => $value) {
                    $poll['answers'][$key]['votes'] = $this->poll_model->getVoteCount($poll['questionid'], $value['answerid']);
                    $this->total += (is_numeric($poll['answers'][$key]['votes'])) ? $poll['answers'][$key]['votes'] : 0;
                }

                foreach ($poll['answers'] as $key => $value) {
                    $poll['answers'][$key]['percent'] = $this->percent($poll['answers'][$key]['votes']);
                }
            } else {
                $myVote = false;
            }
        } else {
            $poll['total'] = 0;
            $poll['answers'] = false;
            $poll['question'] = false;
            $myVote = false;
        }

        $data = array(
            "online" => $this->user->isOnline(),
            "module" => "sidebox_poll",
            "poll" => $poll,
            "myVote" => $myVote,
            "total" => $this->total
        );

        $out = $this->template->loadPage("poll_view.tpl", $data);

        return $out;
    }

    private function percent($count)
    {
        if (
            $this->total == 0
            || $count == 0
            || !is_numeric($this->total)
            || !is_numeric($count)
        ) {
            return 0;
        } else {
            $value = round(($count / $this->total) * 100, 1);

            if ($value > 99) {
                $value = 99;
            }

            return $value;
        }
    }

    public function vote($questionid = false, $answerid = false)
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
