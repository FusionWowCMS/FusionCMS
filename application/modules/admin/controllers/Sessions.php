<?php

use MX\MX_Controller;
use CodeIgniter\HTTP\UserAgent;

/**
 * Sessions Controller Class
 * @property session_model $session_model session_model Class
 */
class Sessions extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('administrator');
        $this->load->model('session_model');

        requirePermission("viewSessions");
    }

    public function index()
    {
        $sessions = $this->session_model->get();
        $user_agent = new UserAgent();

        if ($sessions)
		{
            foreach ($sessions as $key => $value) {
                $session = [];
                $sessionRow = $this->session_model->getSessId($value['id']);

                if (!empty($sessionRow['data'])) {
                    $session = $this->parseSession($sessionRow['data']);
                }

                $userId = $this->getUserId($session);

                if ($userId > 0) {
                    $sessions[$key]['uid'] = $userId;
                    $sessions[$key]['nickname'] = $this->getNickname($session);
                }

                $user_agent->parse($value['user_agent'] ?? '');

                $sessions[$key]['os'] = $this->getPlatform($value['user_agent']);
                $sessions[$key]['osName'] = $user_agent->getPlatform();
                $sessions[$key]['browser'] = $this->getBrowser($value['user_agent']);
                $sessions[$key]['browserName'] = $user_agent->getBrowser();
                $sessions[$key]['date'] = $value["timestamp"];
            }
        }

        $data = ['sessions' => $sessions];

        $output = $this->template->loadPage("sessions/sessions.tpl", $data);
        $content = $this->administrator->box('Active sessions', $output);

        $this->administrator->view($content, false, "modules/admin/js/session.js");
    }

    private function getUserId($data): int
    {
        return isset($data['uid']) ? (int) $data['uid'] : 0;
    }

    private function getNickname($data): string
    {
        return isset($data['nickname']) ? (string) $data['nickname'] : '';
    }

    private function getBrowser($user_agent): string
    {
        if (preg_match('/trident/i', $user_agent) && !preg_match('/opera/i', $user_agent)) {
            return "ie";
        } elseif (preg_match('/opera/i', $user_agent)) {
            return "opera";
        } elseif (preg_match('/firefox/i', $user_agent)) {
            return "firefox";
        } elseif (preg_match('/edg/i', $user_agent)) {
            return "edge";
        } elseif (preg_match('/chrome/i', $user_agent)) {
            return "chrome";
        } elseif (preg_match('/android/i', $user_agent)) {
            return "android";
        } elseif (preg_match('/safari/i', $user_agent)) {
            return "safari";
        } else {
            // Default to most common one to prevent errors
            return "chrome";
        }
    }

    private function getPlatform($user_agent): string
    {
        if (preg_match('/android/i', $user_agent)) {
            return "android";
        } elseif (preg_match('/linux/i', $user_agent)) {
            return "linux";
        } elseif (preg_match('/windows|win32/i', $user_agent)) {
            return "windows";
        } elseif (preg_match('/macintosh|mac os x/i', $user_agent)) {
            return "mac";
        } else {
            // Default to most common one to prevent errors
            return "windows";
        }
    }

    private function parseSession($sess_data): array
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

    public function deleteSessions()
    {
        $ip_address = $this->input->ip_address();

        $this->session_model->deleteSessions($ip_address);

        $this->dblogger->createLog("admin", "purge", "Cleared sessions");

        die('1');
    }
}
