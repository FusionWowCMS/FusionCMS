<?php

use MX\MX_Controller;

/**
 * Visitors Controller Class
 * @property visitor_model $visitor_model visitor_model Class
 */
class Visitors extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('sidebox_visitors/visitor_model');
    }

    public function view()
    {
        $count = $this->visitor_model->getCount();
        $word = ($count == 1) ? lang("visitor", "sidebox_visitors") : lang("visitors", "sidebox_visitors");
        $there_are = ($count == 1) ? lang("there_is", "sidebox_visitors") : lang("there_are", "sidebox_visitors");

        $output = $this->template->loadPage("visitors.tpl", array(
            'module' => "sidebox_visitors",
            'count' => $count,
            'word' => $word,
            'there_are' => $there_are
        ));

        return $output;
    }

    public function getAll()
    {
        $guests = $this->visitor_model->getGuestCount();
        $visitors = $this->visitor_model->get();
        $realVisitors = array();

        if ($visitors) {
            foreach ($visitors as $value) {
                if (empty($value['data'])) {
                    continue;
                }

                $data = $this->parseSession($value['data']);
                $userId = $this->getUserId($data);

                if ($userId <= 0 || array_key_exists($userId, $realVisitors)) {
                    continue;
                }

                $realVisitors[$userId] = $this->getNickname($data);
            }
        }

        $output = $this->template->loadPage("all_visitors.tpl", array('module' => "sidebox_visitors", 'guests' => $guests, 'visitors' => $realVisitors));

        die($output);
    }

    private function getUserId($data)
    {
        return isset($data['uid']) ? (int) $data['uid'] : 0;
    }

    private function getNickname($data)
    {
        return isset($data['nickname']) ? (string) $data['nickname'] : '';
    }

    private function parseSession($sess_data)
    {
        $sessInfo = [];

        if (!str_contains($sess_data, 'uid|') && !str_contains($sess_data, 'nickname|')) {
            return $sessInfo;
        }

        if (preg_match('/(?:^|;)uid\|i:(\d+);/', $sess_data, $uidMatch) === 1) {
            $sessInfo['uid'] = (int) $uidMatch[1];
        } elseif (preg_match('/(?:^|;)uid\|s:\d+:"(\d+)";/', $sess_data, $uidMatch) === 1) {
            $sessInfo['uid'] = (int) $uidMatch[1];
        }

        if (preg_match('/(?:^|;)nickname\|s:\d+:"((?:[^"\\\\]|\\\\.)*)";/', $sess_data, $nicknameMatch) === 1) {
            $sessInfo['nickname'] = stripcslashes($nicknameMatch[1]);
        }

        return $sessInfo;
    }
}
