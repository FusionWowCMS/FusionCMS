<?php namespace CodeIgniter\Debug\Toolbar\Collectors;

use App\Config\Database;
use CI_DB;
use CI_Model;
use CodeIgniter\Database\Query;
use CodeIgniter\I18n\Time;

class DB extends BaseCollector
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
    protected $title = 'Databases';

    /**
     * Array of database connections.
     *
     * @var array
     */
    protected $connections;

    /**
     * The query instances that have been collected
     * through the DBQuery Event.
     *
     * @var array
     */
    protected static $queries = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->getConnections();
    }

    /**
     * The static method used during Events to collect
     * data.
     *
     * @internal
     *
     * @return void
     */
    public static function collect(Query $query)
    {
        // Provide default in case it's not set
        $max = 100;

        if (count(static::$queries) < $max) {
            $queryString = $query->getQuery();

            $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

            if (! is_cli()) {
                // when called in the browser, the first two trace arrays
                // are from the DB event trigger, which are unneeded
                $backtrace = array_slice($backtrace, 2);
            }

            static::$queries[] = [
                'query'     => $query,
                'string'    => $queryString,
                'duplicate' => in_array($queryString, array_column(static::$queries, 'string', null), true),
                'trace'     => $backtrace,
            ];
        }
    }

    //--------------------------------------------------------------------

    /**
     * Builds and returns the HTML needed to fill a tab to display
     * within the Debug Bar
     *
     * @return string
     */
    public function display(): string
    {
        $output = '<table><thead><tr><th class="debug-bar-width6r">Time</th><th>Query String</th></tr></thead><tbody>';
        $data            = [];
        $data['queries'] = array_map(static function (array $query) {
            $isDuplicate = $query['duplicate'] === true;

            $firstNonSystemLine = '';

            foreach ($query['trace'] as $index => &$line) {
                // simplify file and line
                if (isset($line['file'])) {
                    $line['file'] = clean_path($line['file']) . ':' . $line['line'];
                    unset($line['line']);
                } else {
                    $line['file'] = '[internal function]';
                }

                // find the first trace line that does not originate from `system/`
                if ($firstNonSystemLine === '' && !str_contains($line['file'], 'BASEPATH')) {
                    $firstNonSystemLine = $line['file'];
                }

                // simplify function call
                if (isset($line['class'])) {
                    $line['function'] = $line['class'] . $line['type'] . $line['function'];
                    unset($line['class'], $line['type']);
                }

                if (strrpos($line['function'], '{closure}') === false) {
                    $line['function'] .= '()';
                }

                $line['function'] = str_repeat(chr(0xC2) . chr(0xA0), 8) . $line['function'];

                // add index numbering padded with nonbreaking space
                $indexPadded = str_pad(sprintf('%d', $index + 1), 3, ' ', STR_PAD_LEFT);
                $indexPadded = preg_replace('/\s/', chr(0xC2) . chr(0xA0), $indexPadded);

                $line['index'] = $indexPadded . str_repeat(chr(0xC2) . chr(0xA0), 4);
            }

            return [
                'hover'      => $isDuplicate ? 'This query was called more than once.' : '',
                'class'      => $isDuplicate ? 'duplicate' : '',
                'duration'   => ((float) $query['query']->getDuration(5) * 1000) . ' ms',
                'sql'        => $query['query']->debugToolbarDisplay(),
                'trace'      => $query['trace'],
                'trace-file' => $firstNonSystemLine,
                'qid'        => md5($query['query'] . Time::now()->format('0.u00 U')),
            ];
        }, static::$queries);


        foreach ($data['queries'] as $val)
        {
            $output .= '<tr class="'.$val['class'].'" title="'.$val['hover'].'" data-toggle="'.$val['qid'].'-trace">
                            <td class="narrow">'.$val['duration'].'</td>
                            <td>'.$val['sql'].'</td>
                            <td class="debug-bar-alignRight"><strong>'.$val['trace-file'].'</strong></td>
                        </tr>';

            foreach ($val['trace'] as $trc)
            {
                $output .= '<tr class="muted debug-bar-ndisplay" id="'.$val['qid'].'-trace">
                            <td></td>
                            <td colspan="2">
                                '.$trc['index'].'<strong>'.$trc['file'].'</strong><br/>
                                '.$trc['function'].'<br/><br/>
                            </td>
                        </tr>';
            }
        }
        $output .= "</tbody></table>";
        return $output;
    }

    /**
     * Gets the connections from the database config
     */
    private function getConnections(): void
    {
        $this->connections = Database::getConnections();
    }

    //--------------------------------------------------------------------
}
