<?php defined('BASEPATH') OR exit('No direct script access allowed');

# Import required classes
use \VisualAppeal\AutoUpdate;
use MX\MX_Controller;

/**
 * Updater
 *
 * @package    FusionCMS
 * @subpackage admin/updater
 * @since      1.0.0
 * @version    1.0.0
 * @author     Ehsan Zare (Darksider) <darksider.legend@gmail.com>
 * @author     Keramat Jokar (Nightprince) <https://github.com/Nightprince>
 * @link       https://code-path.com
 * @copyright  (c) 2023 Code-path web developing team
 */

class Updater extends MX_Controller
{
    # Directory separator shortcut
    const DS = DIRECTORY_SEPARATOR;

    # CMS version
    private $version;

    # Log path
    private $log_path;

    # Log file
    private $log_file;

    # Cache path
    private $cache_path;

    # Cache file
    private $cache_file;

    # Update path
    private $update_path;

    # Extract path
    private $extract_path;

    # GitHub releases URL
    private $releases_url;

    # Asset file extension
    private $asset_file_ext;

    public function __construct()
    {
        # Call `MX_Controller` construct
        parent::__construct();

        # Make sure user has required permissions
        requirePermission('updateCms');

        # Load libraries
        $this->load->library('administrator');

        # CMS version
        $this->version = $this->administrator->getVersion();

        # Log path
        $this->log_path = (($this->config->item('log_path') && realpath($this->config->item('log_path'))) ? realpath($this->config->item('log_path')) : realpath(WRITEPATH) . self::DS . 'logs') . self::DS;

        # Log file
        $this->log_file = 'update-{DATE}.log';

        # Cache path
        $this->cache_path = (($this->config->item('cache_path') && realpath($this->config->item('cache_path'))) ? realpath($this->config->item('cache_path')) : realpath(APPPATH) . self::DS . 'cache') . self::DS . 'data' . self::DS . 'update' . self::DS;

        # Cache file
        $this->cache_file = 'assets.json';

        # Update path
        $this->update_path = realpath(FCPATH) . self::DS;

        # Extract path
        $this->extract_path = $this->update_path . 'temp';

        # GitHub releases URL
        $this->releases_url = 'https://api.github.com/repos/FusionWowCMS/FusionCMS/releases?page={PAGE}&per_page={PER_PAGE}';

        # Asset file extension
        $this->asset_file_ext = '.zip';

        # Create required paths if not exists
        foreach([$this->log_path, $this->cache_path] as $path)
        {
            if(!file_exists($path))
            {
                try
                {
                    mkdir($path);
                    chmod($path, 0755);
                }
                catch(Error | Exception $e)
                {
                    show_error($e->getMessage());
                }
            }
        }
    }

    public function index()
    {
        // Set page title
        $this->administrator->setTitle('Updater');

        // Get last update log
        ($log = $this->dblogger->getLogs('updater', 0, 1)) ? $log = reset($log) : $log = ['time' => false];

        // Format last update log time
        if($log['time']) $log['time'] = date('Y-m-d H:i:s', $log['time']);

        // Prepare data
        $data = [
            # General
            'url'             => $this->template->page_url,

            # Releases url
            'releases_url'    => str_replace(['api.github.com', 'github.com/repos/'], ['github.com', 'github.com/'], substr($this->releases_url, 0, strrpos($this->releases_url, '?'))),

            # Last updated
            'last_updated'    => $log['time'],

            # Logs
            'logs'            => $this->logs(),

            # Response
            'response'        => $this->check(),

            # Server info
            'server_modules'  => function_exists('apache_get_modules') ? apache_get_modules() : false,
            'server_software' => $_SERVER['SERVER_SOFTWARE'],

            # PHP info
            'php_version'     => phpversion(),
            'php_extensions'  => get_loaded_extensions(),

            # Framework versions
            'ci_version'      => CI_VERSION,
            'cms_version'     => $this->version,
            'smarty_version'  => $this->smarty::SMARTY_VERSION
        ];

        // Append last checked
        $data['last_checked'] = date('Y-m-d H:i:s', filemtime($this->cache_path . $this->cache_file));

        // Render page
        $this->administrator->view($this->administrator->box('Updater', $this->template->loadPage('updater.tpl', $data)), false, 'modules/admin/js/updater.js');
    }

    /**
     * Logs
     * Get update logs
     *
     * @return array $logs
     */
    public function logs()
    {
        // Initialize logs to bake them later
        $logs = [];

        // Get log files
        $files = glob($this->log_path . str_replace('{DATE}', '*', $this->log_file), GLOB_BRACE);

        // Explode log file name
        $log_file_name_arr = explode('{DATE}', $this->log_file);

        // Loop through files
        foreach($files as $file)
        {
            // Export file name
            $fileName = pathinfo(basename($file), PATHINFO_FILENAME);

            // Export file date from name
            $fileDate = str_replace($log_file_name_arr, '', $fileName);

            // Open log file
            $log = fopen($file, 'r');

            // Append log file
            $logs[$fileDate] = fread($log, filesize($file));

            // Close log file
            fclose($log);
        }

        // Fetch GET data
        $today = $this->input->get('today', TRUE);

        // Toss today's log
        if($today)
            die(isset($logs[date('Y-m-d')]) ? $logs[date('Y-m-d')] : '');

        // Sort logs
        uksort($logs, function($a, $b) {
            return strtotime($a) <=> strtotime($b);
        });

        return $logs;
    }

    /**
     * Update
     * Install update packages
     *
     * @return void
     */
    public function update()
    {
        // Make sure its ajax request
        if(!$this->input->is_ajax_request())
            exit('No direct script access allowed');

        // Check for updates
        $response = $this->check();

        // Keep track of updated flag
        $response['updated'] = '0';

        // Make sure updates available
        if(!$response['available'])
            die(json_encode($response));

        // Format update server url
        $update_url = rtrim(str_replace([self::DS, '\\', '/', realpath(APPPATH)], ['/', '/', '/', base_url() . basename(APPPATH)], $this->cache_path), '/');

        // Format packages array
        array_walk($response['packages'], function(&$v) {
            $v = $v['asset']['browser_download_url'];
        });

        // Generate update.json
        $json = fopen($this->cache_path . 'update.json', 'w');

        // Write update.json
        fwrite($json, json_encode($response['packages'], JSON_PRETTY_PRINT));

        // Close update.json
        fclose($json);

        ####################################################################################################
        ########################################## BEGIN UPDATING ##########################################
        ####################################################################################################

        // Create extract path if not exists
        if(!file_exists($this->extract_path))
        {
            try
            {
                mkdir($this->extract_path);
                chmod($this->extract_path, 0755);
            }
            catch(Error | Exception $e)
            {
                // Set message
                $response['message'] = $e->getMessage();

                // Throw response
                die(json_encode($response));
            }
        }

        // Remove extract path (we no longer need them)
        register_shutdown_function(function() { $this->removeDir($this->extract_path); });

        // Create new object off `AutoUpdate`
        $update = new AutoUpdate($this->extract_path, $this->update_path, 60);

        // `AutoUpdate` Set current version
        $update->setCurrentVersion($this->version);

        // `AutoUpdate` Set updateUrl
        $update->setUpdateUrl($update_url);

        // Create new object off `Logger`
        $logger = new \Monolog\Logger('default');

        // `Logger` Set push handler
        $logger->pushHandler((new Monolog\Handler\StreamHandler($this->log_path . str_replace('{DATE}', date('Y-m-d'), $this->log_file)))->setFormatter(new Monolog\Formatter\LineFormatter("[%datetime%] %channel%.%level_name%: %message% \n", "Y-m-d|H:i:s")));

        // `AutoUpdate` Set logger
        $update->setLogger($logger);

        // Check for a new update
        if($update->checkUpdate() === false)
        {
            // Set message
            $response['message'] = 'Could not check for updates! See log file for details.';

            // Throw response
            die(json_encode($response));
        }

        // Application is already up-to-date
        if(!$update->newVersionAvailable())
        {
            // Set message
            $response['message'] = 'Current Version is up to date.';

            // Throw response
            die(json_encode($response));
        }

        // Set error handler
        set_error_handler(function() {});

        try
        {
            // Simulate update
            $result = $update->update(true);

            // Check for errors
            if($result !== true)
            {
                // Set message
                $response['message'] = 'Update simulation failed: ' . $result . '!';

                // Append few more data to message
                if(AutoUpdate::ERROR_SIMULATE && $update->getSimulationResults())
                {
                    $response['message'] = $response['message'] . '<br />';
                    $response['message'] = $response['message'] . '<pre>';
                    $response['message'] = $response['message'] . var_dump($update->getSimulationResults());
                    $response['message'] = $response['message'] . '</pre>';
                }

                // Throw response
                die(json_encode($response));
            }
        }
        catch(Error | Exception $e)
        {
            // Set message
            $response['message'] = $e->getMessage();

            // Throw response
            die(json_encode($response));
        }

        // Restore error handler
        restore_error_handler();

        // Callback on each version update
        $update->onEachUpdateFinish(function($version) use($logger) { $this->updateCallback($version, $logger); });

        // Callback on all version update
        $update->setOnAllUpdateFinishCallbacks(function($versions) use($logger) { $this->updateFinishCallback($versions, $logger); });

        // Finally apply updates
        $result = $update->update(false);

        // Check for possible errors (network)
        if($result !== true)
        {
            // Set message
            $response['message'] = 'Update failed: ' . $result . '!';

            // Throw response
            die(json_encode($response));
        }

        // Set updated flag
        $response['updated'] = '1';

        // Set message
        $response['message'] = 'Update successful.';

        // Throw response
        die(json_encode($response));
    }

    /**
     * Update callback
     * Callback on each version update
     *
     * @param  string $version
     * @param  object $logger
     * @return void
     */
    private function updateCallback($version, $logger)
    {
        $this->insertSQL($logger);
        $this->removeFiles($logger);
        $this->saveLastUpdate($version);
    }

    /**
     * Update finish callback
     * Callback on all version update
     *
     * @param  array  $versions
     * @param  object $logger
     * @return void
     */
    private function updateFinishCallback($versions, $logger)
    {
    }

    /**
     * Insert SQL
     * Execute update SQL queries
     *
     * @param  object $logger
     * @return void
     */
    private function insertSQL($logger)
    {
        // Look for sql files
        $files = array_merge(glob($this->extract_path . self::DS . '*.sql', GLOB_BRACE), glob($this->extract_path . self::DS . '*' . self::DS . '*.sql', GLOB_BRACE));

        // Loop through files
        foreach($files as $file)
        {
            // Logger
            $logger->debug(sprintf('Inserting "%s"', $file));

            // Read the sql file
            $lines = file($file);

            // Initialize statement
            $statement = '';

            // Loop through lines
            foreach($lines as $line)
            {
                // Append line to statement
                $statement .= $line;

                // Semicolon found! do the magic...
                if(substr(trim($line), -1) === ';')
                {
                    // Run query
                    $res = $this->db->simple_query($statement);

                    // Logger
                    ($res) ? $logger->notice(sprintf('Insert "%s" successfully', $file)) : $logger->error(sprintf('Failed to insert: "%s"', $file));

                    // Reset statement
                    $statement = '';
                }
            }

            // Delete the file
            unlink($file);
        }
    }

    /**
     * Remove files
     * Check if update wants to remove any files
     *
     * @param  object $logger
     * @return void
     */
    private function removeFiles($logger)
    {
        // Path to remove.txt file
        $file = $this->extract_path . self::DS . 'remove.txt';

        // Make sure remove.txt exists
        if(!file_exists($file))
            return;

        // Read remove.txt file
        $lines = file($file);

        // Loop through lines
        foreach($lines as $line)
        {
            // Append root dir
            $line = realpath($this->update_path . str_replace(['\\', '/'], self::DS, trim($line)));

            // Make sure its valid path
            if(!$line || strpos($line, $this->update_path) === false)
                continue;

            // Logger
            $logger->debug(sprintf('Trying to delete "%s"', $line));

            (is_dir($line)) ? $this->removeDir($line) : unlink($line);

            // Logger
            (file_exists($line)) ? $logger->error(sprintf('Failed to delete: "%s"', $line)) : $logger->notice(sprintf('Deleted "%s" successfully', $line));
        }

        // Delete remove.txt file
        unlink($file);
    }

    /**
     * Save last update
     * Keep track of last installed update time
     *
     * @param  string $version
     * @return void
     */
    private function saveLastUpdate($version)
    {
        // Prepare data
        $data = [
            'type'    => 'updater',
            'event'   => 'update',
            'message' => 'Installed update: ' . $version
        ];

        // Create log
        $this->dblogger->createLog($data['type'], $data['event'], $data['message']);
    }

    /**
     * Check
     * Determine if any update package is available
     *
     * @return array $data
     */
    private function check()
    {
        // Initialize data to bake them later
        $data = [
            'message'   => false,
            'packages'  => [],
            'available' => false
        ];

        // Get update packages
        $packages = $this->packages();

        // an error occurred getting update packages
        if(!is_array($packages))
        {
            $data['message'] = $packages;
        }
        else
        {
            // No updates available
            if(count($packages) == 0 || array_key_last($packages) == $this->version)
            {
                $data['message'] = 'No updates available.';
            }
            else
            {
                // Keep track of skip
                $skip = !isset($packages[$this->version]) ? false : true;

                // Loop through packages
                foreach($packages as $key => $package)
                {
                    // We're gonna need rest of packages
                    if($skip && $key == $this->version)
                    {
                        $skip = false;
                        continue;
                    }

                    // Skip installed updates
                    if($skip)
                        continue;

                    // Add package
                    $data['packages'][$key] = $package;
                }

                // Updates available
                if(count($data['packages']))
                    $data['available'] = true;
            }
        }

        return $data;
    }

    /**
     * Packages
     * Get update packages
     *
     * @return array $updates
     */
    private function packages()
    {
        // Check for cache
        if(file_exists($this->cache_path . $this->cache_file))
        {
            // Cache file creation time
            $cache_creation_time = filemtime($this->cache_path . $this->cache_file);

            // Make sure cache file is still valid
            if(time() <= ($cache_creation_time + (60 * 60 * 1))) # Valid for 1 hour
            {
                // Open cache file
                $cache = fopen($this->cache_path . $this->cache_file, 'r');

                // Read cache file
                $updates = fread($cache, filesize($this->cache_path . $this->cache_file));

                // Close cache file
                fclose($cache);

                return json_decode($updates, true);
            }
        }

        // Limit
        $limit = ['offset' => 1, 'count' => 100];

        // Initialize updates to bake them later
        $updates = [];

        // Initialize releases to bake them later
        $releases = [];

        // Fetch GitHub repository releases until we find current asset version
        while(strpos(json_encode($releases), $this->version . $this->asset_file_ext) === false)
        {
            // Send http request to fetch releases
            $data = $this->call(str_replace(['{PAGE}', '{PER_PAGE}'], [$limit['offset'], $limit['count']], $this->releases_url));

            // Parse our json
            $data = json_decode($data, true);

            // STOP! API error occurred
            if(is_array($data) && isset($data['message']))
                return $data['message'];

            // STOP! Looks like this is last page
            if(!$data || $data === null || (is_array($data) && count($data) == 0))
                break;

            // Append data
            $releases = array_merge($releases, $data);

            // Increase offset
            $limit['offset'] = $limit['offset'] + 1;
        };

        // Loop through releases
        foreach($releases as $release)
        {
            // Invalid release
            if(!is_array($release) || !isset($release['assets']) || !is_array($release['assets']))
                continue;

            // Loop through assets
            foreach($release['assets'] as $asset)
            {
                // Invalid asset
                if(!is_array($asset) || !isset($asset['browser_download_url']) || !is_string($asset['browser_download_url']))
                    continue;

                // Get asset file name and extension
                $asset['fileName'] = pathinfo(basename($asset['browser_download_url']), PATHINFO_FILENAME);
                $asset['fileExt']  = pathinfo(basename($asset['browser_download_url']), PATHINFO_EXTENSION);

                // Invalid asset
                if(!$asset['fileName'] || $asset['fileExt'] != str_replace('.', '', $this->asset_file_ext))
                    continue;

                // Add asset to our updates array
                $updates[$asset['fileName']] = [
                    # Release info
                    'release' => [
                        'name'     => isset($release['name'])     ? $release['name']     : '',
                        'html_url' => isset($release['html_url']) ? $release['html_url'] : '',
                    ],

                    # Asset info
                    'asset' => [
                        'author' => [
                            'name'     => isset($asset['uploader']['login'])      ? $asset['uploader']['login']      : '',
                            'avatar'   => isset($asset['uploader']['avatar_url']) ? $asset['uploader']['avatar_url'] : '',
                            'html_url' => isset($asset['uploader']['html_url'])   ? $asset['uploader']['html_url']   : ''
                        ],

                        'created_at'           => isset($asset['created_at']) ? date('Y-m-d H:i:s', strtotime($asset['created_at'])) : '',
                        'updated_at'           => isset($asset['updated_at']) ? date('Y-m-d H:i:s', strtotime($asset['updated_at'])) : '',
                        'browser_download_url' => $asset['browser_download_url']
                    ]
                ];
            }
        }

        // Sort updates
        $updates = array_reverse($updates);

        // Create cache file
        $cache = fopen($this->cache_path . $this->cache_file, 'w');

        // Write cache file
        fwrite($cache, json_encode($updates, JSON_PRETTY_PRINT));

        // Close cache file
        fclose($cache);

        return $updates;
    }

    /**
     * Call
     * Send http request
     *
     * @param  string $url
     * @return string $response
     */
    private function call($url)
    {
        if(!$url)
            return false;

        // Ignore client abort
        ignore_user_abort();

        // HACK! Give it some time...
        set_time_limit(0);

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL            => $url,
            CURLOPT_TIMEOUT        => 300,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_USERAGENT      => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1',
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_FOLLOWLOCATION => TRUE
        ]);

        $response = curl_exec($curl);
        //$err      = curl_error($curl);

        curl_close($curl);

        return $response;
    }

    /**
     * Remove dir
     * Destroys a directory
     *
     * @param  string $dir
     * @return void
     */
    private function removeDir($dir)
    {
        // Make sure its directory
        if(!is_dir($dir))
            return;

        // Get the tree
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        // Remove everything inside
        foreach($files as $file)
            ($file->isDir()) ? rmdir($file->getRealPath()) : unlink($file->getRealPath());

        // Remove root directory
        rmdir($dir);
    }
}
