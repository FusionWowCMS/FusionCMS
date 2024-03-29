<?php

use MX\MX_Controller;

class Errorlogs extends MX_Controller
{
    private static $levelsIcon = array(
        'INFO'     => 'fa-duotone fa-circle-info',
        'ERROR'    => 'fa-duotone fa-triangle-exclamation',
        'CRITICAL' => 'fa-duotone fa-triangle-exclamation',
        'DEBUG'    => 'fa-duotone fa-triangle-exclamation',
        'WARNING'  => 'fa-duotone fa-warning',
        'ALL'      => 'fa-duotone fa-minus',
    );

    private static $levelClasses = [
        'INFO'     => 'info',
        'ERROR'    => 'danger',
        'CRITICAL' => 'danger',
        'WARNING'  => 'warning',
        'DEBUG'    => 'debug',
        'ALL'      => 'muted',
    ];

    private $LOG_LINE_START_PATTERN = "/((INFO)|(ERROR)|(DEBUG)|(CRITICAL)|(WARNING)|(ALL))[\s\-\d:\.\/]+(-->)/";
    private $LOG_DATE_PATTERN = ["/^((ERROR)|(INFO)|(DEBUG)|(CRITICAL)|(WARNING)|(ALL))\s\-\s/", "/\s(-->)/"];
    private $LOG_LEVEL_PATTERN = "/^((ERROR)|(INFO)|(DEBUG)|(CRITICAL)|(WARNING)|(ALL))/";

    //this is the path (folder) on the system where the log files are stored
    private $logFolderPath;

    //this is the pattern to pick all log files in the $logFilePath
    private $logFilePattern;

    //this is a combination of the LOG_FOLDER_PATH and LOG_FILE_PATTERN
    private $fullLogFilePath = "";

    private $MAX_STRING_LENGTH = 300; //300 chars

    public function __construct()
    {
        parent::__construct();

        $this->load->library("administrator");

        $this->logFolderPath =  WRITEPATH . "/logs";
        $this->logFilePattern = "log-*.php";

        //concatenate to form Full Log Path
        $this->fullLogFilePath = $this->logFolderPath . "/" . $this->logFilePattern;
    }

    public function index()
    {
        //it will either get the value of f or return null
        $fileName =  $this->input->get("f");

        //get the log files from the log directory
        $files = $this->getFiles();

        //let's determine what the current log file is
        if (!is_null($fileName)) {
            $currentFile = $this->logFolderPath . "/" . basename(base64_decode($fileName));
        } elseif (is_null($fileName) && !empty($files)) {
            $currentFile = $this->logFolderPath . "/" . $files[0];
        } else {
            $currentFile = null;
        }

        if (!is_null($currentFile) && file_exists($currentFile)) {
            $logs =  $this->processLogs($this->getLogs($currentFile));
        } else {
            $logs = [];
        }

        $data = array(
            'logs' => $logs,
            'files' => $files,
            'currentFile' => !is_null($currentFile) ? basename($currentFile) : "",
        );

        $output = $this->template->loadPage("errorlogs.tpl", $data);

        $content = $this->administrator->box('Error logs', $output);

        $this->administrator->view($content);
    }

    private function processLogs($logs)
    {
        if (is_null($logs)) {
            return null;
        }

        $superLog = [];

        foreach ($logs as $log) {
            //get the logLine Start
            $logLineStart = $this->getLogLineStart($log);

            if (!empty($logLineStart)) {
                //this is actually the start of a new log and not just another line from previous log
                $level = $this->getLogLevel($logLineStart);
                $data = [
                    "level" => $level,
                    "date" => $this->getLogDate($logLineStart),
                    "icon" => self::$levelsIcon[$level],
                    "class" => self::$levelClasses[$level],
                ];

                $logMessage = preg_replace($this->LOG_LINE_START_PATTERN, '', $log);

                if (strlen($logMessage) > $this->MAX_STRING_LENGTH) {
                    $data['content'] = substr($logMessage, 0, $this->MAX_STRING_LENGTH);
                    $data["extra"] = substr($logMessage, ($this->MAX_STRING_LENGTH + 1));
                } else {
                    $data["content"] = $logMessage;
                }

                $superLog[] = $data;
            } elseif (!empty($superLog)) {
                //this log line is a continuation of previous logline
                //so let's add them as extra
                $prevLog = $superLog[count($superLog) - 1];
                $extra = (array_key_exists("extra", $prevLog)) ? $prevLog["extra"] : "";
                $prevLog["extra"] = $extra . "<br>" . $log;
                $superLog[count($superLog) - 1] = $prevLog;
            }
        }

        return $superLog;
    }

    private function getLogLevel($logLineStart)
    {
        preg_match($this->LOG_LEVEL_PATTERN, $logLineStart, $matches);
        return $matches[0];
    }

    private function getLogDate($logLineStart)
    {
        return preg_replace($this->LOG_DATE_PATTERN, '', $logLineStart);
    }

    private function getLogLineStart($logLine)
    {
        preg_match($this->LOG_LINE_START_PATTERN, $logLine, $matches);
        if (!empty($matches)) {
            return $matches[0];
        }
        return "";
    }

    private function getLogs($fileName)
    {
        $size = filesize($fileName);
        if (!$size) {
            return null;
        }
        return file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }

    private function getFiles($basename = true)
    {
        $files = glob($this->fullLogFilePath);

        $files = array_reverse($files);
        $files = array_filter($files, 'is_file');
        if ($basename && is_array($files)) {
            foreach ($files as $k => $file) {
                $files[$k] = basename($file);
            }
        }
        return array_values($files);
    }
}
