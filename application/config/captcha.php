<?php

/**
 *
 * Enable captcha for site
 *
 */
$config['use_captcha'] = true;

/**
 *
 * What type of captcha?
 *
 * 'recaptcha'       = Google Recaptcha v2
 * 'recaptcha3'      = Google Recaptcha v3
 * 'image_captcha'   = image captcha system
 * 'fusion_captcha'  = inbuilt captcha system
 *
 */
$config['captcha_type'] = 'fusion_captcha';

/**
 *
 * After how many tries should a captcha pop up?
 *
 */
$config['captcha_attemps'] = 3;

/**
 *
 * After how many tries should we block an IP address?
 * How many minutes should an IP address remain blocked?
 *
 */
$config['block_attemps'] = 5;
$config['block_duration'] = 15;

/**
 *
 * The site key
 * get site key @ www.google.com/recaptcha/admin
 *
 */
$config["recaptcha_site_key"] = "";

/**
 *
 * The secret key
 * get secret key @ www.google.com/recaptcha/admin
 *
 */
$config["recaptcha_secret_key"] = "";

// Theme
$config['recaptcha_theme'] = 'dark'; // dark - light


/**
 * FusionCaptcha Configuration
 *
 * secret_key: Private key, used for HMAC signing on server (never expose)
 * theme     : Widget theme ('light' or 'dark')
 */
$config['fusion_captcha_secret_key'] = '';

$config['fusion_captcha'] = [

    // Challenge expires after
    'challenge_ttl' => 300,

    // Final token expires after
    'token_ttl' => 600,

    // Max worker difficulty
    'difficulty' => 5,

    // Number of POW challenges
    'challenge_count' => 4,

    // Rate limits
    'max_challenges_per_minute' => 15,
    'max_redeems_per_minute'    => 30,

    // Bind token to IP
    'bind_ip' => true,

    // Bind token to user-agent hash
    'bind_ua' => true,
];
