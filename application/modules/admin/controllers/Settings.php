<?php

use App\Config\Services;
use MX\MX_Controller;

class Settings extends MX_Controller
{
    private $email;

    public function __construct()
    {
        // Make sure to load the administrator library!
        $this->load->library('administrator');

        parent::__construct();

        $this->load->config('smtp');
        $this->load->config('performance');
        $this->load->config('social_media');
        $this->load->config('wow_db');
        $this->load->config('cdn');

        require_once('application/libraries/ConfigEditor.php');

        requirePermission("editSystemSettings");
    }

    public function index()
    {
        // Change the title
        $this->administrator->setTitle("Settings");

        $config['title'] = $this->config->item('title');
        $config['server_name'] = $this->config->item('server_name');
        $config['realmlist'] = $this->config->item('realmlist');
        $config['expansions'] = $this->realms->getExpansions();
        $config['max_expansion'] = $this->config->item('max_expansion');
        $config['keywords'] = $this->config->item('keywords');
        $config['description'] = $this->config->item('description');
        $config['analytics'] = $this->config->item('analytics');
        $config['vote_reminder'] = $this->config->item('vote_reminder');
        $config['vote_reminder_image'] = $this->config->item('vote_reminder_image');
        $config['reminder_interval'] = $this->config->item('reminder_interval');
        $config['has_smtp'] = $this->config->item('has_smtp');

        // Performance
        $config['disable_visitor_graph'] = $this->config->item('disable_visitor_graph');
        $config['disable_realm_status'] = $this->config->item('disable_realm_status');
        $config['cache'] = $this->config->item('cache');
        $config['enable_minify_js'] = $this->config->item('enable_minify_js');
        $config['enable_minify_css'] = $this->config->item('enable_minify_css');

        // SMTP
        $config['use_own_smtp_settings'] = $this->config->item('use_own_smtp_settings');
        $config['smtp_protocol'] = $this->config->item('smtp_protocol');
        $config['smtp_sender'] = $this->config->item('smtp_sender');
        $config['smtp_host'] = $this->config->item('smtp_host');
        $config['smtp_user'] = $this->config->item('smtp_user');
        $config['smtp_pass'] = $this->config->item('smtp_pass');
        $config['smtp_port'] = $this->config->item('smtp_port');
        $config['smtp_crypto'] = $this->config->item('smtp_crypto');
		
		// Social Media links
        $config['facebook'] = $this->config->item('facebook');
        $config['twitter'] = $this->config->item('twitter');
        $config['youtube'] = $this->config->item('youtube');
        $config['discord'] = $this->config->item('discord');

		// CDN
        $config['cdn_value'] = $this->config->item('cdn');
        $config['cdn_link'] = $this->config->item('cdn_link');
		
        // Security
        $config['use_captcha'] = $this->config->item('use_captcha');
        $config['captcha_type'] = $this->config->item('captcha_type');
        $config['recaptcha_theme'] = $this->config->item('recaptcha_theme');
        $config['recaptcha_site_key'] = $this->config->item('recaptcha_site_key');
        $config['recaptcha_secret_key'] = $this->config->item('recaptcha_secret_key');
        $config['captcha_attemps'] = $this->config->item('captcha_attemps');
        $config['block_attemps'] = $this->config->item('block_attemps');
        $config['block_duration'] = $this->config->item('block_duration');

        // API link to get item icons
        $config['api_item_icons'] = $this->config->item('api_item_icons');
        $config['api_item_custom'] = $this->config->item('api_item_custom');
        $config['wow_db'] = $this->config->item('wow_db');

        // API link to get item data
        $config['api_item_data'] = $this->config->item('api_item_data');
        $config['api_item_data_custom'] = $this->config->item('api_item_data_custom');
        $config['wow_item_db'] = $this->config->item('wow_item_db');

        // auth configuration
        $config['account_encryption'] = $this->config->item('account_encryption');
        $config['rbac'] = $this->config->item('rbac');
        $config['battle_net'] = $this->config->item('battle_net');
        $config['battle_net_encryption'] = $this->config->item('battle_net_encryption');
        $config['totp_secret'] = $this->config->item('totp_secret');
        $config['totp_secret_name'] = $this->config->item('totp_secret_name');

        // Prepare my data
        $data = [
            'url' => $this->template->page_url,
            'realms' => $this->realms->getRealms(),
            'emulators' => $this->getEmulators(),
            'expansions' => $this->realms->getExpansions(),
            'config' => $config
        ];

        // Load my view
        $output = $this->template->loadPage("settings.tpl", $data);

        // Put my view in the main box with a headline
        $content = $this->administrator->box('Settings', $output);

        // Output my content. The method accepts the same arguments as template->view
        $this->administrator->view($content, false, "modules/admin/js/settings.js");
    }

    private function getEmulators()
    {
        require("application/config/emulator_names.php");

        return $emulators;
    }

    public function saveWebsite()
    {
        $fusionConfig = new ConfigEditor("application/config/fusion.php");

        $fusionConfig->set('title', $this->input->post('title'));
        $fusionConfig->set('server_name', $this->input->post('server_name'));
        $fusionConfig->set('realmlist', $this->input->post('realmlist'));
        $fusionConfig->set('keywords', $this->input->post('keywords'));
        $fusionConfig->set('description', $this->input->post('description'));
        $fusionConfig->set('analytics', $this->input->post('analytics'));
        $fusionConfig->set('vote_reminder', $this->input->post('vote_reminder'));
        $fusionConfig->set('vote_reminder_image', $this->input->post('vote_reminder_image'));
        $fusionConfig->set('reminder_interval', $this->input->post('reminder_interval') * 60 * 60);
        $fusionConfig->set('has_smtp', $this->input->post('has_smtp'));
        $fusionConfig->set('max_expansion', $this->input->post('max_expansion'));

        $fusionConfig->save();
        
        if ($this->input->post('max_expansion') != $this->config->item('max_expansion'))
        {
            $this->external_account_model->setExpansion($this->input->post('max_expansion'));
        }

        die('yes');
    }

    public function savePerformance()
    {
        $fusionConfig = new ConfigEditor("application/config/performance.php");
        $fusionConfig2 = new ConfigEditor("application/config/fusion.php");

        $fusionConfig->set('disable_visitor_graph', $this->input->post('disable_visitor_graph'));
        $fusionConfig->set('disable_realm_status', $this->input->post('disable_realm_status'));
        $fusionConfig2->set('cache', $this->input->post('cache'));

        $fusionConfig->set('enable_minify_js', $this->input->post('enable_minify_js'));
        $fusionConfig->set('enable_minify_css', $this->input->post('enable_minify_css'));

        $fusionConfig->save();
        $fusionConfig2->save();

        die('yes');
    }

    public function saveSmtp()
    {
        $fusionConfig = new ConfigEditor("application/config/smtp.php");

        $fusionConfig->set('use_own_smtp_settings', $this->input->post('use_own_smtp_settings'));
        $fusionConfig->set('smtp_protocol', $this->input->post('smtp_protocol'));
        $fusionConfig->set('smtp_sender', $this->input->post('smtp_sender'));
        $fusionConfig->set('smtp_host', $this->input->post('smtp_host'));
        $fusionConfig->set('smtp_user', $this->input->post('smtp_user'));
        $fusionConfig->set('smtp_pass', $this->input->post('smtp_pass'));
        $fusionConfig->set('smtp_port', $this->input->post('smtp_port'));
        $fusionConfig->set('smtp_crypto', $this->input->post('smtp_crypto'));

        $fusionConfig->save();

        die('yes');
    }

    public function mailDebug()
    {
        error_reporting(E_ERROR | E_PARSE);

        if ($this->input->post('protocol') == 'smtp') {
            $config = array(
                'protocol'   => $this->input->post('protocol'),
                'SMTPHost'   => $this->input->post('host'),
                'SMTPUser'   => $this->input->post('user'),
                'SMTPPass'   => $this->input->post('pass'),
                'SMTPPort'   => (int)$this->input->post('port'),
                'SMTPCrypto' => $this->input->post('crypto'),
            );
        }

        $this->email = Services::email($config ?? []);

        $this->email->setFrom($this->config->item('smtp_sender'), $this->config->item('server_name'));
        $this->email->setTo($this->user->getEmail());

        $this->email->setSubject('Test mail');
        $this->email->setMessage('Looks like your mail configuration is working!');

        if ($this->email->send()) {
            die(json_encode(array("success" => "Please check your spam folder.")));
        } else {
            $error = $this->email->printDebugger(['headers']);
            die(json_encode(array("error" => $error)));
        }
    }

	public function saveSocialMedia()
    {
        $fusionConfig = new ConfigEditor("application/config/social_media.php");

		$fusionConfig->set('facebook', $this->input->post('fb_link'));
		$fusionConfig->set('twitter', $this->input->post('twitter_link'));
		$fusionConfig->set('youtube', $this->input->post('yt_link'));
		$fusionConfig->set('discord', $this->input->post('discord_link'));

        $fusionConfig->save();

        die('yes');
    }

    public function saveWowDatabase()
    {
        $fusionConfig = new ConfigEditor("application/config/wow_db.php");

        $api_item_icons = $this->input->post('api_item_icons');
        $api_item_data = $this->input->post('api_item_data');
        $custom_link = $this->input->post('custom_link');

        $fusionConfig->set('api_item_custom', $api_item_icons == 'custom');
        $fusionConfig->set('api_item_icons', $api_item_icons == 'custom' ? $custom_link : $api_item_icons);
        $fusionConfig->set('api_item_data', $api_item_data);

        if ((empty($api_item_icons) && empty($custom_link)) || ($api_item_icons == 'custom') && empty($custom_link))
            die('The link cannot be empty');

        $fusionConfig->save();

        die('yes');
    }

	public function saveCDN()
    {
        $fusionConfig = new ConfigEditor("application/config/cdn.php");

		$fusionConfig->set('cdn', $this->input->post('cdn_value'));
		$fusionConfig->set('cdn_link', $this->input->post('cdn_link'));

        $fusionConfig->save();

        die('yes');
    }
	
	public function saveSecurity()
    {
        $fusionConfig = new ConfigEditor("application/config/captcha.php");

        $fusionConfig->set('use_captcha', ($this->input->post('captcha') == 'disabled') ? false : true);
        $fusionConfig->set('captcha_type', $this->input->post('captcha'));
        $fusionConfig->set('recaptcha_theme', $this->input->post('recaptcha_theme'));
        $fusionConfig->set('recaptcha_site_key', $this->input->post('recaptcha_site_key'));
        $fusionConfig->set('recaptcha_secret_key', $this->input->post('recaptcha_secret_key'));
        $fusionConfig->set('captcha_attemps', $this->input->post('captcha_attemps'));
        $fusionConfig->set('block_attemps', $this->input->post('block_attemps'));
        $fusionConfig->set('block_duration', $this->input->post('block_duration'));

        $fusionConfig->save();

        die('yes');
    }

    public function saveAuthConfig()
    {
        $fusionConfig = new ConfigEditor("application/config/auth.php");

        $fusionConfig->set('account_encryption', $this->input->post('account_encryption'));
        $fusionConfig->set('rbac', $this->input->post('rbac'));
        $fusionConfig->set('battle_net', $this->input->post('battle_net'));
        $fusionConfig->set('battle_net_encryption', $this->input->post('battle_net_encryption'));
        $fusionConfig->set('totp_secret', $this->input->post('totp_secret'));
        $fusionConfig->set('totp_secret_name', $this->input->post('totp_secret_name'));

        $fusionConfig->save();

        die('yes');
    }
}
