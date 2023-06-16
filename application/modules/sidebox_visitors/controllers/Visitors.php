<?php

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
            foreach ($visitors as $key => $value) {
                if ($value['data'])
                {

                    $sessions = $this->parseSession($value['data']);
					$data = unserialize($sessions);

                    $visitors[$key]['user_id'] = $this->getUserId($data);
                    $visitors[$key]['nickname'] = $this->getNickname($data);

                    if (!array_key_exists($visitors[$key]['user_id'], $realVisitors))
                    {
                        $realVisitors[$visitors[$key]['user_id']] = $visitors[$key]['nickname'];
                    }
                }
            }
        }

        $output = $this->template->loadPage("all_visitors.tpl", array('module' => "sidebox_visitors", 'guests' => $guests, 'visitors' => $realVisitors));

        die($output);
    }

    private function getUserId($data)
    {
        if (array_key_exists("uid", $data)) {
            return (int)$data['uid'];
        }
    }

    private function getNickname($data)
    {
        if (array_key_exists("nickname", $data)) {
            return $data['nickname'];
        }
    }

    private function parseSession($sess_data)
    {
        $sess_data = rtrim($sess_data, ";");
        $sess_data = preg_replace('/(;password\|.*?;email\|)/', '', $sess_data);

        $sess_info = array();
        $parts = explode(";", $sess_data);

        foreach ($parts as $part) {
            $part = explode("|", $part);
            $key = preg_replace('/:.*/', '', $part[0]);
            $value = preg_replace('/.*:/', '', $part[1]);
            $value = str_replace('"', '', $value);
            $sess_info[$key] = $value;
        }

        $sess_info = serialize($sess_info);
        return $sess_info;
    }
}
