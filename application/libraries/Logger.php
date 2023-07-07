<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * @package FusionCMS
 * @author  Jesper Lindström
 * @author  Xavier Geerinck
 * @author  Elliott Robbins
 * @author  Keramat Jokar (Nightprince) <https://github.com/Nightprince>
 * @author  Ehsan Zare (Darksider) <darksider.legend@gmail.com>
 * @link    https://github.com/FusionWowCMS/FusionCMS
 */

class Logger
{
    private $CI;

    /**
     * Logs status
     **/
    public const STATUS_FAILED  = 'failed';
    public const STATUS_SUCCEED = 'succeed';

    public function __construct()
    {
        //Get the instance of the CI
        $this->CI = &get_instance();

        // Load the logger model
        $this->CI->load->model('logger_model');
    }

    /**
     * Get all the logs by type and limit
     *
     * @param  null $type
     * @param  int $limit
     * @return mixed
     */
    public function getLogs($type = "", $offset = 0, $limit = 0)
    {
        return $this->CI->logger_model->getLogsDb($type, $offset, $limit);
    }

    public function getModLogs()
    {
        $modLogs = $this->CI->logger_model->getModLogsDb();

        //Get Characters name if isAcc = 0
        for ($i = 0; $i < count((array)$modLogs); $i++) {
            if ($modLogs[$i]["isAcc"] == false)
            {
                $realm = $this->CI->realms->getRealm($modLogs[$i]["realm"]);
                $characters = $realm->getCharacters();
                $charId = $modLogs[$i]["affected"];

                $modLogs[$i]["charName"] = $characters->characterExists($charId) ? $characters->getNameByGuid($charId) : "Char doesn't exists";
            }
        }

        return $modLogs;
    }

    /**
     * Create a new log with the given data
     *
     * @param $message
     * @param string $event
     * @param string $message
     * @param string $status
     * @param string $custom
     * @param int $user
     */
    public function createLog($type, $event, $message, $custom = [], $status = self::STATUS_SUCCEED, $user = null)
    {
        // Module name
        $module = $this->CI->template->getModuleName();

        if ($this->CI->user->isOnline())
        {
            $user = $this->CI->user->getId();
        }

        // Call our model and add to the db.
        $this->CI->logger_model->createLogDb($module, $user, $type, $event, $message, $status, json_encode($custom), $this->CI->input->ip_address());
    }

    public function createModLog($action, $affected, $isAcc, $realmId)
    {
        $modId = 0;

        if ($this->CI->user->isOnline())
        {
            $modId = $this->CI->user->getId();
        }

        // Call our model and add to the db.
        $this->CI->logger_model->createModLogDb($action, $modId, $affected, $this->CI->input->ip_address(), $isAcc, $realmId);
    }

    /**
     * Get the number of logs.
     *
     * @return mixed
     */
    public function getLogCount()
    {
        return $this->CI->logger_model->getLogCount();
    }
}
