<?php namespace CodeIgniter\Debug;

class Exceptions
{

    /**
     * Nesting level of the output buffering mechanism
     *
     * @var    int
     */
    public $ob_level;

    //--------------------------------------------------------------------

    public function __construct()
    {
        $this->ob_level = ob_get_level();
    }

    //--------------------------------------------------------------------

    /**
     * Responsible for registering the error, exception and shutdown
     * handling of our application.
     */
    public function initialize()
    {
        //Set the Exception Handler
        set_exception_handler([$this, 'exceptionHandler']);

        // Set the Error Handler
        set_error_handler([$this, 'errorHandler']);

        // Set the handler for shutdown to catch Parse errors
        register_shutdown_function([$this, 'shutdownHandler']);
    }

    //--------------------------------------------------------------------

    /**
     * Catches any uncaught errors and exceptions, including most Fatal errors
     * (Yay PHP7!). Will log the error, display it if display_errors is on,
     * and fire an event that allows custom actions to be taken at this point.
     *
     * @param \Throwable $e
     */
    public function exceptionHandler(\Throwable $exception)
    {
        // Get Exception Info - these are available
        // directly in the template that's displayed.
        $type    = get_class($exception);
        $code    = $exception->getCode();
        $message = $exception->getMessage();
        $file    = $exception->getFile();
        $line    = $exception->getLine();
        $trace   = $exception->getTrace();

        if (empty($message))
        {
            $message = '(null)';
        }

        // Log it
        log_message('critical', get_class($exception) . ": {message}\nin {exFile} on line {exLine}.\n{trace}", [
            'message' => $exception->getMessage(),
            'exFile'  => self::clean_path($exception->getFile()), // {file} refers to THIS file
            'exLine'  => $exception->getLine(), // {line} refers to THIS line
            'trace'   => self::renderBacktrace($exception->getTrace()),
        ]);

        // Get the first exception.
        $last = $exception;

        while ($prevException = $last->getPrevious()) {
            $last = $prevException;

            log_message('critical', '[Caused by] ' . get_class($prevException) . ": {message}\nin {exFile} on line {exLine}.\n{trace}", [
                'message' => $prevException->getMessage(),
                'exFile'  => self::clean_path($prevException->getFile()), // {file} refers to THIS file
                'exLine'  => $prevException->getLine(), // {line} refers to THIS line
                'trace'   => self::renderBacktrace($prevException->getTrace()),
            ]);
        }

        // Fire an Event

        $view = 'production.php';

        if (str_ireplace(['off', 'none', 'no', 'false', 'null'], '', ini_get('display_errors')))
        {
            $view = 'error_exception.php';
        }

        $templates_path = config_item('error_views_path');
        if (empty($templates_path))
        {
            $templates_path = APPPATH.'views/errors/';
        }

        // Make a nicer title based on the type of Exception.
        $title = get_class($exception);

        if (is_cli())
        {
            $templates_path .= 'cli/';

            // CLI will never accessed by general public
            // while in production.
            $view = 'error_exception.php';
        }
        else
        {
            header('HTTP/1.1 401 Unauthorized', true, 500);
            $templates_path .= 'html/';
        }

        if (ob_get_level() > $this->ob_level + 1)
        {
            ob_end_flush();
        }

        ob_start();
        include($templates_path.$view);
        $buffer = ob_get_contents();
        ob_end_clean();
        echo $buffer;
    }

    /**
     * 404 Error Handler
     *
     * @param string $page Page URI
     * @param  bool $log_error Whether to log the error
     * @return void
     * @uses Exceptions::show_error()
     *
     */
    public function show_404(string $page = '', bool $log_error = true)
    {
        if (is_cli())
        {
            $heading = 'Not Found';
            $message = 'The controller/method pair you requested was not found.';
        }
        else
        {
            $heading = '404 Page Not Found';
            $message = 'The page you requested was not found.';
        }

        // By default, we log this, but allow a dev to skip it
        if ($log_error)
        {
            log_message('error', $heading.': '.$page);
        }

        echo $this->show_error($heading, $message, 'error_404', 404);
        exit(4); // EXIT_UNKNOWN_FILE
    }

    // --------------------------------------------------------------------

    /**
     * General Error Page
     *
     * Takes an error message as input (either as a string or an array)
     * and displays it using the specified template.
     *
     * @param string $heading Page heading
     * @param string|string[] $message Error message
     * @param string $template Template name
     * @param int $status_code (default: 500)
     *
     * @return string Error page output
     */
    public function show_error(string $heading, array|string $message, string $template = 'error_general', int $status_code = 500): string
    {
        $templates_path = config_item('error_views_path');
        if (empty($templates_path))
        {
            $templates_path = APPPATH.'views'.DIRECTORY_SEPARATOR.'errors'.DIRECTORY_SEPARATOR;
        }

        if (is_cli())
        {
            $message = "\t".(is_array($message) ? implode("\n\t", $message) : $message);
            $templates_path .= 'cli/';
        }
        else
        {
            set_status_header($status_code, $heading);
            $message = '<p>'.(is_array($message) ? implode('</p><p>', $message) : $message).'</p>';
            $templates_path .= 'html/';
        }

        if (ob_get_level() > $this->ob_level + 1)
        {
            ob_end_flush();
        }

        ob_start();
        include($templates_path.$template.'.php');
        $buffer = ob_get_contents();
        ob_end_clean();
        return $buffer;
    }

    //--------------------------------------------------------------------

    /**
     * Even in PHP7, some errors make it through to the errorHandler, so
     * convert these to Exceptions and let the exception handler log it and
     * display it.
     *
     * This seems to be primarily when a user triggers it with trigger_error().
     *
     * @param int         $severity
     * @param string      $message
     * @param string|null $file
     * @param int|null    $line
     * @param null        $context
     *
     * @throws \ErrorException
     */
    public function errorHandler(int $severity, string $message, string $file = null, int $line = null, $context = null)
    {
        $config =& get_config2('logger');

        if ($this->isDeprecationError($severity)) {
            if (! $config['logDeprecations']) {
                throw new \ErrorException($message, 0, $severity, $file, $line);
            }

            return $this->handleDeprecationError($message, $file, $line);
        }

        if ((error_reporting() & $severity) !== 0) {
            throw new \ErrorException($message, 0, $severity, $file, $line);
        }

        return false; // return false to propagate the error to PHP standard error handler
    }

    //--------------------------------------------------------------------

    /**
     * Checks to see if any errors have happened during shutdown that
     * need to be caught and handle them.
     */
    public function shutdownHandler()
    {
        $error = error_get_last();

        // If we've got an error that hasn't been displayed, then convert
        // it to an Exception and use the Exception handler to display it
        // to the user.
        if (! is_null($error))
        {
            // Fatal Error?
            if (in_array($error['type'], [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_PARSE]))
            {
                $this->exceptionHandler(new \ErrorException($error['message'], $error['type'], 0, $error['file'], $error['line']));
            }
        }
    }

    //--------------------------------------------------------------------

    private function isDeprecationError(int $error): bool
    {
        $deprecations = E_DEPRECATED | E_USER_DEPRECATED;

        return ($error & $deprecations) !== 0;
    }

    /**
     * @return true
     */
    private function handleDeprecationError(string $message, ?string $file = null, ?int $line = null): bool
    {
        // Remove the trace of the error handler.
        $trace = array_slice(debug_backtrace(), 2);

        log_message(
            5,
            "[DEPRECATED] {message} in {errFile} on line {errLine}.\n{trace}",
            [
                'message' => $message,
                'errFile' => self::clean_path($file ?? ''),
                'errLine' => $line ?? 0,
                'trace'   => self::renderBacktrace($trace),
            ]
        );

        return true;
    }

    //--------------------------------------------------------------------
    // Display Methods
    //--------------------------------------------------------------------

    /**
     * Clean Path
     *
     * This makes nicer looking paths for the error output.
     *
     * @param    string $file
     *
     * @return    string
     */
    public static function clean_path($file)
    {
        switch (true) {
            case str_starts_with($file, APPPATH):
                $file = 'APPPATH/'.substr($file, strlen(APPPATH));
                break;
            case str_starts_with($file, BASEPATH):
                $file = 'BASEPATH/'.substr($file, strlen(BASEPATH));
                break;

            case str_starts_with($file, SYSDIR):
                $file = 'SYSDIR/'.substr($file, strlen(SYSDIR));
                break;

            case str_starts_with($file, FCPATH):
                $file = 'FCPATH/'.substr($file, strlen(FCPATH));
                break;

            case defined('VENDORPATH') && str_starts_with($file, VENDORPATH):
                $file = 'VENDORPATH/' . substr($file, strlen(VENDORPATH));
                break;
        }

        return $file;
    }

    //--------------------------------------------------------------------

    /**
     * Describes memory usage in real-world units. Intended for use
     * with memory_get_usage, etc.
     *
     * @param $bytes
     *
     * @return string
     */
    public static function describeMemory(int $bytes): string
    {
        if ($bytes < 1024)
        {
            return $bytes.'B';
        }
        else if ($bytes < 1048576)
        {
            return round($bytes/1024, 2).'KB';
        }

        return round($bytes/1048576, 2).'MB';
    }

    //--------------------------------------------------------------------

    /**
     * Creates a syntax-highlighted version of a PHP file.
     *
     * @param     $file
     * @param     $lineNumber
     * @param int $lines
     *
     * @return bool|string
     */
    public static function highlightFile($file, $lineNumber, $lines = 15)
    {
        if (empty ($file) || ! is_readable($file))
        {
            return false;
        }

        // Set our highlight colors:
        if (function_exists('ini_set'))
        {
            ini_set('highlight.comment', '#767a7e; font-style: italic');
            ini_set('highlight.default', '#c7c7c7');
            ini_set('highlight.html', '#06B');
            ini_set('highlight.keyword', '#f1ce61;');
            ini_set('highlight.string', '#869d6a');
        }

        try {
            $source = file_get_contents($file);
        } catch (Throwable $e) {
            return false;
        }

        $source = str_replace(["\r\n", "\r"], "\n", $source);
        $source = explode("\n", highlight_string($source, true));
        $source = str_replace('<br />', "\n", $source[1]);

        $source = explode("\n", str_replace("\r\n", "\n", $source));

        // Get just the part to show
        $start = max($lineNumber - (int) round($lines / 2), 0);

        // Get just the lines we need to display, while keeping line numbers...
        $source = array_splice($source, $start, $lines, true);

        // Used to format the line number in the source
        $format = '% ' . strlen((string) ($start + $lines)) . 'd';

        $out = '';
        // Because the highlighting may have an uneven number
        // of open and close span tags on one line, we need
        // to ensure we can close them all to get the lines
        // showing correctly.
        $spans = 1;

        foreach ($source as $n => $row) {
            $spans += substr_count($row, '<span') - substr_count($row, '</span');
            $row = str_replace(["\r", "\n"], ['', ''], $row);

            if (($n + $start + 1) === $lineNumber) {
                preg_match_all('#<[^>]+>#', $row, $tags);

                $out .= sprintf(
                    "<span class='line highlight'><span class='number'>{$format}</span> %s\n</span>%s",
                    $n + $start + 1,
                    strip_tags($row),
                    implode('', $tags[0])
                );
            } else {
                $out .= sprintf('<span class="line"><span class="number">' . $format . '</span> %s', $n + $start + 1, $row) . "\n";
            }
        }

        if ($spans > 0) {
            $out .= str_repeat('</span>', $spans);
        }

        return '<pre><code>'.$out.'</code></pre>';
    }

    private static function renderBacktrace(array $backtrace): string
    {
        $backtraces = [];

        foreach ($backtrace as $index => $trace) {
            $frame = $trace + ['file' => '[internal function]', 'line' => '', 'class' => '', 'type' => '', 'args' => []];

            if ($frame['file'] !== '[internal function]') {
                $frame['file'] = sprintf('%s(%s)', $frame['file'], $frame['line']);
            }

            unset($frame['line']);
            $idx = $index;
            $idx = str_pad((string) ++$idx, 2, ' ', STR_PAD_LEFT);

            $args = implode(', ', array_map(static function ($value): string {
                switch (true) {
                    case is_object($value):
                        return sprintf('Object(%s)', get_class($value));

                    case is_array($value):
                        return $value !== [] ? '[...]' : '[]';

                    case $value === null:
                        return 'null';

                    case is_resource($value):
                        return sprintf('resource (%s)', get_resource_type($value));

                    default:
                        return var_export($value, true);
                }
            }, $frame['args']));

            $backtraces[] = sprintf(
                '%s %s: %s%s%s(%s)',
                $idx,
                self::clean_path($frame['file']),
                $frame['class'],
                $frame['type'],
                $frame['function'],
                $args
            );
        }

        return implode("\n", $backtraces);
    }

    //--------------------------------------------------------------------

}
