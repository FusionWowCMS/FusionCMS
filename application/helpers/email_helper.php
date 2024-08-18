<?php

if (! defined('BASEPATH')) exit('No direct script access allowed');

use App\Config\Services;

/**
 * Send mail
 *
 * @param String $receiver
 * @param String $subject
 * @param String $username
 * @param String $message
 * @param $templateId
 * @return false|void
 */
function sendMail(string $receiver, string $subject, string $username, string $message, $templateId)
{
    static $CI;

    if (!$CI) {
        $CI = &get_instance();
    }

    // Make sure the website has SMTP available
    if (!$CI->config->item('has_smtp')) {
        return false;
    }

    $CI->load->config('smtp');

    // Pass the custom SMTP settings if any
    if ($CI->config->item('smtp_protocol') == 'smtp') {
        $config = [
            'protocol'   => $CI->config->item('smtp_protocol'),
            'SMTPHost'   => $CI->config->item('smtp_host'),
            'SMTPUser'   => $CI->config->item('smtp_user'),
            'SMTPPass'   => $CI->config->item('smtp_pass'),
            'SMTPPort'   => $CI->config->item('smtp_port'),
            'SMTPCrypto' => $CI->config->item('smtp_crypto')
        ];
    }

    // Configuration
    $config['mailType'] = 'html';

    $sender = $CI->config->item('smtp_sender');
    $email = Services::email($config);

    // Set email data
    $email->setFrom($sender, $CI->config->item('server_name'));
    $email->setTo($receiver);
    $email->setSubject($subject);
    $email->setMessage($message);

    ######
    $data = [
        'username' => $username,
        'message' => $message,
        'server_name' => $CI->config->item('server_name'),
        'url' => $CI->template->page_url,
    ];
    $template = $CI->cms_model->getTemplate($templateId);
    $body = $CI->load->view('email_templates/' . $template['template_name'], $data, true);
    ######

    $email->setMessage($body);

    // Send the email
    if (!$email->send()) {
        die("cannot be send");
    }

    $data2 = [
        'uid' => $CI->external_account_model->getIdByEmail($receiver),
        'email' => $receiver,
        'subject' => $subject,
        'message' => $message,
        'timestamp' => time()
    ];

    $CI->db->table('email_log')->insert($data2);
}
