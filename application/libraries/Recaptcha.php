<?php (! defined('BASEPATH')) and exit('No direct script access allowed');

use App\Config\Services;

/**
 * @package FusionCMS
 * @author  Keramat Jokar (Nightprince) <https://github.com/Nightprince>
 * @link    https://github.com/FusionWowCMS/FusionCMS
 */

class Recaptcha
{
    /**
     * CI instance object
     *
     */
    private $CI;

    private ?string $siteKey;
    private ?string $secretKey;
    private ?string $language;
    private ?string $theme;

    /**
     * reCAPTCHA site up, verify and api url.
     *
     */
    const sign_up_url = 'https://www.google.com/recaptcha/admin';
    const site_verify_url = 'https://www.google.com/recaptcha/api/siteverify';
    const api_url = 'https://www.google.com/recaptcha/api.js';

    /**
     * constructor
     *
     */
    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->config('captcha');
        $this->siteKey = $this->CI->config->item('recaptcha_site_key');
        $this->secretKey = $this->CI->config->item('recaptcha_secret_key');
        $this->language = $this->CI->language->getLanguageAbbreviation();
        $this->theme = $this->CI->config->item('recaptcha_theme');

        if ($this->getEnabledRecaptcha() && (empty($this->siteKey) or empty($this->secretKey))) {
            die("To use reCAPTCHA you must get an API key from <a href='" . self::sign_up_url . "'>". self::sign_up_url . "</a> and add in application\config\captcha.php or disable Captcha");
        }
    }
    /**
     * Submits an HTTP GET to a reCAPTCHA server.
     *
     * @param array $data array of parameters to be sent.
     *
     * @return false|string response
     */
    private function _submitHTTPGet(array $data): false|string
    {
        $url = self::site_verify_url.'?'.http_build_query($data);
        $options = [
            'timeout'         => 300,
            'allow_redirects' => [
                'max' => 10,
            ],
            'user_agent'      => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1',
            'version'         => CURL_HTTP_VERSION_2_0,
            'verify'          => false,
        ];
        return Services::curlrequest()->get($url, $options)->getBody();
    }
    /**
     * Calls the reCAPTCHA site-verify API to verify whether the user passes
     * CAPTCHA test.
     *
     * @param string $response response string from recaptcha verification.
     * @param string|null $remoteIp IP address of end user.
     *
     * @return array
     */
    public function verifyResponse(string $response, string $remoteIp = null): array
    {
        $remoteIp = (!empty($remoteIp)) ? $remoteIp : $this->CI->input->ip_address();
        // Discard empty solution submissions
        if (empty($response)) {
            return [
                'success' => false,
                'error-codes' => 'missing-input',
            ];
        }
        $getResponse = $this->_submitHttpGet(
            [
                'secret' => $this->secretKey,
                'remoteip' => $remoteIp,
                'response' => $response,
            ]
        );
        // get reCAPTCHA server response
        $responses = json_decode($getResponse, true);
        if (isset($responses['success']) and $responses['success']) {
            $status = true;
        } else {
            $status = false;
            $error = (isset($responses['error-codes'])) ? $responses['error-codes']
                : 'invalid-input-response';
        }
        return [
            'success' => $status,
            'error-codes' => (isset($error)) ? $error : null,
        ];
    }
    /**
     * Render Script Tag
     *
     * Onload: Optional.
     * Render: [explicit|onload] Optional.
     * Hl: Optional.
     * See: https://developers.google.com/recaptcha/docs/display
     *
     * @param array $parameters.
     *
     * @return string
     */
    public function getScriptTag(array $parameters = []): string
    {
        $default = [];

        if ($this->CI->config->item('captcha_type') == 'recaptcha') {
            $default = [
                'render' => 'onload',
                'hl' => $this->language,
            ];
        } else if ($this->CI->config->item('captcha_type') == 'recaptcha3') {
            $default = [
                'render' => $this->siteKey,
                'lang' => $this->language,
            ];
        }

        $result = array_merge($default, $parameters);
        return sprintf('<script type="text/javascript" src="%s?%s" async defer></script>',
            self::api_url, http_build_query($result));
    }
    /**
     * render the reCAPTCHA widget
     *
     * data-theme: dark|light
     * data-type: audio|image
     *
     * @param array $parameters.
     *
     * @return string
     */
    public function getWidget(array $parameters = []): string
    {
        if ($this->CI->config->item('captcha_type') == 'recaptcha3') {
            $js = '<script>
                    const setCaptchaToken = function ()
                    {
                        if(typeof grecaptcha === \'undefined\')
                        {
                            setTimeout(setCaptchaToken, 50);
                            return false;
                        }
                        grecaptcha.ready(function() {
                            grecaptcha.execute("' . $this->siteKey . '", {action: "submit"}).then(function(token) {
                                document.querySelector(".g-recaptcha-response").value = token;
                            });
                        });
                    }

                    setCaptchaToken();
            </script>';



            return $js. '<input type="hidden" class="g-recaptcha-response" name="g-recaptcha-response">';
        }

        $default = [
            'data-sitekey' => $this->siteKey,
            'data-theme' => $this->theme,
            'data-type' => 'image',
            'data-size' => 'normal',
        ];

        $result = array_merge($default, $parameters);
        $html = '';
        foreach ($result as $key => $value) {
            $html .= sprintf('%s="%s" ', $key, $value);
        }
        return '<div class="g-recaptcha" '.$html.'></div>';
    }

    /**
     * Render enable use Recaptcha
     */
    public function getEnabledRecaptcha(): bool
    {
        return $this->CI->config->item('use_captcha') && ($this->CI->config->item('captcha_type') == 'recaptcha' || $this->CI->config->item('captcha_type') == 'recaptcha3');
    }

    /**
     *
     * Returns a float from 0 to 1 indicating the likelihood that the request is a from a human
     * 0 is considered a robot
     * 1 is considered a human
     *
     * @param string $response
     * @return float|int
     */
    function verifyScore(string $response): float|int
    {
        $getResponse = $this->_submitHttpGet(
            [
                'secret' => $this->secretKey,
                'response' => $response,
            ]
        );
        $responses = json_decode($getResponse);

        // handle any errors
        if(!$responses->{'success'}){
            foreach($responses->{'error-codes'} as $code){
                switch ($code){
                    case 'missing-input-secret':
                        log_message('error', 'RECAPTCHA: The secret parameter is missing.');
                        break;
                    case 'invalid-input-secret':
                        log_message('error', 'RECAPTCHA: The secret parameter is invalid or malformed.');
                        break;
                    case 'missing-input-response':
                        log_message('error', 'RECAPTCHA: The response parameter is missing.');
                        break;
                    case 'invalid-input-response':
                        log_message('error', 'RECAPTCHA: The response parameter is invalid or malformed.');
                        break;
                    case 'bad-request':
                        log_message('error', 'RECAPTCHA: The request is invalid or malformed.');
                        break;
                    case 'timeout-or-duplicate':
                        log_message('error', 'RECAPTCHA: The response is no longer valid: either is too old or has been used previously.');
                        break;
                    default:
                        log_message('error', 'RECAPTCHA: Unknown error');
                }
            }
            return 0; // treat it as spam?
        }

        return $responses->score;
    }
}