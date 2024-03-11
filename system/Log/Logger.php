<?php

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CodeIgniter\Log;

use DateTime;
use Psr\Log\LoggerInterface;
use Throwable;

/**
 * The CodeIgntier Logger
 *
 * The message MUST be a string or object implementing __toString().
 *
 * The message MAY contain placeholders in the form: {foo} where foo
 * will be replaced by the context data in key "foo".
 *
 * The context array can contain arbitrary data, the only assumption that
 * can be made by implementors is that if an Exception instance is given
 * to produce a stack trace, it MUST be in a key named "exception".
 *
 * @package CodeIgniter\Log
 */
class Logger implements LoggerInterface
{

    /**
     * Path to save log files to.
     *
     * @var string
     */
    protected $logPath;

    /**
     * Used by the logThreshold Config setting to define
     * which errors to show.
     *
     * @var array<string, int>
     */
    protected $logLevels = [
        'emergency' => 1,
        'alert'     => 2,
        'critical'  => 3,
        'error'     => 4,
        'warning'   => 5,
        'notice'    => 6,
        'info'      => 7,
        'debug'     => 8,
    ];

    /**
     * Array of levels to be logged.
     * The rest will be ignored.
     * Set in Config/logger.php
     *
     * @var array
     */
    protected $loggableLevels = [];

    /**
     * File permissions
     *
     * @var int
     */
    protected $filePermissions = 0644;

    /**
     * Format of the timestamp for log files.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * Filename Extension
     *
     * @var string
     */
    protected $fileExt;

    /**
     * Caches logging calls for debugbar.
     *
     * @var array
     */
    public $logCache;

    /**
     * Should we cache our logged items?
     *
     * @var bool
     */
    protected $cacheLogs = false;


    public function __construct(bool $debug = CI_DEBUG)
    {
        $config =& get_config2('logger');

        $this->logPath = ! empty($config['log_path']) ? rtrim($config['log_path']).'/' : WRITEPATH.'logs/';

        $this->loggableLevels = is_array($config['log_threshold']) ? $config['log_threshold'] : range(0, (int)$config['log_threshold']);

        // Now convert loggable levels to strings.
        // We only use numbers to make the threshold setting convenient for users.
        if ($this->loggableLevels !== []) {
            $temp = [];

            foreach ($this->loggableLevels as $level) {
                $temp[] = array_search((int) $level, $this->logLevels, true);
            }

            $this->loggableLevels = $temp;
            unset($temp);
        }

        $this->fileExt = ! empty($config['log_fileExtension']) ? ltrim($config['log_fileExtension'], '.') : 'php';

        $this->dateFormat = $config['log_dateFormat'] ?? $this->dateFormat;

        $this->filePermissions = ! empty($config['log_filePermissions']) && is_int($config['log_filePermissions'])
            ? $config['log_filePermissions'] : $this->filePermissions;

        $this->cacheLogs = (bool)$debug;
        if ($this->cacheLogs)
        {
            $this->logCache = [];
        }
    }

    /**
     * System is unusable.
     *
     * @param string $message
     * @param array $context
     *
     * @return bool
     */
    public function emergency($message, array $context = []): bool
    {
        return $this->log('emergency', $message, $context);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array $context
     *
     * @return bool
     */
    public function alert($message, array $context = []): bool
    {
        return $this->log('alert', $message, $context);
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array  $context
     *
     * @return bool
     */
    public function critical($message, array $context = []): bool
    {
        return $this->log('critical', $message, $context);
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array  $context
     *
     * @return bool
     */
    public function error($message, array $context = []): bool
    {
        return $this->log('error', $message, $context);
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array  $context
     *
     * @return bool
     */
    public function warning($message, array $context = []): bool
    {
        return $this->log('warning', $message, $context);
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array  $context
     *
     * @return bool
     */
    public function notice($message, array $context = []): bool
    {
        return $this->log('notice', $message, $context);
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array  $context
     *
     * @return bool
     */
    public function info($message, array $context = []): bool
    {
        return $this->log('info', $message, $context);
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array  $context
     *
     * @return bool
     */
    public function debug($message, array $context = []): bool
    {
        return $this->log('debug', $message, $context);
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     *
     * @return bool
     */
    public function log($level, $message, array $context = []): bool
    {
        if (is_numeric($level)) {
            $level = array_search((int) $level, $this->logLevels, true);
        }

        // Does the app want to log this right now?
        if (! in_array($level, $this->loggableLevels, true)) {
            return false;
        }

        // Parse our placeholders
        $message = $this->interpolate($message, $context);

        if (! is_string($message))
        {
            $message = print_r($message, true);
        }

        if ($this->cacheLogs)
        {
            $this->logCache[] = [
                'level' => $level,
                'msg'   => $message
            ];
        }

        $filepath = $this->logPath.'log-'.date('Y-m-d').'.'.$this->fileExt;

        $msg = '';

        if ( ! file_exists($filepath))
        {
            $newfile = true;

            // Only add protection to php files
            if ($this->fileExt === 'php')
            {
                $msg .= "<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>\n\n";
            }
        }

        if ( ! $fp = @fopen($filepath, 'ab'))
        {
            return false;
        }

        // Instantiating DateTime with microseconds appended to initial date is needed for proper support of this format
        if (strpos($this->dateFormat, 'u') !== false)
        {
            $microtime_full  = microtime(true);
            $microtime_short = sprintf("%06d", ($microtime_full - floor($microtime_full)) * 1000000);
            $date            = new DateTime(date('Y-m-d H:i:s.'.$microtime_short, $microtime_full));
            $date            = $date->format($this->dateFormat);
        }
        else
        {
            $date = date($this->dateFormat);
        }

        $msg .= strtoupper($level).' - '.$date.' --> '.$message."\n";

        flock($fp, LOCK_EX);

        for ($written = 0, $length = strlen($msg); $written < $length; $written += $result)
        {
            if (($result = fwrite($fp, substr($msg, $written))) === false)
            {
                break;
            }
        }

        flock($fp, LOCK_UN);
        fclose($fp);

        if (isset($newfile) && $newfile === true)
        {
            chmod($filepath, $this->filePermissions);
        }

        return is_int($result);
    }

    /**
     * Replaces any placeholders in the message with variables
     * from the context, as well as a few special items like:
     *
     * {session_vars}
     * {post_vars}
     * {get_vars}
     * {env}
     * {env:foo}
     * {file}
     * {line}
     *
     * @param string $message
     *
     * @return string
     */
    protected function interpolate($message, array $context = [])
    {
        if (! is_string($message)) {
            return print_r($message, true);
        }

        // build a replacement array with braces around the context keys
        $replace = [];

        foreach ($context as $key => $val) {
            // Verify that the 'exception' key is actually an exception
            // or error, both of which implement the 'Throwable' interface.
            if ($key === 'exception' && $val instanceof \Throwable) {
                $val = $val->getMessage() . ' ' . $val->getFile() . ':' . $val->getLine();
            }

            // todo - sanitize input before writing to file?
            $replace['{' . $key . '}'] = $val;
        }

        // Add special placeholders
        $replace['{post_vars}'] = '$_POST: ' . print_r($_POST, true);
        $replace['{get_vars}']  = '$_GET: ' . print_r($_GET, true);
        $replace['{env}']       = ENVIRONMENT;

        // Allow us to log the file/line that we are logging from
        if (strpos($message, '{file}') !== false) {
            [$file, $line] = $this->determineFile();

            $replace['{file}'] = $file;
            $replace['{line}'] = $line;
        }

        // Match up environment variables in {env:foo} tags.
        if (strpos($message, 'env:') !== false) {
            preg_match('/env:[^}]+/', $message, $matches);

            foreach ($matches as $str) {
                $key                 = str_replace('env:', '', $str);
                $replace["{{$str}}"] = $_ENV[$key] ?? 'n/a';
            }
        }

        if (isset($_SESSION)) {
            $replace['{session_vars}'] = '$_SESSION: ' . print_r($_SESSION, true);
        }

        // interpolate replacement values into the message and return
        return strtr($message, $replace);
    }

    /**
     * Determines the file and line that the logging call
     * was made from by analyzing the backtrace.
     * Find the earliest stack frame that is part of our logging system.
     */
    public function determineFile(): array
    {
        $logFunctions = [
            'log_message',
            'log',
            'error',
            'debug',
            'info',
            'warning',
            'critical',
            'emergency',
            'alert',
            'notice',
        ];

        // Generate Backtrace info
        $trace = \debug_backtrace(0);

        // So we search from the bottom (earliest) of the stack frames
        $stackFrames = \array_reverse($trace);

        // Find the first reference to a Logger class method
        foreach ($stackFrames as $frame) {
            if (\in_array($frame['function'], $logFunctions, true)) {
                $file = $frame['file'] ?? 'unknown';
                $line = $frame['line'] ?? 'unknown';

                return [
                    $file,
                    $line,
                ];
            }
        }

        return [
            'unknown',
            'unknown',
        ];
    }
}
