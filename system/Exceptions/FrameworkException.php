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
 * Class FrameworkException
 *
 * A collection of exceptions thrown by the framework
 * that can only be determined at run time.
 */
class FrameworkException extends RuntimeException implements ExceptionInterface
{
    use DebugTraceableTrait;

    /**
     * @return static
     */
    public static function forEnabledZlibOutputCompression()
    {
        return new static('Your zlib.output_compression ini directive is turned on. This will not work well with output buffers.');
    }

    /**
     * @return static
     */
    public static function forInvalidFile(string $path)
    {
        return new static('Invalid file: ' . $path);
    }

    /**
     * @return static
     */
    public static function forInvalidDirectory(string $path)
    {
        return new static('Directory does not exist: ' . $path);
    }

    /**
     * @return static
     */
    public static function forCopyError(string $path)
    {
        return new static('An error was encountered while attempting to replace the file ' . $path . '. Please make sure your file directory is writable.');
    }

    /**
     * @return static
     */
    public static function forMissingExtension(string $extension)
    {
        $message = sprintf('The framework needs the following extension(s) installed and loaded: %s.', $extension);

        return new static($message);
    }

    /**
     * @return static
     */
    public static function forNoHandlers(string $class)
    {
        return new static($class . ' must provide at least one Handler.');
    }

    /**
     * @return static
     */
    public static function forFabricatorCreateFailed(string $table, string $reason)
    {
        return new static('Fabricator failed to insert on table ' . $table . ': ' .$reason);
    }
}