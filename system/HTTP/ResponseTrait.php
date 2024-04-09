<?php

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CodeIgniter\HTTP;

use CodeIgniter\HTTP\Exceptions\HTTPException;
use CodeIgniter\I18n\Time;
use Config\Services;
use DateTime;
use DateTimeZone;
use InvalidArgumentException;

/**
 * Response Trait
 *
 * Additional methods to make a PSR-7 Response class
 * compliant with the framework's own ResponseInterface.
 *
 * @see https://github.com/php-fig/http-message/blob/master/src/ResponseInterface.php
 */
trait ResponseTrait
{
    /**
     * Whether Content Security Policy is being enforced.
     *
     * @var bool
     *
     * @deprecated Use $this->CSP->enabled() instead.
     */
    protected $CSPEnabled = false;

    /**
     * Content security policy handler
     *
     * @var ContentSecurityPolicy
     *
     * @deprecated Will be protected. Use `getCSP()` instead.
     */
    public $CSP;

    /**
     * Set a cookie name prefix if you need to avoid collisions
     *
     * @var string
     *
     * @deprecated Use the dedicated Cookie class instead.
     */
    protected $cookiePrefix = '';

    /**
     * Set to .your-domain.com for site-wide cookies
     *
     * @var string
     *
     * @deprecated Use the dedicated Cookie class instead.
     */
    protected $cookieDomain = '';

    /**
     * Typically will be a forward slash
     *
     * @var string
     *
     * @deprecated Use the dedicated Cookie class instead.
     */
    protected $cookiePath = '/';

    /**
     * Cookie will only be set if a secure HTTPS connection exists.
     *
     * @var bool
     *
     * @deprecated Use the dedicated Cookie class instead.
     */
    protected $cookieSecure = false;

    /**
     * Cookie will only be accessible via HTTP(S) (no javascript)
     *
     * @var bool
     *
     * @deprecated Use the dedicated Cookie class instead.
     */
    protected $cookieHTTPOnly = false;

    /**
     * Stores all cookies that were set in the response.
     *
     * @var array
     *
     * @deprecated Use the dedicated Cookie class instead.
     */
    protected $cookies = [];

    /**
     * Type of format the body is in.
     * Valid: html, json, xml
     *
     * @var string
     */
    protected $bodyFormat = 'html';

    /**
     * Return an instance with the specified status code and, optionally, reason phrase.
     *
     * If no reason phrase is specified, will default recommended reason phrase for
     * the response's status code.
     *
     * @see http://tools.ietf.org/html/rfc7231#section-6
     * @see http://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml
     *
     * @param int    $code   The 3-digit integer result code to set.
     * @param string $reason The reason phrase to use with the
     *                       provided status code; if none is provided, will
     *                       default to the IANA name.
     *
     * @return $this
     *
     * @throws HTTPException For invalid status code arguments.
     */
    public function setStatusCode(int $code, string $reason = '')
    {
        // Valid range?
        if ($code < 100 || $code > 599) {
            throw HTTPException::forInvalidStatusCode($code);
        }

        // Unknown and no message?
        if (! array_key_exists($code, static::$statusCodes) && ($reason === '')) {
            throw HTTPException::forUnkownStatusCode($code);
        }

        $this->statusCode = $code;

        $this->reason = ($reason !== '') ? $reason : static::$statusCodes[$code];

        return $this;
    }

    // --------------------------------------------------------------------
    // Convenience Methods
    // --------------------------------------------------------------------

    /**
     * Sets the date header
     *
     * @return $this
     */
    public function setDate(DateTime $date)
    {
        $date->setTimezone(new DateTimeZone('UTC'));

        $this->setHeader('Date', $date->format('D, d M Y H:i:s') . ' GMT');

        return $this;
    }

    /**
     * Sets the Content Type header for this response with the mime type
     * and, optionally, the charset.
     *
     * @return $this
     */
    public function setContentType(string $mime, string $charset = 'UTF-8')
    {
        // add charset attribute if not already there and provided as parm
        if ((strpos($mime, 'charset=') < 1) && ($charset !== '')) {
            $mime .= '; charset=' . $charset;
        }

        $this->removeHeader('Content-Type'); // replace existing content type
        $this->setHeader('Content-Type', $mime);

        return $this;
    }

    /**
     * Converts the $body into JSON and sets the Content Type header.
     *
     * @param array|object|string $body
     *
     * @return $this
     */
    public function setJSON($body, bool $unencoded = false)
    {
        $this->body = $this->formatBody($body, 'json' . ($unencoded ? '-unencoded' : ''));

        return $this;
    }

    /**
     * Returns the current body, converted to JSON is it isn't already.
     *
     * @return string|null
     *
     * @throws InvalidArgumentException If the body property is not array.
     */
    public function getJSON()
    {
        $body = $this->body;

        if ($this->bodyFormat !== 'json') {
            $body = Services::format()->getFormatter('application/json')->format($body);
        }

        return $body ?: null;
    }

    /**
     * Converts $body into XML, and sets the correct Content-Type.
     *
     * @param array|string $body
     *
     * @return $this
     */
    public function setXML($body)
    {
        $this->body = $this->formatBody($body, 'xml');

        return $this;
    }

    /**
     * Retrieves the current body into XML and returns it.
     *
     * @return bool|string|null
     *
     * @throws InvalidArgumentException If the body property is not array.
     */
    public function getXML()
    {
        $body = $this->body;

        if ($this->bodyFormat !== 'xml') {
            $body = Services::format()->getFormatter('application/xml')->format($body);
        }

        return $body;
    }

    /**
     * Handles conversion of the data into the appropriate format,
     * and sets the correct Content-Type header for our response.
     *
     * @param array|object|string $body
     * @param string              $format Valid: json, xml
     *
     * @return false|string
     *
     * @throws InvalidArgumentException If the body property is not string or array.
     */
    protected function formatBody($body, string $format)
    {
        $this->bodyFormat = ($format === 'json-unencoded' ? 'json' : $format);
        $mime             = "application/{$this->bodyFormat}";
        $this->setContentType($mime);

        // Nothing much to do for a string...
        if (! is_string($body) || $format === 'json-unencoded') {
            $body = Services::format()->getFormatter($mime)->format($body);
        }

        return $body;
    }

    // --------------------------------------------------------------------
    // Cache Control Methods
    //
    // http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.9
    // --------------------------------------------------------------------

    /**
     * Sets the appropriate headers to ensure this response
     * is not cached by the browsers.
     *
     * @return $this
     *
     * @todo Recommend researching these directives, might need: 'private', 'no-transform', 'no-store', 'must-revalidate'
     *
     * @see DownloadResponse::noCache()
     */
    public function noCache()
    {
        $this->removeHeader('Cache-Control');
        $this->setHeader('Cache-Control', ['no-store', 'max-age=0', 'no-cache']);

        return $this;
    }

    /**
     * A shortcut method that allows the developer to set all of the
     * cache-control headers in one method call.
     *
     * The options array is used to provide the cache-control directives
     * for the header. It might look something like:
     *
     *      $options = [
     *          'max-age'  => 300,
     *          's-maxage' => 900
     *          'etag'     => 'abcde',
     *      ];
     *
     * Typical options are:
     *  - etag
     *  - last-modified
     *  - max-age
     *  - s-maxage
     *  - private
     *  - public
     *  - must-revalidate
     *  - proxy-revalidate
     *  - no-transform
     *
     * @return $this
     */
    public function setCache(array $options = [])
    {
        if ($options === []) {
            return $this;
        }

        $this->removeHeader('Cache-Control');
        $this->removeHeader('ETag');

        // ETag
        if (isset($options['etag'])) {
            $this->setHeader('ETag', $options['etag']);
            unset($options['etag']);
        }

        // Last Modified
        if (isset($options['last-modified'])) {
            $this->setLastModified($options['last-modified']);

            unset($options['last-modified']);
        }

        $this->setHeader('Cache-Control', $options);

        return $this;
    }

    /**
     * Sets the Last-Modified date header.
     *
     * $date can be either a string representation of the date or,
     * preferably, an instance of DateTime.
     *
     * @param DateTime|string $date
     *
     * @return $this
     */
    public function setLastModified($date)
    {
        if ($date instanceof DateTime) {
            $date->setTimezone(new DateTimeZone('UTC'));
            $this->setHeader('Last-Modified', $date->format('D, d M Y H:i:s') . ' GMT');
        } elseif (is_string($date)) {
            $this->setHeader('Last-Modified', $date);
        }

        return $this;
    }

    // --------------------------------------------------------------------
    // Output Methods
    // --------------------------------------------------------------------

    /**
     * Sends the output to the browser.
     *
     * @return $this
     */
    public function send()
    {
        // If we're enforcing a Content Security Policy,
        // we need to give it a chance to build out it's headers.
        if ($this->CSP->enabled()) {
            $this->CSP->finalize($this);
        } else {
            $this->body = str_replace(['{csp-style-nonce}', '{csp-script-nonce}'], '', $this->body ?? '');
        }

        $this->sendHeaders();
        $this->sendBody();

        return $this;
    }

    /**
     * Sends the headers of this HTTP response to the browser.
     *
     * @return $this
     */
    public function sendHeaders()
    {
        // Have the headers already been sent?
        if (headers_sent()) {
            return $this;
        }

        // Per spec, MUST be sent with each request, if possible.
        // http://www.w3.org/Protocols/rfc2616/rfc2616-sec13.html
        if (! isset($this->headers['Date']) && PHP_SAPI !== 'cli-server') {
            $this->setDate(DateTime::createFromFormat('U', (string) Time::now()->getTimestamp()));
        }

        // HTTP Status
        header(sprintf('HTTP/%s %s %s', $this->getProtocolVersion(), $this->getStatusCode(), $this->getReason()), true, $this->getStatusCode());

        // Send all of our headers
        foreach (array_keys($this->headers()) as $name) {
            header($name . ': ' . $this->getHeaderLine($name), false, $this->getStatusCode());
        }

        return $this;
    }

    /**
     * Sends the Body of the message to the browser.
     *
     * @return $this
     */
    public function sendBody()
    {
        echo $this->body;

        return $this;
    }

    /**
     * Perform a redirect to a new URL, in two flavors: header or location.
     *
     * @param string   $uri  The URI to redirect to
     * @param int|null $code The type of redirection, defaults to 302
     *
     * @return $this
     *
     * @throws HTTPException For invalid status code.
     */
    public function redirect(string $uri, string $method = 'auto', ?int $code = null)
    {
        // IIS environment likely? Use 'refresh' for better compatibility
        if (
            $method === 'auto'
            && isset($_SERVER['SERVER_SOFTWARE'])
            && strpos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS') !== false
        ) {
            $method = 'refresh';
        } elseif ($method !== 'refresh' && $code === null) {
            // override status code for HTTP/1.1 & higher
            if (
                isset($_SERVER['SERVER_PROTOCOL'], $_SERVER['REQUEST_METHOD'])
                && $this->getProtocolVersion() >= 1.1
            ) {
                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    $code = 302;
                } elseif (in_array($_SERVER['REQUEST_METHOD'], ['POST', 'PUT', 'DELETE'], true)) {
                    // reference: https://en.wikipedia.org/wiki/Post/Redirect/Get
                    $code = 303;
                } else {
                    $code = 307;
                }
            }
        }

        if ($code === null) {
            $code = 302;
        }

        switch ($method) {
            case 'refresh':
                $this->setHeader('Refresh', '0;url=' . $uri);
                break;

            default:
                $this->setHeader('Location', $uri);
                break;
        }

        $this->setStatusCode($code);

        return $this;
    }

    /**
     * Extracted call to `setrawcookie()` in order to run unit tests on it.
     *
     * @codeCoverageIgnore
     */
    private function doSetRawCookie(string $name, string $value, array $options): void
    {
        setrawcookie($name, $value, $options);
    }

    /**
     * Extracted call to `setcookie()` in order to run unit tests on it.
     *
     * @codeCoverageIgnore
     */
    private function doSetCookie(string $name, string $value, array $options): void
    {
        setcookie($name, $value, $options);
    }

    /**
     * Force a download.
     *
     * Generates the headers that force a download to happen. And
     * sends the file to the browser.
     *
     * @param string      $filename The name you want the downloaded file to be named
     *                              or the path to the file to send
     * @param string|null $data     The data to be downloaded. Set null if the $filename is the file path
     * @param bool        $setMime  Whether to try and send the actual MIME type
     *
     * @return DownloadResponse|null
     */
    public function download(string $filename = '', $data = '', bool $setMime = false)
    {
        if ($filename === '' || $data === '') {
            return null;
        }

        $filepath = '';
        if ($data === null) {
            $filepath = $filename;
            $filename = explode('/', str_replace(DIRECTORY_SEPARATOR, '/', $filename));
            $filename = end($filename);
        }

        $response = new DownloadResponse($filename, $setMime);

        if ($filepath !== '') {
            $response->setFilePath($filepath);
        } elseif ($data !== null) {
            $response->setBinary($data);
        }

        return $response;
    }

    public function getCSP(): ContentSecurityPolicy
    {
        return $this->CSP;
    }
}
