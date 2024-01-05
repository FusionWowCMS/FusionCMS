<?php namespace CodeIgniter\Debug\Toolbar\Collectors;

use CI_DB;
use CI_Model;

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
     * Number of queries to show before making the additional queries togglable
     *
     * @var int
     */
    protected int $query_toggle_count = 25;

    //--------------------------------------------------------------------

    /**
     * Builds and returns the HTML needed to fill a tab to display
     * within the Debug Bar
     *
     * @return string
     */
    public function display(): string
    {
        $CI =& get_instance();

        $output = "<table><tbody>";

        $dbs = [];

        // Let's determine which databases are currently connected to
        foreach (get_object_vars($CI) as $name => $object)
        {
            if (is_object($object))
            {
                if ($object instanceof CI_DB)
                {
                    $dbs[get_class($CI).':$'.$name] = $object;
                }
                elseif ($object instanceof CI_Model)
                {
                    foreach (get_object_vars($object) as $mname => $mobject)
                    {
                        if ($mobject instanceof CI_DB)
                        {
                            $dbs[get_class($object).':$'.$mname] = $mobject;
                        }
                    }
                }
            }
        }

        if (count($dbs) === 0)
        {
            return '<tr><td>' .$CI->lang->line('profiler_no_db') ."</td></tr>";
        }

        // Load the text helper so we can highlight the SQL
        $CI->load->helper('text');

        // Key words we want bolded
        $highlight = array('SELECT', 'DISTINCT', 'FROM', 'WHERE', 'AND', 'LEFT&nbsp;JOIN', 'ORDER&nbsp;BY', 'GROUP&nbsp;BY', 'LIMIT', 'INSERT', 'INTO', 'VALUES', 'UPDATE', 'OR&nbsp;', 'HAVING', 'OFFSET', 'NOT&nbsp;IN', 'IN', 'LIKE', 'NOT&nbsp;LIKE', 'COUNT', 'MAX', 'MIN', 'ON', 'AS', 'AVG', 'SUM', '(', ')');

        $count = 0;

        foreach ($dbs as $name => $db)
        {
            ++$count;

            $hide_queries = (count($db->queries) > $this->query_toggle_count) ? ' display:none' : '';
            $total_time = number_format(array_sum($db->query_times), 4).' '.$CI->lang->line('profiler_seconds');

            $output .= '<legend>'.$CI->lang->line('profiler_database')
                .': '.$db->database.' ('.$name.') '.$CI->lang->line('profiler_queries')
                .': '.count($db->queries).' ('.$total_time.')'."</legend>\n\n\n";

            if (count($db->queries) === 0)
            {
                $output .= '<tr><td>' .$CI->lang->line('profiler_no_queries') . "</td></tr>\n";
            }
            else
            {
                foreach ($db->queries as $key => $val)
                {
                    $time = number_format($db->query_times[$key], 4);
                    $val = highlight_code($val);

                    foreach ($highlight as $bold)
                    {
                        $val = str_replace($bold, '<strong>'.$bold.'</strong>', $val);
                    }

                    $output .= '<tr><td>'
                        .$time.'</td><td>'
                        .$val."</td></tr>\n";
                }
            }
        }

        $output .= "</tbody></table>";

        return $output;
    }

    //--------------------------------------------------------------------
}
