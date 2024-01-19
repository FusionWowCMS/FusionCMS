<?php

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CodeIgniter\HTTP\Exceptions;

use CodeIgniter\Exceptions\FrameworkException;

/**
 * Things that can go wrong with HTTP
 */
class HTTPException extends FrameworkException
{
    /**
     * For CurlRequest
     *
     * @return HTTPException
     *
     * @codeCoverageIgnore
     */
    public static function forMissingCurl()
    {
        return new static('CURL must be enabled to use the CURLRequest class.');
    }

    /**
     * For CurlRequest
     *
     * @return HTTPException
     */
    public static function forSSLCertNotFound(string $cert)
    {
        return new static('SSL certificate not found at: '.$cert);
    }

    /**
     * For CurlRequest
     *
     * @return HTTPException
     */
    public static function forInvalidSSLKey(string $key)
    {
        return new static('Cannot set SSL Key. '.$key.' is not a valid file.');
    }

    /**
     * For CurlRequest
     *
     * @return HTTPException
     *
     * @codeCoverageIgnore
     */
    public static function forCurlError(string $errorNum, string $error)
    {
        return new static($errorNum . ' : ' . $error);
    }

    /**
     * For IncomingRequest
     *
     * @return HTTPException
     */
    public static function forInvalidNegotiationType(string $type)
    {
        return new static($type . ' is not a valid negotiation type. Must be one of: media, charset, encoding, language.');
    }

    /**
     * Thrown in IncomingRequest when the json_decode() produces
     *  an error code other than JSON_ERROR_NONE.
     *
     * @param string $error The error message
     *
     * @return static
     */
    public static function forInvalidJSON(?string $error = null)
    {
        return new static('Failed to parse JSON string. Error: ' . $error);
    }

    /**
     * For Message
     *
     * @return HTTPException
     */
    public static function forInvalidHTTPProtocol(string $invalidVersion)
    {
        return new static('Invalid HTTP Protocol Version: ' . $invalidVersion);
    }

    /**
     * For Negotiate
     *
     * @return HTTPException
     */
    public static function forEmptySupportedNegotiations()
    {
        return new static('You must provide an array of supported values to all Negotiations.');
    }

    /**
     * For RedirectResponse
     *
     * @return HTTPException
     */
    public static function forInvalidRedirectRoute(string $route)
    {
        return new static('The route for '. $route .' cannot be found.');
    }

    /**
     * For Response
     *
     * @return HTTPException
     */
    public static function forMissingResponseStatus()
    {
        return new static('HTTP Response is missing a status code');
    }

    /**
     * For Response
     *
     * @return HTTPException
     */
    public static function forInvalidStatusCode(int $code)
    {
        return new static($code . ' is not a valid HTTP return status code');
    }

    /**
     * For Response
     *
     * @return HTTPException
     */
    public static function forUnkownStatusCode(int $code)
    {
        return new static('Unknown HTTP status code provided with no message: ' .$code);
    }

    /**
     * For URI
     *
     * @return HTTPException
     */
    public static function forUnableToParseURI(string $uri)
    {
        return new static('Unable to parse URI: ' . $uri);
    }

    /**
     * For URI
     *
     * @return HTTPException
     */
    public static function forURISegmentOutOfRange(int $segment)
    {
        return new static('Request URI segment is out of range: ' . $segment);
    }

    /**
     * For URI
     *
     * @return HTTPException
     */
    public static function forInvalidPort(int $port)
    {
        return new static('Ports must be between 0 and 65535. Given: ' . $port);
    }

    /**
     * For URI
     *
     * @return HTTPException
     */
    public static function forMalformedQueryString()
    {
        return new static('Query strings may not include URI fragments.');
    }

    /**
     * For Uploaded file move
     *
     * @return HTTPException
     */
    public static function forAlreadyMoved()
    {
        return new static('The uploaded file has already been moved.');
    }

    /**
     * For Uploaded file move
     *
     * @return HTTPException
     */
    public static function forInvalidFile(?string $path = null)
    {
        return new static('The original file is not a valid file.');
    }

    /**
     * For Uploaded file move
     *
     * @return HTTPException
     */
    public static function forMoveFailed(string $source, string $target, string $error)
    {
        return new static('Could not move file '.$source.' to '.$target.'. Reason: ' . $error);
    }

    /**
     * For Invalid SameSite attribute setting
     *
     * @return HTTPException
     *
     * @deprecated Use `CookieException::forInvalidSameSite()` instead.
     *
     * @codeCoverageIgnore
     */
    public static function forInvalidSameSiteSetting(string $samesite)
    {
        return new static('The SameSite setting must be None, Lax, Strict, or a blank string. Given: ' . $samesite);
    }

    /**
     * Thrown when the JSON format is not supported.
     * This is specifically for cases where data validation is expected to work with key-value structures.
     *
     * @return HTTPException
     */
    public static function forUnsupportedJSONFormat()
    {
        return new static('The provided JSON format is not supported.');
    }
}