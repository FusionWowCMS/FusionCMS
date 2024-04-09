<?php namespace CodeIgniter\Debug\Toolbar\Collectors;

use Config\Services;

class Logs extends BaseCollector
{
    /**
     * Whether this collector has data that can
     * be displayed in the Timeline.
     *
     * @var bool
     */
    protected $hasTimeline = false;

    /**
     * Whether this collector needs to display
     * content in a tab or not.
     *
     * @var bool
     */
    protected $hasTabContent = true;

    /**
     * The 'title' of this Collector.
     * Used to name things in the toolbar HTML.
     *
     * @var string
     */
    protected $title = 'Logs';

    /**
     * Our collected data.
     *
     * @var array
     */
    protected $data;

    //--------------------------------------------------------------------

    /**
     * Returns the data of this collector to be formatted in the toolbar
     */
    public function display(): string
    {
        $logger = Services::logger(true);
        $logs = $logger->logCache;

        if (empty($logs) || ! is_array($logs))
        {
            return '<p>Nothing was logged. If you were expecting logged items, ensure that LoggerConfig file has the correct threshold set.</p>';
        }

        $output = "<table><theader><tr><th>Severity</th><th>Message</th></tr></theader><tbody>";

        foreach ($logs as $log)
        {
            $output .= "<tr>";
            $output .= "<td>{$log['level']}</td>";
            $output .= "<td>".htmlspecialchars($log['msg'], ENT_SUBSTITUTE, 'UTF-8')."</td>";
            $output .= "</tr>";
        }

        return $output."</tbody></table>";
    }

    //--------------------------------------------------------------------


}
