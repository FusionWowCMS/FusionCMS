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

use RuntimeException;

/**
 * Class DownloadException
 */
class DownloadException extends RuntimeException implements ExceptionInterface
{
    use DebugTraceableTrait;

    /**
     * @return static
     */
    public static function forCannotSetFilePath(string $path)
    {
        return new static('When setting binary cannot set filepath: "' . $path . '"');
    }

    /**
     * @return static
     */
    public static function forCannotSetBinary()
    {
        return new static('When setting filepath cannot set binary.');
    }

    /**
     * @return static
     */
    public static function forNotFoundDownloadSource()
    {
        return new static('Not found download body source.');
    }

    /**
     * @return static
     */
    public static function forCannotSetCache()
    {
        return new static('It does not support caching for downloading.');
    }

    /**
     * @return static
     */
    public static function forCannotSetStatusCode(int $code, string $reason)
    {
        return new static('It does not support change status code for downloading. code: ' . $code . ', reason: ' . $reason);
    }
}
