<?php

declare(strict_types=1);

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CodeIgniter\Exceptions;

use OutOfBoundsException;

class PageNotFoundException extends OutOfBoundsException implements ExceptionInterface, HTTPExceptionInterface
{
    use DebugTraceableTrait;

    /**
     * HTTP status code
     *
     * @var int
     */
    protected $code = 404;

    /**
     * @return static
     */
    public static function forPageNotFound(?string $message = null)
    {
        return new static($message ?? 'Page Not Found');
    }

    /**
     * @return static
     */
    public static function forEmptyController()
    {
        return new static('No Controller specified.');
    }

    /**
     * @return static
     */
    public static function forControllerNotFound(string $controller, string $method)
    {
        return new static('Controller or its method is not found: ' . $controller . '::' . $method);
    }

    /**
     * @return static
     */
    public static function forMethodNotFound(string $method)
    {
        return new static('Controller method is not found: "' . $method . '"');
    }

    /**
     * @return static
     */
    public static function forLocaleNotSupported(string $locale)
    {
        return new static('Locale is not supported: ' . $locale);
    }
}
