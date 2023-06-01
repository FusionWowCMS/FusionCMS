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
 * 'recaptcha' = Google Recaptcha v2 | NOT WORKING ATM
 * 'inbuilt'   = inbuilt captcha system
 *
 */
$config["captcha_type"] = 'inbuilt';

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
$config["recaptcha_sitekey"] = "";

/**
 *
 * The secret key
 * get secret key @ www.google.com/recaptcha/admin
 *
 */
$config["recaptcha_secretkey"] = "";
