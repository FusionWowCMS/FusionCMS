<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Send a mail
 *
 * @param String $receiver
 * @param String $subject
 * @param String $message
 */
function sendMail($receiver, $subject, $username, $message, $templateId)
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
        $config = array(
            'protocol'    => $CI->config->item('smtp_protocol'),
            'smtp_host'   => $CI->config->item('smtp_host'),
            'smtp_user'   => $CI->config->item('smtp_user'),
            'smtp_pass'   => $CI->config->item('smtp_pass'),
            'smtp_port'   => $CI->config->item('smtp_port'),
            'smtp_crypto' => $CI->config->item('smtp_crypto'),
            'crlf'        => "\r\n",
            'newline'     => "\r\n",
        );
    }

    // Configuration
    $config['charset'] = 'utf-8';
    $config['wordwrap'] = true;
    $config['mailtype'] = 'html';

    $sender = $CI->config->item('smtp_sender');
    $CI->load->library('email', $config);

    // Set email data
    $CI->email->from($sender, $CI->config->item('server_name'));
    $CI->email->to($receiver);
    $CI->email->subject($subject);
    $CI->email->message($message);

    ######
    $data = array(
        'username' => $username,
        'message' => $message,
        'server_name' => $CI->config->item('server_name'),
        'url' => $CI->template->page_url,
    );
    $template = $CI->cms_model->getTemplate($templateId);
    $body = $CI->load->view('email_templates/' . $template['template_name'] . '', $data, true);
    ######

    $CI->email->message($body);

    // Send the email
    if (!$CI->email->send()) {
        die("cannot be send");
    }

    $data2 = array(
        'uid' => $CI->external_account_model->getIdByEmail($receiver),
        'email' => $receiver,
        'subject' => $subject,
        'message' => $message,
        'timestamp' => time(),
    );

    $CI->db->insert('email_log', $data2);
}
