<?php

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CodeIgniter\Session\Exceptions;

use CodeIgniter\Exceptions\FrameworkException;

class SessionException extends FrameworkException
{
    public static function forMissingDatabaseTable()
    {
        return new static('"sessionSavePath" must have the table name for the Database Session Handler to work.');
    }

    public static function forInvalidSavePath(?string $path = null)
    {
        return new static('Session: Configured save path "' . $path . '" is not a directory, does not exist or cannot be created.');
    }

    public static function forWriteProtectedSavePath(?string $path = null)
    {
        return new static('Session: Configured save path "' . $path . '" is not writable by the PHP process.');
    }

    public static function forEmptySavepath()
    {
        return new static('Session: No save path configured.');
    }

    public static function forInvalidSavePathFormat(string $path)
    {
        return new static('Session: Invalid Redis save path format: "' . $path . '"');
    }

    /**
     * @deprecated
     *
     * @codeCoverageIgnore
     */
    public static function forInvalidSameSiteSetting(string $samesite)
    {
        return new static('Session: The SameSite setting must be None, Lax, Strict, or a blank string. Given: "' . $samesite . '"');
    }
}
